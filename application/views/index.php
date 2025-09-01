<!DOCTYPE html>
<html lang="en" data-x="html" data-x-toggle="html-overflow-hidden">
    <head>
        <?php $this->load->view('includes/head'); ?>
        <meta content="<?=$pageMain->seo_keywords != '' ? $pageMain->seo_keywords : '' ?>" name="keywords">
        <meta content="<?=$pageMain->seo_description != '' ? $pageMain->seo_description : '' ?>" name="description">
        <title><?=$pageMain->seo_title != '' ? $pageMain->seo_title : 'Home' ?></title>
        <style>
            .date-disabled:hover {
                background-color: #eee;
            }
            .top-deals .cardImage__leftBadge {
                left: unset;
                right: 0;
                z-index: 9999;
                top: 10px;
            }
            .top-deals .cardImage__leftBadge .rounded-right-4 {
                border-radius: 4px 0 0 4px;
            }
            .font-visiblity {
                background-color: rgba(0,0,0,0.3);
            }
            .shaded-bg-content::before {
                background: linear-gradient(245deg, rgba(6, 17, 56, 0.13209033613445376) 0%, rgba(6, 17, 56, 0.5) 50%, rgba(6, 17, 56, 0.8) 100%) !important;
            }
            .content-position {
                position: absolute;
                bottom: 25px;
            }
        </style>
    </head>
    <body>
        <?php $this->load->view('includes/preloader'); ?>
        <main>
            <?php $this->load->view('includes/header'); ?>
            <div class="singleMenu js-singleMenu">
                <div class="col-12">
                    <div class="py-10" style="margin-top:100px;">
                        <div class="container">
                            <div class="row">
                                <?php $this->load->view('includes/common-search'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                $bannerImage = base_url().'/assets/img/masthead/1/bg.webp';
                if ($pageMain->photo_path != '' && $pageMain->photo_path != null) {
                    $bannerImage = PHOTO_DOMAIN.'pages/'.$pageMain->photo_path.'-org.jpg';
                }
            ?>
            <section data-anim-wrap="" class="masthead -type-1 z-5">
                <div data-anim-child="fade" class="masthead__bg">
                    <img src="#" alt="image" data-src="<?=$bannerImage?>" class="js-lazy">
                </div>
                <div class="container">
                    <div class="row justify-center">
                        <div class="col-auto">
                            <div class="text-center">
                                <h1
                                    data-anim-child="slide-up delay-4"
                                    class="text-60 lg:text-40 md:text-30 text-white">Find Next Place To Visit</h1>
                                <p data-anim-child="slide-up delay-5" class="text-white mt-6 md:mt-10">Discover amzaing places at exclusive deals</p>
                            </div>
                            <div data-anim-child="slide-up delay-6" class="tabs -underline mt-60 js-tabs">
                                <div class="tabs__content mt-30 md:mt-20 js-tabs-content">
                                    <div class="tabs__pane -tab-item-1 is-tab-el-active">
                                        <div
                                            class="mainSearch -w-900 bg-white px-10 py-10 lg:px-20 lg:pt-5 lg:pb-20 rounded-100">
                                            <div class="button-grid items-center">
                                                <div class="searchMenu-loc px-30 lg:py-20 lg:px-0 js-form-dd js-liverSearch">
                                                    <div data-x-dd-click="searchMenu-loc">
                                                        <h4 class="text-15 fw-500 ls-2 lh-16">Location</h4>
                                                        <div class="text-15 text-light-1 ls-2 lh-16">
                                                            <input
                                                                autocomplete="off"
                                                                type="search"
                                                                placeholder="Where are you going?"
                                                                class="js-search js-dd-focus">
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="searchMenu-loc__field shadow-2 js-popup-window"
                                                        data-x-dd="searchMenu-loc"
                                                        data-x-dd-toggle="-is-active">
                                                        <div class="bg-white px-30 py-30 sm:px-0 sm:py-15 rounded-4 dropdown-box">
                                                            <div class="y-gap-5 js-results searchContent" id="searchContent">
                                                                <?php 
                                                                    foreach($searchRecord as $key => $item) { 
                                                                        if ($key == 4) {
                                                                            break;
                                                                        }
                                                                ?>
                                                                <div>
                                                                    <button
                                                                        class="-link d-block col-12 text-left rounded-4 px-20 py-15 js-search-option dropdown-button" type="<?=$item['type']?>" value="<?=$item['id']?>" name-value="<?=$item['name']?>" icon="<?=$item['icon']?>" country="<?=$item['country']?>">
                                                                        <div class="d-flex">
                                                                            <div class="<?=$item['icon']?> text-light-1 text-20 pt-4"></div>
                                                                            <div class="ml-10">
                                                                                <div class="text-15 lh-12 fw-500 js-search-option-target"><?=$item['name']?></div>
                                                                                <div class="text-14 lh-12 text-light-1 mt-5"><?=$item['country']?></div>
                                                                            </div>
                                                                        </div>
                                                                    </button>
                                                                </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="searchMenu-date px-30 lg:py-20 lg:px-0 js-form-dd js-calendar">

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

                                                <div
                                                    class="searchMenu-guests px-30 lg:py-20 lg:px-0 js-form-dd js-form-counters">

                                                    <div data-x-dd-click="searchMenu-guests">
                                                        <h4 class="text-15 fw-500 ls-2 lh-16">Guest</h4>

                                                        <div class="text-15 text-light-1 ls-2 lh-16">
                                                            <span class="js-count-adult">2</span>
                                                            adults -
                                                            <span class="js-count-child">0</span>
                                                            children -
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
                                                                            <div class="text-15 js-count adult-count">2</div>
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
                                                                            <div class="text-15 js-count child-count">0</div>
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
                                                                            <div class="text-15 js-count infant-count">0</div>
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
                                                                            <div class="text-15 js-count room-count">1</div>
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

                                                <div class="button-item">
                                                    <button
                                                        class="mainSearch__submit button -dark-1 h-60 px-35 col-12 rounded-100 bg-blue-1 text-white search-button">
                                                        <i class="icon-search text-20 mr-10"></i>
                                                        Search
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Top Deals section -->
            <?php if(!empty($topDealsList) ) { ?>
            <section class="layout-pt-md layout-pb-md">
                <div data-anim-wrap="" class="container">
                    <div data-anim-child="slide-up delay-1" class="row justify-center text-center">
                        <div class="col-auto">
                            <div class="sectionTitle -md">
                                <h2 class="sectionTitle__title"><?=$pageTopDeals->headline?></h2>
                                <p class=" sectionTitle__text mt-5 sm:mt-0"><?=$pageTopDeals->second_title?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row y-gap-40 justify-between pt-40 sm:pt-20">
                        <?php 
                            $delayCount = 3;
                            foreach ($topDealsList as $key => $row) {
                                $colClass = 'col-xl-3';
                                $fullOrHalf = '';
                                $ratioClass = 'ratio ratio-1:1';
                                if ($key != 5 && $key % 2 == 1) {
                                    $colClass = 'col-xl-6';
                                    $fullOrHalf = 'h-full';
                                    $ratioClass = '';
                                }
                                $start_date = date('Y-m-d', $nextWeekFirstDay);
                                // $end_date = date('Y-m-d');
                                $end_date = date('Y-m-d', $nextWeekFourthDay);

                                // Night count calculation.
                                $date1 = new DateTime($start_date);
                                $date2 = new DateTime($end_date);

                                $interval = $date1->diff($date2);
                                $topDeaNightsCount = $interval->days;

                                $prs = 'st='.base64_encode(base64_encode('1')).'&sv='.base64_encode(base64_encode($row->resort_id)).'&ssd='.base64_encode(base64_encode($start_date)).'&sed='.base64_encode(base64_encode($end_date)).'&ac='.base64_encode(base64_encode($row->adult)).'&cc='.base64_encode(base64_encode('0')).'&rc='.base64_encode(base64_encode('1')).'&ic='.base64_encode(base64_encode('0'));
                                $url = base_url().'search?prs='.base64_encode($prs);

                                $packageStartAt = date('jS F Y', strtotime($row->start_date));
                                $packageEndAt = date('jS F Y', strtotime($row->end_date));
                        ?>
                        <div data-anim-child="slide-up delay-<?=$delayCount?>" class="<?=$colClass?> col-md-4 col-sm-6 top-deals">
                            <a href="<?=$url?>" class="citiesCard -type-3 d-block rounded-4 <?=$fullOrHalf?>">
                                <div class="citiesCard__image <?=$ratioClass?>">
                                    <img
                                        class="img-ratio js-lazy"
                                        src="<?=$url?>"
                                        data-src="<?=PHOTO_DOMAIN.'hotels/'.$row->photo_path.'-std.jpg'?>"
                                        alt="<?=$row->hotel_name?>">
                                </div>
                                <?php if($row->tag != '') { ?>
                                <div class="cardImage__leftBadge">
                                    <div
                                        class="py-5 px-15 rounded-right-4 text-12 lh-16 fw-500 uppercase bg-dark-1 text-white">
                                        <?=$row->tag?>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="citiesCard__content px-30 pt-30 font-visiblity shaded-bg-content">
                                    <div class="content-position">
                                        <h4 class="text-22 fw-600 text-white"><?=$row->hotel_name?></h4>
                                        <div class="text-15 text-white">Valid till <?=$packageEndAt?></div>
                                        <div class="text-18 fw-500 text-white"><?=$cur?><?=($row->calculated_final_amount)?> for <?=$row->adult?> adults <?=$topDeaNightsCount?> Night<?=$topDeaNightsCount > 1 ? 's' : ''?></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php $delayCount++;} ?>
                    </div>
                </div>
            </section>
            <?php } ?>

            <!-- Popular resorts -->
            <?php if(!empty($popularResortList) ) { ?>
            <section class="layout-pt-lg layout-pb-md">
                <div data-anim-wrap="" class="container">
                    <div
                        data-anim-child="slide-up delay-1"
                        class="row y-gap-20 justify-between items-end">
                        <div class="col-auto">
                            <div class="sectionTitle -md">
                                <h2 class="sectionTitle__title"><?=$pagePopularResorts->headline?></h2>
                                <p class=" sectionTitle__text mt-5 sm:mt-0"><?=strip_tags($pagePopularResorts->page_text)?></p>
                            </div>
                        </div>

                        <div class="col-auto">
                            <?php 
                                $prs = 'st='.base64_encode(base64_encode('0')).'&sv='.base64_encode(base64_encode('0')).'&ssd='.base64_encode(base64_encode(date('Y-m-d',$nextWeekFirstDay))).'&sed='.base64_encode(base64_encode(date('Y-m-d', $nextWeekFourthDay))).'&ac='.base64_encode(base64_encode('2')).'&cc='.base64_encode(base64_encode('0')).'&rc='.base64_encode(base64_encode('1')).'&ic='.base64_encode(base64_encode('0'));
                            ?>
                            <a href="<?=base_url().'search?prs='.base64_encode($prs)?>" class="button -md -blue-1 bg-blue-1-05 text-blue-1">
                                <?=$pagePopularResorts->second_title?>
                                <div class="icon-arrow-top-right ml-15"></div>
                            </a>

                        </div>
                    </div>

                    <div
                        class="relative overflow-hidden pt-40 sm:pt-20 js-section-slider"
                        data-gap="30"
                        data-scrollbar=""
                        data-slider-cols="xl-4 lg-3 md-2 sm-2 base-1"
                        data-nav-prev="js-hotels-prev"
                        data-pagination="js-hotels-pag"
                        data-nav-next="js-hotels-next">
                        <div class="swiper-wrapper">
                            <?php 
                                $delay = 2;
                                foreach ($popularResortList as $ppr) { 
                                    if ($delay > 5) {
                                        $delay = 5;
                                    }
                                    $prs = 'st='.base64_encode(base64_encode('1')).'&sv='.base64_encode(base64_encode($ppr->ho_id)).'&ssd='.base64_encode(base64_encode(date('Y-m-d', $nextWeekFirstDay))).'&sed='.base64_encode(base64_encode(date('Y-m-d', $nextWeekFourthDay))).'&ac='.base64_encode(base64_encode('2')).'&cc='.base64_encode(base64_encode('0')).'&rc='.base64_encode(base64_encode('1')).'&ic='.base64_encode(base64_encode('0'));
                                    $url = base_url().'search?prs='.base64_encode($prs);
                            ?>
                            <div data-anim-child="slide-up delay-<?=$delay?>" class="swiper-slide">

                                <a href="<?=$url?>" class="tourCard -type-1 rounded-4 ">
                                    <div class="tourCard__image">
                                        <div class="cardImage ratio ratio-1:1">
                                            <div class="cardImage__content">
                                                <img class="rounded-4 col-12" src="<?=PHOTO_DOMAIN?>hotels/<?=$ppr->photo_path?>-std.jpg" alt="<?=$ppr->hotel_name?>">
                                            </div>
                                            <div class="cardImage__leftBadge">
                                                <div
                                                    class="py-5 px-15 rounded-right-4 text-12 lh-16 fw-500 uppercase bg-dark-1 text-white">
                                                    POPULAR
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tourCard__content mt-10">
                                        <h4 class="tourCard__title text-dark-1 text-18 lh-16 fw-500">
                                            <span><?=$ppr->hotel_name?></span>
                                        </h4>

                                        <p class="text-light-1 lh-14 text-14 mt-5"><?=$ppr->atoll?>, <?=$ppr->country?></p>

                                        <div class="row justify-between items-center pt-15">
                                            <div class="col-auto">
                                                <div class="d-flex items-center">
                                                    <div class="d-flex items-center x-gap-5">
                                                        <?=str_repeat('<div class="icon-star text-yellow-1 text-10"></div>', $ppr->stars)?>
                                                    </div>
                                                    <div class="text-14 text-light-1 ml-10"><?=$ppr->review_count?> reviews</div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="text-14 text-light-1">
                                                    From
                                                    <span class="text-16 fw-500 text-dark-1"><?=$cur?><?=($ppr->calculated_per_night_price+0)?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </div>
                            <?php $delay++; } ?>
                        </div>

                        <div class="d-flex x-gap-15 items-center justify-center pt-40 sm:pt-20">
                            <div class="col-auto">
                                <button class="d-flex items-center text-24 arrow-left-hover js-hotels-prev">
                                    <i class="icon icon-arrow-left"></i>
                                </button>
                            </div>

                            <div class="col-auto">
                                <div class="pagination -dots text-border js-hotels-pag"></div>
                            </div>

                            <div class="col-auto">
                                <button class="d-flex items-center text-24 arrow-right-hover js-hotels-next">
                                    <i class="icon icon-arrow-right"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
            <?php } ?>
            
            <section class="layout-pb-md">
                <div data-anim-wrap="" class="container">
                    <div data-anim-child="slide-up delay-1" class="row y-gap-30">
                        <div class="col-xl-4 col-lg-5 why-choose-us">
                            <h2 class="text-30 fw-600"><?=$pageWhyChooseUs->headline?></h2>
                            <p class="mt-5"><?=$pageWhyChooseUs->second_title?></p>
                            <?=$pageWhyChooseUs->page_text?>
                            <div class="d-inline-block mt-40 sm:mt-20">

                                <a href="<?=base_url()?>about-us/#whychooseus" class="button -md -blue-1 bg-yellow-1 text-dark-1">
                                    Learn More
                                    <div class="icon-arrow-top-right ml-15"></div>
                                </a>

                            </div>
                        </div>

                        <div class="col-xl-6 offset-xl-1 col-lg-7">
                            <div class="row y-gap-60">

                                <div data-anim-child="slide-up delay-3" class="col-sm-6">
                                    <img src="<?=base_url()?>assets/img/featureIcons/3/1.svg" alt="image" class="size-60">
                                    <h5 class="text-18 fw-500 mt-10"><?=$pageBestTravelAgent->headline?></h5>
                                    <p class="mt-10"><?=strip_tags($pageBestTravelAgent->page_text)?></p>
                                </div>

                                <div data-anim-child="slide-up delay-4" class="col-sm-6">
                                    <img src="<?=base_url()?>assets/img/featureIcons/3/2.svg" alt="image" class="size-60">
                                    <h5 class="text-18 fw-500 mt-10"><?=$pageBestPrice->headline?></h5>
                                    <p class="mt-10"><?=strip_tags($pageBestPrice->page_text)?></p>
                                </div>

                                <div data-anim-child="slide-up delay-5" class="col-sm-6">
                                    <img src="<?=base_url()?>assets/img/featureIcons/3/3.svg" alt="image" class="size-60">
                                    <h5 class="text-18 fw-500 mt-10"><?=$pageBestTrustSafty->headline?></h5>
                                    <p class="mt-10"><?=strip_tags($pageBestTrustSafty->page_text)?></p>
                                </div>

                                <div data-anim-child="slide-up delay-6" class="col-sm-6">
                                    <img src="<?=base_url()?>assets/img/featureIcons/3/4.svg" alt="image" class="size-60">
                                    <h5 class="text-18 fw-500 mt-10"><?=$pageFastBooking->headline?></h5>
                                    <p class="mt-10"><?=strip_tags($pageFastBooking->page_text)?></p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="section-bg layout-pt-lg layout-pb-lg">
                <div class="section-bg__item bg-light-2" style="width: 100%;"></div> <!-- removed classes: -right -w-1165 -->
                <!-- <div class="section-bg__item -video-left">
                    <div class="row y-gap-30">
                        <?php foreach ($pageAboutUsPics as $aboutSlider) {?>
                        <div class="col-sm-6">
                            <img src="<?=PHOTO_DOMAIN.'pages/'.$aboutSlider->photo_path.'-std.jpg'?>" alt="image">
                        </div>
                        <?php } ?>
                    </div>
                </div> -->

                <div class="container lg:mt-30">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 text-center"> <!-- removed class: offset-xl-6 | changed classes: col-xl-5 col-lg-6 | added class: text-center  -->
                            <h2 class="text-30 fw-600"><?=$pageAboutUs->headline?></h2>
                            <p class="text-dark-1 mt-40 lg:mt-20 sm:mt-15"><?=strip_tags($pageAboutUs->page_text);?></p>

                            <div class="d-inline-block mt-40 lg:mt-30 sm:mt-20">

                                <a href="<?=base_url('about-us')?>" class="button -md -blue-1 bg-yellow-1 text-dark-1">
                                    Learn More
                                    <div class="icon-arrow-top-right ml-15"></div>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Popular Atolls -->
            <?php if (!empty($popularAtollList)) { ?>
            <section class="layout-pt-md layout-pb-lg">
                <div data-anim-wrap="" class="container">
                    <div
                        data-anim-child="slide-up delay-1"
                        class="row y-gap-20 justify-center text-center">
                        <div class="col-auto">
                            <div class="sectionTitle -md">
                                <h2 class="sectionTitle__title"><?=$pagePopularAtolls->headline?></h2>
                                <p class=" sectionTitle__text mt-5 sm:mt-0"><?=$pagePopularAtolls->second_title?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row y-gap-30 pt-40">
                    <?php 
                        $delay = 2;
                        foreach ($popularAtollList as $row) {
                            $prs = 'st='.base64_encode(base64_encode('2')).'&sv='.base64_encode(base64_encode($row->atoll_id)).'&ssd='.base64_encode(base64_encode(date('Y-m-d', $nextWeekFirstDay))).'&sed='.base64_encode(base64_encode(date('Y-m-d', $nextWeekFourthDay))).'&ac='.base64_encode(base64_encode('2')).'&cc='.base64_encode(base64_encode('0')).'&rc='.base64_encode(base64_encode('1')).'&ic='.base64_encode(base64_encode('0'));
                            $url = base_url().'search?prs='.base64_encode($prs);
                    ?>
                        <div data-anim-child="slide-up delay-<?=$delay?>" class="col-xl-2 col-lg-3 col-sm-6">
                            <a href="<?=$url?>" class="citiesCard -type-4 d-block text-center">
                                <div class="citiesCard__image size-160 rounded-full mx-auto">
                                    <img
                                        class="object-cover js-lazy"
                                        src="<?=$url?>"
                                        data-src="<?=PHOTO_DOMAIN?>atoll_details/<?=$row->photo_path?>-std.jpg"
                                        alt="<?=$row->name?>">
                                </div>
                                <div class="citiesCard__content mt-10">
                                    <h4 class="text-18 lh-13 fw-500 text-dark-1"><?=$row->name?></h4>
                                    <div class="text-14 text-light-1"><?=$row->hotel_count?> Resorts & <?=$row->room_count?> Rooms</div>
                                </div>
                            </a>
                        </div>
                    <?php $delay++; } ?>
                    </div>
                </div>
            </section>
            <?php } ?>
            <?php $this->load->view('includes/footer'); ?>
        </main>
        <?php $this->load->view('includes/js'); ?>
        <script>
            $(document).ready(function() {
                $('.pop-balance-atolls').hide();
                $('.why-choose-us p:not(:first)').addClass('text-dark-1 mt-40 sm:mt-20');

                const start = '<?=date('Y-m-d', $nextWeekFirstDay)?>';
                const end = '<?=date('Y-m-d', $nextWeekFourthDay)?>';


                // Set start and end dates
                const calendarStart = new Date(start);
                const calendarEnd = new Date(end);

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

                $(`.table-calendar__grid div[date="${start}"]`).addClass('-is-active');
                dates.forEach(el => {
                    $(`.table-calendar__grid div[date="${el}"]`).addClass('-is-in-path');
                });
                $(`.table-calendar__grid div[date="${end}"]`).addClass('-is-active');
            });

            (function() {
                const originalSetItem = localStorage.setItem;
                const originalRemoveItem = localStorage.removeItem;

                // Override setItem method
                localStorage.setItem = function(key, value) {
                    const event = new Event('localStorageChange');
                    event.key = key;
                    event.newValue = value;
                    event.oldValue = localStorage.getItem(key);
                    originalSetItem.apply(this, arguments); // Call the original setItem method
                    window.dispatchEvent(event); // Dispatch the custom event
                };

                // Override removeItem method
                localStorage.removeItem = function(key) {
                    const event = new Event('localStorageChange');
                    event.key = key;
                    event.oldValue = localStorage.getItem(key);
                    event.newValue = null;
                    originalRemoveItem.apply(this, arguments); // Call the original removeItem method
                    window.dispatchEvent(event); // Dispatch the custom event
                };
            })();
            
            let firstItemIndex = lastItemIndex = searchType = searchValue = 0; // initialize the variables.
            let  searchedNameValue = searchedIcon = searchedCountry = ''; // initialize the variables.
            window.addEventListener('localStorageChange', (event) => {
                if(event.newValue != '') {
                    /* console.log(`LocalStorage key "${event.key}" changed.`);
                    console.log("Old Value:", event.oldValue);
                    console.log("New Value:", event.newValue); */
                    if(event.key == 'searchStartDate' || event.key == 'searchEndDate') { 
                        $('div[data-index]').removeClass('-is-in-path -is-active'); // remove already added both classes.
                        if(event.key == 'searchStartDate') {
                            $('.js-first-date').html(formatDate(event.newValue)); // if changed value is start date value, then format that date and replace it.
                            firstItemIndex = getDateIndex($(`div[date="${event.newValue}"]`)); // get the data-index value of the selected start date.
                        } else if(event.key == 'searchEndDate') {
                            $('.js-last-date').html(formatDate(event.newValue)); // if changed value is end date value, the format that date and replace it.
                            lastItemIndex = getDateIndex($(`div[date="${event.newValue}"]`)); // get the data-index value of the selected end date.
                        }
                        
                        const iterationCount = Math.abs(
                            firstItemIndex - lastItemIndex
                        ); // get the difference between both start and end dates indexes.
                        for (let l = 1; l < iterationCount; l++) {
                            $(`div[data-index="${(firstItemIndex) + l}"]`).addClass('-is-in-path'); // select the paths which are between the start and end dates.
                        }
                        $(`div[data-index="${firstItemIndex}"]`).addClass('-is-active'); // make start date active
                        $(`div[data-index="${lastItemIndex}"]`).addClass('-is-active'); // make end date active
                    } else if (['searchType', 'searchValue', 'searchedNameValue', 'searchedIcon', 'searchedCountry'].includes(event.key)) {
                        // Update variables based on the event key
                        switch (event.key) {
                            case 'searchType':
                                searchType = event.newValue;
                                break;
                            case 'searchValue':
                                searchValue = event.newValue;
                                break;
                            case 'searchedNameValue':
                                searchedNameValue = event.newValue;
                                break;
                            case 'searchedIcon':
                                searchedIcon = event.newValue;
                                break;
                            case 'searchedCountry':
                                searchedCountry = event.newValue;
                                break;
                            default:
                                break;
                        }

                        // Generate a unique ID for the new item
                        const uniqueId = Date.now();

                        // Create and append the new dropdown list item
                        const dropdownListItem = `
                            <div>
                                <button class="-link d-block col-12 text-left rounded-4 px-20 py-15 js-search-option dropdown-button" data-id="${uniqueId}" type="${searchType}" value="${searchValue}" name-value="${searchedNameValue}" icon="${searchedIcon}" country="${searchedCountry}">
                                    <div class="d-flex">
                                        <div class="${searchedIcon} text-light-1 text-20 pt-4"></div>
                                        <div class="ml-10">
                                            <div class="text-15 lh-12 fw-500 js-search-option-target">${searchedNameValue}</div>
                                            <div class="text-14 lh-12 text-light-1 mt-5">${searchedCountry}</div>
                                        </div>
                                    </div>
                                </button>
                            </div>
                        `;
                        
                        // Append the new item
                        $('.searchContent').append(dropdownListItem);

                        // Remove 'selected' class from all buttons
                        $('.searchContent .dropdown-button').removeClass('selected');

                        // Use setTimeout to ensure the new button is in the DOM
                        setTimeout(() => {
                            const $button = $(".searchContent").find(`button[data-id="${uniqueId}"]`).first();
                            if ($button.length) {
                                $button.addClass('selected'); // Add a class to highlight the latest button
                                
                                // Set the input value based on the new button
                                const selectedSearchValue = $button.find('div.js-search-option-target').text();
                                $('input[type="search"].js-search').val(selectedSearchValue);
                            }
                        }, 100); // Adjust the timeout duration if needed
                    }
                }
            });

            $('.js-up, .js-down').on('click', function() {
                const containAttr = $(this).parent('div').attr('data-value-change');
                // const paxCount = parseInt($(this).siblings('div').find('div.js-count').text()) + 1;

                // Determine whether to increment or decrement the count
                let paxCount = parseInt($(this).siblings('div').find('div.js-count').text());
                paxCount = $(this).hasClass('js-up') ? paxCount + 1 : paxCount - 1;

                // Ensure paxCount doesn't go below 0
                if (paxCount < 0) paxCount = 0;

                switch (containAttr) {
                    case '.js-count-adult':
                        const jsAdulcCountClass = $(this).siblings('div').find('div.js-count').hasClass('adult-count');
                        paxCount = paxCount == 0 ? 1 : paxCount; // when paxCount is 0, only for the adult, it made as 1. 
                        $('span.js-count-adult').text(paxCount)
                        if(jsAdulcCountClass) {
                            $(`div.common-adult-count`).text(paxCount);
                        } else {
                            $(`div.adult-count`).text(paxCount);
                        }
                        break;
                    case '.js-count-child':
                        const jsChildCountClass = $(this).siblings('div').find('div.js-count').hasClass('child-count');
                        $('span.js-count-child').text(paxCount)
                        if(jsChildCountClass) {
                            $(`div.common-child-count`).text(paxCount);
                        } else {
                            $(`div.child-count`).text(paxCount);
                        }
                        break;
                    case '.js-count-infant':
                        const jsInfantCountClass = $(this).siblings('div').find('div.js-count').hasClass('infant-count');
                        if(jsInfantCountClass) {
                            $(`div.common-infant-count`).text(paxCount);
                        } else {
                            $(`div.infant-count`).text(paxCount);
                        }
                        break;
                    case '.js-count-room':
                        const jsRoomCountClass = $(this).siblings('div').find('div.js-count').hasClass('room-count');
                        $('span.js-count-room').text(paxCount)
                        if(jsRoomCountClass) {
                            $(`div.common-room-count`).text(paxCount);
                        } else {
                            $(`div.room-count`).text(paxCount);
                        }
                        break;
                    default:
                        break;
                }
            });

            function getDateIndex(element) {
                return parseInt(element.attr("data-index"));
            }

        </script>
    </body>
</html>