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
                                        <h1 class="text-22 fw-500">Welcome back</h1>
                                        <p class="mt-10">Don't have an account yet?
                                            <a href="<?=base_url('sign-up'.$redirect_with_r);?>" class="text-blue-1">Sign up for free</a>
                                        </p>
                                    </div>
                                    <div class="col-12" id="error-message-div">
                                      <div class="d-flex items-center justify-between bg-error-1 pl-30 pr-20 py-30 rounded-8">
                                        <div class="text-error-2 lh-1 fw-500" id="error-message"></div>
                                        <div class="text-error-2 text-14 icon-close"></div>
                                      </div>
                                    </div>
                                    <div class="col-12" id="success-message-div">
                                      <div class="d-flex items-center justify-between bg-success-1 pl-30 pr-20 py-30 rounded-8">
                                        <div class="text-success-2 lh-1 fw-500" id="success-message"></div>
                                        <div class="text-success-2 text-14 icon-close"></div>
                                      </div>
                                    </div>
                                    <div class="col-12">
                                      <div class="form-input ">
                                        <input type="email" required="" name="email" id="email" />
                                        <label class="lh-1 text-14 text-light-1">Email</label>
                                      </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-input ">
                                            <input type="password" required="" name="password">
                                            <label class="lh-1 text-14 text-light-1">Password</label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="rval" id="rval" value="<?=$redirect_url?>" />

                                    <div class="col-12">
                                        <a href="javascript:void(0);" class="text-14 fw-500 text-blue-1 underline" onclick="forgotPassword();">Forgot your password?</a>
                                    </div>

                                    <div class="col-12">
                                      <button type="submit" class="button px-24 h-50 -dark-1 bg-blue-1 text-white" style="width: 100%;">
                                        <span id="submitText">Sign In</span>
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
                                      <div class="text-center px-30">By creating an account, you agree to our Terms of Service and Privacy Statement.</div>
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
            $('#error-message-div,#success-message-div').hide();
          });

          $('form.needs-validation').validate({
              // Validation rules for each input field
              rules: {
                  email: {
                    required: true,
                    email: true
                  },
                  password: {
                    required: true
                  }
              },
              // Validation messages for each input field
              messages: {
                  email: {
                    required: "Please enter your email address",
                    email: "Please enter a valid email address"
                  },
                  password: {
                    required: "Please enter your password"
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
                  url: "<?=base_url()?>submit-signin-form",
                  data: formData,
                  success: function(response) {
                    // Handle the response from the server
                    const resp = $.parseJSON(response);
                    if (resp.status == 'success') {
                      setTimeout(() => {
                          window.location.href = resp.redirect_to;
                      }, 2000);
                    } else {
                      $('#error-message-div').show();
                      $('#error-message').html(resp.message);
                      $('#submitText').text('Sign In');
                    }
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                    // Handle errors that occur during the AJAX request
                    console.log(textStatus, errorThrown);
                  }
                });
              }
          });

          const forgotPassword = () => {
            $('#error-message-div,#success-message-div').hide();
            const email = $('#email').val();
            if (email == '' || email == undefined || email == null) {
              $('#error-message-div').show();
              $('#error-message').html('Please enter your email address.');
            }
            const validate = validateEmail(email);
            if (!validate) {
              $('#error-message-div').hide();
              $('#error-message-div').show();
              $('#error-message').html('Please enter valid email address.');
            } else {
              $('#error-message-div').hide();
              $('#error-message').html('');

              $.ajax({
                type: "POST",
                url: "<?=base_url()?>forgot-password",
                data: 'email='+email,
                success: function(response) {
                  const resp = $.parseJSON(response);
                  if (resp.status == 'success') {
                    $('#success-message').html(resp.message);
                    $('#success-message-div').show();
                    setTimeout(() => {
                      $('#success-message-div').hide();
                      $('#success-message-div').html('');
                    }, 3000);
                  } else {
                    $('#error-message').html(resp.message);
                    $('#error-message-div').show();
                  }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                  // Handle errors that occur during the AJAX request
                  console.log(textStatus, errorThrown);
                }
              });
            }
          }

          const validateEmail = (email) => {
            return String(email)
              .toLowerCase()
              .match(
                /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
              );
          };
      </script>
    </body>

</html>