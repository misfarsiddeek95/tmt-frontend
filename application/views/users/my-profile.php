<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view('includes/head'); ?>
        <link rel="stylesheet" href="<?=base_url()?>assets/css/toastr.min.css">
        <title>My Profile</title>
        <style>
            label.error {
                display: block;
                color: red;
            }
        </style>
    </head>

    <body data-barba="wrapper">
        <?php $this->load->view('includes/preloader'); ?>
        <?php $this->load->view('users/includes/topbar'); ?>

        <div class="dashboard" data-x="dashboard" data-x-toggle="-is-sidebar-open">
            <?php $this->load->view('users/includes/sidebar'); ?>

            <div class="dashboard__main">
                <div class="dashboard__content bg-light-2">
                    <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
                        <div class="col-auto">
                            <h1 class="text-30 lh-14 fw-600">Profile</h1>
                            <div class="text-15 text-light-1">
                                Find your profile detail below.
                            </div>
                        </div>

                        <div class="col-auto"></div>
                    </div>
                    <div class="py-30 px-30 rounded-4 bg-white shadow-3">
                        <div class="tabs -underline-2 js-tabs">
                            <div class="tabs__controls row x-gap-40 y-gap-10 lg:x-gap-20 js-tabs-controls">
                                <div class="col-auto">
                                    <button
                                        class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 js-tabs-button is-tab-el-active"
                                        data-tab-target=".-tab-item-1">
                                        Personal Information
                                    </button>
                                </div>

                                <div class="col-auto">
                                    <button
                                        class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 js-tabs-button"
                                        data-tab-target=".-tab-item-3">
                                        Change Password
                                    </button>
                                </div>
                            </div>

                            <div class="tabs__content pt-30 js-tabs-content">
                                <div class="tabs__pane -tab-item-1 is-tab-el-active">
                                    <div class="row y-gap-30 items-center">
                                        <div class="col-auto">
                                            <div class="d-flex ratio ratio-1:1 w-200" id="image-wrap">
                                                <?php 
                                                    $hasImg = false;
                                                    $img = PHOTO_DOMAIN.'user_default.jpg';
                                                    if ($profileDetail->user_pic != null & $profileDetail->user_pic != '') {
                                                        $hasImg = true;
                                                        $img = PHOTO_DOMAIN.'staff/'.$profileDetail->user_pic;
                                                    }
                                                ?>
                                                <img src="<?=$img?>" alt="image" id="avatar-preview" class="img-ratio rounded-4" old-image="<?=$img?>" />
                                                <?php if($hasImg) {?>
                                                <div class="d-flex justify-end px-10 py-10 h-100 w-1/1 absolute" id="delete-btn">
                                                    <button class="button -red-1 bg-error-2 size-30 rounded-full shadow-2 text-white-50" id="remove-image">
                                                        <i class="icon-trash text-15 fw-700 text-white"></i>
                                                    </button>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <form method="POST" class="col-auto" enctype="multipart/form-data" id="image-upload-form">
                                            <div class="row y-gap-30 items-center">
                                                <div class="col-auto">
                                                    <h4 class="text-16 fw-500">Your avatar</h4>
                                                    <div class="text-14 mt-5">
                                                        PNG or JPG no bigger than 4MB.
                                                    </div>

                                                    <div class="d-inline-block mt-15">
                                                        <input type="file" id="avatar-upload" name="avatar" accept=".jpg,.jpeg,.png" style="display: none;">
                                                        <label for="avatar-upload" class="button h-50 px-24 -dark-1 bg-blue-1 text-white">
                                                            <i class="icon-upload-file text-20 mr-10"></i>
                                                            Browse
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-auto action-buttons">
                                                    <div class="d-inline-block mt-15">
                                                        <button type="submit" class="button h-50 px-24 -dark-1 bg-info-2 text-white" id="upload-button">
                                                            <i class="icon-check text-20 mr-10"></i>
                                                            Save
                                                        </button>
                                                    </div>
                                                </div>    
                                                <div class="col-auto action-buttons">
                                                    <div class="d-inline-block mt-15">
                                                        <button type="button" id="cancel" class="button h-50 px-24 -dark-1 bg-red-2 text-white">
                                                            <i class="icon-close text-20 mr-10"></i>
                                                            Clear
                                                        </button>
                                                    </div>
                                                </div>   
                                            </div>
                                        </form> 
                                    </div>

                                    <div class="border-top-light mt-30 mb-30"></div>

                                    <form method="POST" class="needs-validation">
                                        <div class="col-xl-9">
                                            <div class="row x-gap-20 y-gap-20">
                                                <div class="col-12" id="error-message-div">
                                                    <div class="d-flex items-center justify-between bg-error-1 pl-30 pr-20 py-30 rounded-8">
                                                        <div class="text-error-2 lh-1 fw-500" id="error-message"></div>
                                                        <div class="text-error-2 text-14 icon-close"></div>
                                                    </div>
                                                </div>
                                                <div class="col-12" id="success-message-div">
                                                    <div class="d-flex items-center justify-between bg-green-1 pl-30 pr-20 py-30 rounded-8">
                                                        <div class="text-green-2 lh-1 fw-500" id="success-message"></div>
                                                        <div class="text-green-2 text-14 icon-close"></div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-input">
                                                        <input type="text" required name="username" id="username" value="<?= $profileDetail->username != '' ? $profileDetail->username : '' ?>"/>
                                                        <label class="lh-1 text-16 text-light-1" id="username">User Name</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-input">
                                                        <input type="text" required name="fname" id="fname" value="<?= $profileDetail->fname != '' ? $profileDetail->fname : '' ?>" />
                                                        <label class="lh-1 text-16 text-light-1">First Name</label >
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-input">
                                                        <input type="text" required name="lname" id="lname" value="<?= $profileDetail->lname != '' ? $profileDetail->lname : '' ?>"/>
                                                        <label class="lh-1 text-16 text-light-1">Last Name</label >
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-input">
                                                        <input type="email" required name="email" id="email" value="<?= $profileDetail->email != '' ? $profileDetail->email : '' ?>"/>
                                                        <label class="lh-1 text-16 text-light-1">Email</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-input">
                                                        <input type="text" name="phone" id="phone" value="<?= $profileDetail->phone != '' ? $profileDetail->phone : '' ?>" />
                                                        <label class="lh-1 text-16 text-light-1">Phone Number</label >
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-input">
                                                        <input type="date" name="dob" id="dob" value="<?= $profileDetail->dob != '' ? date('Y-m-d', strtotime($profileDetail->dob)) : '' ?>" />
                                                        <label class="lh-1 text-16 text-light-1">Birthday</label >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="d-inline-block pt-30">
                                            <button type="submit" class="button h-50 px-24 -dark-1 bg-blue-1 text-white" id="submitText">
                                                Save Changes
                                                <div class="icon-arrow-top-right ml-15"></div>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <div class="tabs__pane -tab-item-3">
                                    <div class="col-12" id="pw-error-message-div">
                                        <div class="d-flex items-center justify-between bg-error-1 pl-30 pr-20 py-30 rounded-8">
                                            <div class="text-error-2 lh-1 fw-500" id="pw-error-message"></div>
                                            <div class="text-error-2 text-14 icon-close"></div>
                                        </div>
                                    </div>
                                    <div class="col-12" id="pw-success-message-div">
                                        <div class="d-flex items-center justify-between bg-green-1 pl-30 pr-20 py-30 rounded-8">
                                            <div class="text-green-2 lh-1 fw-500" id="pw-success-message"></div>
                                            <div class="text-green-2 text-14 icon-close"></div>
                                        </div>
                                    </div>
                                    <form method="POST" class="password-form">
                                        <div class="col-xl-9">
                                            <div class="row x-gap-20 y-gap-20">
                                                <div class="col-12">
                                                    <div class="form-input">
                                                        <input type="password" required name="current_password" id="current_password"/>
                                                        <label class="lh-1 text-16 text-light-1" for="current_password">Current Password</label >
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-input">
                                                        <input type="password" required name="new_password" id="new_password" />
                                                        <label class="lh-1 text-16 text-light-1" for="new_password">New Password</label >
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-input">
                                                        <input type="password" required name="c_new_password" id="c_new_password" />
                                                        <label class="lh-1 text-16 text-light-1" for="c_new_password">New Password Again</label >
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="row x-gap-10 y-gap-10">
                                                        <div class="col-auto">
                                                            <button type="submit" class="button h-50 px-24 -dark-1 bg-blue-1 text-white" id="passwordBtn">
                                                                Save Changes
                                                                <div class="icon-arrow-top-right ml-15"></div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php $this->load->view('users/includes/footer'); ?>
                </div>
            </div>
        </div>

        <!-- JavaScript -->
        <?php $this->load->view('includes/js'); ?>
        <script src="<?=base_url()?>assets/js/toastr.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#error-message-div,#success-message-div,.action-buttons,#pw-error-message-div,#pw-success-message-div').hide();
            });

            $('form.needs-validation').validate({
                // Validation rules for each input field
                rules: {
                    username: {
                        required: true
                    },
                    fname: {
                        required: true
                    },
                    lname: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    }
                },
                // Validation messages for each input field
                messages: {
                    username: {
                        required: "Please enter your username"
                    },
                    fname: {
                        required: "Please enter your first name"
                    },
                    lname: {
                        required: "Please enter your last name"
                    },
                    email: {
                        required: "Please enter your email address",
                        email: "Please enter a valid email address"
                    }
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                // Submit handler for the form
                submitHandler: function(form) {
                    $('#submitText').text('Loading...');
                    $('#error-message-div,#success-message-div').hide();
                    // Serialize the form data
                    var formData = $(form).serialize();

                    // Submit the form using AJAX
                    $.ajax({
                        type: "POST",
                        url: "<?=base_url()?>update-user-detail",
                        data: formData,
                        success: function(response) {
                            // Handle the response from the server
                            const resp = $.parseJSON(response);
                            var elementId = '';
                            if (resp.status == 'success') {
                                elementId = '#success-message-div';
                                $('#submitText').prop('disabled', true);
                                $('#submitText').text('Submitted');
                                $('#success-message-div').show();
                                $('#success-message').html(resp.message);
                                setTimeout(() => {
                                    $('#success-message').html('');
                                    $('#success-message-div').hide();
                                    $('#submitText').html('Save Changes<div class="icon-arrow-top-right ml-15"></div>');
                                    $('#submitText').prop('disabled', false);
                                }, 3000);
                            } else {
                                elementId = '#error-message-div';
                                $('#error-message-div').show();
                                $('#error-message').html(resp.message);
                                $('#submitText').text('Submit Again');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            // Handle errors that occur during the AJAX request
                            console.log(textStatus, errorThrown);
                        }
                    });
                }
            });

            const fileInput = document.getElementById("avatar-upload");
            const previewImg = document.getElementById("avatar-preview");
            const cancelButton = document.getElementById("cancel");

            fileInput.addEventListener("change", function() {
                const file = this.files[0];
                if (file) {
                const allowedTypes = ["image/jpeg", "image/png"];
                const fileType = file.type;
                if (allowedTypes.indexOf(fileType) !== -1) {
                    const reader = new FileReader();
                    reader.addEventListener("load", function() {
                        previewImg.setAttribute("src", this.result);
                    });
                    reader.readAsDataURL(file);
                    $('.action-buttons').show();
                } else {
                    toastr.error("Invalid file type. Please select a JPG or PNG image.");
                    this.value = ""; // reset the file input to clear the selection
                }
                }
            });

            cancelButton.addEventListener("click", function() {
                fileInput.value = ""; // reset the file input to clear the selection
                const oldImage = $('#avatar-preview').attr('old-image');
                previewImg.setAttribute("src", oldImage);
                $('.action-buttons').hide();
            });

            const $form = $("#image-upload-form");
            const $submitButton = $("#upload-button");

            $form.on("submit", function(event) {
                event.preventDefault();

                $submitButton.prop("disabled", true); // disable submit button while uploading
                $submitButton.text('Uploading...');
                const formData = new FormData(this);

                $.ajax({
                    url: "<?=base_url()?>upload-avatar",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        const resp = $.parseJSON(response);
                        if (resp.status == 'success') {
                            toastr.success(resp.message);
                            $('#profile-picture').attr('src', resp.imgpath)
                            if ($('#delete-btn').length > 0) {
                                $('#delete-btn').remove();
                            }
                            const deleteBtn =   `<div class="d-flex justify-end px-10 py-10 h-100 w-1/1 absolute" id="delete-btn">
                                                    <button class="button -red-1 bg-error-2 size-30 rounded-full shadow-2 text-white-50" id="remove-image">
                                                        <i class="icon-trash text-15 fw-700 text-white"></i>
                                                    </button>
                                                </div>`;
                            $('#image-wrap').append(deleteBtn);
                        } else {
                            toastr.error(resp.message);
                        }
                        $('.action-buttons').hide();
                        $submitButton.prop("disabled", false); // re-enable submit button
                        $submitButton.html('<i class="icon-check text-20 mr-10"></i> Save');
                    },
                    error: function() {
                        alert("Error uploading image.");
                        $submitButton.prop("disabled", false); // re-enable submit button
                    }
                });
            });

            $(document).on('click', '#remove-image', function () {
                toastr.warning(
                    "<button type='button' id='confirmBtn' class='bg-red-2 text-white-50 fw-600' style='width:40%;display:inline;margin:3px;'>Yes</button><button type='button' id='closeBtn' class='bg-light-1 text-white-50 fw-600' style='width:40%;display:inline;margin:3px;'>No</button>",
                    'Do you want to remove this image?', {
                    closeButton: true,
                    allowHtml: true,
                    onShown: function (toast) {
                        $("#confirmBtn").click(function () {
                            const isLoggedIn = '<?=$this->session->userdata('logged_in')?>';
                            if (!isLoggedIn) {
                                return toastr.error("You aren't logged in to remove the image.");
                            }
                            $.ajax({
                                type:'POST',
                                url:'<?=base_url()?>remove-avatar',
                                success:function(result){
                                    var resp = $.parseJSON(result);
                                    if (resp.status == 'success') {
                                        toastr.success(resp.message);
                                        $('#profile-picture').attr('src', resp.imgpath);
                                        $("#delete-btn").remove();
                                        $('#avatar-preview').attr('src',resp.imgpath)
                                        $('#avatar-preview').attr('old-image',resp.imgpath)
                                    } else {
                                        toastr.warning(resp.message);
                                    }
                                },
                                error:function(result){
                                    toastr.error('Something went wrong :(');
                                }
                            });
                        });
                        $("#closeBtn").click(function () {
                            toastr.clear()
                        });
                    }
                });
            });

            $('form.password-form').validate({
                // Validation rules for each input field
                rules: {
                    current_password: {
                        required: true
                    },
                    new_password: {
                        required: true
                    },
                    c_new_password: {
                        required: true,
                        equalTo: "#new_password"
                    }
                },
                // Validation messages for each input field
                messages: {
                    current_password: {
                        required: "Please enter your current password"
                    },
                    new_password: {
                        required: "Please enter your new password"
                    },
                    c_new_password: {
                        required : 'Confirm Password is required',
			   		    equalTo : 'Password is not matching',
                    }
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                // Submit handler for the form
                submitHandler: function(form) {
                    $('#passwordBtn').text('Loading...');
                    $('#pw-error-message-div').hide();
                    // Serialize the form data
                    var formData = $(form).serialize();

                    // Submit the form using AJAX
                    $.ajax({
                        type: "POST",
                        url: "<?=base_url()?>change-password",
                        data: formData,
                        success: function(response) {
                            // Handle the response from the server
                            const resp = $.parseJSON(response);
                            if (resp.status == 'success') {
                                elementId = '#pw-success-message-div';
                                $('#passwordBtn').prop('disabled', true);
                                $('#passwordBtn').text('Submitted');
                                $('#pw-success-message-div').show();
                                $('#pw-success-message').html(resp.message);
                                setTimeout(() => {
                                    $('#pw-success-message').html('');
                                    $('#pw-success-message-div').hide();
                                    $('#passwordBtn').html('Save Changes<div class="icon-arrow-top-right ml-15"></div>');
                                    $('#passwordBtn').prop('disabled', false);
                                }, 3000);
                                $(".password-form")[0].reset();
                            } else {
                                $('#pw-error-message-div').show();
                                $('#pw-error-message').html(resp.message);
                                $('#passwordBtn').prop('disabled', false);
                                $('#passwordBtn').html('Save Again<div class="icon-arrow-top-right ml-15"></div>');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            // Handle errors that occur during the AJAX request
                            console.log(textStatus, errorThrown);
                        }
                    });
                }
            });
        </script>
    </body>
</html>