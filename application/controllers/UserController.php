<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends Base_Controller {
    private $userId = 0;
    public function __construct() {
        parent::__construct();
        $isLoggedIn = $this->session->userdata('logged_in');
        if (!$isLoggedIn) {
            return redirect(base_url('sign-in'));
        }
        $this->userId = $this->session->userdata('id');
		$this->load->model('User_model');
    }

    public function index() {
        $data['activeTab'] = 'dashboard';
        $data['totalBookingCounts'] = count($this->User_model->commonFetch(['bid'],'booking',['user_id' => $this->userId],0,''));
        $data['totalWishlistCounts'] = count($this->User_model->commonFetch(['wp_id'],'wishlist_products',['user_id' => $this->userId],0,''));
        $data['recentBooking'] = $this->User_model->fetch_bookings($this->userId, true);
        $this->load->view('users/dashboard',$data);
    }

    public function myBookings() {
        $data['activeTab'] = 'bookings';
        $data['allBookings'] = $this->User_model->fetch_bookings($this->userId);
        $this->load->view('users/my-bookings',$data);
    }

    public function myWishlists() {
        $data['activeTab'] = 'wishlists';
        $data['allWishlists'] = $this->User_model->fetch_wishlist_products($this->userId);
        $this->load->view('users/my-wishlist',$data);
    }

    public function myProfile() {
        $data['activeTab'] = 'profile';
        $data['profileDetail'] = $this->User_model->fetch_user_detail($this->userId);
        $this->load->view('users/my-profile',$data);
    }

    public function removeFromWhishlist() {
        try {
            $isLoggedIn = $this->session->userdata('logged_in');
			if (!$isLoggedIn) {
				throw new Exception("You aren't logged in to remove the product from wishlist.");
			}
			$wpId = $this->input->post('wpId');
			
			$checkExists = $this->Front_model->check_value_exist('wishlist_products', ['wp_id' => $wpId]);

			if (!$checkExists) {
				throw new Exception("You don't have this product in your wishlist to remove.");
			}
            $_arr = array(
				'wp_id' => $wpId,
			);
            $removed = $this->User_model->delete('wishlist_products',$_arr);
            if ($removed) {
                $msg = array('status' => 'success', 'message' => "Well done! You've successfully removed product from your wishlist.");
            }
        } catch (Exception $x) {
			$msg = array('status' => 'error', 'message' => $x->getMessage());
        }
		echo json_encode($msg);
    }

    public function viewBooking() {
        if (!isset($_GET['bk'])) {
            $this->viewBookingError("Booking number missing in your request.");
        }

        $parameter = base64_decode($this->input->get('bk'));
        $bookedDetail = $this->User_model->booking_detail($parameter);

        if (empty($bookedDetail)) {
            $this->viewBookingError("You don't have booking with this booking number.");
        }

        if (!empty($bookedDetail) && $bookedDetail->user_id != $this->userId) {
            $this->viewBookingError("You don't have booking with this booking number.");
        }

        $data['activeTab'] = 'bookings';
        $data['bookingDetail'] = $bookedDetail;
        $this->load->view('users/booking-detail',$data);
    }

    private function viewBookingError($message) {
        $this->session->set_flashdata('message_class', 'd-flex');
        $this->session->set_flashdata('message', $message);
        return redirect(base_url('my-bookings'));
    }

    public function updateUserDetail() {
        try {
            $username = $this->input->post('username');
            $fname = $this->input->post('fname');
            $lname = $this->input->post('lname');
            $email = $this->input->post('email');
            $phone = $this->input->post('phone');
            $dob = $this->input->post('dob');

            $listOfUsernames = [
                'admin',
                'admin123',
                'admin123',
                'admin12345',
                '123',
                '12345',
                '123456',
                '143',
                'admin@',
                'admin@gmail.com',
                'admin@123',
                'root',
                'administrator',
                'root@',
                'root@123',
            ];
            if (in_array( $username ,$listOfUsernames )) {
                throw new Exception("You are not allowed to use this username. Please choose another.");
            }

            $getDetailByUsername = $this->User_model->commonFetch(['user_id'],'staff_users',['username' => trim($username)],1,'');
            if (!empty($getDetailByUsername) && $getDetailByUsername->user_id != $this->userId) {
                throw new Exception("Sorry, that username is taken. Please choose another.");
            }

            $getDetailByEmail = $this->User_model->commonFetch(['user_id'],'staff_users',['email' => trim($email)],1,'');
            if (!empty($getDetailByEmail) && $getDetailByEmail->user_id != $this->userId) {
                throw new Exception("Sorry, that email is taken. Please choose another.");
            }

            $_arr = array(
                'username' => $username, 
                'fname' => $fname, 
                'lname' => $lname, 
                'email' => $email, 
                'phone' => $phone != '' ? $phone : null, 
                'dob' => $dob != '' ? date('Y-m-d', strtotime($dob)) : null,
            );

            $updated = $this->User_model->update(['user_id' => $this->userId], 'staff_users', $_arr);
            $msg = array('status' => 'success', 'message' => "Well done! You've successfully updated your personal information.");

        } catch (Exception $x) {
			$msg = array('status' => 'error', 'message' => $x->getMessage());
        }
		echo json_encode($msg);
    }

    public function uploadAvatar() {
        try {
            if (isset($_FILES['avatar'])) {
                $file_name = $_FILES['avatar']['name'];
                $file_size =$_FILES['avatar']['size'];
                $file_tmp = $_FILES['avatar']['tmp_name'];
                $file_type =$_FILES['avatar']['type'];
                
                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                
                $folder = $this->folder."/photos/staff/";
                if(!is_dir($folder)){
                    mkdir($folder, 0755, true);
                }

                $extensions= array("jpeg","jpg","png");

                if(in_array($file_ext,$extensions)=== false){
                    throw new Exception("Please choose PNG of JPG file.");
                }

                if($file_size > 4194304){
                    throw new Exception("Cannot upload a image more than 4 MB.");
                }

                $userDetail = $this->User_model->commonFetch(['user_id','user_pic'],'staff_users',['user_id' => $this->userId],1,'');
                if ($userDetail->user_pic != null || $userDetail->user_pic != '') {
                    unlink( $folder . $userDetail->user_pic);
                }

                $PhotoFileNameMD5 = md5(date('YmdHis').$file_name).'.'.$file_ext;
                move_uploaded_file($file_tmp,$folder.$PhotoFileNameMD5);
                $data['user_pic'] = $PhotoFileNameMD5;
                $this->User_model->update(['user_id' => $this->userId], 'staff_users', $data);
                $msg = array('status' => 'success', 'message' => "Well done! You've successfully updated your profile picture.",'imgpath' => PHOTO_DOMAIN.'staff/'.$PhotoFileNameMD5);
                $this->session->userdata['profile_pic'] = 'staff/'.$PhotoFileNameMD5;
            } else {
                throw new Exception("Please select the image.");
            }
        } catch (Exception $x) {
			$msg = array('status' => 'error', 'message' => $x->getMessage());
        }
		echo json_encode($msg);
    }

    public function removeAvatar() {
        try {
            $result = $this->User_model->commonFetch(['user_id','user_pic'],'staff_users',['user_id' => $this->userId],1,'');
            $folder = $this->folder."/photos/staff/";
            if ($result->user_pic != '' && $result->user_pic != null) {
                unlink( $folder . $result->user_pic);
            } else {
                throw new Exception("You don't have profile picture to remove.");
            }
            $data['user_pic'] = null;
            $this->User_model->update(['user_id' => $this->userId], 'staff_users', $data);
            $msg = array('status' => 'success', 'message' => "Well done! You've successfully updated your profile picture.",'imgpath' => PHOTO_DOMAIN.'user_default.jpg');
            $this->session->userdata['profile_pic'] = 'user_default.jpg';
        } catch (Exception $x) {
			$msg = array('status' => 'error', 'message' => $x->getMessage());
        }
		echo json_encode($msg);
    }

    public function changePassword() {
        try {
            $currentPassword = $this->input->post('current_password');
            $newPassword = $this->input->post('new_password');
            $confirmNewPassword = $this->input->post('c_new_password');

            if ($currentPassword == '' || $currentPassword == null) {
                throw new Exception("Please enter your current password.");
            }

            if ($newPassword == '' || $newPassword == null) {
                throw new Exception("Please enter your new password.");
            }

            if ($confirmNewPassword == '' || $confirmNewPassword == null) {
                throw new Exception("Please enter your new confirm password.");
            }

            $fetUserDetail = $this->User_model->commonFetch(['user_id','password'],'staff_users',['user_id' => $this->userId],1,'');
            if (empty($fetUserDetail)) {
                throw new Exception("Cannot find the user.");
            }
            if (!password_verify($currentPassword, $fetUserDetail->password)) {
                throw new Exception("Your current password is not matched.");
            }
            
            $confirmNewPassword = $this->get_encrypted_password($confirmNewPassword);
            if (!password_verify($newPassword, $confirmNewPassword)) {
                throw new Exception("Your new password and confirm password are not matched.");
            }
            $data['password'] = $this->get_encrypted_password($newPassword);
            $this->User_model->update(['user_id' => $this->userId], 'staff_users', $data);
            $msg = array('status' => 'success', 'message' => "Well done! You've successfully updated your password.");
        } catch (Exception $x) {
			$msg = array('status' => 'error', 'message' => $x->getMessage());
        }
		echo json_encode($msg);
    }
}