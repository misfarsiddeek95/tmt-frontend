<!DOCTYPE html>
<html lang="en" data-x="html" data-x-toggle="html-overflow-hidden">
    <head>
        <meta content="<?=$pageMain->seo_keywords != '' ? $pageMain->seo_keywords : '' ?>" name="keywords">
        <meta content="<?=$pageMain->seo_description != '' ? $pageMain->seo_description : '' ?>" name="description">
        <title><?=$pageMain->seo_title != '' ? $pageMain->seo_title : 'Signup' ?></title>
        <?php $this->load->view('includes/head'); ?>
        <style>
            label.error {
                display: block;
                color: red;
            }
        </style>
    </head>
    <body>
        <?php $this->load->view('includes/preloader'); ?>

        <main>
            <?php $this->load->view('includes/header'); ?>

            <section class="layout-pt-lg layout-pb-lg bg-blue-2">
                <div class="container">
                    <div class="row justify-center">
                        <div class="col-xl-6 col-lg-7 col-md-9">
                            <div class="px-50 py-50 sm:px-20 sm:py-20 bg-white shadow-4 rounded-4">
                                <?php
                                    $redirect_url = '';
                                    $redirect_with_r = '';
                                    if (isset($_GET['r'])) {
                                        $redirect_url = $_GET['r'];
                                        $redirect_with_r = '?r='.$redirect_url;
                                    }
                                ?>
                                <form class="needs-validation" method="POST">
                                    <div class="row y-gap-20">
                                        <div class="col-12">
                                            <h1 class="text-22 fw-500"><?=$pageMain->headline?></h1>
                                            <p class="mt-10">Already have an account?
                                                <a href="<?=base_url('sign-in'.$redirect_with_r);?>" class="text-blue-1">Log in</a>
                                            </p>
                                        </div>
                                        <div class="col-12" id="error-message-div">
                                            <div class="d-flex items-center justify-between bg-error-1 pl-30 pr-20 py-30 rounded-8">
                                                <div class="text-error-2 lh-1 fw-500" id="error-message"></div>
                                                <div class="text-error-2 text-14 icon-close"></div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-input">
                                                <input type="text" required="" name="first_name" />
                                                <label class="lh-1 text-14 text-light-1">First Name</label>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-input ">
                                                <input type="text" required="" name="last_name" />
                                                <label class="lh-1 text-14 text-light-1">Last Name</label>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-input ">
                                                <input type="email" required="" name="email" />
                                                <label class="lh-1 text-14 text-light-1">Email</label>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-input ">
                                                <input type="password" required="" name="password" id="password" />
                                                <label class="lh-1 text-14 text-light-1">Password</label>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-input ">
                                                <input type="password" required="" name="c_password" id="c_password" />
                                                <label class="lh-1 text-14 text-light-1">Confirm Password</label>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-flex ">
                                                <div class="form-checkbox mt-5">
                                                    <input type="checkbox" name="use_to_subscribe"  />
                                                    <div class="form-checkbox__mark">
                                                        <div class="form-checkbox__icon icon-check"></div>
                                                    </div>
                                                </div>
                                                <div class="text-15 lh-15 text-light-1 ml-10">Email me exclusive Agoda
                                                    promotions. I can opt out later as stated in the Privacy Policy.</div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="rval" id="rval" value="<?=$redirect_url?>" />
                                        <div class="col-12">
                                            <button type="submit" class="button px-24 h-50 -dark-1 bg-blue-1 text-white" style="width: 100%;">
                                                <span id="submitText">Sign Up</span>
                                                <div class="icon-arrow-top-right ml-15"></div>
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <div class="row y-gap-20 pt-30">
                                    <div class="col-12">
                                        <div class="text-center">or sign in with</div>

                                        <button class="button col-12 -outline-blue-1 text-blue-1 py-15 rounded-8 mt-10">
                                            <i class="icon-apple text-15 mr-10"></i>
                                            Facebook
                                        </button>

                                        <button class="button col-12 -outline-red-1 text-red-1 py-15 rounded-8 mt-15">
                                            <i class="icon-apple text-15 mr-10"></i>
                                            Google
                                        </button>

                                        <button class="button col-12 -outline-dark-2 text-dark-2 py-15 rounded-8 mt-15">
                                            <i class="icon-apple text-15 mr-10"></i>
                                            Apple
                                        </button>
                                    </div>

                                    <div class="col-12">
                                        <div class="text-center px-30">By signing in, I agree to GoTrip Terms of Use and Privacy Policy.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <?php $this->load->view('includes/subscribe'); ?>
            <?php $this->load->view('includes/footer'); ?>
        </main>
        <?php $this->load->view('includes/js'); ?>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#error-message-div').hide();
            });

            $('form.needs-validation').validate({
                // Validation rules for each input field
                rules: {
                    first_name: {
                        required: true
                    },
                    last_name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    },
                    c_password: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                // Validation messages for each input field
                messages: {
                    first_name: {
                        required: "Please enter your first name"
                    },
                    last_name: {
                        required: "Please enter your last name"
                    },
                    email: {
                        required: "Please enter your email address",
                        email: "Please enter a valid email address"
                    },
                    password: {
                        required: "Please enter your password"
                    },
                    c_password: {
                        required : 'Confirm Password is required',
			   		    equalTo : 'Password is not matching',
                    }
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                // Submit handler for the form
                submitHandler: function(form) {
                    $('#submitText').text('Loading...');
                    $('#error-message-div').hide();
                    // Serialize the form data
                    var formData = $(form).serialize();

                    // Submit the form using AJAX
                    $.ajax({
                        type: "POST",
                        url: "<?=base_url()?>submit-signup-form",
                        data: formData,
                        success: function(response) {
                            // Handle the response from the server
                            const resp = $.parseJSON(response);
                            if (resp.status == 'success') {
                                $('#submitText').text('Submitted');
                                setTimeout(() => {
                                    window.location.href = resp.redirect_to;
                                }, 2000);
                            } else {
                                $('#error-message-div').show();
                                $('#error-message').html(resp.message);
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