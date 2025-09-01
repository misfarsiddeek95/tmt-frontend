<!DOCTYPE html>
<html lang="en" data-x="html" data-x-toggle="html-overflow-hidden">
    <head>
        <?php $this->load->view('includes/head'); ?>
        <meta
            content="<?=$pageMain->seo_keywords != '' ? $pageMain->seo_keywords : '' ?>"
            name="keywords">
        <meta
            content="<?=$pageMain->seo_description != '' ? $pageMain->seo_description : '' ?>"
            name="description">
        <title><?=$pageMain->seo_title != '' ? $pageMain->seo_title : 'Contact Us' ?></title>
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

            <div class="ratio ratio-16:9">
                <div class="map-ratio">
                    <!-- <div class="map js-map-single"></div> -->
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31668.204210302007!2d79.93428674018638!3d7.180711918191104!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2e53c90c5fccb%3A0x330fe93bfc82930f!2sMinuwangoda!5e0!3m2!1sen!2slk!4v1679732332032!5m2!1sen!2slk" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="true" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

            <section>
                <div class="relative container">
                    <div class="row justify-end">
                        <div class="col-xl-5 col-lg-7">
                            <div
                                class="map-form px-40 pt-40 pb-50 lg:px-30 lg:py-30 md:px-24 md:py-24 bg-white rounded-4 shadow-4">
                                <div class="col-12" id="error-message-div">
                                    <div class="d-flex items-center justify-between bg-error-1 pl-30 pr-20 py-30 rounded-8">
                                    <div class="text-error-2 lh-1 fw-500" id="error-message"></div>
                                    <div class="text-error-2 text-14 icon-close"></div>
                                    </div>
                                </div>
                                <div class="text-22 fw-500">Send a message</div>
                                <form class="needs-validation" method="POST">
                                    <div class="row y-gap-20 pt-20">
                                        <div class="col-12">
                                            <div class="form-input">
                                                <input type="text" name="full_name" required/>
                                                <label class="lh-1 text-16 text-light-1">Full Name</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-input">
                                                <input type="email" name="email" required=""/>
                                                <label class="lh-1 text-16 text-light-1">Email</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-input">
                                                <input type="text" name="mobile_number" required=""/>
                                                <label class="lh-1 text-16 text-light-1">Mobile Number</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-input">
                                                <input type="text" name="country" required=""/>
                                                <label class="lh-1 text-16 text-light-1">Country</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-input">
                                                <input type="text" name="booking_id"/>
                                                <label class="lh-1 text-16 text-light-1">Booking ID (if available)</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-input">
                                                <textarea required="" rows="4" name="inquiry"></textarea>
                                                <label class="lh-1 text-16 text-light-1">Your Messages</label >
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="button px-24 h-50 -dark-1 bg-blue-1 text-white" id="submitBtn">
                                                <span id="submitText">Send a Messsage</span>
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

            <section class="layout-pt-md layout-pb-lg">
                <div class="container">
                    <div class="row x-gap-80 y-gap-20 justify-between">
                        <div class="col-12">
                            <div class="text-30 sm:text-24 fw-600">Contact Us</div>
                        </div>

                        <div class="col-lg-3">
                            <div class="text-14 text-light-1">Address</div>
                            <div class="text-18 fw-500 mt-10">
                                <?=$pageContactInfo->headline?> <?=$pageContactInfo->second_title?>
                            </div>
                        </div>

                        <div class="col-auto">
                            <div class="text-14 text-light-1">Toll Free Customer Care</div>
                            <div class="text-18 fw-500 mt-10"><?=$pageContactInfo->seo_title?></div>
                        </div>

                        <div class="col-auto">
                            <div class="text-14 text-light-1">Need live support?</div>
                            <div class="text-18 fw-500 mt-10"><?=$pageContactInfo->seo_keywords?></div>
                        </div>

                        <div class="col-auto">
                            <div class="text-14 text-light-1">Follow us on social media</div>
                            <div class="d-flex x-gap-20 items-center mt-10">
                                <a href="<?=$socialMediaLinks->seo_description?>">
                                    <i class="icon-facebook text-14"></i>
                                </a>
                                <a href="<?=$socialMediaLinks->seo_url?>">
                                    <i class="icon-twitter text-14"></i>
                                </a>
                                <a href="<?=$socialMediaLinks->headline?>">
                                    <i class="icon-instagram text-14"></i>
                                </a>
                                <a href="<?=$socialMediaLinks->second_title?>">
                                    <i class="icon-linkedin text-14"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="layout-pt-lg layout-pb-lg bg-blue-2">
                <div class="container">
                    <div class="row justify-center text-center">
                        <div class="col-auto">
                            <div class="sectionTitle -md">
                                <h2 class="sectionTitle__title"><?=$pageWhyChooseUs->headline?></h2>
                                <p class="sectionTitle__text mt-5 sm:mt-0">
                                <?=$pageWhyChooseUs->second_title?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row y-gap-40 justify-between pt-50">
                        <div class="col-lg-3 col-sm-6">
                            <div class="featureIcon -type-1">
                                <div class="d-flex justify-center">
                                    <img src="#" data-src="<?=base_url()?>assets/img/featureIcons/3/1.svg" alt="image" class="js-lazy"/>
                                </div>

                                <div class="text-center mt-30">
                                    <h4 class="text-18 fw-500"><?=$pageBestTravelAgent->headline?></h4>
                                    <p class="text-15 mt-10"><?=$pageBestTravelAgent->second_title?></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6">
                            <div class="featureIcon -type-1">
                                <div class="d-flex justify-center">
                                    <img src="#" data-src="<?=base_url()?>assets/img/featureIcons/3/2.svg" alt="image" class="js-lazy"/>
                                </div>

                                <div class="text-center mt-30">
                                    <h4 class="text-18 fw-500"><?=$pageBestPrice->headline?></h4>
                                    <p class="text-15 mt-10"><?=$pageBestPrice->second_title?></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6">
                            <div class="featureIcon -type-1">
                                <div class="d-flex justify-center">
                                    <img src="#" data-src="<?=base_url()?>assets/img/featureIcons/3/3.svg" alt="image" class="js-lazy"/>
                                </div>

                                <div class="text-center mt-30">
                                    <h4 class="text-18 fw-500"><?=$pageBestTrustSafty->headline?></h4>
                                    <p class="text-15 mt-10"><?=$pageBestTrustSafty->second_title?></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6">
                            <div class="featureIcon -type-1">
                                <div class="d-flex justify-center">
                                    <img src="#" data-src="<?=base_url()?>assets/img/featureIcons/3/4.svg" alt="image" class="js-lazy"/>
                                </div>

                                <div class="text-center mt-30">
                                    <h4 class="text-18 fw-500"><?=$pageFastBooking->headline?></h4>
                                    <p class="text-15 mt-10"><?=$pageFastBooking->second_title?></p>
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
            $(document).ready(function () {
                $('#error-message-div').hide();
            });

            $.validator.addMethod("phone", function(value, element) {
                return this.optional(element) || /^(\+?\d{1,3}|\d{1,4})[- .]?\(?\d{2,3}\)?[- .]?\d{3}[- .]?\d{4}$/.test(value);
            }, "Please enter a valid phone number.");

            $('form.needs-validation').validate({
                // Validation rules for each input field
                rules: {
                    full_name: {
                    required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    mobile_number: {
                        required: true,
                        phone: true
                    },
                    country: {
                        required: true
                    },
                    inquiry: {
                        required: true
                    }
                },
                // Validation messages for each input field
                messages: {
                    full_name: {
                        required: "Please enter your full name"
                    },
                    email: {
                        required: "Please enter your email address",
                        email: "Please enter a valid email address"
                    },
                    mobile_number: {
                        required: "Please enter your mobile number",
                        phone: "Please enter a valid phone number"
                    },
                    country: {
                        required: "Please select your country"
                    },
                    inquiry: {
                        required: "Please enter your inquiry"
                    }
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                // Submit handler for the form
                submitHandler: function(form) {
                    $('#error-message-div').hide();
                    $('#submitText').text('Loading...');
                    $('#submitBtn').attr('disabled', 'disabled');
                    // Serialize the form data
                    var formData = $(form).serialize();

                    // Submit the form using AJAX
                    $.ajax({
                        type: "POST",
                        url: "<?=base_url()?>submit-contact-form",
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
                                $('#error-message').html(resp.message);
                                $('#error-message-div').show();
                                $('#submitText').text('Submit Again');
                                $('#submitText').removeAttr('disabled');
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