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
        <style>
            .firstImage img {
                width: 660px !important;
                height: 518px !important;
                object-fit: cover !important;
            }
            .otherImages img {
                width: 305px !important;
                height: 254px !important;
                object-fit: cover !important;
            }
            .pax-icons div:nth-child(2n+1),
            .pax-icons div:nth-child(2n+2) {
                float: left;
            }
            .pax-icons:after {
                content: "";
                display: table;
                clear: both;
            }
            .p-scroll {
                height: 160px; /* Set the height of the container */
                overflow-y: auto; /* Add scroll bars */
            }
            /* Customize the scroll bar */
            .p-scroll::-webkit-scrollbar {
                width: 6px; /* Set the width of the scrollbar */
                background-color: #f9f9f9; /* Set the background color of the scrollbar track */
            }
            .p-scroll::-webkit-scrollbar-thumb {
                background-color: #e0e0e0; /* Set the color of the scrollbar thumb */
                border-radius: 3px; /* Set the radius of the scrollbar thumb */
            }
            .singleMenu {
                z-index: 9999;
            }
            .map-bottom-2 {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }
            .date-disabled:hover {
                background-color: #eee;
            }

            .popup {
                display: none; /* Hidden by default */
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                justify-content: center;
                align-items: center;
            }

            .popup-content {
                background: white;
                padding: 20px;
                border-radius: 8px;
                max-width: 100%;
                width: 90%;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                text-align: center;
            }

            .close-btn {
                position: absolute;
                right: 100px;
                font-size: 24px;
                cursor: pointer;
            }

            /* Responsive design */
            @media (max-width: 600px) {
                .popup-content {
                    width: 95%;
                    padding: 15px;
                }
            }
        </style>
    </head>

    <body>
        <?php $this->load->view('includes/preloader'); ?>
        <main>
            <?php $this->load->view('includes/header'); ?>
            <?php
                $hotelExtra = array_filter($accomodationDetail->hotelExtra, function($obj) {
                    return !empty($obj->childContent);
                });

                // removing current hotel from related hotel list.
                $remove_id = $accomodationDetail->ho_id;
                $relatedHotels = array_filter($accomodationDetail->relatedHotels, function($hotel) use ($remove_id) {
                    return $hotel->ho_id != $remove_id;
                });
            ?>
            <div class="singleMenu js-singleMenu">
                <div class="singleMenu__content">
                    <div class="container">
                        <div class="row y-gap-20 justify-between items-center">
                            <?php $this->load->view('includes/common-search'); ?>
                            <div class="col-auto">
                                <div class="singleMenu__links row x-gap-30 y-gap-10">
                                    <?php if($accomodationDetail->description != '') { ?>
                                    <div class="col-auto">
                                        <a href="#overview">Overview</a>
                                    </div>
                                    <?php } if (!empty($accomodationDetail->hotelRooms)) { ?>
                                    <div class="col-auto">
                                        <a href="#rooms">Rooms</a>
                                    </div>
                                    <?php } if (!empty($hotelExtra)) { ?>
                                    <div class="col-auto">
                                        <a href="#wine-and-dine">Wine and Dine</a>
                                    </div>
                                    <?php } if (!empty($accomodationDetail->hotelFaqs)) { ?>
                                    <div class="col-auto">
                                        <a href="#faq">Faq</a>
                                    </div>
                                    <?php } if (!empty($relatedHotels)) { ?>
                                    <div class="col-auto">
                                        <a href="#similar-list">Similar Resorts</a>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="row x-gap-15 y-gap-15 items-center">
                                    <div class="col-auto">
                                        <div class="text-14">
                                            <!-- From
                                            <span class="text-22 text-dark-1 fw-500"><?=$cur?><?=($accomodationDetail->min_price + 0)?></span> -->
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <a href="#rooms" class="button h-50 px-24 -dark-1 bg-blue-1 text-white">
                                            Select Room <div class="icon-arrow-top-right ml-15"></div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <pre>
                <?php print_r($accomodationDetail);?>
            </pre> -->
            <section class="pt-40">
                <div class="container">
                    <div class="row y-gap-20 justify-between items-end">
                        <div class="col-auto">
                            <div class="row x-gap-20  items-center">
                                <div class="col-auto">
                                    <h1 class="text-30 sm:text-25 fw-600"><?=$accomodationDetail->hotel_name?></h1>
                                </div>

                                <div class="col-auto">
                                    <?=str_repeat('<i class="icon-star text-10 text-yellow-1"></i>', $accomodationDetail->stars);?>
                                </div>
                            </div>

                            <div class="row x-gap-20 y-gap-20 items-center">
                                <div class="col-auto">
                                    <div class="d-flex items-center text-15 text-light-1">
                                        <i class="icon-location-2 text-16 mr-5"></i>
                                        <?=$accomodationDetail->atoll.', '.$accomodationDetail->nicename?>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <button data-x-click="mapFilter" class="text-blue-1 text-15 underline">Show on map</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-auto">
                            <div class="row x-gap-15 y-gap-15 items-center">
                                <div class="col-auto">
                                    <div class="text-14">
                                        <!-- From
                                        <span class="text-22 text-dark-1 fw-500"><?=$cur.''.($accomodationDetail->min_price+0)?></span> -->
                                    </div>
                                </div>

                                <!-- <div class="col-auto"> <a href="#" class="button h-50 px-24 -dark-1
                                bg-blue-1 text-white"> Select Room <div class="icon-arrow-top-right
                                ml-15"></div> </a> </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="galleryGrid -type-1 pt-30">
                        <?php
                        foreach ($accomodationDetail->hotelImages as $ik => $image) {
                          $imageClass = ''; // otherImages –––––––> This class name removed for the purpose of the mobile view.
                          if ($ik == 0) {
                            $imageClass = 'relative d-flex firstImage';
                          }
                          if ($ik == 4) break;
                          $img = PHOTO_DOMAIN.'hotels/'.$image->photo_path.'-std.jpg';
                      ?>
                        <div class="galleryGrid__item <?=$imageClass?>">
                            <img src="<?=$img?>" alt="image" class="rounded-4">
                        </div>
                        <?php } ?>
                        <?php 
                        if (isset($accomodationDetail->hotelImages[4]) && $accomodationDetail->hotelImages[4]->photo_path != '') {
                          $forthImage = PHOTO_DOMAIN.'hotels/'.$accomodationDetail->hotelImages[4]->photo_path.'-std.jpg';
                      ?>
                        <div class="galleryGrid__item relative d-flex">
                            <img src="<?=$forthImage?>" alt="image" class="rounded-4">

                            <div class="absolute px-10 py-10 col-12 h-full d-flex justify-end items-end">
                                <?php
                                    foreach ($accomodationDetail->hotelImages as $imageKey => $imageValue) {
                                    $class = '';
                                    $anchorText = '';
                                    if ($imageKey == 0) {
                                        $class = 'button -blue-1 px-24 py-15 bg-white text-dark-1';
                                        $anchorText = 'See All '.count($accomodationDetail->hotelImages).' Photos';
                                    }
                                    $image = PHOTO_DOMAIN.'hotels/'.$imageValue->photo_path.'-std.jpg';
                                ?>
                                <a href="<?=$image?>" class="<?=$class?> js-gallery" data-gallery="gallery2">
                                    <?=$anchorText?>
                                </a>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </section>

            <section class="pt-30">
                <div class="container">
                    <div class="row y-gap-30">
                        <div class="col-xl-8">
                            <div class="row y-gap-40">
                                <?php if (!empty($accomodationDetail->hotelFacilities)) {?>
                                <div class="col-12">
                                    <h3 class="text-22 fw-500">Property highlights</h3>
                                    <div class="row y-gap-20 pt-30">
                                        <?php foreach (array_slice($accomodationDetail->hotelFacilities,0,4) as $facility) { ?>
                                        <div class="col-lg-3 col-6">
                                            <div class="text-center">
                                                <i class="<?=$facility->facility_icon?> text-24 text-blue-1"></i>
                                                <div class="text-15 lh-1 mt-10"><?=$facility->facility_name?></div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php } ?>

                                <div id="overview" class="col-12">
                                    <h3 class="text-22 fw-500 pt-40 border-top-light">Overview</h3>
                                    <?=$accomodationDetail->description?>
                                    <a href="javascript:void(0);" class="d-block text-14 text-blue-1 fw-500 underline mt-10 show-more" onclick="clickShowMore('show');">Show More</a>
                                </div>
                                <?php if (!empty($accomodationDetail->hotelFacilities)) { ?>
                                    <div class="col-12">
                                        <h3 class="text-22 fw-500 pt-40 border-top-light">Most Popular Facilities</h3>
                                        <div class="row y-gap-10 pt-20">
                                            <?php
                                            $facilities = $accomodationDetail->hotelFacilities;
                                            $chunks = array_chunk($facilities, 5);

                                            foreach ($chunks as $chunk) {
                                                ?>
                                                <div class="col-md-3">
                                                    <?php foreach ($chunk as $facility) { ?>
                                                        <div class="d-flex x-gap-15 y-gap-15 items-center">
                                                            <i class="<?= $facility->facility_icon ?>"></i>
                                                            <div class="text-15"><?= $facility->facility_name ?></div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="ml-50 lg:ml-0">
                                <!-- <div class="px-30 py-30 border-light rounded-4 shadow-4">
                                    <div class="d-flex items-center justify-between">
                                        <div class="">
                                        </div>

                                        <div class="d-flex items-center">
                                            <div class="text-14 text-right mr-10">
                                                <div class="lh-15 fw-500">Exceptional</div>
                                                <div class="lh-15 text-light-1"><?=str_pad($accomodationDetail->review_count, 2, "0", STR_PAD_LEFT)?> reviews</div>
                                            </div>

                                            <div class="size-40 flex-center bg-blue-1 rounded-4">
                                                <div class="text-14 fw-600 text-white"><?=number_format($accomodationDetail->stars,1)?></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row y-gap-20 pt-30">
                                        <div class="col-12">
                                            <div
                                                class="searchMenu-date px-20 py-10 border-light rounded-4 -right js-form-dd js-calendar">
                                                <div data-x-dd-click="searchMenu-date">
                                                    <h4 class="text-15 fw-500 ls-2 lh-16">Check in - Check out</h4>

                                                    <div class="text-15 text-light-1 ls-2 lh-16">
                                                        <span class="js-first-date"><?=date('D j M', $nextWeekFirstDay)?></span>
                                                        -
                                                        <span class="js-last-date"><?=date('D j M', $nextWeekFourthDay)?></span>
                                                    </div>
                                                </div>
                                                <div
                                                    class="searchMenu-date__field shadow-2"
                                                    data-x-dd="searchMenu-date"
                                                    data-x-dd-toggle="-is-active">
                                                    <div class="bg-white px-30 py-30 rounded-4">
                                                        <div class="overflow-hidden js-calendar-slider">
                                                            <div class="swiper-wrapper">
                                                                <?php
                                                                    // Get the current date
                                                                    $today = new DateTime();

                                                                    // Create a date for three years from now
                                                                    $endDate = new DateTime('+3 years');

                                                                    // Loop through each month and generate a calendar
                                                                    $ab = 1;
                                                                    while ($today <= $endDate) {
                                                                        // Get the month and year of the current date
                                                                        $month = $today->format('F');
                                                                        $year = $today->format('Y');

                                                                        // Output the month and year
                                                                        echo '<div class="swiper-slide">';
                                                                        echo '<div class="text-28 fw-500 text-center mb-10">' . $month . ' ' . $year . '</div>';

                                                                        // Output the calendar table
                                                                        echo '<div class="table-calendar js-calendar-single">';
                                                                        echo '<div class="table-calendar__header">';
                                                                        echo '<div>Sat</div><div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div>';
                                                                        echo '</div>';
                                                                        echo '<div class="table-calendar__grid overflow-hidden">';

                                                                        // Get the number of days in the current month
                                                                        $numDays = $today->format('t');

                                                                        // Output each day of the month
                                                                        
                                                                        for ($day = 1; $day <= $numDays; $day++) {
                                                                            $date = new DateTime("$year-$month-$day");
                                                                            $dbDate = $date->format('Y').'-'.$date->format('m').'-'.str_pad($day, 2, "0", STR_PAD_LEFT);
                                                                            $tod = date('Y-m-d');
                                                                            $dis = $dbDate < $tod ? 'date-disabled' : '';
                                                                            echo '<div data-index="'.$ab.'" data-week="' . date('D', strtotime($dbDate)) . '" data-month="' . $date->format('M') . '" class="table-calendar__cell lh-1 text-light-1 '.$dis.'"  date="'.$dbDate.'">';
                                                                            echo '<span class="js-date">' . $day . '</span>';
                                                                            echo '</div>';
                                                                            $ab++;
                                                                        }

                                                                        // Close the calendar table and slide divs
                                                                        echo '</div></div></div>';
                                                                        
                                                                        // Move the current date to the next month
                                                                        $today->modify('first day of next month');
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

                                        <div class="col-12">

                                            <div
                                                class="searchMenu-guests px-20 py-10 border-light rounded-4 js-form-dd js-form-counters">

                                                <div data-x-dd-click="searchMenu-guests">
                                                    <h4 class="text-15 fw-500 ls-2 lh-16">Guest</h4>

                                                    <div class="text-15 text-light-1 ls-2 lh-16">
                                                        <span class="js-count-adult">2</span>
                                                        adults -
                                                        <span class="js-count-child">0</span>
                                                        childeren -
                                                        <span class="js-count-room">1</span>
                                                        room
                                                    </div>
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
                                                                        <div class="text-15 js-count check-adult-count">2</div>
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
                                                                <div class="text-14 lh-12 text-light-1 mt-5">Ages 3 - 12</div>
                                                            </div>

                                                            <div class="col-auto">
                                                                <div class="d-flex items-center js-counter" data-value-change=".js-count-child">
                                                                    <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-down">
                                                                        <i class="icon-minus text-12"></i>
                                                                    </button>

                                                                    <div class="flex-center size-20 ml-15 mr-15">
                                                                        <div class="text-15 js-count check-child-count">0</div>
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
                                                                <div class="text-15 lh-12 fw-500">Infant</div>
                                                                <div class="text-14 lh-12 text-light-1 mt-5">Ages 0 - 2</div>
                                                            </div>

                                                            <div class="col-auto">
                                                                <div class="d-flex items-center js-counter" data-value-change=".js-count-infant">
                                                                    <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-down">
                                                                        <i class="icon-minus text-12"></i>
                                                                    </button>

                                                                    <div class="flex-center size-20 ml-15 mr-15">
                                                                        <div class="text-15 js-count check-infant-count">0</div>
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
                                                                        <div class="text-15 js-count check-room-count">1</div>
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

                                        <div class="col-12">
                                            <button class="button -dark-1 px-35 h-60 col-12 bg-blue-1 text-white" id="check-availability-button">
                                                Check availability
                                            </button>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="px-30 py-30 border-light rounded-4 mt-30">
                                    <div
                                        class="flex-center ratio ratio-15:9 mb-15 js-lazy"
                                        data-bg="<?=base_url()?>assets/img/general/map.png">
                                        <iframe class="map-bottom" src="https://maps.google.com/maps?q=<?=$accomodationDetail->latitude?>,<?=$accomodationDetail->longitude?>&hl=en&z=14&amp;output=embed" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <?php if(!empty($accomodationDetail->hotelRooms)) { ?>
            <section id="rooms" class="pt-30">
                <div class="container">
                    <div class="row pb-20">
                        <div class="col-auto">
                            <h3 class="text-22 fw-500">Available Rooms</h3>
                        </div>
                    </div>
                    <?php 
                        foreach ($accomodationDetail->hotelRooms as $key => $room) {
                            $mtCls = 'mt-20';
                            if ($key == 0) {
                                $mtCls = '';
                            }
                            $urlParams = 'accomId='.base64_encode(base64_encode($accomId)).'&roomId='.base64_encode(base64_encode($room->hr_id)).'&sd='.base64_encode(base64_encode($startDate)).'&ed='.base64_encode(base64_encode($end_date)).'&roomCount='.base64_encode(base64_encode($roomCount)).'&adultCount='.base64_encode(base64_encode($adultCount)).'&childCount='.base64_encode(base64_encode($childCount)).'&packId='.base64_encode(base64_encode($accomodationDetail->p_id)).'&packStart='.base64_encode(base64_encode($accomodationDetail->package_start)).'&packEnd='.base64_encode(base64_encode($accomodationDetail->package_end)).'&infantCount='.base64_encode(base64_encode($infantCount));

                            // Minstay count check.
                            /* 
                                First check the room wise package minstay,
                                    if it's not available, checks the package wise min stay.

                                    if both are not ok, link will be redirected to the inquiry page.
                            */
                            $packageMinStay = ($room->package_room_min_stay) 
                                            ? $room->package_room_min_stay 
                                            : ($accomodationDetail->package_min_stay 
                                                ? explode(',', $accomodationDetail->package_min_stay)[1] 
                                                : 0
                                            );

                            if($packageMinStay && ($room->nightCount >= $packageMinStay)) {
                                $bookingUrl = base_url().'booking?bkg='.base64_encode($urlParams);
                            } else {
                                $bookingUrl = base_url('inquiry/main/internet-inquiry');
                            }

                    ?>
                    <div class="border-light rounded-4 px-30 py-30 sm:px-20 sm:py-20 <?=$mtCls?>">
                        <div class="row y-gap-20">
                            <div class="col-12">
                                <h3 class="text-18 fw-500 mb-15"><?=$room->room_title?></h3>
                                <div class="roomGrid">
                                    <div class="roomGrid__header">
                                        <div>Room Type</div>
                                        <div>Benefits</div>
                                        <div>Sleeps</div>
                                        <div>Price for <?=$nightCount?> night</div>
                                        <div>Select Rooms</div>
                                        <div></div>
                                    </div>
                                    <div class="roomGrid__grid">
                                        <div>
                                            <?php 
                                                $roomImage = PHOTO_DOMAIN.'default.jpg';
                                                if (!empty($room->roomImages)) {
                                                    $firstElement = reset($room->roomImages);
                                                    $roomImage = PHOTO_DOMAIN.'hotel_rooms/'.$firstElement->photo_path.'-std.jpg';
                                                }
                                            ?>
                                            <div class="ratio ratio-1:1">
                                                <img
                                                    src="<?=$roomImage?>"
                                                    alt="<?=$room->room_title?> image"
                                                    class="img-ratio rounded-4">
                                            </div>
                                            
                                            <?php if(!empty($room->roomAttributes)) { ?>
                                            <div class="y-gap-5 mt-20">
                                                <?php 
                                                    $inc = 0;
                                                    foreach ($room->roomAttributes as $aKey => $attr) {
                                                        if($inc == 4) break;
                                                ?>
                                                <div class="d-flex items-center">
                                                    <i class="<?=$attr->room_attr_icon?> text-20 mr-10"></i>
                                                    <div class="text-15"><?=$attr->room_attr_val?></div>
                                                </div>
                                                <?php 
                                                    $inc++; }
                                                    
                                                    // Convert PHP array to JSON and escape it for inclusion in HTML
                                                    $jsonData = json_encode($room->roomAttributes);
                                                    $escapedJsonData = htmlspecialchars($jsonData, ENT_QUOTES, 'UTF-8');
                                                ?>
                                                <?php if(count($room->roomAttributes) > 4) { ?>
                                                <div class="px-10 py-10 col-12 h-full">
                                                    <a href="javascript:void(0);" class="d-block text-15 fw-500 underline text-blue-1" onclick="showMoreRoomIncludes('<?=$room->room_title?>',<?=$escapedJsonData?>);">See All Attributes</a>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <?php } ?>
                                            <div class="galleryGrid__item">
                                                <div class="px-10 py-10 col-12 h-full">
                                                    <?php
                                                        foreach ($room->roomImages as $imageKey => $imageValue) {
                                                        $class = '';
                                                        $anchorText = '';
                                                        if ($imageKey == 0) {
                                                            $class = 'd-block text-15 fw-500 underline text-blue-1 mt-15';
                                                            $anchorText = 'See All '.count($room->roomImages).' Photos';
                                                        }
                                                        $image = PHOTO_DOMAIN.'hotel_rooms/'.$imageValue->photo_path.'-std.jpg';
                                                    ?>
                                                    <a href="<?=$image?>" class="<?=$class?> js-gallery" data-gallery="gallery2">
                                                        <?=$anchorText?>
                                                    </a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="y-gap-30">

                                            <div class="roomGrid__content">
                                                <div>
                                                    <div class="text-15 fw-500 mb-10">Your price includes:</div>

                                                    <div class="y-gap-8">
                                                        <?php
                                                            $mealPlan = $room->priceIncludes['default_meal_plan'] ?? $room->meal_plan_name;
                                                            if ($mealPlan != '') {
                                                        ?>
                                                            <div class="d-flex items-center text-green-2">
                                                                <i class="icon-check text-12 mr-10"></i>
                                                                <div class="text-15">Daily <?= $mealPlan ?></div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if($room->priceIncludes['default_transfer_name'] != '') { ?>
                                                            <div class="d-flex items-center text-green-2">
                                                                <i class="icon-check text-12 mr-10"></i>
                                                                <div class="text-15"><?=$room->priceIncludes['default_transfer_name']?></div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if($accomodationDetail->isTaxIncluded) { ?>
                                                        <div class="d-flex items-center text-green-2">
                                                            <i class="icon-check text-12 mr-10"></i>
                                                            <div class="text-15">All Payable Tax & Charges for Booking</div>
                                                        </div>
                                                        <div class="d-flex items-center text-green-2">
                                                            <i class="icon-check text-12 mr-10"></i>
                                                            <div class="text-15">Airport Pickup</div>
                                                        </div>
                                                        <!-- <ul class="list-disc y-gap-4 pt-5 ml-15">
                                                            <?php foreach ($room->priceIncludes['taxes'] as $taxType) { ?>
                                                            <li class="text-14"><?=$taxType?></li>
                                                            <?php } ?>
                                                        </ul> -->
                                                        <?php } ?>
                                                        <!-- <?php 
                                                            if($room->priceIncludes['applied_offer_name']) { 
                                                                foreach ($room->priceIncludes['applied_offer_name'] as $k => $val) {
                                                        ?>
                                                            <div class="d-flex items-center text-green-2">
                                                                <i class="icon-check text-12 mr-10"></i>
                                                                <div class="text-15"><?=$val?> applied</div>
                                                            </div>
                                                        <?php }} ?> -->
                                                        <?php 
                                                            if($room->roomOffers) {
                                                                echo('<div class="border-top-light mt-10 mb-10"></div>
                                                                    <div class="items-center text-center">
                                                                        <div class="text-15"><?=$room->Applied Offers</div>
                                                                    </div>');
                                                                foreach ($room->roomOffers as $offer) {
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
                                                        <div class="border-top-light mt-10 mb-10"></div>
                                                        <div class="d-flex items-center text-red-2">
                                                            <i class="icon-award text-12 mr-10"></i>
                                                            <div class="text-15"><?=$offerTitle?></div>
                                                        </div>
                                                        <?php }} ?>
                                                    </div>
                                                </div>

                                                <div>
                                                    <div class="d-flex items-center text-light-1">
                                                        <?php
                                                            $totalPax = (int)$room->adult + (int)$room->child + (int)$room->infant;
                                                            echo '<div class="pax-icons">'.str_repeat('<div class="icon-man text-24 mt-10"></div>', $totalPax).'</div>';
                                                        ?>
                                                    </div>
                                                </div>

                                                <div>
                                                    <div class="text-18 lh-15 fw-500"><?=$cur.''.number_format($room->calculatedPrice,2)?></div>
                                                    <div class="text-14 lh-18 text-light-1">Includes taxes and charges</div>
                                                </div>

                                                <div>

                                                    <div class="dropdown js-dropdown js-price-1-active">
                                                        <div
                                                            class="dropdown__button d-flex items-center rounded-4 border-light px-15 h-50 text-14"
                                                            data-el-toggle=".js-price-<?=$key?>-toggle"
                                                            data-el-toggle-active=".js-price-<?=$key?>-active">
                                                            <?php
                                                                $priceAmount = 0;
                                                                if ((int)$room->room_count >= $roomCount) {
                                                                    $priceAmount = floatval($room->calculatedPrice) * (int)$roomCount;
                                                                    $priceLabel = $roomCount.' ('.$cur.''.number_format($priceAmount,2).')';
                                                                } else {
                                                                    $priceAmount = floatval($room->calculatedPrice);
                                                                    $priceLabel = '1 ('.$cur.''.number_format($priceAmount,2).')';
                                                                }
                                                            ?>
                                                            <span class="js-dropdown-title"><?=$priceLabel?></span>
                                                            <i class="icon icon-chevron-sm-down text-7 ml-10"></i>
                                                        </div>

                                                        <div class="toggle-element -dropdown  js-click-dropdown js-price-<?=$key?>-toggle">
                                                            <div class="text-14 y-gap-15 js-dropdown-list">
                                                                <?php
                                                                    if ((int)$room->room_count >= (int)$roomCount) {
                                                                        $countPrice = 0;
                                                                        for ($i= 1; $i <= (int)$roomCount; $i++) {
                                                                            $countPrice = floatval($room->calculatedPrice) * (int)$i;
                                                                            $label = $i.' ('.$cur.''.number_format($countPrice,2).')';
                                                                            $sel = '';
                                                                            if ($i == $roomCount) {
                                                                                $sel = 'selected';
                                                                            }
                                                                ?>
                                                                <div>
                                                                    <a href="#" class="d-block js-dropdown-link price-list <?=$sel?>" room-count="<?=$i?>" room-price="<?=$countPrice?>" room-index="<?=$key?>"><?=$label?></a>
                                                                </div>
                                                                <?php }} else { ?>
                                                                    <?php
                                                                        $countPrice = 0;
                                                                        for ($i= 1; $i <= (int)$room->room_count; $i++) {
                                                                            $countPrice = floatval($room->calculatedPrice) * (int)$i;
                                                                            $label = $i.' ('.$cur.''.$countPrice.')';
                                                                            $sel = '';
                                                                            if ($i == 1) {
                                                                                $sel = 'selected';
                                                                            }
                                                                    ?>
                                                                    <div>
                                                                        <a href="#" class="d-block js-dropdown-link price-list <?=$sel?>" room-count="<?=$i?>" room-price="<?=$countPrice?>" room-index="<?=$key?>"><?=$label?></a>
                                                                    </div>
                                                                <?php }} ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="text-14 lh-1" id="room-count-for<?=$key?>"></div>
                                            <span class="text-22 fw-500 lh-17 mt-5" id="room-price-for<?=$key?>" total-pax="<?=$totalPax?>"></span> <span class="text-20 fw-500 lh-17 mt-5">/ <?=$room->nightCount?> Nights</span>

                                            <a href="<?=$bookingUrl?>" class="button h-50 px-24 -dark-1 bg-blue-1 text-white mt-10">
                                                Reserve
                                                <div class="icon-arrow-top-right ml-15"></div>
                                            </a>

                                            <div class="text-15 fw-500 mt-30">You'll be taken to the next step</div>

                                            <ul class="list-disc y-gap-4 pt-5">

                                                <li class="text-14">Confirmation is immediate</li>

                                                <li class="text-14">No registration required</li>

                                                <li class="text-14">No booking or credit card fees!</li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                </div>
            </section>
            <?php } ?>

            <div id="wine-and-dine"></div>
            <?php 
                if(!empty($hotelExtra)) { 
            ?>
            <section class="pt-40">
                <div class="container">
                    <div class="py-30 px-30 rounded-4 bg-white shadow-3">
                        <div class="tabs -underline-2 js-tabs">
                            <div class="tabs__controls row x-gap-40 y-gap-10 lg:x-gap-20 js-tabs-controls">
                                <?php 
                                    foreach ($hotelExtra as $k => $row) {
                                        $topicTitle = strtoupper($row->ae_name);
                                        $targetTab = url_title($row->ae_name, '-', true);
                                        $active = "";
                                        if ($k == 0) {
                                            $active = "is-tab-el-active";
                                        }
                                ?>
                                <div class="col-auto">
                                    <button
                                        class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 js-tabs-button <?=$active?>"
                                        data-tab-target=".<?=$targetTab?>"><?=$topicTitle?></button>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="tabs__content pt-30 js-tabs-content">
                                <?php 
                                    foreach ($accomodationDetail->hotelExtra as $k => $row) {
                                        $tabName = url_title($row->ae_name, '-', true);
                                        $active = "";
                                        if ($k == 0) {
                                            $active = "is-tab-el-active";
                                        }
                                ?>
                                <div class="tabs__pane <?=$tabName?> <?=$active?>">
                                    <div class="row y-gap-20">
                                        <?php 
                                            foreach ($row->childContent as $cK => $child) {
                                                $image = PHOTO_DOMAIN.'default.jpg';
                                                if ($child->photo_path != null && $child->photo_path != '') {
                                                    $image = PHOTO_DOMAIN.'hotel_extras/'.$child->photo_path.'-std.'.$child->file_ext;
                                                }
                                        ?>
                                        <div class="col-12">
                                            <div class="">
                                                <div class="row x-gap-20 y-gap-30">
                                                    <div class="col-md-auto">
                                                        <div class="cardImage ratio ratio-1:1 w-200 md:w-1/1 rounded-4">
                                                            <div class="cardImage__content">
                                                                <img class="rounded-4 col-12" src="<?=$image?>" alt="image">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md">
                                                        <h3 class="text-18 lh-14 fw-500"><?=$child->he_title?></h3>
                                                        <div class="row x-gap-10 y-gap-10 items-center pt-20">
                                                            <div class="col-auto">
                                                                <p class="text-14 p-scroll"><?=strip_tags($child->he_description)?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php } ?>

            <?php
                $healthBannerBottomClass = "";
                if (empty($accomodationDetail->hotelFaqs) && empty($relatedHotels)) {
                    $healthBannerBottomClass = 'layout-pb-lg';
                }
            ?>
            <section class="pt-40 <?=$healthBannerBottomClass?>">
                <div class="container"></div>
            </section>

            <?php if(!empty($accomodationDetail->hotelFaqs)) { ?>
            <section id="faq" class="pt-40 layout-pb-md">
                <div class="container">
                    <div class="pt-40 border-top-light">
                        <div class="row y-gap-20">
                            <div class="col-lg-4">
                                <h2 class="text-22 fw-500">
                                    FAQs about<br>
                                    <?=$accomodationDetail->hotel_name?>
                                </h2>
                            </div>

                            <div class="col-lg-8">
                                <div class="accordion -simple row y-gap-20 js-accordion">
                                    <?php foreach ($accomodationDetail->hotelFaqs as $faq) { ?>
                                    <div class="col-12">
                                        <div class="accordion__item px-20 py-20 border-light rounded-4">
                                            <div class="accordion__button d-flex items-center">
                                                <div class="accordion__icon size-40 flex-center bg-light-2 rounded-full mr-20">
                                                    <i class="icon-plus"></i>
                                                    <i class="icon-minus"></i>
                                                </div>

                                                <div class="button text-dark-1"><?=$faq->faq_question?></div>
                                            </div>

                                            <div class="accordion__content">
                                                <div class="pt-20 pl-60">
                                                    <p class="text-15"><?=strip_tags($faq->faq_answer)?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php } ?>

            <?php if(!empty($relatedHotels)) { ?>
            <section class="layout-pt-md layout-pb-lg" id="similar-list">
                <div class="container">
                    <div class="row justify-center text-center">
                        <div class="col-auto">
                            <div class="sectionTitle -md">
                                <h2 class="sectionTitle__title">Popular properties similar to <?=$accomodationDetail->hotel_name?></h2>
                                <p class=" sectionTitle__text mt-5 sm:mt-0">Interdum et malesuada fames ac ante ipsum</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row y-gap-30 pt-40 sm:pt-20">
                        <?php
                            foreach ($relatedHotels as $related) {
                                $resortId = base64_encode(base64_encode($related->ho_id));
                                $start_date = base64_encode(base64_encode($related->start_date));
                                $end_date = base64_encode(base64_encode($related->end_date));
                                $adults = base64_encode(base64_encode($related->adult));
                                $child = base64_encode(base64_encode($related->child));
                                $rooms = base64_encode(base64_encode($roomCount));

                                $urlSearch = "rid=".$resortId."&sd=".$start_date."&ed=".$end_date."&ac=".$adults."&cc=".$child."&rc=".$rooms."";
                        ?>
                        <div class="col-xl-3 col-lg-3 col-sm-6">

                            <a href="<?=base_url()?>detail?prs=<?=base64_encode($urlSearch)?>" class="hotelsCard -type-1 ">
                                <div class="hotelsCard__image">

                                    <div class="cardImage ratio ratio-1:1">
                                        <div class="cardImage__content">

                                            <img
                                                class="rounded-4 col-12"
                                                src="<?=PHOTO_DOMAIN.$related->photo_folder.'/'.$related->photo_path.'-std.'.$related->file_ext?>"
                                                alt="<?=$related->hotel_name?>">

                                        </div>

                                    </div>

                                </div>

                                <div class="hotelsCard__content mt-10">
                                    <h4 class="hotelsCard__title text-dark-1 text-18 lh-16 fw-500">
                                        <span><?=$related->hotel_name?></span>
                                    </h4>

                                    <p class="text-light-1 lh-14 text-14 mt-5"><?=$related->atoll?>, <?=$related->nicename?></p>

                                    <div class="d-flex items-center mt-20">
                                        <div class="flex-center bg-blue-1 rounded-4 size-30 text-12 fw-600 text-white"><?=number_format($related->stars,1)?></div>
                                        <div class="text-14 text-dark-1 fw-500 ml-10">Exceptional</div>
                                        <div class="text-14 text-light-1 ml-10"><?=str_pad($related->review_count, 2, "0", STR_PAD_LEFT)?> reviews</div>
                                    </div>

                                    <div class="mt-5">
                                        <div class="fw-500">
                                            Starting from
                                            <span class="text-blue-1"><?=$cur?><?=floatval($related->min_price + 0)?></span>
                                        </div>
                                    </div>
                                </div>
                            </a>

                        </div>
                        <?php } ?>
                    </div>
                </div>
            </section>
            <?php } ?>

            <?php $this->load->view('includes/subscribe'); ?>

            <?php $this->load->view('includes/footer'); ?>

            <div id="popup" class="popup">
                <div class="popup-content">
                    <span class="close-btn" id="closePopupBtn">&times;</span>
                    <h2 id="popup-title"></h2> <hr/>
                    <div class="row" id="room-include-popup"></div>
                </div>
            </div>
        </main>
        <div class="mapFilter" data-x="mapFilter" data-x-toggle="-is-active">
            <div class="mapFilter__overlay"></div>

            <div class="mapFilter__close">
                <button class="button -blue-1 size-40 bg-white shadow-2" data-x-click="mapFilter">
                <i class="icon-close text-15"></i>
                </button>
            </div>

            <div class="mapFilter__grid" data-x="mapFilter__grid" data-x-toggle="-filters-hidden">
                <iframe class="map-bottom-2" src="https://maps.google.com/maps?q=<?=$accomodationDetail->latitude?>,<?=$accomodationDetail->longitude?>&hl=en&z=14&amp;output=embed" allowfullscreen="true" loading="lazy" referrerpolicy="no-referrer-when-downgrade" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></iframe>
            </div>
        </div>

        <?php $this->load->view('includes/js'); ?>
        <script>
            $(document).ready(function() {

                // manually set the common search fields value when coming to the detail page. ÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷
                const detailPageSearchedType = 1;
                const detailPageSearchedValue = '<?=$accomodationDetail->ho_id?>';
                const detailPageSearchedName = '<?=$accomodationDetail->hotel_name?>';
                const detailPageIcon = 'icon-bed';
                const detailPageCountry = '<?=$accomodationDetail->nicename?>';

                const dropdownListItem = `<div><button class="-link d-block col-12 text-left rounded-4 px-20 py-15 js-search-option dropdown-button" type="${detailPageSearchedType}" value="${detailPageSearchedValue}" name-value="${detailPageSearchedName}" icon="${detailPageIcon}" country="${detailPageCountry}">
                                                <div class="d-flex">
                                                <div class="${detailPageIcon} text-light-1 text-20 pt-4"></div>
                                                <div class="ml-10">
                                                    <div class="text-15 lh-12 fw-500 js-search-option-target">${detailPageSearchedName}</div>
                                                    <div class="text-14 lh-12 text-light-1 mt-5">${detailPageCountry}</div>
                                                </div>
                                                </div>
                                            </button></div>`;
                $('.searchContent').append(dropdownListItem);

                setTimeout(() => {
                    const $button = $("#commonSearchContent").find(`button.dropdown-button[type="${detailPageSearchedType}"][value="${detailPageSearchedValue}"]`).first();
                    const selectedSearchValue = $button.find('div.js-search-option-target').text();
                    $('input[type="search"].js-search').val(selectedSearchValue);
                }, 500);
                // --------÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷÷

                $('.show-more').hide();
                const paraCount = $('#overview p').length;
                $('#overview p').addClass('text-dark-1 text-15 mt-20');
                $('#overview p').slice(2).addClass('hide-content');
                if (paraCount > 2) {
                    $('.show-more').show();
                    $('.hide-content').hide();
                }
                $("a.js-dropdown-link.price-list.selected").trigger('click'); // click the price dropdown when detail page is loading.
                localStorage.setItem('accomId', '<?=$accomodationDetail->ho_id?>');

                // Set start and end dates
                const calendarStart = new Date('<?=$startDate?>');
                const calendarEnd = new Date('<?=$end_date?>');

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

                $(`.table-calendar__grid div[date="<?=$startDate?>"]`).addClass('-is-active');
                dates.forEach(el => {
                    $(`.table-calendar__grid div[date="${el}"]`).addClass('-is-in-path');
                });
                $(`.table-calendar__grid div[date="<?=$end_date?>"]`).addClass('-is-active');

                // Get elements
                const closePopupBtn = document.getElementById('closePopupBtn');
                // const openPopupBtn = document.getElementById('openPopupBtn');
                const popup = document.getElementById('popup');

                /* // Open the popup
                openPopupBtn.addEventListener('click', () => {
                    popup.style.display = 'flex';
                }); */

                // Close the popup
                closePopupBtn.addEventListener('click', () => {
                    popup.style.display = 'none';
                });

                // Optional: Close the popup when clicking outside of it
                window.addEventListener('click', (event) => {
                    if (event.target === popup) {
                        popup.style.display = 'none';
                    }
                });

            });

            const clickShowMore = (type) => {
                if (type == 'show') {
                    $('.hide-content').show();
                    $('.show-more').text('Show less').attr('onclick', 'clickShowMore("hide")');
                } else {
                    $('.hide-content').hide();
                    $('.show-more').text('Show more').attr('onclick', 'clickShowMore("show")');;
                }
            }

            $(window).scroll(function() {
                const hasActiveClass = $('.singleMenu').hasClass('-is-active');
                if (hasActiveClass) {
                    $('header').removeClass('bg-dark-3');
                } else {
                    $('header').addClass('bg-dark-3');
                }
            });

            const showMoreRoomIncludes = (roomTitle,_attrArr) => {
                let popupContent = ``;
                for (const key in _attrArr) {
                    let attr = _attrArr[key];
                    popupContent += `<div class="col-md-4 col-sm-4 mb-10">
                                        <div class="d-flex items-center">
                                            <i class="${attr.room_attr_icon} text-20 mr-10"></i>
                                            <div class="text-15">${attr.room_attr_val}</div>
                                        </div>
                                    </div>`;
                }
                $('#popup-title').text(roomTitle);
                $('#room-include-popup').html(popupContent);
                document.getElementById('popup').style.display = 'flex'; // Show the popup
            }
        </script>
    </body>
</html>