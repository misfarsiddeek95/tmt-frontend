<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FrontController extends Base_Controller {
	public function __construct() {
        parent::__construct();
		$this->load->model('Front_model');
		// $commonData['footerResorts'] = $this->Front_model->getAccomodations(['ho_id', 'hotel_name'], ['h_status' => 1, 'hotel_type' => 2]);
		$commonData['footerContactInfo'] = $this->Front_model->fetchPage(25);
		$commonData['socialMediaLinks'] = $this->Front_model->fetchPage(31);
		$commonData['searchRecord'] = $this->Front_model->getSearchRecord();
		// $commonData['minMaxRoomPrices'] = $this->Front_model->fetchMinMaxRoomPrice();
		$this->load->vars($commonData);
    }

	public function index() {
		$data['activeTab'] = 'index';
		$data['pageMain'] = $this->Front_model->fetchPage(1);
		$data['pageTopDeals'] = $this->Front_model->fetchPage(2);
		$data['pageWhyChooseUs'] = $this->Front_model->fetchPage(3);
		$data['pageBestTravelAgent'] = $this->Front_model->fetchPage(4);
		$data['pageBestPrice'] = $this->Front_model->fetchPage(5);
		$data['pageBestTrustSafty'] = $this->Front_model->fetchPage(6);
		$data['pageFastBooking'] = $this->Front_model->fetchPage(7);
		$data['pagePopularResorts'] = $this->Front_model->fetchPage(8);
		$data['pagePopularAtolls'] = $this->Front_model->fetchPage(9);
		$data['pagePopularHotels'] = $this->Front_model->fetchPage(10);
		$data['pagePopularCities'] = $this->Front_model->fetchPage(11);
		$data['pageAboutUs'] = $this->Front_model->fetchPage(12);
		$data['pageAboutUsPics'] = $this->Front_model->fetchPageManyPics(12,2);
		$data['pagePopularDestinations'] = $this->Front_model->fetchPage(13);
		$data['topDealsList'] = $this->Front_model->loadTopDeals();
		$data['popularResortList'] = $this->Front_model->loadPopularResorts(); # select fields, conditions and limit
		$data['popularAtollList'] = $this->Front_model->atollList();

		$this->load->view('index', $data);
	}

	public function notFound() {
		$data['activeTab'] = 'not-found';
		$this->load->view('not_found',$data);
	}

	public function aboutUs() {
		$data['activeTab'] = 'about';
		$data['pageMain'] = $this->Front_model->fetchPage(15);
		$data['pageBanner'] = $this->Front_model->fetchPage(26);
		$data['pageWhyChooseUs'] = $this->Front_model->fetchPage(27);
		$data['pageBestTravelAgent'] = $this->Front_model->fetchPage(16);
		$data['pageBestPrice'] = $this->Front_model->fetchPage(17);
		$data['pageBestTrustSafty'] = $this->Front_model->fetchPage(18);
		$data['pageFastBooking'] = $this->Front_model->fetchPage(19);
		$data['pageContent'] = $this->Front_model->fetchPage(28);
		$data['pageTeam'] = $this->Front_model->fetchPage(29);
		$data['ourTeam'] = $this->Front_model->getOurTeam();
		$data['pageTestimonial'] = $this->Front_model->fetchPage(30);
		$data['testimonials'] = $this->Front_model->loadTestimonials();
		$this->load->view('about', $data);
	}

	public function antiFraudPolicy() {
		$data['activeTab'] = 'fraud';
		$data['pageMain'] = $this->Front_model->fetchPage(20);
		$this->load->view('anti-fraud', $data);
	}

	public function privacyPolicy() {
		$data['activeTab'] = 'privacy';
		$data['pageMain'] = $this->Front_model->fetchPage(21);
		$this->load->view('privacy-policy', $data);
	}

	public function termsOfUse() {
		$data['activeTab'] = 'terms';
		$data['pageMain'] = $this->Front_model->fetchPage(22);
		$this->load->view('terms-of-use', $data);
	}

	public function siteFaqs() {
		$data['activeTab'] = 'faq';
		$data['pageMain'] = $this->Front_model->fetchPage(23);
		$data['siteFaqs'] = $this->Front_model->loadFaqs();
		$this->load->view('faq', $data);
	}

	public function contactUs() {
		$data['activeTab'] = 'contact';
		$data['pageMain'] = $this->Front_model->fetchPage(24);
		$data['pageContactInfo'] = $this->Front_model->fetchPage(25);
		$data['pageWhyChooseUs'] = $this->Front_model->fetchPage(3);
		$data['pageBestTravelAgent'] = $this->Front_model->fetchPage(4);
		$data['pageBestPrice'] = $this->Front_model->fetchPage(5);
		$data['pageBestTrustSafty'] = $this->Front_model->fetchPage(6);
		$data['pageFastBooking'] = $this->Front_model->fetchPage(7);
		// $data['countries'] = $this->Front_model->getCountries();
		$this->load->view('contact', $data);
	}

	public function submitContactForm() {
		try {
			$this->load->library('form_validation');
	
		$this->setFormValidationRules();
	
		if ($this->form_validation->run() == FALSE) {
			// If form validation fails, return to the form with validation errors
			$data['activeTab'] = 'contact';
			$data['pageMain'] = $this->Front_model->fetchPage(24);
			$data['pageContactInfo'] = $this->Front_model->fetchPage(25);
			$data['pageWhyChooseUs'] = $this->Front_model->fetchPage(3);
			$data['pageBestTravelAgent'] = $this->Front_model->fetchPage(4);
			$data['pageBestPrice'] = $this->Front_model->fetchPage(5);
			$data['pageBestTrustSafty'] = $this->Front_model->fetchPage(6);
			$data['pageFastBooking'] = $this->Front_model->fetchPage(7);
			// $data['countries'] = $this->Front_model->getCountries();
			$this->load->view('contact', $data);
		} else {
			// If form validation passes, retrieve the form values securely
			$full_name = $this->input->post('full_name', true);
			$email = $this->input->post('email', true);
			$mobile_number = $this->input->post('mobile_number', true);
			$country = $this->input->post('country', true);
			$booking_id = $this->input->post('booking_id', true);
			$inquiry = $this->input->post('inquiry', true);

			$mail_temp = file_get_contents(base_url().'assets/mail/contactmail.html');  
            $report_rep = array(
                '[logo]' => base_url().'assets/img/web-logo-black.png',
                '[message]' => $inquiry,
            );
            
            $subject = 'Contact Form - '.COMPANY_NAME;
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: '.$full_name.'<'.$email.'>' . "\r\n";
            
            $mail_temp = strtr($mail_temp, $report_rep);
            if ($full_name != '' && $email != '' && $subject != '' && $inquiry != '') {
                $sent = mail(COMMON_MAIL_ID,$subject,$mail_temp,$headers);
            }

			if ($sent) {
                $msg = array('status' => 'success','message' => 'Mail sent successfully.','redirect_to' => base_url());
                // check email exists,
				$checkEmailExist = $this->Front_model->getRecordByValue($email);
				// save email in the db.
				if (!$checkEmailExist) {
					$data = array(
						'email' => $email,
						'date' => date('Y-m-d H:i:s'),
						'ip' => $this->input->ip_address()
					);
					$this->Front_model->insert('subscription_email', $data);
				}
            }else{
                $msg = array('status' => 'error','message' => 'Something went wrong.');
            }
		}
		} catch (Exception $x) {
			$msg = array('status' => 'error','message' => $x->getMessage());
		}
		echo json_encode($msg);
	}
	
	private function setFormValidationRules() {
		$this->form_validation->set_rules('full_name', 'Full Name', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[100]|valid_email');
		$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required|regex_match[/^\+?\d{1,3}[- ]?\d{3}[- ]?\d{4,}$/]');
		$this->form_validation->set_rules('country', 'Country', 'trim|required');
		$this->form_validation->set_rules('booking_id', 'Booking ID', 'trim|max_length[100]');
		$this->form_validation->set_rules('inquiry', 'Inquiry', 'trim|required|max_length[500]');
	}

	public function getSearchData() {
		$result = $this->Front_model->getSearchRecord();
		echo json_encode($result);
	}

	public function accommodation() {
		if (!isset($_GET['prs'])) {
			return redirect(base_url());
		}

		$data['activeTab'] = 'list';
		$data['pageMain'] = $this->Front_model->fetchPage(32);

		$urlParams = $this->input->get('prs');
		$decodedParams = base64_decode($urlParams);
		$explodedUrl = explode('&', $decodedParams);

		$data['st'] = base64_decode(base64_decode($this->removeEqualSign($explodedUrl[0])));
		$data['sv'] = base64_decode(base64_decode($this->removeEqualSign($explodedUrl[1])));
		$data['ssd'] = date('Y-m-d', strtotime(base64_decode(base64_decode($this->removeEqualSign($explodedUrl[2])))));
		$data['sed'] = date('Y-m-d', strtotime(base64_decode(base64_decode($this->removeEqualSign($explodedUrl[3])))));
		$data['ac'] = base64_decode(base64_decode($this->removeEqualSign($explodedUrl[4])));
		$data['cc'] = base64_decode(base64_decode($this->removeEqualSign($explodedUrl[5])));
		$data['rc'] = base64_decode(base64_decode($this->removeEqualSign($explodedUrl[6])));
		$data['ic'] = base64_decode(base64_decode($this->removeEqualSign($explodedUrl[7])));

		$data['propertyTypes'] = $this->Front_model->fetchPropertyTypes();
		$data['villaTypes'] = $this->Front_model->commonFetch(['vt_id','vt_name'],'villa_types',['status' => 1],0,'vt_id');
		$data['transferTypes'] = $this->Front_model->commonFetch(['*'],'transfer');
		$data['atollList'] = $this->Front_model->fetchAtolls();

		$this->load->view('list', $data);
	}

	public function filterList() {
		$nameSearch = $this->input->post('nameSearch');
		$searchedType = $this->input->post('searchedType'); // if 1: accomodation, if 2: atoll, if nothing selected value will be 0.
		$searchedValue = $this->input->post('searchedValue'); // value of dropdown selected, if nothing selected value will be 0.
		$searchedStartDate = $this->input->post('searchedStartDate');
		$searchedEndDate = $this->input->post('searchedEndDate');
		$adultCount = $this->input->post('adultCount');
		$childCount = $this->input->post('childCount');
		$infantCount = $this->input->post('infantCount');
		$roomCount = $this->input->post('roomCount');
		$priceMin = $this->input->post('priceMin');
		$priceMax = $this->input->post('priceMax');
		$propertyList = $this->input->post('propertyList'); // array of selected property list ids.
		$villaTypes = $this->input->post('villaTypes'); // array of selected villa type ids.
		$starVal = $this->input->post('starVal'); // star rating value.
		$transerTypes = $this->input->post('transerTypes'); // array of selected transfer type ids.
		$atollList = $this->input->post('atollList'); // array of selected atoll list ids.

		$sortBy = $this->input->post('sortBy');

		$limit = $this->input->post('limit'); // get the result limit.
		$offset = $this->input->post('offset'); // result starts from.

		$listOfRecords = $this->Front_model->filterList($nameSearch,$searchedType,$searchedValue,$searchedStartDate,$searchedEndDate,$adultCount,$childCount,$infantCount,$roomCount,$priceMin,$priceMax,$propertyList,$villaTypes,$starVal,$transerTypes,$atollList,$limit,$offset);

		switch ($sortBy) {
			case 'by_name':
				usort($listOfRecords['result'], function($a, $b) {
					return strcmp($a->hotel_name, $b->hotel_name);
				});
				break;
			case 'by_price_low_to_high':
				usort($listOfRecords['result'], function($a, $b) {
					return $a->actualPrice <=> $b->actualPrice;
				});
				break;
			case 'by_price_high_to_low':
				usort($listOfRecords['result'], function($a, $b) {
					return $b->actualPrice <=> $a->actualPrice;
				});
				break;
			case 'by_review':
				usort($listOfRecords['result'], function($a, $b) {
					return $b->review_count <=> $a->review_count;
				});
				break;
		}

		echo json_encode($listOfRecords);
	}

	public function accommodationDetail() {
		if (!isset($_GET['prs'])) {
			return redirect(base_url());
		}

		$data['activeTab'] = 'detail';
		$data['pageMain'] = $this->Front_model->fetchPage(33);// This line will be moved to another page.

		$urlParams = $this->input->get('prs');
		$decodedParams = base64_decode($urlParams);
		$explodedUrl = explode('&', $decodedParams);

		$resortId = base64_decode(base64_decode($this->removeEqualSign($explodedUrl[0])));
		$startDate = date('Y-m-d', strtotime(base64_decode(base64_decode($this->removeEqualSign($explodedUrl[1])))));
		$endDate = date('Y-m-d', strtotime(base64_decode(base64_decode($this->removeEqualSign($explodedUrl[2])))));
		$adultCount = base64_decode(base64_decode($this->removeEqualSign($explodedUrl[3])));
		$childCount = base64_decode(base64_decode($this->removeEqualSign($explodedUrl[4])));
		$roomCount = base64_decode(base64_decode($this->removeEqualSign($explodedUrl[5])));
		$infantCount = base64_decode(base64_decode($this->removeEqualSign($explodedUrl[6])));

		$data['accomodationDetail'] = $this->Front_model->getAccomodationDetail($startDate,$endDate,$resortId,$adultCount,$childCount);
		
		if (empty($data['accomodationDetail'])) {
			return redirect(base_url());
		}
		$data['roomCount'] = $roomCount;
		$data['accomId'] = $resortId;
		$data['startDate'] = $startDate;
		$data['end_date'] = $endDate;
		$data['adultCount'] = $adultCount;
		$data['childCount'] = $childCount;
		$data['infantCount'] = $infantCount;
		$data['nightCount'] = $this->Front_model->nightCount($startDate,$endDate);
		
		$this->load->view('detail', $data);
	}

	// remove 1st = sign from the parameter string.
	private function removeEqualSign($str) {
		$pos = strpos($str, "=");
		if ($pos !== false) {
			// Extract the substring starting from the first "=" sign
			$newStr = substr($str, $pos + 1);
			return $newStr; // Output: MjAyMy0wNC0xMw==
		} 
	}

	public function subscribeEmail() {
		try {
			$email = $this->input->post('email');
			if ($email == '' || $email == null) {
				throw new Exception("Please enter the email.");
			}

			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				throw new Exception("Invalid email format");
			}

			// check email exists,
			$checkEmailExist = $this->Front_model->getRecordByValue($email);
			// save email in the db.
			if (!$checkEmailExist) {
				$data = array(
					'email' => $email,
					'date' => date('Y-m-d H:i:s'),
					'ip' => $this->input->ip_address()
				);
				$inserted = $this->Front_model->insert('subscription_email', $data);
				$msg = array('status' => 'success', 'message' => 'Email subscribed successfully.');
			} else {
				$msg = array('status' => 'success', 'message' => 'This email already subscribed.');
			}

		} catch (Exception $e) {
			$msg = array('status' => 'error', 'message' => $e->getMessage());
		}
		echo json_encode($msg);
	}

	public function signUp() {
		if ($this->session->userdata('logged_in')) {
			redirect(base_url()); // have to mention the redirect url
		}
		$data['activeTab'] = 'signup';
		$data['pageMain'] = $this->Front_model->fetchPage(34);
		$this->load->view('signup', $data);
	}

	private function setRegistrationRules() {
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('c_password', 'Password Confirmation', 'required|matches[password]');
	}

	public function submitSignUp() {
		try {
			$this->load->library('form_validation');
			$this->setRegistrationRules();
			if ($this->form_validation->run() == FALSE) {
				throw new Exception("Form validation failed. Please fill the form correctly.");
			} else {
				$firstName = $this->input->post('first_name');
				$lastName = $this->input->post('last_name');
				$email = $this->input->post('email');
				$password = $this->input->post('password');

				$redirect_value = $this->input->post('rval');

				$use_to_subscribe = isset($_POST['use_to_subscribe']) ? true : false;

				$checkEmailExist = $this->Front_model->check_value_exist('staff_users',['email' => $email]);
				if ($checkEmailExist) {
					throw new Exception("This email is already registered.");
				}

				$isSubscribed = $this->Front_model->getRecordByValue($email);
				
				$arr = array(
					'fname' => $firstName,
					'lname' => $lastName,
					'email' => $email,
					'username' => $email,
					'status' => 0,
					'user_type' => 1,
					'password' => $this->get_encrypted_password($password)
				);
				$registered = $this->Front_model->insert('staff_users', $arr);
				if ($registered) {
					if ($use_to_subscribe && !$isSubscribed) {
						$data = array(
							'email' => $email,
							'date' => date('Y-m-d H:i:s'),
							'ip' => $this->input->ip_address()
						);
						$this->Front_model->insert('subscription_email', $data);
					}
					$insertedData = $this->Front_model->commonFetch(['user_id','username','email','fname','lname','phone'],'staff_users',[],1,'');
					$loginSession = array(
						'id' => $insertedData->user_id, // The user's ID in the database
						'name' => $insertedData->fname.' '.$insertedData->lname,
						'username' => $insertedData->username, // The user's username
						'email' => $insertedData->email, // The user's email
						'phone' => $insertedData->phone, // The user's phone
						'profile_pic' => 'user_default.jpg',
						'logged_in' => true // Set the logged_in value to true
					);
					$this->session->set_userdata($loginSession);
					
					$redirect_to = base_url('dashboard');
					if ($redirect_value != '') {
						$redirect_to = base64_decode(base64_decode($redirect_value));
					}

					$msg = array('status' => 'success', 'message' => 'You have registered successfully.','redirect_to' => $redirect_to);
				}
			}
		} catch (Exception $x) {
			$msg = array('status' => 'error', 'message' => $x->getMessage());
		}
		echo json_encode($msg);
	}

	public function signIn() {
		if ($this->session->userdata('logged_in')) {
			redirect(base_url()); // have to mention the redirect url
		}
		$data['activeTab'] = 'login';
		$data['pageMain'] = $this->Front_model->fetchPage(35);
		$this->load->view('login', $data);
	}

	public function submitSignIn() {
		try {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if ($this->form_validation->run() == FALSE) {
				throw new Exception("Form validation failed. Please fill the form correctly.");
			} else {
				$email = $this->input->post('email');
				$password = $this->input->post('password');

				$redirect_value = $this->input->post('rval');

				$userData = $this->Front_model->commonFetch(['user_id','username','email','fname','lname','user_type','status','password','user_pic','phone'],'staff_users',['username' => trim($email)],1,'');
				
				if ($userData && $userData->user_type == 1 && $userData->status == 0 && password_verify($password, $userData->password)) {
					$img = 'user_default.jpg';
					if ($userData->user_pic!=null && $userData->user_pic!= '') {
						$img = 'staff/'.$userData->user_pic;
					}
					$loginSession = array(
						'id' => $userData->user_id, // The user's ID in the database
						'name' => $userData->fname.' '.$userData->lname,
						'username' => $userData->username, // The user's username
						'email' => $userData->email, // The user's email
						'phone' => $userData->phone, // The user's phone
						'profile_pic' => $img,
						'logged_in' => true // Set the logged_in value to true
					);
					$this->session->set_userdata($loginSession);

					$redirect_to = base_url('dashboard');
					if ($redirect_value != '') {
						$redirect_to = base64_decode(base64_decode($redirect_value));
					}
					$msg = array('status' => 'success', 'message' => 'You have loggedin successfully.','redirect_to' => $redirect_to);
				} else if($userData && $userData->status == 1) {
					throw new Exception("User blocked. Please contact Administrator.");
				} else {
					throw new Exception("Invalid username or password.");
				}
			}
			
		} catch (Exception $x) {
			$msg = array('status' => 'error', 'message' => $x->getMessage());
		}
		echo json_encode($msg);
	}

	public function logout() {
		// Unset multiple user data at once using an array
		$this->session->unset_userdata(array('id', 'name', 'username', 'email' , 'logged_in'));
		// Redirect the user to the login page
		redirect(base_url());
	}

	public function mainInquiry() {
		$data['activeTab'] = 'inquiry';
		$data['pageMain'] = $this->Front_model->fetchPage(36);
		$data['pageContactInfo'] = $this->Front_model->fetchPage(25);
		$data['accomodations'] = $this->Front_model->commonFetch(['ho_id','hotel_name'],'hotels',['h_status' => 1,'hotel_type' => 2],0,'ho_id');
        $data['meal_plan'] = $this->Front_model->commonFetch(['*'],'package_meal_plan_types');
        $data['transfer'] = $this->Front_model->commonFetch(['*'],'transfer');
		$data['celebrate'] = $this->Front_model->commonFetch(['*'],'holiday_celebrating_categories');
		$data['countries'] = $this->Front_model->commonFetch(['*'],'country');

		if (isset($_GET['prs'])) {
			$urlParams = $this->input->get('prs');
			$decodedParams = base64_decode($urlParams);
			$explodedUrl = explode('&', $decodedParams);

			$data['ssd'] = date('Y-m-d', strtotime(base64_decode(base64_decode($this->removeEqualSign($explodedUrl[0])))));
			$data['sed'] = date('Y-m-d', strtotime(base64_decode(base64_decode($this->removeEqualSign($explodedUrl[1])))));
			$data['ac'] = base64_decode(base64_decode($this->removeEqualSign($explodedUrl[2])));
			$data['cc'] = base64_decode(base64_decode($this->removeEqualSign($explodedUrl[3])));
			$data['rc'] = base64_decode(base64_decode($this->removeEqualSign($explodedUrl[4])));
			$data['rid'] = base64_decode(base64_decode($this->removeEqualSign($explodedUrl[5])));
		}

		$this->load->view('inquiry',$data);
	}

	public function loadAccomRooms() {
        $accomId = $this->input->post('accomId');
        $result = $this->Front_model->loadAccomRooms($accomId);
        echo json_encode($result);
    }

	public function getSpecificDetail() {
        $accomId = $this->input->post('accomId');
        $roomId = $this->input->post('roomId');
        if ($roomId == 'select-villa' || $roomId == '' || $roomId == 0) { # When room id is not select, then detail come from resort
            $seoUrl = $this->Front_model->returnAccomSeoUrl($accomId);
            if ($seoUrl) {
                $result = $this->Front_model->getResortDetail($seoUrl);
            }
        }else{
            $result = $this->Front_model->getVillaDetail($roomId);
        }
        echo json_encode($result);
    }

	public function sendMainInquiry() {
		try {
			if (!isset($_POST['input_start_date'])) {
                throw new Exception("Please select arrival date.");
            }
            if (!isset($_POST['input_end_date'])) {
                throw new Exception("Please select depature date.");
            }
			if (!isset($_POST['country']) || $this->input->post('country') == 0) {
                throw new Exception("Please select country.");
            }
			$inquire_for = $this->input->post('inquire_for');
            $resort = $this->input->post('resort');
            $room = $this->input->post('room');
            $date_from = date('Y-m-d',strtotime($this->input->post('input_start_date')));
            $date_to = date('Y-m-d',strtotime($this->input->post('input_end_date')));
            $nights = $this->input->post('nights');
            $hcc_id = $this->input->post('hcc_id');
            $price_range = $this->input->post('price_range');
            $room_count = $this->input->post('room_count');
            $adult = $this->input->post('adult');
            $child = $this->input->post('child');
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $phone = $this->input->post('phone');
            $comment = $this->input->post('comment');
            $meal_plan = $this->input->post('meal_plan');
            $transfer = $this->input->post('transfer');
            $country = $this->input->post('country');
            $date = date('Y-m-d H:i:s');
			$reference_code = $this->generateRandomString(8,'inquiry','reference_code');

			$arr = array(
                'inquire_for' => $inquire_for, 
                'for_id' => $resort != 0 ? $resort : null,
                'room_id' => $room != 0 ? $room : null,
                'f_name' => $name,
                'email' => $email,
                'phone' => $phone,
                'adult' => $adult,
                'child' => $child, 
                'country_id' => $country, 
                'date_from' => $date_from, 
                'date_to' => $date_to, 
                'no_rooms' => $room_count, 
                'stay_nights' => $nights, 
                'celebrating' => $hcc_id, 
                'amount_range' => $price_range, 
                'mp_id' => $meal_plan, 
                'trans_id' => $transfer, 
                'comment' => $comment, 
                'reference_code' => $reference_code, 
                'assigned' => 0, 
                'added_date' => $date, 
            );
			$inserted = $this->Front_model->insert('inquiry',$arr);

			// MAIL ------------------------------------------------------------------------------------------
			if ($hcc_id != 0 && $hcc_id != '' && $hcc_id != null) {
                $celeb = $this->Front_model->commonFetch(['*'],'holiday_celebrating_categories',['hcc_id'=> $hcc_id],1);
                $celebTitle = $celeb->hcc_title;
            }else{
                $celebTitle = '';
            }

			$country_name = $this->Front_model->commonFetch(['nicename'],'country',[],1);

            $mail_temp = file_get_contents(base_url().'assets/mail/inqmail.html');
            $report_rep = array(
                '[baseurl]' => base_url(),
                '[name]' => $name,
                '[email]' => $email,
                '[inq_refcode]' => $reference_code,
                '[inq_date]' => date('d/m/Y',strtotime($this->input->post('input_start_date'))),
                '[inq_date_to]' => date('d/m/Y',strtotime($this->input->post('input_end_date'))),
                '[inq_nights]' => str_pad($nights, 2, "0", STR_PAD_LEFT).' Nights',
                '[inq_celebrate]' => $celebTitle,
                '[inq_price]' => $price_range,
                '[contact]' => $phone,
                '[country]' => $country_name->nicename,
                '[inq_rooms]' => str_pad($room_count, 2, "0", STR_PAD_LEFT).' Rooms',
                '[inq_adults]' => str_pad($adult, 2, "0", STR_PAD_LEFT).' Adults',
                '[inq_child]' => str_pad($child, 2, "0", STR_PAD_LEFT).' Children',
            );
            if(isset($resort) && $resort != 0){
                $getResortDetail = $this->Front_model->getAccomForMail($resort);
				$img = PHOTO_DOMAIN.'default.jpg';
				if ($getResortDetail->photo_path != '' && $getResortDetail->photo_path != null) {
					$img = PHOTO_DOMAIN.'hotels/'.$getResortDetail->photo_path.'-std.jpg';
				}
                $resortSet = '<tr>
                                <td style="padding-bottom: 30px;">
                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <td valign="middle" width="50%">
                                    <img src="'.$img.'" alt="" style="width: 100%; max-width: 600px; height: auto; margin: auto; display: block;">
                                </td>
                                <td valign="middle" width="50%">
                                    <div class="text-blog" style="text-align: left; padding-left: 15px; margin-top: 10px;">
                                            <h2>'.$getResortDetail->hotel_name.'</h2>
                                            <p><a href="#" class="btn btn-primary">View Resorts</a></p>
                                    </div>
                                </td>
                                    </table>
                                </td>
                            </tr>';
                $report_rep['[resort_set]'] = $resortSet;
                $report_rep['[type]'] = 'Resort';
                $report_rep['[resort_name]'] = $getResortDetail->hotel_name;
                $report_rep['[resort_link]'] = base_url(); //.'accomodation/resorts/'.$getResortDetail->seo_url.'/';
            }else{
                $report_rep['[resort_set]'] = '';
                $report_rep['[type]'] = '';
                $report_rep['[resort_name]'] = '';
                $report_rep['[resort_link]'] = '';
            }
            if ($room && $room != 0) {
                $getVillaDetail = $this->Front_model->getVillaForMail($room);
                $villaSet = '<tr>
                                <td valign="middle" style="text-align:center; padding: 1em -1.5em;">
                                    <p>Selected Room</p>
                                </td>
                                <td valign="middle" style="text-align:center; padding: 1em -1.5em;">
                                    <p>'.$getVillaDetail->room_title.'</p>
                                </td>
                            </tr>';
                $report_rep['[villa_set]'] = $villaSet;
            }else{
                $report_rep['[villa_set]'] = '';
            }

            if (isset($meal_plan) && $meal_plan != 0) {
                $mp =  $this->Front_model->commonFetch(['type_title'],'package_meal_plan_types',['id'=> $meal_plan],1);
                $mealset = '<tr>
                                <td valign="middle" style="text-align:center; padding: 1em -1.5em;">
                                    <p>Meal Plan</p>
                                </td>
                                <td valign="middle" style="text-align:center; padding: 1em -1.5em;">
                                    <p>'.$mp->type_title.'</p>
                                </td>
                            </tr>';
                $report_rep['[meal]'] = $mealset;
            }else{
                $report_rep['[meal]'] = '';
            }
            
            if (isset($transfer) && $transfer != 0) {
                $tr = $this->Front_model->commonFetch(['transfer_type'],'transfer',['tras_id' => $transfer],1);
                $transet = '<tr>
                                <td valign="middle" style="text-align:center; padding: 1em -1.5em;">
                                    <p>Transport</p>
                                </td>
                                <td valign="middle" style="text-align:center; padding: 1em -1.5em;">
                                    <p>'.$tr->transfer_type.'</p>
                                </td>
                            </tr>';
                $report_rep['[transport]'] = $transet;
            }else{
                $report_rep['[transport]'] = '';
            }

            $subject = 'We have recieved your inquiry - '.COMPANY_NAME;
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: '.COMPANY_NAME.' <'.COMMON_MAIL_ID.'>'."\r\n";
            $mail_temp = strtr($mail_temp, $report_rep);
            mail(INQUIRY_MAIL_ID,$subject,$mail_temp,$headers);
			// ---

			# save to subscription
            $existMail = $this->Front_model->check_value_exist('subscription_email',['email' => $email]);
            if (!$existMail) {
                $data['email'] = $email;
                $this->Front_model->insert('subscription_email',$data);
            }
            $msg = array('status' => 'success', 'message' => 'Thank you for contacting us. We will get back to you shortly.');

			# Mail to client
            $clmail_temp = file_get_contents(base_url().'assets/mail/thanku.html');

			$pageContactInfo = $this->Front_model->fetchPage(25);
            $clreport_rep = array(
                '[baseurl]' => base_url(),
                '[name]' => $name,
                '[inq_refcode]' => $reference_code,
				'[company_phone]' => $pageContactInfo->seo_title,
				'[company_mail]' => $pageContactInfo->seo_keywords,
				'[address]' => $pageContactInfo->headline.' '.$pageContactInfo->second_title
            );
            $clsubject = 'We have recieved your inquiry - '.COMPANY_NAME;
            $clheaders = "MIME-Version: 1.0" . "\r\n";
            $clheaders .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $clheaders .= 'From: '.COMPANY_NAME.' <'.COMMON_MAIL_ID.'>'."\r\n";
            $clmail_temp = strtr($clmail_temp, $clreport_rep);
            mail($email,$clsubject,$clmail_temp,$clheaders);
		} catch (Exception $x) {
			$msg = array('status' => 'error', 'message' => $x->getMessage());
		}
		echo json_encode($msg);
	}

	private function generateRandomString($length = 10,$table,$field,$prefix='TXM') {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $mr_code = '';
        for ($i = 0; $i < $length; $i++) {
            $mr_code .= $characters[rand(0, $charactersLength - 1)];
        }
        $ext = $this->Front_model->check_value_exist($table,[$field => $mr_code]);
        if ($ext) {
            $this->generateRandomString($prefix,$length = 10,$table,$field);
        }else{
            return $prefix.$mr_code;
        }
    }

	public function booking() {
		if (!isset($_GET['bkg'])) {
			return redirect(base_url());
		}

		$urlParams = $this->input->get('bkg');
		$decodedParams = base64_decode($urlParams);
		$explodedUrl = explode('&', $decodedParams);

		$data['accomId'] = base64_decode(base64_decode($this->removeEqualSign($explodedUrl[0])));
		$data['roomId'] = base64_decode(base64_decode($this->removeEqualSign($explodedUrl[1])));
		$data['sd'] = date('Y-m-d', strtotime(base64_decode(base64_decode($this->removeEqualSign($explodedUrl[2])))));
		$data['ed'] = date('Y-m-d', strtotime(base64_decode(base64_decode($this->removeEqualSign($explodedUrl[3])))));
		$data['rc'] = base64_decode(base64_decode($this->removeEqualSign($explodedUrl[4])));
		$data['ac'] = base64_decode(base64_decode($this->removeEqualSign($explodedUrl[5])));
		$data['cc'] = base64_decode(base64_decode($this->removeEqualSign($explodedUrl[6])));
		$data['pid'] = base64_decode(base64_decode($this->removeEqualSign($explodedUrl[7])));
		$data['ps'] = base64_decode(base64_decode($this->removeEqualSign($explodedUrl[8])));
		$data['pe'] = base64_decode(base64_decode($this->removeEqualSign($explodedUrl[9])));
		$data['ic'] = base64_decode(base64_decode($this->removeEqualSign($explodedUrl[10])));

		$data['activeTab'] = 'booking';
		$data['pageMain'] = $this->Front_model->fetchPage(37);
		$data['countries'] = $this->Front_model->commonFetch(['*'],'country');
		$data['specialRequests'] = $this->Front_model->commonFetch(['*'],'booking_special_requests');
		$data['moreRequests'] = $this->Front_model->commonFetch(['*'],'booking_more_requests');

		$data['resortDetail'] = $this->Front_model->getAccomForMail($data['accomId']);
		$data['mealPlans'] = $this->Front_model->fetchPackageMealPlans($data['pid']);
		$data['packageTransfers'] = $this->Front_model->fetchPackageTransfers($data['pid']);

		$totalPaxCount = (int)$data['ac'] + (int)$data['cc'];

		// $data['packageOffers'] = $this->Front_model->fetchPackageOffers($data['pid'],$data['roomId'],$data['sd'],$data['ed'],$totalPaxCount);
		$data['packageOffers'] = $this->Front_model->load_offers($data['accomId'],$data['pid'],$data['roomId'],$data['sd'],$data['ed'],$totalPaxCount,200); # country id will be changed.

		$this->load->view('booking', $data);
	}

	public function addToWishlist() {
		try {
			$isLoggedIn = $this->session->userdata('logged_in');
			if (!$isLoggedIn) {
				throw new Exception("You aren't logged in to add the product to your wishlist.");
			}
			$userId = $this->session->userdata('id');
			$resortId = $this->input->post('productId');
			
			$checkExists = $this->Front_model->check_value_exist('wishlist_products', ['user_id' => $userId, 'resort_id' => $resortId]);
			if ($checkExists) {
				throw new Exception("This product is already in your wishlist.");
			}
			$_arr = array(
				'user_id' => $userId,
				'resort_id' => $resortId
			);
			$inserted = $this->Front_model->insert('wishlist_products',$_arr);
			if ($inserted) {
				$msg = array('status' => 'success', 'message' => "Well done! You've successfully added this product to your wishlist.");
			}
		} catch (Exception $x) {
			$msg = array('status' => 'error', 'message' => $x->getMessage());
		}
		echo json_encode($msg);
	}

	public function forgotPassword() {
		try {
			if(!isset($_POST["email"]) && (empty($_POST["email"]))){
				throw new Exception("Please enter your email address.");
			}
			$email = $this->input->post('email');
			$email = filter_var($email, FILTER_SANITIZE_EMAIL);
			$email = filter_var($email, FILTER_VALIDATE_EMAIL);

			if (!$email) {
				throw new Exception("Please enter valid email address.");
			}

			$result = $this->Front_model->commonFetch(['user_id'],'staff_users',['email' => trim($email)],1,'');

			if (empty($result)) {
				throw new Exception("No user is registered with this email.");
			}
			
			$expFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
			$expDate = date("Y-m-d H:i:s",$expFormat);
			$email_as_integer = intval($email);
			$key = md5(2418*2+$email_as_integer);
			$addKey = substr(md5(uniqid(rand(),1)),3,10);
			$key = $key . $addKey;

			$insertList = array(
				'email' => $email,
				'key' => $key,
				'exp_date' => $expDate
			);
			$this->Front_model->insert('password_reset_temp', $insertList);


			$params = 'key='.$key.'&email='.$email.'&action=reset';
			$resetLink = base_url().'forgot-password/reset-password?rsp='.base64_encode(base64_encode($params));

			# Mail Template --------------------------------------------------------------------------------
			$output='<p>Dear user,</p>';
			$output.='<p>Please click on the following link to reset your password.</p>';
			$output.='<p>-------------------------------------------------------------</p>';
			$output.='<p><a href="'.$resetLink.'" target="_blank">'.$resetLink.'</a></p>';		
			$output.='<p>-------------------------------------------------------------</p>';
			$output.='<p>Please be sure to copy the entire link into your browser.
			The link will expire after 1 day for security reason.</p>';
			$output.='<p>If you did not request this forgotten password email, no action 
			is needed, your password will not be reset. However, you may want to log into 
			your account and change your security password as someone may have guessed it.</p>';   	
			$output.='<p>Thanks,</p>';
			$output.='<p>'.COMPANY_NAME.'</p>';
			$body = $output; 
			$subject = "Password Recovery - ".COMPANY_NAME;

			$email_to = $email;
			$fromserver = "noreply@travelxmaldives.com";

            $clheaders = "MIME-Version: 1.0" . "\r\n";
            $clheaders .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $clheaders .= 'From: '.COMPANY_NAME.' <'.$fromserver.'>'."\r\n";
            if (mail($email_to, $subject, $body, $clheaders)) {
				// The email was sent successfully
				$msg = array('status' => 'success', 'message' => 'An email has been sent to you with instructions on how to reset your password.');
			  } else {
				// The email was not sent successfully
				$msg = array('status' => 'error', 'message' => 'Mail sending error.');
			  }

		} catch (Exception $x) {
			$msg = array('status' => 'error', 'message' => $x->getMessage());
		}
		echo json_encode($msg);
	}

	public function resetPasswordPage() {
		$urlParams = $this->input->get('rsp');
		$decodedParams = base64_decode(base64_decode($urlParams));
		$explodedUrl = explode('&', $decodedParams);

		$key = $this->removeEqualSign($explodedUrl[0]);
		$email = $this->removeEqualSign($explodedUrl[1]);
		$curDate = date("Y-m-d H:i:s");

		$row =  $this->Front_model->commonFetch(['*'],'password_reset_temp',['email' => trim($email),'key' => $key],1,'','id','DESC');

		if (empty($row)) {
			$this->session->set_flashdata('invalid_link', 'The link is invalid/expired. Either you did not copy the correct link
			from the email, or you have already used the key in which case it is 
			deactivated.');
			$this->session->set_flashdata('goto_signin', base_url('sign-in'));
			return redirect(base_url('not-found'));
		}

		$expDate = $row->exp_date;
		if (!($expDate >= $curDate)){
			$this->session->set_flashdata('link_expired', 'The link is expired. You are trying to use the expired link which 
			as valid only 24 hours (1 days after request).');
			$this->session->set_flashdata('goto_home', base_url());
			return redirect(base_url('not-found'));
		}

		$data['activeTab'] = 'resetpw';
		$data['username'] = base64_encode(base64_encode($email));
		$this->load->view('reset_password',$data);
	}

	public function doResetPassword() {
		try {
			$newPassword = $this->input->post('password');
            $confirmNewPassword = $this->input->post('c_password');

			$email = base64_decode(base64_decode($this->input->post('uk_token')));

			if ($newPassword == '' || $newPassword == null) {
                throw new Exception("Please enter your new password.");
            }

            if ($confirmNewPassword == '' || $confirmNewPassword == null) {
                throw new Exception("Please enter your new confirm password.");
            }

			$confirmNewPassword = $this->get_encrypted_password($confirmNewPassword);
            if (!password_verify($newPassword, $confirmNewPassword)) {
                throw new Exception("Your new password and confirm password are not matched.");
            }
			$data['password'] = $this->get_encrypted_password($newPassword);
            $this->Front_model->update(['username' => $email], 'staff_users', $data);
			$this->Front_model->delete('password_reset_temp',['email'=>$email]);

            $msg = array('status' => 'success', 'message' => "Well done! You've successfully updated your password.", 'redirect_to' => base_url('sign-in'));
			
		} catch (Exception $x) {
			$msg = array('status' => 'error', 'message' => $x->getMessage());
		}
		echo json_encode($msg);
	}

	public function calculatePrice() {
		try {
			$packageId = $this->input->post('packageId');
			$accomId = $this->input->post('accomId');
			$roomId = $this->input->post('roomId');
			$startDate = date('Y-m-d', strtotime($this->input->post('startDate')));
			$endDate = date('Y-m-d',strtotime($this->input->post('endDate')));
			$selectedMeal = $this->input->post('selectedMeal') ?? null;
			$selectedTransfer = $this->input->post('selectedTransfer') ?? null;
			$adultCount = $this->input->post('adultCount');
			$childCount = $this->input->post('childCount');
			$roomCount = $this->input->post('roomCount');
			$childAges = $this->input->post('childAges');

			// $packageOffer = $this->input->post('selectedPackOffer') ?? null;

			$ageWiseCount = $this->getTheExactPax($childAges,$accomId); // actual pax based on the selected child ages. its categorized with according to the infant, child and adult.
			
			$adultCount = $adultCount + $ageWiseCount['adult']; // add the new adult count with existing adult count.
			$childCount = $ageWiseCount['child']; // overwrite the new child count to the existing child count.
			$infantCount = $ageWiseCount['infant']; // new infant count.

			$nights = $this->returnNightCount($startDate,$endDate);

			// get the calculated price
			
			$queryArr = array(
                'packageId' => $packageId,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'roomId' => $roomId,
                'adults' => $adultCount,
                'children' => $childCount,
                'infant' => $infantCount,
                'roomCount' => $roomCount,
                'nights' => $nights,
                'mealType' => $selectedMeal,
                'transferType' => $selectedTransfer,
                'resortId' => $accomId
            );

			$final_amount_with_tax_room_and_nights = $this->Front_model->calculatePackagePrice($queryArr,'BOOKING_PAGE');
			// $final_amount_with_tax_room_and_nights = $this->Front_model->calculateActualPrice($packageId,$startDate,$endDate,$roomId,$adultCount,$childCount,$infantCount,$nights,$roomCount,$selectedMeal,$selectedTransfer,$packageOffer,'BOOKING_PAGE');
			
			if ($final_amount_with_tax_room_and_nights === 'SEND_INQUIRY') {
				throw new Exception("SEND INQUIRY");
			}

			$nightsText = $nights > 1 ? 'Nights' : 'Night';
			$adultText = $adultCount > 1 ? 'Adults' : 'Adult';
			$childText = $childCount > 1 ? 'Children' : 'Child';

			$encKey = 'AMTTXMMR@1995';
			$amountEncrypt = $this->encrypt(number_format($final_amount_with_tax_room_and_nights['calculatedPrice'],2),$encKey);
			$iv = $amountEncrypt[1];
			$serialized_amount = serialize($amountEncrypt);

			$returnData = array(
				'nights' => $nights.' '.$nightsText,
				'pax' => $adultCount.' '.$adultText.' + '.$childCount.' '.$childText,
				'final_amount' => $this->currency.''.number_format($final_amount_with_tax_room_and_nights['calculatedPrice'],2),
				'actual_amount' => $final_amount_with_tax_room_and_nights['calculatedPrice'],
				'enc_amt' => base64_encode($serialized_amount),
				'iv' => base64_encode($iv)
			);
			$msg = array('status' => 'success', 'message' => 'final amount calculated', 'final_data' => $returnData);

		} catch (Exception $x) {
			$msg = array('status' => 'NO_DATA', 'message' => $x->getMessage());
		}
		echo json_encode($msg);
	}

	private function getTheCommission($percentage,$amount) {
		return floatval($percentage / 100) * floatval($amount);
	}
	
	private function returnNightCount($startDate,$endDate) {
		$date1 = new DateTime($startDate);
		$date2 = new DateTime($endDate);

		$interval = $date1->diff($date2);
        $nightsCount = $interval->days; // because of the hotel booking, start date's night also included.
		return $nightsCount;
	}

	private function getTheExactPax($ageArr,$accomId) {
		$result = $this->Front_model->getTheExactPax($ageArr,$accomId);
		return $result;
	}

	public function submitBooking() {
		try {
			$user_id = $this->input->post('user_id');
			$user_id = $user_id == 0 ? NULL : $user_id;
			$isRegistered = 0;
			if ($user_id != 0 && $user_id != NULL) {
				$isRegistered = 1;
			}

			$packageId = $this->input->post('packageId');

			$full_name = $this->input->post('full_name');
			$email = $this->input->post('email');
			$phone = $this->input->post('phone');
			$input_country = $this->input->post('input_country');

			$input_special_request = $this->input->post('input_special_request');
			
			$message = $this->input->post('message');
			$additional_notes = $this->input->post('additional_notes');

			$guest_name = null;
			$input_guest_country = null;
			if (isset($_POST['select_for_someone'])) {
				$guest_name = $this->input->post('guest_name');
				$input_guest_country = $this->input->post('input_guest_country');
			}

			$select_more_req = array();
			if (isset($_POST['select_more_req'])) {
				$select_more_req = $this->input->post('select_more_req');
			}
			
			$flight_ticket = $this->input->post('flight_ticket');
			$arrival_flight_number = null;
			$arrival_date = null;
			$depature_flight_number = null;
			$depature_date = null;
			if ($flight_ticket == 1) {
				$arrival_flight_number = $this->input->post('arrival_flight_number');
				$arrival_date = date('Y-m-d',strtotime($this->input->post('arrival_date')));
				$depature_flight_number = $this->input->post('depature_flight_number');
				$depature_date = date('Y-m-d',strtotime($this->input->post('depature_date')));
			}

			$startDate = date('Y-m-d',strtotime($this->input->post('startDate')));
			$endDate = date('Y-m-d',strtotime($this->input->post('endDate')));

			$selectedMeal = $this->input->post('selectedMeal');
			$selectedTransfer = $this->input->post('selectedTransfer');
			$roomCount = $this->input->post('roomCount');
			$adultCount = $this->input->post('adultCount');
			$childCount = $this->input->post('childCount');
			$accomId = $this->input->post('accomId');
			$roomId = $this->input->post('roomId');
			$nightCount = $this->input->post('nightCount');

			$paid_method = $this->input->post('paid_method');

			$bookingNumber = $this->generateRandomString(8,'booking','booking_number','BKG');

			$enc_amt = base64_decode($this->input->post('enc_amt'));
			$iv = base64_decode($this->input->post('iv'));
			
			$encKey = 'AMTTXMMR@1995';
			$dec_amount = $this->decrypt(unserialize($enc_amt)[0], $encKey, $iv);
			
			$_arr = array(
				'booking_number' => $bookingNumber, 
				'is_registered' => $isRegistered,
				'user_id' => $user_id,
				'full_name' => $full_name,
				'email' => $email,
				'phone' => $phone,
				'country_id' => $input_country,
				'special_request' => $input_special_request,
				'message' => $message,
				'guest_full_name' => $guest_name,
				'guest_country_id' => $input_guest_country,
				'more_requests' => implode('|',$select_more_req),
				'additional_notes' => $additional_notes,
				'is_flight_booked' => $flight_ticket,
				'flight_arrival_number' => $arrival_flight_number,
				'flight_arrival_date' => $arrival_date,
				'flight_depature_number' => $depature_flight_number,
				'flight_depature_date' => $depature_date,
				'paid_method' => $paid_method,
				'package_id' => $packageId,
				'ho_id' => $accomId,
				'room_id' => $roomId,
				'checkin_date' => $startDate,
				'checkout_date' => $endDate,
				'adult' => $adultCount,
				'child' => $childCount,
				'room_count' => $roomCount,
				'no_of_nights' => $nightCount,
				'meal_type_id' => $selectedMeal,
				'transfer_type_id' => $selectedTransfer,
				'total_amount' => (float) str_replace(',', '', $dec_amount)
			);
			$inserted = $this->Front_model->insert('booking', $_arr);
			$msg = array('status' => 'error', 'message' => 'Something went wrong :(');
			if ($inserted) {
				$lastAdded = $this->Front_model->getBookingDetail($inserted);
				$msg = array('status' => 'success', 'message' => 'Your booking was submitted successfully.', 'added_booking' => $lastAdded);


				// Thank you mail to customer.=========================================================================================================
				$clmail_temp = file_get_contents(base_url().'assets/mail/thankuforbooking.html');

				$booked_detail = 	'<li><strong>Booking Number:</strong> '.$lastAdded->booking_number.'</li>
									<li><strong>Email:</strong> '.$lastAdded->email.'</li>
									<li><strong>Phone:</strong> '.$lastAdded->phone.'</li>
									<li><strong>Country:</strong> '.$lastAdded->my_country.'</li>';
				if ($lastAdded->guest_full_name != '') {
					$booked_detail .= '<li><strong>Guest name:</strong> '.$lastAdded->guest_full_name.'</li>';
				}
				if ($lastAdded->guest_country_id != '' && $lastAdded->guest_country_id != NULL) {
					$booked_detail .= '<li><strong>Guest country:</strong> '.$lastAdded->guest_country.'</li>';
				}
				$totalPax = (int)$lastAdded->adult + (int)$lastAdded->child;
				$booked_detail .= 	'<li><strong>Check in:</strong> '.date('d/m/Y',strtotime($lastAdded->checkin_date)).'</li>
									<li><strong>Check out:</strong> '.date('d/m/Y',strtotime($lastAdded->checkout_date)).'</li>
									<li><strong>Hotel/Resort:</strong> '.$lastAdded->hotel_name.'</li>
									<li><strong>Room:</strong> '.$lastAdded->room_title.'</li>
									<li><strong>Pax:</strong> '.$totalPax.'</li>
									<li><strong>Stay:</strong> '.$lastAdded->no_of_nights.' Nights</li>
									<li><strong>Meal plan:</strong> '.$lastAdded->meal_plan.'</li>
									<li><strong>Transfer method:</strong> '.$lastAdded->transfer_type.'</li>
									<li><strong>Special Request:</strong> '.$lastAdded->special_request_title.'</li>';
				if ($lastAdded->more_requests != '' && $lastAdded->more_requests != NULL) {
					$moreReq = explode('|', $lastAdded->more_requests);
					$req = '';
					foreach ($moreReq as $key => $value) {
						$req .= $value.'<br/>';
					}
					$booked_detail .= '<li><strong>More requests:</strong> '.$req.'</li>';
				}

				if ($lastAdded->additional_notes != '' && $lastAdded->additional_notes != NULL) {
					$booked_detail .= '<li><strong>Additional notes:</strong> '.$lastAdded->additional_notes.'</li>';
				}

				$isFlightBooked = '';
				switch ($lastAdded->is_flight_booked) {
					case '0':
						$isFlightBooked = 'No';
						$booked_detail .= '<li><strong>Is flight booked:</strong> '.$isFlightBooked.'</li>';
						break;
					case '1':
						$isFlightBooked = 'Yes';
						$booked_detail .= 	'<li><strong>Is flight booked:</strong> '.$isFlightBooked.'</li>
											<li><strong>Flight arrival date:</strong> '.date('d/m/Y',strtotime($lastAdded->flight_arrival_date)).'</li>
											<li><strong>Flight arrival number:</strong> '.$lastAdded->flight_arrival_number.'</li>
											<li><strong>Flight depature date:</strong> '.date('d/m/Y',strtotime($lastAdded->flight_depature_date)).'</li>
											<li><strong>Flight depature number:</strong> '.$lastAdded->flight_depature_number.'</li>';
						break;
					case '2':
						$isFlightBooked = 'I will book after confirmation';
						$booked_detail .= 	'<li><strong>Is flight booked:</strong> '.$isFlightBooked.'</li>';
						break;
					
					default:
						$isFlightBooked = 'No';
						$booked_detail .= 	'<li><strong>Is flight booked:</strong> '.$isFlightBooked.'</li>';
						break;
				}

				$clreport_rep = array(
					'[logo]' => base_url().'assets/img/web-logo-black.png',
					'[company_name]' => COMPANY_NAME,
					'[customer_name]' => $full_name,
					'[booking_detail]' => $booked_detail,
					'[company_mail]' => COMMON_MAIL_ID,
					'[hotel_name]' => $lastAdded->hotel_name

				);
				$clsubject = 'We have recieved your booking - '.COMPANY_NAME;
				$clheaders = "MIME-Version: 1.0" . "\r\n";
				$clheaders .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$clheaders .= 'From: '.COMPANY_NAME.' <'.COMMON_MAIL_ID.'>'."\r\n";
				$clmail_temp = strtr($clmail_temp, $clreport_rep);
				mail($email,$clsubject,$clmail_temp,$clheaders);
				# ======================================================================================================================================================

				// Mail to system owner ================================================================================================================================
				$admin_temp = file_get_contents(base_url().'assets/mail/bookingmail.html');

				$hotelImages = $this->Front_model->getAppropriatePhotos($lastAdded->ho_id,'hotels');
				$hotelImg = PHOTO_DOMAIN.'default.jpg';
				if (!empty($hotelImages)) {
					$hotelImg = PHOTO_DOMAIN.'hotels/'.$hotelImages[0]->photo_path.'-std.jpg';
				}
				$starRating = number_format($lastAdded->stars,1);

				$admin_booking_detail = '<p style="margin-top: 5px"><strong>Name:</strong> '.$lastAdded->full_name.'</p>
										<p style="margin-top: 5px"><strong>Booking Number:</strong> '.$lastAdded->booking_number.'</p>
										<p style="margin-top: 5px"><strong>Email:</strong> '.$lastAdded->email.'</p>
										<p style="margin-top: 5px"><strong>Phone:</strong> '.$lastAdded->phone.'</p>
										<p style="margin-top: 5px"><strong>Country:</strong> '.$lastAdded->my_country.'</p>';
				if ($lastAdded->guest_full_name != '') {
					$admin_booking_detail .= '<p style="margin-top: 5px"><strong>Guest name:</strong> '.$lastAdded->guest_full_name.'</p>';
				}
				if ($lastAdded->guest_country_id != '' && $lastAdded->guest_country_id != NULL) {
					$admin_booking_detail .= '<p style="margin-top: 5px"><strong>Guest country:</strong> '.$lastAdded->guest_country.'</p>';
				}
				$adminTotalPax = (int)$lastAdded->adult + (int)$lastAdded->child;
				$admin_booking_detail .= 	'<p style="margin-top: 5px"><strong>Check in:</strong> '.date('d/m/Y',strtotime($lastAdded->checkin_date)).'</p>
											<p style="margin-top: 5px"><strong>Check out:</strong> '.date('d/m/Y',strtotime($lastAdded->checkout_date)).'</p>
											<p style="margin-top: 5px"><strong>Room:</strong> '.$lastAdded->room_title.'</p>
											<p style="margin-top: 5px"><strong>Pax:</strong> '.$adminTotalPax.'</p>
											<p style="margin-top: 5px"><strong>Stay:</strong> '.$lastAdded->no_of_nights.' Nights</p>
											<p style="margin-top: 5px"><strong>Meal plan:</strong> '.$lastAdded->meal_plan.'</p>
											<p style="margin-top: 5px"><strong>Transfer method:</strong> '.$lastAdded->transfer_type.'</p>
											<p style="margin-top: 5px"><strong>Special Request:</strong> '.$lastAdded->special_request_title.'</p>';

				if ($lastAdded->more_requests != '' && $lastAdded->more_requests != NULL) {
					$adminMoreReq = explode('|', $lastAdded->more_requests);
					$adminReq = '';
					foreach ($adminMoreReq as $k => $v) {
						$adminReq .= $v.'<br/>';
					}
					$admin_booking_detail .= '<p style="margin-top: 5px"><strong>More requests:</strong> '.$adminReq.'</p>';
				}

				if ($lastAdded->additional_notes != '' && $lastAdded->additional_notes != NULL) {
					$admin_booking_detail .= '<p style="margin-top: 5px"><strong>Additional notes:</strong> '.$lastAdded->additional_notes.'</p>';
				}		
						
				$adminIsFlightBooked = '';
				switch ($lastAdded->is_flight_booked) {
					case '0':
						$adminIsFlightBooked = 'No';
						$admin_booking_detail .= '<p style="margin-top: 5px"><strong>Is flight booked:</strong> '.$adminIsFlightBooked.'</p>';
						break;
					case '1':
						$adminIsFlightBooked = 'Yes';
						$admin_booking_detail .= 	'<p style="margin-top: 5px"><strong>Is flight booked:</strong> '.$adminIsFlightBooked.'</p>
													<p style="margin-top: 5px"><strong>Flight arrival date:</strong> '.date('d/m/Y',strtotime($lastAdded->flight_arrival_date)).'</p>
													<p style="margin-top: 5px"><strong>Flight arrival number:</strong> '.$lastAdded->flight_arrival_number.'</p>
													<p style="margin-top: 5px"><strong>Flight depature date:</strong> '.date('d/m/Y',strtotime($lastAdded->flight_depature_date)).'</p>
													<p style="margin-top: 5px"><strong>Flight depature number:</strong> '.$lastAdded->flight_depature_number.'</p>';
						break;
					case '2':
						$adminIsFlightBooked = 'I will book after confirmation';
						$admin_booking_detail .= 	'<p style="margin-top: 5px"><strong>Is flight booked:</strong> '.$adminIsFlightBooked.'</p>';
						break;
					
					default:
						$adminIsFlightBooked = 'No';
						$admin_booking_detail .= 	'<p style="margin-top: 5px"><strong>Is flight booked:</strong> '.$adminIsFlightBooked.'</p>';
						break;
				}

				$adreport_rep = array(
					'[logo]' => base_url().'assets/img/web-logo-black.png',
					'[company_name]' => COMPANY_NAME,
					'[hotel_image]' => $hotelImg,
					'[hotel_name]' => $lastAdded->hotel_name,
					'[hotel_rating]' => $starRating,
					'[hotel_star]' => str_repeat('&#9733;',$lastAdded->stars),
					'[booking_detail]' => $admin_booking_detail,
				);

				$admin_mail_subject = 'You have recieved new booking - '.COMPANY_NAME;
				$admin_mail_headers = "MIME-Version: 1.0" . "\r\n";
				$admin_mail_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$admin_mail_headers .= 'From: '.$lastAdded->full_name.' <'.$email.'>'."\r\n";
				$admin_mail_mail_temp = strtr($admin_temp, $adreport_rep);
				mail(COMMON_MAIL_ID,$admin_mail_subject,$admin_mail_mail_temp,$admin_mail_headers);
			}
		} catch (Exception $x) {
			$msg = array('status' => 'error', 'message' => $x->getMessage());
		}
		echo json_encode($msg);
	}

	public function copyPrice($seasonId, $passId) {
		return false;
		// $result = $this->Front_model->get_data_by_id($seasonId, $passId);
	}
}