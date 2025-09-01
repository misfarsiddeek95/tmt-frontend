<!DOCTYPE html>
<html lang="en" data-x="html" data-x-toggle="html-overflow-hidden">
    <head>
        
        <?php $this->load->view('includes/head'); ?>
        <style>
            label.error {
                display: block;
                color: red;
            }
        </style>
        <title>Password Reset</title>
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
                                <form class="needs-validation" method="POST">
                                    <div class="row y-gap-20">
                                        <div class="col-12" id="error-message-div">
                                            <div class="d-flex items-center justify-between bg-error-1 pl-30 pr-20 py-30 rounded-8">
                                                <div class="text-error-2 lh-1 fw-500" id="error-message"></div>
                                                <div class="text-error-2 text-14 icon-close"></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <h1 class="text-22 fw-500">Reset Password</h1>
                                        </div>
                                       
                                        <div class="col-12">
                                            <div class="form-input ">
                                                <input type="password" required="" name="password" id="password" />
                                                <label class="lh-1 text-14 text-light-1">Password</label>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-input ">
                                                <input type="password" required="" name="c_password" id="c_password" />
                                                <label class="lh-1 text-14 text-light-1">Confirm Password</label>
                                            </div>
                                        </div>
                                        <input type="hidden" name="uk_token" value="<?=$username?>">
                                        <div class="col-12">
                                            <button type="submit" class="button px-24 h-50 -dark-1 bg-blue-1 text-white" style="width: 100%;">
                                                <span id="submitText">Submit</span>
                                                <div class="icon-arrow-top-right ml-15"></div>
                                            </button>
                                        </div>
                                    </div>
                                </form>
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
                        url: "<?=base_url()?>forgot-password/do-reset-password",
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