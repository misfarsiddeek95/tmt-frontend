<!DOCTYPE html>
<html lang="en" data-x="html" data-x-toggle="html-overflow-hidden">
    <head>
        <meta
            content="<?=$pageMain->seo_keywords != '' ? $pageMain->seo_keywords : '' ?>"
            name="keywords">
        <meta
            content="<?=$pageMain->seo_description != '' ? $pageMain->seo_description : '' ?>"
            name="description">
        <title><?=$pageMain->seo_title != '' ? $pageMain->seo_title : 'Accommodation List' ?></title>
        <?php $this->load->view('includes/head'); ?>
        <link rel="stylesheet" href="<?=base_url()?>assets/css/toastr.min.css">
        <style>
            .h-70 {
                height: 70px !important;
            }
            .error-message {
                color: #dc3545!important;
            }
            .date-disabled:hover {
                background-color: #eee;
            }
        </style>
    </head>

    <body>
        <?php $this->load->view('includes/preloader'); ?>

        <main>
            <?php $this->load->view('includes/header'); ?>

            <section class="pt-40">
                <div class="container">
                    <div class="row x-gap-40 y-gap-30 items-center">
                        <div class="col-auto">
                            <div class="d-flex items-center">
                                <div class="size-40 rounded-full flex-center bg-blue-1">
                                    <i class="icon-check text-16 text-white"></i>
                                </div>
                                <div class="text-18 fw-500 ml-10">Customer Information</div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="w-full h-1 bg-border"></div>
                        </div>

                        <div class="col-auto">
                            <div class="d-flex items-center">
                                <div class="size-40 rounded-full flex-center bg-blue-1-05 text-blue-1 fw-500" id="booking-information-tab">
                                    2
                                </div>
                                <div class="text-18 fw-500 ml-10">Booking Information</div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="w-full h-1 bg-border"></div>
                        </div>

                        <div class="col-auto">
                            <div class="d-flex items-center">
                                <div class="size-40 rounded-full flex-center bg-blue-1-05 text-blue-1 fw-500" id="booking-success-tab">
                                    3
                                </div>
                                <div class="text-18 fw-500 ml-10">Booking Confirmed</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="pt-40 layout-pb-md">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-7 col-lg-8">
                            <?php 
                                $isLoggedIn = $this->session->userdata('logged_in');
                                if (!$isLoggedIn) { 
                            ?>
                            <div class="py-15 px-20 rounded-4 text-15 bg-blue-1-05">
                                <?php 
                                    $redirect = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                ?>
                                <a href="<?=base_url()?>sign-in?r=<?=base64_encode(base64_encode($redirect))?>" class="text-blue-1 fw-500">Sign in</a>
                                to book with your saved details or
                                <a href="<?=base_url()?>sign-up?r=<?=base64_encode(base64_encode($redirect))?>" class="text-blue-1 fw-500">register</a>
                                to manage your bookings on the go!
                            </div>
                            <?php } ?>

                            <form method="post" id="infoForm">
                                <h2 class="text-22 fw-500 mt-40 md:mt-24">
                                    Let us know who you are
                                </h2>
                                <div class="row x-gap-20 y-gap-20 pt-20" id="personal-information">
                                    <input type="hidden" name="user_id" id="user_id" value="<?php if($isLoggedIn) {echo $this->session->userdata('id');} else { echo(0); } ?>" />
                                    <div class="col-12">
                                        <div class="form-input">
                                            <input type="text" required id="full_name" name="full_name" value="<?php if($isLoggedIn) {echo $this->session->userdata('name');} ?>" />
                                            <label class="lh-1 text-16 text-light-1" for="full_name">Full Name</label>
                                        </div>
                                        <div class="error-message"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-input">
                                            <input type="email" required id="email" name="email" value="<?php if($isLoggedIn) {echo $this->session->userdata('email');} ?>"/>
                                            <label class="lh-1 text-16 text-light-1" for="email">Email</label>
                                        </div>
                                        <div class="error-message"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-input">
                                            <input type="email" required id="retypeEmail" name="retype_email" value="<?php if($isLoggedIn) {echo $this->session->userdata('email');} ?>"/>
                                            <label class="lh-1 text-16 text-light-1">Retype Email</label >
                                        </div>
                                        <div class="error-message"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-input">
                                            <input type="text" name="phone" id="my_phone" value="<?php if($isLoggedIn) {echo $this->session->userdata('phone');} ?>"/>
                                            <label class="lh-1 text-16 text-light-1">Phone Number
                                                <span class="text-14 text-light-1">(Optional)</span ></label >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="select js-select js-liveSearch" data-select-value="">
                                            <button type="button" class="select__button js-button">
                                                <span class="js-button-title">Country</span>
                                                <i class="select__icon" data-feather="chevron-down"></i>
                                            </button>

                                            <div class="select__dropdown js-dropdown">
                                                <input type="text" placeholder="Search" class="select__search js-search"/>

                                                <div class="select__options js-options">
                                                    <?php foreach ($countries as $row) { ?>
                                                        <div class="select__options__button" data-value="<?=strtolower($row->nicename)?>" country-id="<?=$row->country_id?>" onclick="selectDropdownValue('<?=$row->country_id?>', 'input_country');">
                                                            <?=$row->nicename?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="input_country" id="input_country" value="0" />
                                    </div>
                                    <div class="col-12">
                                        <div class="select js-select js-liveSearch" data-select-value="">
                                            <button type="button" class="select__button js-button">
                                                <span class="js-button-title">Special Request</span>
                                                <i class="select__icon" data-feather="chevron-down"></i>
                                            </button>

                                            <div class="select__dropdown js-dropdown">
                                                <input type="text" placeholder="Search" class="select__search js-search"/>

                                                <div class="select__options js-options">
                                                    <?php foreach ($specialRequests as $row) { ?>
                                                        <div class="select__options__button" data-value="<?=strtolower($row->title)?>" special-request-id="<?=$row->id?>" onclick="selectDropdownValue('<?=$row->id?>', 'input_special_request');">
                                                            <?=$row->title?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="input_special_request" id="input_special_request" value="0" />
                                    </div>

                                    <div class="col-12">
                                        <div class="form-input">
                                            <textarea
                                                rows="6"
                                                style="
                                                overflow: hidden;
                                                overflow-wrap: break-word;
                                                height: 150px;"
                                                name="message"
                                                id="message"
                                                ></textarea>
                                            <label class="lh-1 text-16 text-light-1">Tell us more about this holiday</label >
                                        </div>
                                    </div>
                                    <!-- GUEST -->
                                    <div class="col-12">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox">
                                                <input type="checkbox" name="select_for_someone" id="select_for_someone"/>
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <label class="text-15 ml-10" for="select_for_someone">
                                                Please tick if you're making this booking for someone else.
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12" id="guest-box">
                                        <div class="d-flex justify-center flex-column px-80 py-40 md:px-30 bg-light-2">
                                            <h2 class="text-22 fw-500 mb-10 md:mt-24">
                                                Guest information
                                            </h2>
                                            <div class="form-input my-3">
                                                <input type="text" name="guest_name" style="background: #fff"/>
                                                <label class="lh-1 text-16 text-light-1">Full Name</label>
                                            </div>
                                            <div class="select js-select js-liveSearch" data-select-value="">
                                                <button type="button" class="select__button js-button">
                                                    <span class="js-button-title">Guest Country</span>
                                                    <i class="select__icon" data-feather="chevron-down"></i>
                                                </button>

                                                <div class="select__dropdown js-dropdown">
                                                    <input type="text" placeholder="Search" class="select__search js-search"/>

                                                    <div class="select__options js-options">
                                                        <?php foreach ($countries as $row) { ?>
                                                            <div class="select__options__button" data-value="<?=strtolower($row->nicename)?>" guest-country-id="<?=$row->country_id?>"  onclick="selectDropdownValue('<?=$row->country_id?>', 'input_guest_country');">
                                                                <?=$row->nicename?>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="input_guest_country" id="input_guest_country" value="0" />
                                        </div>
                                    </div>
                                    <!-- End Guest -->
                                    <!-- More Request -->
                                    <div class="col-12">
                                        <button type="button" class="d-flex items-center text-blue-1" id="more-request-btn">
                                            <i class="icon-wifi text-20 mr-10 pb-1"></i>
                                            Click here for more requests
                                        </button>
                                    </div>
                                    <div class="col-12" id="more-request-box">
                                        <div class="px-30 py-30 border-light rounded-4 mt-10">
                                            <div class="text-20 fw-500 mb-20">
                                                We'll make sure your property or host gets your request quickly.
                                            </div>

                                            <div class="row y-gap-5 justify-between">
                                                <?php foreach ($moreRequests as $row) { ?>
                                                <div class="col-6">
                                                    <div class="d-flex items-center">
                                                        <div class="form-checkbox">
                                                            <input type="checkbox" name="select_more_req[]" id="select_more_req_<?=$row->id?>" value="<?=$row->title?>" />
                                                            <div class="form-checkbox__mark">
                                                                <div class="form-checkbox__icon icon-check"></div>
                                                            </div>
                                                        </div>
                                                        <label class="text-15 ml-10" for="select_more_req_<?=$row->id?>"><?=$row->title?></label>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <div class="border-top-light mt-30 mb-30"></div>
                                            <div class="form-input">
                                                <textarea
                                                    rows="6"
                                                    style="
                                                    overflow: hidden;
                                                    overflow-wrap: break-word;
                                                    height: 150px;"
                                                    name="additional_notes"
                                                    id="additional_notes"
                                                    ></textarea>
                                                <label class="lh-1 text-16 text-light-1">Additional notes</label >
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End More Request -->
                                    <!-- Flight -->
                                    <div class="col-12">
                                        <div class="text-22 fw-500">Have you booked your Flight?</div>
                                    </div>
                                    <div class="row y-gap-5 justify-between">
                                        <div class="col-auto">
                                            <div class="form-radio d-flex items-center">
                                                <div class="radio">
                                                    <input type="radio" name="flight_ticket" value="1" id="flight_ticket_yes" required/>
                                                    <div class="radio__mark">
                                                        <div class="radio__icon"></div>
                                                    </div>
                                                </div>
                                                <label class="ml-10" for="flight_ticket_yes">Yes</label>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="form-radio d-flex items-center">
                                                <div class="radio">
                                                    <input type="radio" name="flight_ticket" id="flight_ticket_no" value="0" required/>
                                                    <div class="radio__mark">
                                                        <div class="radio__icon"></div>
                                                    </div>
                                                </div>
                                                <label class="ml-10" for="flight_ticket_no">No</label>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="form-radio d-flex items-center">
                                                <div class="radio">
                                                    <input type="radio" name="flight_ticket" id="flight_ticket_after_conf" value="2" required/>
                                                    <div class="radio__mark">
                                                        <div class="radio__icon"></div>
                                                    </div>
                                                </div>
                                                <label class="ml-10" for="flight_ticket_after_conf">I'll book after confirmation</label >
                                            </div>
                                        </div>
                                        <div class="error-message"></div>
                                    </div>
                                    <div class="justify-center flex-column px-80 py-40 md:px-30 bg-light-2" id="flight-info-box">
                                        <h2 class="text-22 fw-500 mb-10 md:mt-24">
                                            Flight information
                                        </h2>
                                        <div class="row justify-between">
                                            <div class="col-6">
                                                <div class="form-input my-3">
                                                    <input type="text" name="arrival_flight_number" style="background: #fff"/>
                                                    <label class="lh-1 text-16 text-light-1">Arrival Flight Number</label >
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-input my-3">
                                                    <input type="date" name="arrival_date" style="background: #fff"/>
                                                    <label class="lh-1 text-16 text-light-1">Arrival Date</label >
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-input my-3">
                                                    <input type="text" name="depature_flight_number" style="background: #fff"/>
                                                    <label class="lh-1 text-16 text-light-1">Depature Flight Number</label >
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-input my-3">
                                                    <input type="date" name="depature_date" style="background: #fff"/>
                                                    <label class="lh-1 text-16 text-light-1">Depature Date</label >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="age-div"></div>
                                    <?php 
                                        for ($i=1; $i <= $cc; $i++) {
                                            $colNum = 12;
                                            if ($cc >= 3) {
                                                $colNum = 4;
                                            } else if($cc == 2) {
                                                $colNum = 6;
                                            }
                                    ?>
                                    <div class="col-<?=$colNum?> age-div">
                                        <div class="select js-select js-liveSearch" data-select-value="">
                                            <button type="button" class="select__button js-button">
                                                <span class="js-button-title">Child <?=$i?> Age</span>
                                                <i class="select__icon" data-feather="chevron-down"></i>
                                            </button>

                                            <div class="select__dropdown js-dropdown">
                                                <input type="text" placeholder="Search" class="select__search js-search"/>

                                                <div class="select__options js-options">
                                                    <?php 
                                                        $ages = range(0,150);
                                                        foreach ($ages as $age) { 
                                                    ?>
                                                        <div class="select__options__button" data-value="<?=strtolower($age)?>">
                                                            <?=$age?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <input type="hidden" name="input_special_request" id="input_special_request" value="0" /> -->
                                    </div>
                                    <?php } ?>
                                    <!-- End Flight -->
                                    <input type="hidden" name="enc_amt" id="enc_amt" value="" />
                                    <input type="hidden" name="iv" id="iv" value="" />

                                    <div class="col-12">
                                        <div class="row y-gap-20 items-center justify-between">
                                            <div class="col-auto">
                                                <div class="text-14 text-light-1">
                                                    By proceeding with this booking, I agree to <?=COMPANY_NAME?> Terms of Use and Privacy
                                                    Policy.
                                                </div>
                                            </div>

                                            <div class="col-auto">
                                                <button type="button" class="button h-60 px-24 -dark-1 bg-blue-1 text-white" id="firstNext">
                                                    Next: Final details
                                                    <div class="icon-arrow-top-right ml-15"></div>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="mt-40" id="paymentMethod">
                                <h3 class="text-22 fw-500">How do you want to pay?</h3>

                                <div class="row y-gap-20 x-gap-20">
                                    <div class="col-6">
                                        <div class="px-30 py-30 border-light rounded-4 mt-30">
                                            <div class="text-20 fw-500 mb-20">Your price summary</div>

                                            <div class="row y-gap-5 justify-between">
                                                <div class="col-auto">
                                                    <div class="text-15">Price for</div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="text-15 final-nights"></div>
                                                </div>
                                            </div>

                                            <div class="row y-gap-5 justify-between pt-5">
                                                <div class="col-auto">
                                                    <div class="text-15">Pax count</div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="text-15 final-pax"></div>
                                                </div>
                                            </div>

                                            <div class="row y-gap-5 justify-between pt-5">
                                                <div class="col-auto">
                                                    <div class="text-15">Booking fees</div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="text-15">FREE</div>
                                                </div>
                                            </div>

                                            <div class="px-20 py-20 bg-blue-2 rounded-4 mt-20 mb-20">
                                                <div class="row y-gap-5 justify-between">
                                                    <div class="col-auto">
                                                        <div class="text-18 lh-13 fw-500">Price</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="text-18 lh-13 fw-500 final-amount"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="javascript:void(0);" class="button -md -outline-blue-1 text-blue-1" onclick="payMoney('0');">
                                                Pay by bank transfer
                                                <div class="icon-arrow-top-right ml-15"></div>
                                            </a>
                                            <ul class="text-15 pt-10">
                                                <li class="d-flex items-center">
                                                    <i class="icon-check text-10 mr-20"></i>Pay online with a credit card or other method
                                                </li>

                                                <li class="d-flex items-center">
                                                    <i class="icon-check text-10 mr-20"></i>TravelX Maldives will process your payment at the time of booking
                                                </li>

                                                <li class="d-flex items-center">
                                                    <i class="icon-check text-10 mr-20"></i>You can cancel and get a full refund before july 24, 2018
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="px-30 py-30 border-light rounded-4 mt-30">
                                            <div class="text-20 fw-500 mb-20">Your price summary</div>

                                            <div class="row y-gap-5 justify-between">
                                                <div class="col-auto">
                                                    <div class="text-15">Price for</div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="text-15 final-nights"></div>
                                                </div>
                                            </div>

                                            <div class="row y-gap-5 justify-between pt-5">
                                                <div class="col-auto">
                                                    <div class="text-15">Pax count</div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="text-15 final-pax"></div>
                                                </div>
                                            </div>

                                            <div class="row y-gap-5 justify-between pt-5">
                                                <div class="col-auto">
                                                    <div class="text-15">Booking fees</div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="text-15">FREE</div>
                                                </div>
                                            </div>

                                            <div class="px-20 py-20 bg-blue-2 rounded-4 mt-20 mb-20">
                                                <div class="row y-gap-5 justify-between">
                                                    <div class="col-auto">
                                                        <div class="text-18 lh-13 fw-500">Price</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="text-18 lh-13 fw-500 final-amount"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="javascript:void(0);" class="button -md -outline-blue-1 text-blue-1" onclick="payMoney('1');">
                                                Pay by credit card online
                                                <div class="icon-arrow-top-right ml-15"></div>
                                            </a>
                                            <ul class="text-15 pt-10">
                                                <li class="d-flex items-center">
                                                    <i class="icon-check text-10 mr-20"></i>Pay online with a credit card or other method
                                                </li>

                                                <li class="d-flex items-center">
                                                    <i class="icon-check text-10 mr-20"></i>TravelX Maldives will process your payment at the time of booking
                                                </li>

                                                <li class="d-flex items-center">
                                                    <i class="icon-check text-10 mr-20"></i>You can cancel and get a full refund before july 24, 2018
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full h-1 bg-border mt-40 mb-40"></div>
                                <div class="row y-gap-20 items-center justify-between">
                                    <div class="col-auto">
                                        <button type="button" class="button -md -dark-1 bg-yellow-1 text-dark-1" id="previousBtn">
                                            <div class="icon-arrow-sm-left mr-15"></div> Previous
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div id="successSection">
                                <div class="d-flex flex-column items-center mt-60 lg:md-40 sm:mt-24">
                                    <div class="size-80 flex-center rounded-full bg-dark-3">
                                        <i class="icon-check text-30 text-white"></i>
                                    </div>

                                    <div class="text-30 lh-1 fw-600 mt-20" id="booking-success-msg"></div>
                                    <div class="text-15 text-light-1 mt-10">
                                        Booking details has been sent to: admin@bookingcore.test <br>
                                        Page will be redirect to home page in <span id="seconds"></span> Seconds.
                                    </div>
                                </div>

                                <div class="border-type-1 rounded-8 px-50 py-35 mt-40">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6">
                                            <div class="text-15 lh-12">Booking Number</div>
                                            <div class="text-15 lh-12 fw-500 text-blue-1 mt-10" id="booking-number"></div>
                                        </div>

                                        <div class="col-lg-3 col-md-6">
                                            <div class="text-15 lh-12">Date</div>
                                            <div class="text-15 lh-12 fw-500 text-blue-1 mt-10" id="booking-added-at">
                                                27/07/2021
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6">
                                            <div class="text-15 lh-12">Total</div>
                                            <div class="text-15 lh-12 fw-500 text-blue-1 mt-10" id="booking-amount"></div>
                                        </div>

                                        <div class="col-lg-3 col-md-6">
                                            <div class="text-15 lh-12">Payment Method</div>
                                            <div class="text-15 lh-12 fw-500 text-blue-1 mt-10" id="booking-paid-by"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-light rounded-8 px-50 py-40 mt-40">
                                    <h4 class="text-20 fw-500 mb-30">Your Information</h4>

                                    <div class="row y-gap-10">
                                        <div class="col-12">
                                            <div class="d-flex justify-between">
                                                <div class="text-15 lh-16">Full name</div>
                                                <div class="text-15 lh-16 fw-500 text-blue-1" id="booked-name"></div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-flex justify-between border-top-light pt-10">
                                                <div class="text-15 lh-16">Email</div>
                                                <div class="text-15 lh-16 fw-500 text-blue-1" id="booked-email"></div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-flex justify-between border-top-light pt-10">
                                                <div class="text-15 lh-16">Phone</div>
                                                <div class="text-15 lh-16 fw-500 text-blue-1" id="booked-phone"></div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-flex justify-between border-top-light pt-10">
                                                <div class="text-15 lh-16">Country</div>
                                                <div class="text-15 lh-16 fw-500 text-blue-1" id="booked-country"></div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-flex justify-between border-top-light pt-10">
                                                <div class="text-15 lh-16">Special Requirements</div>
                                                <div class="text-15 lh-16 fw-500 text-blue-1" id="booked-special-req"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <div class="col-xl-5 col-lg-4">
                            <div class="ml-80 lg:ml-40 md:ml-0">
                                <div class="px-30 py-30 border-light rounded-4">
                                    <div class="text-20 fw-500 mb-30">Your booking details</div>

                                    <div class="row x-gap-15 y-gap-20">
                                        <div class="col-auto">
                                            <?php
                                                $img = PHOTO_DOMAIN.'default.jpg';
                                                if ($resortDetail->photo_path != '' && $resortDetail->photo_path != null) {
                                                    $img = PHOTO_DOMAIN.'hotels/'.$resortDetail->photo_path.'-std.jpg';
                                                }
                                            ?>
                                            <img
                                                src="<?=$img?>"
                                                alt="<?=$resortDetail->hotel_name?>"
                                                class="size-140 rounded-4 object-cover"/>
                                        </div>

                                        <div class="col">
                                            <div class="d-flex x-gap-5 pb-10">
                                                <?=str_repeat('<i class="icon-star text-yellow-1 text-10"></i>',$resortDetail->stars)?>
                                            </div>

                                            <div class="lh-17 fw-500">
                                               <?=$resortDetail->hotel_name?>, <?=$resortDetail->nicename?>
                                            </div>
                                            <div class="text-14 lh-15 mt-5">
                                                <?=$resortDetail->atoll_name?>, <?=$resortDetail->nicename?>
                                            </div>

                                            <div class="row x-gap-10 y-gap-10 items-center pt-10">
                                                <div class="col-auto">
                                                    <div class="d-flex items-center">
                                                        <div class="size-30 flex-center bg-blue-1 rounded-4">
                                                            <div class="text-12 fw-600 text-white"><?=number_format($resortDetail->stars,1)?></div>
                                                        </div>

                                                        <div class="text-14 fw-500 ml-10">Exceptional</div>
                                                    </div>
                                                </div>

                                                <div class="col-auto">
                                                    <div class="text-14"><?=number_format($resortDetail->review_count)?> reviews</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border-top-light mt-30 mb-20"></div>
                                    <div class="row y-gap-20 justify-between">
                                        <div class="col-12">
                                            <div class="text-15">Total length of stay:</div>
                                            <?php
                                                $date1 = new DateTime($sd);
                                                $date2 = new DateTime($ed);
                                                
                                                $interval = $date1->diff($date2);
                                                $nightsCount = $interval->days; // because of the hotel booking, starting date's night also included.
                                            ?>
                                            <div class="fw-500" id="night-count" night-count="<?=$nightsCount?>"><?=$nightsCount?> nights</div>
                                            <div
                                                class="searchMenu-date pr-20 py-10 rounded-4 -right js-form-dd js-calendar">
                                                <div data-x-dd-click="searchMenu-date">
                                                    <h4 class="text-15 fw-500 ls-2 lh-16">Check in - Check out</h4>
                                                    <div class="text-15 text-light-1 ls-2 lh-16">
                                                        <span class="js-first-date"><?=date('D j M',strtotime($sd))?></span>
                                                        -
                                                        <span class="js-last-date"><?=date('D j M', strtotime($ed))?></span>
                                                    </div>
                                                    <a href="javascript:void(0);" class="text-15 text-15 text-blue-1 underline ls-2 lh-16 click-link">Change your selection</a>
                                                </div>
                                                <div
                                                    class="searchMenu-date__field shadow-2"
                                                    data-x-dd="searchMenu-date"
                                                    data-x-dd-toggle="-is-active">
                                                    <div class="bg-white px-30 py-30 rounded-4">
                                                        <div class="overflow-hidden js-calendar-slider">
                                                            <div class="swiper-wrapper">
                                                                <?php
                                                                    // Initialize the start date to the first day of the current month
                                                                    $startDate = new DateTime('first day of this month');
                                                                    $startDate->setTime(0, 0); // Set time to midnight

                                                                    // Create a date for three years from now
                                                                    $endDate = new DateTime('+3 years');
                                                                    $endDate->modify('first day of this month');
                                                                    $endDate->setTime(0, 0); // Set time to midnight

                                                                    // Get today's date for comparison
                                                                    $today = new DateTime();
                                                                    $today->setTime(0, 0); // Set time to midnight
                                                                    $tod = $today->format('Y-m-d');

                                                                    // Loop through each month and generate a calendar
                                                                    $ab = 1;
                                                                    while ($startDate <= $endDate) {
                                                                        // Get the month and year of the current date
                                                                        $month = $startDate->format('m'); // Numeric month with leading zeros
                                                                        $monthName = $startDate->format('F');
                                                                        $year = $startDate->format('Y');

                                                                        // Output the month and year
                                                                        echo '<div class="swiper-slide">';
                                                                        echo '<div class="text-28 fw-500 text-center mb-10">' . $monthName . ' ' . $year . '</div>';

                                                                        // Output the calendar table
                                                                        echo '<div class="table-calendar js-calendar-single">';
                                                                        echo '<div class="table-calendar__header">';
                                                                        echo '<div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>';
                                                                        echo '</div>';
                                                                        echo '<div class="table-calendar__grid overflow-hidden">';

                                                                        // Create a new DateTime object for the first day of the month
                                                                        $firstDayOfMonth = new DateTime($year . '-' . $month . '-01');
                                                                        $startDay = $firstDayOfMonth->format('w'); // Numeric representation of the day of the week (0=Sunday, 1=Monday, etc.)

                                                                        // Output leading empty cells for the days before the first day of the month
                                                                        for ($i = 0; $i < $startDay; $i++) {
                                                                            echo '<div class="table-calendar__cell"></div>';
                                                                        }

                                                                        // Output each day of the month
                                                                        $numDays = $firstDayOfMonth->format('t');
                                                                        for ($day = 1; $day <= $numDays; $day++) {
                                                                            // Correctly format the date string
                                                                            $dateStr = sprintf('%04d-%02d-%02d', $year, $month, $day);
                                                                            $dis = $dateStr < $tod ? 'date-disabled' : '';

                                                                            // Debug output for the current date
                                                                            // Uncomment this line if you want to see the debug output
                                                                            // echo '<!-- DateStr: ' . $dateStr . ', Today: ' . $tod . ' -->';

                                                                            echo '<div data-index="'.$ab.'" data-week="' . date('D', strtotime($dateStr)) . '" data-month="' . $startDate->format('M') . '" class="table-calendar__cell lh-1 text-light-1 '.$dis.'" date="'.$dateStr.'">';
                                                                            echo '<span class="js-date">' . $day . '</span>';
                                                                            echo '</div>';
                                                                            $ab++;
                                                                        }

                                                                        // Close the calendar table and slide divs
                                                                        echo '</div></div></div>';

                                                                        // Move the start date to the next month
                                                                        $startDate->modify('first day of next month');
                                                                    }
                                                                ?>
                                                            </div>

                                                            <button class="calendar-icon -left js-calendar-prev z-2">
                                                                <i class="icon-arrow-left text-24"></i>
                                                            </button>

                                                            <button class="calendar-icon -right js-calendar-next z-2">
                                                                <i class="icon-arrow-right text-24"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border-top-light mt-30 mb-20"></div>
                                    <?php
                                        $mealTitle = 'No default meal selected.';
                                        if (!empty($mealPlans)) {
                                            $defaultMealPlan = array_reduce($mealPlans, function($carry, $element) {
                                                if ($element->is_default == 1) {
                                                    return $element;
                                                }
                                                return $carry;
                                            });
                                            if ($defaultMealPlan) {
                                                $mealTitle = $defaultMealPlan->type_title;
                                            }
                                        }
                                        
                                    ?>
                                    <div class="">
                                        <div class="row y-gap-5 justify-between">
                                            <div class="col-auto">
                                                <div class="text-15">Meal Included</div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="text-15 selected-meal"><?=$mealTitle?></div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="text-15 text-blue-1 underline click-link" onclick="showHiddenBox('meal-box','show');">Change your selection</a>
                                        <div class="row y-gap-5 justify-between" id="meal-box">
                                            <div class="col-md-12 px-30 py-30 border-light rounded-4 mt-30">
                                                <div class="text-16 lh-12 text-dark-1 fw-500 mb-30">
                                                    Select a meal 
                                                </div>
                                                <div class="row y-gap-15">
                                                    <?php
                                                        foreach ($mealPlans as $meal) {
                                                            $checked = '';
                                                            if ($meal->is_default == 1) {
                                                                $checked = 'checked';
                                                            }
                                                    ?>
                                                    <div class="col-6">
                                                        <div class="form-radio d-flex items-center">
                                                            <div class="radio">
                                                            <input type="radio" name="meal_plan" id="meal_plan<?=$meal->pm_id?>" <?=$checked?> value="<?=$meal->pm_id?>" onchange="changeRadioValue('<?=$meal->type_title?>','.selected-meal');" />
                                                            <div class="radio__mark">
                                                                <div class="radio__icon"></div>
                                                            </div>
                                                            </div>
                                                            <label class="text-14 lh-1 ml-10" for="meal_plan<?=$meal->pm_id?>"><?=$meal->short_name?> - <?=$meal->type_title?></label>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="border-top-light mt-30 mb-20"></div>
                                                <div class="d-flex items-center">
                                                    <a href="javascript:void(0);" class="text-15 text-blue-1 underline ls-2 lh-16 mx-5" onclick="clearRadioSelection('meal_plan');">Clear your selection</a>
                                                    <a href="javascript:void(0);" class="text-15 text-red-1 underline ls-2 lh-16" onclick="showHiddenBox('meal-box','hide');">Close</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border-top-light mt-30 mb-20"></div>
                                    <?php
                                        $transferTitle = 'No default transfers selected.';
                                        if (!empty($packageTransfers)) {
                                            $defaultTransfer = array_reduce($packageTransfers, function($carry, $element) {
                                                if ($element->is_default == 1) {
                                                    return $element;
                                                } else {
                                                    return $element;
                                                }
                                                return $carry;
                                            });
                                            $transferTitle = $defaultTransfer->transfer_type.' - '.$defaultTransfer->transfer_vehicle;
                                        }
                                    ?>
                                    <div class="">
                                        <div class="row y-gap-5 justify-between">
                                            <div class="col-auto">
                                                <div class="text-15">Transfer</div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="text-15 selected-transfer"><?=$transferTitle?></div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="text-15 text-blue-1 underline click-link" onclick="showHiddenBox('transfer-box','show');">Change your selection</a>
                                        <div class="row y-gap-5 justify-between" id="transfer-box">
                                            <div class="col-md-12 px-30 py-30 border-light rounded-4 mt-30">
                                                <div class="text-16 lh-12 text-dark-1 fw-500 mb-30">
                                                    Select a transfer type 
                                                </div>
                                                <div class="row y-gap-15">
                                                    <?php
                                                        foreach ($packageTransfers as $transfer) {
                                                            $checked = '';
                                                            if ($transfer->is_default == 1) {
                                                                $checked = 'checked';
                                                            }
                                                    ?>
                                                    <div class="col-12">
                                                        <div class="form-radio d-flex items-center">
                                                            <div class="radio">
                                                            <input type="radio" name="transfer_type" id="transfer_type<?=$transfer->pts_id?>" <?=$checked?> value="<?=$transfer->pts_id?>" onchange="changeRadioValue('<?=$transfer->transfer_type?> - <?=$transfer->transfer_vehicle?>','.selected-transfer');" />
                                                            <div class="radio__mark">
                                                                <div class="radio__icon"></div>
                                                            </div>
                                                            </div>
                                                            <label class="text-14 lh-1 ml-10" for="transfer_type<?=$transfer->pts_id?>"><?=$transfer->transfer_type?> - <?=$transfer->transfer_vehicle?></label>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="border-top-light mt-30 mb-20"></div>
                                                <div class="d-flex items-center">
                                                    <a href="javascript:void(0);" class="text-15 text-blue-1 underline ls-2 lh-16 mx-5" onclick="clearRadioSelection('transfer_type');">Clear your selection</a>
                                                    <a href="javascript:void(0);" class="text-15 text-red-1 underline ls-2 lh-16" onclick="showHiddenBox('transfer-box','hide');">Close</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border-top-light mt-30 mb-20"></div>

                                    <div class="row y-gap-20 justify-between items-center">
                                        <div class="col-auto">
                                            <div class="text-15">You selected:</div>
                                            <div
                                                class="searchMenu-guests pr-20 py-10 rounded-4 js-form-dd js-form-counters">

                                                <div data-x-dd-click="searchMenu-guests">

                                                    <div class="text-15 text-light-1 ls-2 lh-16">
                                                        <span class="js-count-adult"><?=$ac?></span>
                                                        adults -
                                                        <span class="js-count-child"><?=$cc?></span>
                                                        children -
                                                        <span class="js-count-room"><?=$rc?></span>
                                                        room
                                                    </div>
                                                    <a href="javascript:void(0);" class="text-15 text-15 text-blue-1 underline ls-2 lh-16 click-link">Change your selection</a>
                                                </div>

                                                <div
                                                    class="searchMenu-guests__field shadow-2"
                                                    data-x-dd="searchMenu-guests"
                                                    data-x-dd-toggle="-is-active">
                                                    <div class="bg-white px-30 py-30 rounded-4">
                                                        <div class="row y-gap-10 justify-between items-center">
                                                            <div class="col-auto">
                                                                <div class="text-15 fw-500">Adults</div>
                                                            </div>

                                                            <div class="col-auto">
                                                                <div class="d-flex items-center js-counter" data-value-change=".js-count-adult">
                                                                    <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-down adults">
                                                                        <i class="icon-minus text-12"></i>
                                                                    </button>

                                                                    <div class="flex-center size-20 ml-15 mr-15">
                                                                        <div class="text-15 js-count check-adult-count"><?=$ac?></div>
                                                                    </div>

                                                                    <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-up">
                                                                        <i class="icon-plus text-12"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="border-top-light mt-24 mb-24"></div>
                                                        
                                                        <div class="row y-gap-10 justify-between items-center">
                                                            <div class="col-auto">
                                                                <div class="text-15 lh-12 fw-500">Children</div>
                                                                <div class="text-14 lh-12 text-light-1 mt-5">
                                                                    Ages <?=$resortDetail->child_min_age != null ? $resortDetail->child_min_age : 3 ?> - <?=$resortDetail->child_max_age != null ? $resortDetail->child_max_age : 12?>
                                                                </div>
                                                            </div>

                                                            <div class="col-auto">
                                                                <div class="d-flex items-center js-counter" data-value-change=".js-count-child">
                                                                    <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-down" onclick="childCountChange('-');">
                                                                        <i class="icon-minus text-12"></i>
                                                                    </button>

                                                                    <div class="flex-center size-20 ml-15 mr-15">
                                                                        <div class="text-15 js-count check-child-count"><?=$cc?></div>
                                                                    </div>

                                                                    <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-up" onclick="childCountChange('+');">
                                                                        <i class="icon-plus text-12"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="border-top-light mt-24 mb-24"></div>
                                                        
                                                        <div class="row y-gap-10 justify-between items-center">
                                                            <div class="col-auto">
                                                                <div class="text-15 lh-12 fw-500">Infant</div>
                                                                <div class="text-14 lh-12 text-light-1 mt-5">
                                                                    Ages <?=$resortDetail->infant_min_age != null ? $resortDetail->infant_min_age : 0 ?> - <?=$resortDetail->infant_max_age != null ? $resortDetail->infant_max_age : 2?>
                                                                </div>
                                                            </div>

                                                            <div class="col-auto">
                                                                <div class="d-flex items-center js-counter" data-value-change=".js-count-infant">
                                                                    <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-down">
                                                                        <i class="icon-minus text-12"></i>
                                                                    </button>

                                                                    <div class="flex-center size-20 ml-15 mr-15">
                                                                        <div class="text-15 js-count check-infant-count"><?=$ic?></div>
                                                                    </div>

                                                                    <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-up">
                                                                        <i class="icon-plus text-12"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="border-top-light mt-24 mb-24"></div>

                                                        <div class="row y-gap-10 justify-between items-center">
                                                            <div class="col-auto">
                                                                <div class="text-15 fw-500">Rooms</div>
                                                            </div>

                                                            <div class="col-auto">
                                                                <div class="d-flex items-center js-counter" data-value-change=".js-count-room">
                                                                    <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-down rooms">
                                                                        <i class="icon-minus text-12"></i>
                                                                    </button>

                                                                    <div class="flex-center size-20 ml-15 mr-15">
                                                                        <div class="text-15 js-count check-room-count"><?=$rc?></div>
                                                                    </div>

                                                                    <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-up">
                                                                        <i class="icon-plus text-12"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Offer section -->
                                    <!-- <?php if(!empty($packageOffers)) { ?>
                                    <div class="border-top-light mt-30 mb-20"></div>
                                    <div class="row y-gap-20 justify-between items-center">
                                        <div class="col-auto">
                                            <div class="text-15">You can select any of below offers:</div>
                                            <div class="row y-gap-5 mt-20 justify-between">
                                                <div class="row y-gap-15">
                                                    <?php 
                                                        foreach ($packageOffers as $offer) {
                                                            $offerTitle = $offer->offer_kind;

                                                            if ($offer->special_offers_type == 1) {
                                                                $offerTitle .= ' - Stay ' . $offer->free_night_stay . ' & Pay ' . $offer->free_night_pay;
                                                            } else {
                                                                $formatAmount = function ($amount, $currency = '') {
                                                                    return $currency . floatval(number_format($amount,2) + 0);
                                                                };

                                                                switch ($offer->bill_charge_type) { // percentage or fixed amount.
                                                                    case '1':
                                                                        $offerTitle .= ' - Adult: ' . $formatAmount($offer->adult_amount) . '%, Child: ' . $formatAmount($offer->child_amount) . '%, Infant: ' . $formatAmount($offer->infant_amount) . '%';
                                                                        break;

                                                                    case '2':
                                                                        $offerTitle .= ' - Adult: ' . $formatAmount($offer->adult_amount, $this->currency) . ', Child: ' . $formatAmount($offer->child_amount, $this->currency) . ', Infant: ' . $formatAmount($offer->infant_amount, $this->currency);
                                                                        break;
                                                                }
                                                            }

                                                    ?>
                                                    <div class="col-12">
                                                        <div class="form-radio d-flex items-center">
                                                            <div class="radio">
                                                            <input type="radio" name="package_offer" id="package_offer<?=$offer->po_id?>" value="<?=$offer->po_id?>" onchange="changeRadioValue('','');" />
                                                            <div class="radio__mark">
                                                                <div class="radio__icon"></div>
                                                            </div>
                                                            </div>
                                                            <label class="text-14 lh-1 ml-10" for="package_offer<?=$offer->po_id?>"><?=$offerTitle?></label>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="d-flex items-center">
                                                    <a href="javascript:void(0);" class="text-15 text-blue-1 underline ls-2 lh-16 offer-clear-option" onclick="clearRadioSelection('package_offer');">Clear your selection</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?> -->
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
        <script src="<?=base_url()?>assets/js/toastr.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#guest-box,#more-request-box,#flight-info-box,#paymentMethod,#meal-box,#transfer-box,#successSection').hide();
                
                // select the first offer from the offer list if offer exists.
                const packageOfferExists = $('input[name="package_offer"]');
                if (packageOfferExists.length !== 0) {
                    packageOfferExists.first().prop('checked', true);
                }

                // Set start and end dates
                const calendarStart = new Date('<?=$sd?>');
                const calendarEnd = new Date('<?=$ed?>');

                // Create an empty array to hold the dates
                const dates = [];

                // Set the current date to the start date plus one day
                let currentDate = new Date(calendarStart);
                currentDate.setDate(calendarStart.getDate() + 1);

                // Loop through each day between the start and end dates
                while (currentDate < calendarEnd) {
                    // Add the date to the array in the desired format
                    dates.push(currentDate.toISOString().substr(0, 10));

                    // Increment the current date by one day
                    currentDate.setDate(currentDate.getDate() + 1);
                }

                $(`.table-calendar__grid div[date="<?=$sd?>"]`).addClass('-is-active');
                dates.forEach(el => {
                    $(`.table-calendar__grid div[date="${el}"]`).addClass('-is-in-path');
                });
                $(`.table-calendar__grid div[date="<?=$ed?>"]`).addClass('-is-active');

                // set the package start and end date to the localstorage.
                const packageStartAt = '<?=$sd?>';
                const packageEndAt = '<?=$ed?>';
                localStorage.setItem('searchStartDate', packageStartAt);
                localStorage.setItem('searchEndDate', packageEndAt);
            });
            const guestBox = document.getElementById('select_for_someone').addEventListener('click', event => {
                $('#guest-box').hide();
                if(event.target.checked) {
                    $('#guest-box').show();
                }
            });
            const moreRequestBox = document.getElementById('more-request-btn').addEventListener('click', event => {
                $('#more-request-box').toggle();
            });
            
            $('input[name="flight_ticket"]').click(function() {
                const selectedValue = $('input[name="flight_ticket"]:checked').val();
                $('#flight-info-box').hide();
                if (selectedValue == 1) {
                    $('#flight-info-box').show();
                }
                $(this).parent().parent().parent().siblings('.error-message').text('');
            });

            const childCountChange = (changeType='+') => {
                const childAgeDivCount = $('.age-div').not(':first').length;
                var colNum = 12;
                if (childAgeDivCount >= 2) {
                    colNum = 4;
                } else if(childAgeDivCount == 1) {
                    colNum = 6;
                }
                $('.age-div').not(':first').removeClass(function(index, className) {
                    return className.match(/\bcol-\S+/g).join(" ");
                }).addClass('col-'+colNum);
                switch (changeType) {
                    case '+':
                        const ages = Array.from({ length: 150 }, (_, index) => index + 1);
                        var ageDiv = `<div class="col-${colNum} age-div">
                                            <div class="select js-select js-liveSearch" data-select-value="">
                                                <button type="button" class="select__button js-button" onclick="openThisDropdown(this);">
                                                    <span class="js-button-title">Child ${(childAgeDivCount + 1)} Age</span>
                                                    <i class="select__icon" data-feather="chevron-down"></i>
                                                </button>

                                                <div class="select__dropdown js-dropdown">
                                                    <input type="text" placeholder="Search" class="select__search js-search"/>

                                                    <div class="select__options js-options">`;
                                                    ages.forEach(age => {
                                                        ageDiv += `<div class="select__options__button" data-value="${age}">
                                                            ${age}
                                                        </div>`;
                                                    });
                                        ageDiv +=   `</div>
                                                </div>
                                            </div>
                                        </div>`;
                        $('.age-div:last').after(ageDiv)
                        break;
                    case '-':
                        $('.age-div:last').remove();
                        break;
                    default:
                        break;
                }
            }

            // This function is for dynamically added child age dropdown.
            const openThisDropdown = (el) => {
                let dropdown = $(el).siblings('.js-dropdown');
                
                const target = $(el).parent();
                if($(el).parent().hasClass('js-liveSearch')) {
                    searchLive(target);
                }

                if (dropdown.hasClass("-is-visible")) {
                    dropdown.removeClass("-is-visible");
                } else {
                    const targets = document.querySelectorAll(
                        ".js-select, .js-multiple-select"
                    );
                    if (!targets) return;

                    targets.forEach((el) => {
                        if (el.querySelector(".-is-visible")) {
                        el.querySelector(".-is-visible").classList.remove("-is-visible");
                        }
                    });
                    dropdown.addClass("-is-visible");
                }

                makeDropdownSelect(target);
            }

            const searchLive = (target) => {
                const search = target.find(".js-search");
                const options = target.find(".js-options > *");

                search.on("input", (event) => {
                    let searchTerm = event.target.value.toLowerCase();

                    options.each((index, el) => {
                        const element = $(el); // Convert the DOM element to a jQuery object
                        element.addClass("d-none");

                        if (element.attr("data-value").includes(searchTerm)) {
                            element.removeClass("d-none");
                        }
                    });
                });
            };

            const makeDropdownSelect = (target) => {
                const dropdown = $(target).find(".js-dropdown");
                const options = dropdown.find(".js-options > *");

                options.on("click", function() {
                    const el = $(this);
                    const title = target.find('.js-button-title'); // Replace with the appropriate selector for the title element
                    title.html(el.html());
                    target.attr("data-select-value", el.attr("data-value"));
                    dropdown.toggleClass("-is-visible");
                });
            };
            // ----------------------------------------------------------------


            $('#firstNext').on('click', function () {
                let form = document.getElementById("infoForm");
                const requiredFields = form.querySelectorAll("[required]");
                var isValid = true;
                for (let j = 0; j < requiredFields.length; j++) {
                    const element = requiredFields[j];
                    $(element).parent().siblings('.error-message').text('');
                    if (element.type === "radio" && !document.querySelector(`input[name="${element.name}"]:checked`)) {
                        isValid = false;
                        $(element).parent().parent().parent().siblings('.error-message').text('Please select an option');
                    }

                    if (element.value == '') {
                        isValid = false;
                        showError(element,'This field is required.')
                    }
                }
                if (isValid) {
                    validateEmail();
                }
            });

            function validateEmail() {
                let form = document.getElementById("infoForm");
                const emailInput = form.querySelector('#email');
                const emailValue = emailInput.value.trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if (!emailRegex.test(emailValue)) {
                    showError(emailInput, 'Please enter a valid email address.');
                } else {
                    matchEmails();
                }
            }

            function matchEmails() {
                let form = document.getElementById("infoForm");
                const emailInput = form.querySelector('#email');
                const retypeEmailInput = form.querySelector('#retypeEmail');
                
                if (emailInput.value !== retypeEmailInput.value) {
                    showError(retypeEmailInput, 'Email addresses do not match.');
                } else {
                    
                    const packageId = '<?=$pid?>';
                    const accomId = '<?=$accomId?>';
                    const roomId = '<?=$roomId?>';
                    const startDate = localStorage.getItem('searchStartDate');
                    const endDate = localStorage.getItem('searchEndDate');
                    const selectedMeal = $('input[name="meal_plan"]:checked').val();
                    const selectedTransfer = $('input[name="transfer_type"]:checked').val();
                    const adultCount =  $(".check-adult-count").text();
                    const childCount =  $(".check-child-count").text();
                    const roomCount =   $(".check-room-count").text();
                    const childAges =   $('.age-div').find('.js-button-title').map(function() {
                                            return parseInt($(this).text(), 10);
                                        }).get();
                    // const selectedPackOffer = $('input[name="package_offer"]:checked').val();

                    const data = {packageId,accomId,roomId,startDate,endDate,selectedMeal,selectedTransfer,adultCount,childCount,roomCount,childAges};
                    $.ajax({
                        url: '<?=base_url()?>calculate-price',
                        type: 'POST',
                        data: data,
                        success: function(result) {
                            const resp = $.parseJSON(result);
                            if (resp.status == 'NO_DATA') {
                                const prs = `ssd=${btoa(btoa(startDate))}&sed=${btoa(
                                    btoa(endDate)
                                )}&ac=${btoa(btoa(adultCount))}&cc=${btoa(btoa(childCount))}&rc=${btoa(
                                    btoa(roomCount)
                                )}&rid=${btoa(btoa(accomId))}`;
                                const dynamicUrl = `${BASE_URL}inquiry/main/internet-inquiry?prs=${btoa(
                                    prs
                                )}`;
                                return window.location.href = dynamicUrl
                            }
                            if (resp.status == 'success') {
                                $('.final-nights').text(resp.final_data.nights);
                                $('.final-pax').text(resp.final_data.pax);
                                $('.final-amount').text(resp.final_data.final_amount);
                                $('#enc_amt').val(resp.final_data.enc_amt);
                                $('#iv').val(resp.final_data.iv);

                                $('.click-link').hide();
                                $('div.searchMenu-date__field.shadow-2').hide();
                                $('div.searchMenu-guests__field.shadow-2').hide();

                                showHiddenBox('meal-box','hide');
                                showHiddenBox('transfer-box','hide');
                                
                                $('.offer-clear-option').hide();
                                $('input[name="package_offer"]').prop('disabled', true);
                                
                                $('#booking-information-tab').removeAttr('class').addClass('size-40 rounded-full flex-center bg-blue-1').html('<i class="icon-check text-16 text-white"></i>');
                                $('#infoForm').fadeOut(1000)
                                $('#paymentMethod').fadeIn(1000);
                            }
                        },
                        error: function(result) {}
                    });
                }
            }

            const showError = (element, message) => {
                $(element).parent().siblings('.error-message').text(message);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
            
            $('#previousBtn').on('click', function () {
                $('#booking-information-tab').removeAttr('class').addClass('size-40 rounded-full flex-center bg-blue-1-05 text-blue-1 fw-500').text('2');
                $('#paymentMethod').fadeOut(1000);
                $('#infoForm').fadeIn(1000);
                setTimeout(() => {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }, 1000);

                $('.click-link').show();
                $('div.searchMenu-date__field.shadow-2').show();
                $('div.searchMenu-guests__field.shadow-2').show();

                $('.offer-clear-option').show();
                $('input[name="package_offer"]').prop('disabled', false);
            });

            const showHiddenBox = (element,type) => {
                $(`#${element}`).hide();
                if (type === 'show') {
                    $(`#${element}`).show();
                }
            }

            const clearRadioSelection = (nameAttr) => {
                $('input[name="'+nameAttr+'"]').prop('checked', false);
            }

            const payMoney = (paymethod) => {
                const formValues = $('#infoForm').serializeArray();

                const startDate = localStorage.getItem('searchStartDate');
                const endDate = localStorage.getItem('searchEndDate');
                const selectedMeal = $('input[name="meal_plan"]:checked').val();
                const selectedTransfer = $('input[name="transfer_type"]:checked').val();
                const adultCount = $(".check-adult-count").text();
                const childCount = $(".check-child-count").text();
                const roomCount = $(".check-room-count").text();
                const nightCount = $('#night-count').attr('night-count');

                const otherData = [
                    {name: "startDate", value: startDate},
                    {name: "endDate", value: endDate},
                    {name: "selectedMeal", value: selectedMeal},
                    {name: "selectedTransfer", value: selectedTransfer},
                    {name: "roomCount", value: roomCount},
                    {name: "adultCount", value: adultCount},
                    {name: "childCount", value: childCount},
                    {name: "accomId", value: '<?=$accomId?>'},
                    {name: "roomId", value: '<?=$roomId?>'},
                    {name: "nightCount", value: nightCount}
                    
                ];
                formValues.push(...otherData);

                submitPayBtn(paymethod, formValues);
            }

            // select the date range and show the night count.
            const dateArr = [];
            var clickedCount = 0;
            $('div[date]:not(.date-disabled)').on('click', function () {
                clickedCount++;
                if (clickedCount == 1) {
                    $('div[date]').removeClass('-is-active -is-in-path'); // have to check ---------------
                }
                const val = $(this).attr('date');
                dateArr.push(val);
                if (dateArr.length > 1) {
                    const lastTwoElements = dateArr.slice(-2)
                    const startDate = new Date(lastTwoElements[0]);
                    const endDate = new Date(lastTwoElements[1]);

                    const millisecondsPerDay = 1000 * 60 * 60 * 24;

                    const startTime = startDate.getTime();
                    const endTime = endDate.getTime();

                    const dayCount = Math.floor((endTime - startTime) / millisecondsPerDay);
                    const nightCount = parseInt(dayCount) - 1;

                    if (dayCount < 0) {
                        return;
                    }
                    $('#night-count').text(`${nightCount} nights`);
                    $('#night-count').attr('night-count', nightCount);
                }
            });

            const changeRadioValue = (textValue,elmentSelector) => {
                $(elmentSelector).text(textValue);
            }

            const selectDropdownValue = (value,elementId) => {
                $(`#${elementId}`).val(value);
            }

            const submitPayBtn = (paymethod,data) => {
                // if paymethod = 0: pay by bank, if it is = 1, paid online.
                const paydata = [
                    {name: "paid_method", value: paymethod},
                    {name: "packageId", value: '<?=$pid?>'}
                ];
                data.push(...paydata);
                $.ajax({
                    url: '<?=base_url()?>submit-booking',
                    type: 'POST',
                    data: data,
                    success: function(result) {
                        const resp = $.parseJSON(result);
                        if (resp.status == 'error') {
                            return toastr.error(resp.message);
                        }
                        const addedData = resp.added_booking;
                        if (paymethod == '0') {
                            $('#booking-success-msg').text(resp.message);
                            $('#booking-number').text(addedData.booking_number);
                            $('#booking-added-at').text(formatDate(addedData.created_at));
                            $('#booking-amount').text('<?=$cur?>'+formatNumberWithCommas(addedData.total_amount));
                            $('#booking-paid-by').text('Paid by Bank');

                            $('#booked-name').text(addedData.full_name);
                            $('#booked-email').text(addedData.email);
                            $('#booked-phone').text(addedData.phone);
                            $('#booked-country').text(addedData.my_country);
                            $('#booked-special-req').text(addedData.special_request_title);


                            $('#paymentMethod').fadeOut(1000);
                            $('#successSection').fadeIn(1000)
                            $('#booking-success-tab').removeAttr('class').addClass('size-40 rounded-full flex-center bg-blue-1').html('<i class="icon-check text-16 text-white"></i>');

                            countdownTimer(25);
                        } else if (paymethod == '1') { // another condition will be added online payment done or not.
                            $('#booking-success-msg').text(resp.message);
                            $('#booking-number').text(addedData.booking_number);
                            $('#booking-added-at').text(formatDate(addedData.created_at));
                            $('#booking-amount').text('<?=$cur?>'+formatNumberWithCommas(addedData.total_amount));
                            $('#booking-paid-by').text('Paid online');

                            $('#booked-name').text(addedData.full_name);
                            $('#booked-email').text(addedData.email);
                            $('#booked-phone').text(addedData.phone);
                            $('#booked-country').text(addedData.my_country);
                            $('#booked-special-req').text(addedData.special_request_title);


                            $('#paymentMethod').fadeOut(1000);
                            $('#successSection').fadeIn(1000)
                            $('#booking-success-tab').removeAttr('class').addClass('size-40 rounded-full flex-center bg-blue-1').html('<i class="icon-check text-16 text-white"></i>');

                            countdownTimer(25);
                        }
                    },
                    error: function(result) {}
                });
            }

            function formatDate(inputDate) {
                var date = new Date(inputDate);
                if (isNaN(date)) {
                    return "Invalid date";
                }

                var day = String(date.getDate()).padStart(2, "0");
                var month = String(date.getMonth() + 1).padStart(2, "0");
                var year = date.getFullYear();

                return day + "/" + month + "/" + year;
            }

            function formatNumberWithCommas(number) {
                var parts = number.toString().split(".");
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                return parts.join(".");
            }

            function countdownTimer(seconds) {
                $('#seconds').text(seconds);
                seconds--;
                if (seconds < 0) {
                    location.href = '<?=base_url()?>';
                } else {
                    setTimeout(function() {
                        countdownTimer(seconds);
                    }, 1000);
                }
            }
        </script>
    </body>
</html>