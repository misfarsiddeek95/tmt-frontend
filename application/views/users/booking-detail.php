<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('includes/head'); ?>
    <title>My Bookings</title>
    <style>
        .p-scroll {
            height: 100px;
            width: 50%;
            overflow-y: auto;
        }
        .p-scroll::-webkit-scrollbar {
            width: 6px; /* Set the width of the scrollbar */
            background-color: #f9f9f9; /* Set the background color of the scrollbar track */
        }
        .p-scroll::-webkit-scrollbar-thumb {
            background-color: #e0e0e0; /* Set the color of the scrollbar thumb */
            border-radius: 3px; /* Set the radius of the scrollbar thumb */
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
                        <h1 class="text-30 lh-14 fw-600">Booking Detail</h1>
                        <div class="text-15 text-light-1">
                            Find your booking detail below.
                        </div>
                    </div>
                    <div class="col-auto"></div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="border-light rounded-8 px-50 py-40 mt-5 bg-white">
                            <h4 class="text-20 fw-500 mb-30">Your Booking Information</h4>

                            <div class="row y-gap-10">
                                <div class="col-12">
                                    <div class="d-flex justify-between ">
                                        <div class="text-15 lh-16">Booking Number</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1"><?=$bookingDetail->booking_number?></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Full name</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1"><?=$bookingDetail->full_name?></div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Email</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1"><?=$bookingDetail->email?></div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Phone</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1"><?=$bookingDetail->phone?></div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Country</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1"><?=$bookingDetail->my_country?></div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Check in</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1"><?=date('d/m/Y', strtotime($bookingDetail->checkin_date))?></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Check out</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1"><?=date('d/m/Y', strtotime($bookingDetail->checkout_date))?></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Hotel/Resort</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1"><?=$bookingDetail->hotel_name?></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Room</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1"><?=$bookingDetail->room_title?></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Pax</div>
                                        <?php
                                            $adultText = ' adult';
                                            $childText = ' child';
                                            if ($bookingDetail->adult > 1) {
                                                $adultText = ' adults';
                                            }
                                            if ($bookingDetail->child > 1) {
                                                $childText = ' children';
                                            }
                                            $pax = $bookingDetail->adult.$adultText.' & '.$bookingDetail->child.$childText;
                                        ?>
                                        <div class="text-15 lh-16 fw-500 text-blue-1"><?=$pax?></div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Stay</div>
                                        <?php
                                            $roomText = ' room';
                                            $nightText = ' night';
                                            if ($bookingDetail->room_count > 1) {
                                                $roomText = ' rooms';
                                            }
                                            if ($bookingDetail->no_of_nights > 1) {
                                                $nightText = ' nights';
                                            }
                                            $stay = $bookingDetail->room_count.$roomText.' & '.$bookingDetail->no_of_nights.$nightText;
                                        ?>
                                        <div class="text-15 lh-16 fw-500 text-blue-1"><?=$stay?></div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Meal plan</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1"><?=$bookingDetail->meal_plan?></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Transfer method</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1"><?=$bookingDetail->transfer_type?></div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Special request</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1"><?=$bookingDetail->special_request_title?></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">About holiday</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1 p-scroll"><?=$bookingDetail->message?></div>
                                    </div>
                                </div>
                                <?php if($bookingDetail->guest_full_name != null && $bookingDetail->guest_full_name != '') { ?>
                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Guest name</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1"><?=$bookingDetail->guest_full_name?></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Guest country</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1"><?=$bookingDetail->guest_country?></div>
                                    </div>
                                </div>
                                <?php } ?>
                                <?php if($bookingDetail->more_requests != null && $bookingDetail->more_requests != '') { ?>
                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">More requests</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1 p-scroll"><?=str_replace('|', ', ', $bookingDetail->more_requests);?></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Additional notes</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1"><?=$bookingDetail->additional_notes?></div>
                                    </div>
                                </div>
                                <?php } ?>
                                <?php if($bookingDetail->is_flight_booked == 1) { ?>
                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Is flight booked</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1">Yes</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Flight arrival date</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1"><?=date('d/m/Y', strtotime($bookingDetail->flight_arrival_date))?></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Flight arrival number</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1"><?=$bookingDetail->flight_arrival_number?></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Flight depature date</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1"><?=date('d/m/Y', strtotime($bookingDetail->flight_depature_date))?></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Flight depature number</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1"><?=$bookingDetail->flight_depature_number?></div>
                                    </div>
                                </div>
                                <?php } elseif($bookingDetail->is_flight_booked == 0) { ?>
                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Is flight booked</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1">No</div>
                                    </div>
                                </div>
                                <?php } elseif($bookingDetail->is_flight_booked == 2) { ?>
                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Is flight booked</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1">I'll book after confirmation</div>
                                    </div>
                                </div>
                                <?php } ?>
                                
                                <?php 
                                    $payMethod = 'Paid by bank';
                                    if ($bookingDetail->paid_method == 1) {
                                        $payMethod = 'Paid online';
                                    }
                                ?>
                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Paid method</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1"><?=$payMethod?></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Paid amount</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1"><?=$cur.''.number_format($bookingDetail->total_amount)?></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-between border-top-light pt-10">
                                        <div class="text-15 lh-16">Booking  added date & time</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1"><?=date('d/m/Y H:i', strtotime($bookingDetail->created_at))?></div>
                                    </div>
                                </div>

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
  </body>
</html>