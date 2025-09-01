<!DOCTYPE html>
<html lang="en" data-x="html" data-x-toggle="html-overflow-hidden">
    <head>
        <meta content="<?=$pageMain->seo_keywords != '' ? $pageMain->seo_keywords : '' ?>" name="keywords">
        <meta content="<?=$pageMain->seo_description != '' ? $pageMain->seo_description : '' ?>" name="description">
        <title><?=$pageMain->seo_title != '' ? $pageMain->seo_title : 'Accommodation List' ?></title>
        <?php $this->load->view('includes/head'); ?>
        <link rel="stylesheet" href="<?=base_url()?>assets/css/toastr.min.css">
        <style>
            .date-disabled:hover {
                background-color: #eee;
            }
            .star-active {
                border-color: var(--color-blue-1);
                background-color: var(--color-blue-1) !important;
                color: white !important;
            }
            .map-bottom-2 {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }
            #pagination_ul div {
                cursor: pointer;
            }
            #pagination_ul div.rounded-full:not(.bg-dark-1):hover {
                background-color: var(--color-light-2) !important;
            }
            .tooltip__content ul, .tooltip__content li {
                list-style: inside !important;
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
            <!-- Search -->
            <section class="pb-20 bg-light-2">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div
                                class="mainSearch -col-3-big bg-white px-10 py-10 lg:px-20 lg:pt-5 lg:pb-20 rounded-4 mt-30">
                                <div class="button-grid items-center">
                                    <div class="searchMenu-loc pl-20 lg:py-20 lg:px-0 js-form-dd js-liverSearch">
                                        <div data-x-dd-click="searchMenu-loc">
                                            <h4 class="text-15 fw-500 ls-2 lh-16">Location</h4>

                                            <div class="text-15 text-light-1 ls-2 lh-16">
                                                <input
                                                    autocomplete="off"
                                                    type="search"
                                                    placeholder="Where are you go..."
                                                    class="js-search js-dd-focus"/>
                                            </div>
                                        </div>

                                        <div
                                            class="searchMenu-loc__field shadow-2 js-popup-window"
                                            data-x-dd="searchMenu-loc"
                                            data-x-dd-toggle="-is-active">
                                            <div class="bg-white px-30 py-30 sm:px-0 sm:py-15 rounded-4">
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
                                            <h4 class="text-15 fw-500 ls-2 lh-16">
                                                Check in - Check out
                                            </h4>

                                            <div class="text-15 text-light-1 ls-2 lh-16">
                                                <span class="js-first-date"><?=date('D j M', strtotime($ssd))?></span>
                                                -
                                                <span class="js-last-date"><?=date('D j M', strtotime($sed))?></span>
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
                                                <span class="js-count-adult"><?=$ac?></span>
                                                adults -
                                                <span class="js-count-child"><?=$cc?></span>
                                                children -
                                                <span class="js-count-room"><?=$rc?></span>
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
                                                                <div class="text-15 js-count adult-count"><?=$ac?></div>
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
                                                            Ages 3 - 12
                                                        </div>
                                                    </div>

                                                    <div class="col-auto">
                                                        <div class="d-flex items-center js-counter" data-value-change=".js-count-child">
                                                            <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-down">
                                                                <i class="icon-minus text-12"></i>
                                                            </button>

                                                            <div class="flex-center size-20 ml-15 mr-15">
                                                                <div class="text-15 js-count child-count"><?=$cc?></div>
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
                                                        <div class="text-14 lh-12 text-light-1 mt-5">
                                                            Ages 0 - 2
                                                        </div>
                                                    </div>

                                                    <div class="col-auto">
                                                        <div class="d-flex items-center js-counter" data-value-change=".js-count-infant">
                                                            <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-down">
                                                                <i class="icon-minus text-12"></i>
                                                            </button>

                                                            <div class="flex-center size-20 ml-15 mr-15">
                                                                <div class="text-15 js-count infant-count"><?=$ic?></div>
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
                                                                <div class="text-15 js-count room-count"><?=$rc?></div>
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
                                            class="mainSearch__submit button -dark-1 py-15 px-40 col-12 rounded-4 bg-blue-1 text-white search-button">
                                            <i class="icon-search text-20 mr-10"></i>
                                            Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <section class="layout-pt-md layout-pb-lg">
                <div class="container">
                    <div class="row y-gap-30">
                        <div class="col-xl-3 col-lg-4 lg:d-none">
                            <aside class="sidebar y-gap-40">
                                <div class="sidebar__item -no-border">
                                    <h5 class="text-18 fw-500 mb-10">Search by property name</h5>
                                    <div class="single-field relative d-flex items-center py-10">
                                        <input
                                            class="pl-50 border-light text-dark-1 h-50 rounded-8"
                                            type="text"
                                            placeholder="e.g. Ayada Maldives" id="search-property-name"/>
                                        <button class="absolute d-flex items-center h-full">
                                            <i class="icon-search text-20 px-15 text-dark-1"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="sidebar__item">
                                    <h5 class="text-18 fw-500 mb-10">Property types</h5>
                                    <div class="sidebar-checkbox">
                                        <?php foreach ($propertyTypes as $row) {?>
                                        <div class="row y-gap-10 items-center justify-between">
                                            <div class="col-auto">
                                                <div class="d-flex items-center">
                                                    <div class="form-checkbox">
                                                        <input type="checkbox" name="property_types" value="<?=$row->ht_id?>" onchange="filterList();"/>
                                                        <div class="form-checkbox__mark">
                                                            <div class="form-checkbox__icon icon-check"></div>
                                                        </div>
                                                    </div>
                                                    <div class="text-15 ml-10"><?=$row->name?></div>
                                                </div>
                                            </div>

                                            <div class="col-auto">
                                                <div class="text-15 text-light-1"><?=str_pad($row->count, 2, '0', STR_PAD_LEFT)?></div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="sidebar__item">
                                    <h5 class="text-18 fw-500 mb-10">Sort By</h5>
                                    <div class="sidebar-checkbox">
                                        <div class="row y-gap-10 items-center justify-between">
                                            <div class="col-auto">
                                                <div class="form-radio d-flex items-center ">
                                                    <div class="radio">
                                                    <input type="radio" name="sort_by" value="by_name">
                                                    <div class="radio__mark">
                                                        <div class="radio__icon"></div>
                                                    </div>
                                                    </div>
                                                    <div class="ml-10">Name Ascending</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row y-gap-10 items-center justify-between">
                                            <div class="col-auto">
                                                <div class="form-radio d-flex items-center ">
                                                    <div class="radio">
                                                    <input type="radio" name="sort_by" value="by_price_low_to_high">
                                                    <div class="radio__mark">
                                                        <div class="radio__icon"></div>
                                                    </div>
                                                    </div>
                                                    <div class="ml-10">Price Low to High</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row y-gap-10 items-center justify-between">
                                            <div class="col-auto">
                                                <div class="form-radio d-flex items-center ">
                                                    <div class="radio">
                                                    <input type="radio" name="sort_by" value="by_price_high_to_low">
                                                    <div class="radio__mark">
                                                        <div class="radio__icon"></div>
                                                    </div>
                                                    </div>
                                                    <div class="ml-10">Price High to Low</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row y-gap-10 items-center justify-between">
                                            <div class="col-auto">
                                                <div class="form-radio d-flex items-center ">
                                                    <div class="radio">
                                                    <input type="radio" name="sort_by" value="by_review">
                                                    <div class="radio__mark">
                                                        <div class="radio__icon"></div>
                                                    </div>
                                                    </div>
                                                    <div class="ml-10">Review High to Low</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="sidebar__item pb-30">
                                    <h5 class="text-18 fw-500 mb-10">Nightly Price</h5>
                                    <div class="row x-gap-10 y-gap-30">
                                        <div class="col-12">
                                            <div class="js-price-rangeSlider">
                                                <div class="text-14 fw-500"></div>

                                                <div class="d-flex justify-between mb-20">
                                                    <div class="text-15 text-dark-1">
                                                        <span class="js-lower"></span>
                                                        -
                                                        <span class="js-upper"></span>
                                                    </div>
                                                </div>

                                                <div class="px-5">
                                                    <div class="js-slider"></div>
                                                </div>
                                                <input type="hidden" class="min-price" id="price0" value="<?=($minMaxRoomPrices->min_price + 0)?>" />
                                                <input type="hidden" class="max-price" id="price1" value="<?=($minMaxRoomPrices->max_price + 0)?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="sidebar__item">
                                    <h5 class="text-18 fw-500 mb-10">Villa Types</h5>
                                    <div class="sidebar-checkbox">
                                        <?php foreach ($villaTypes as $row) { ?>
                                        <div class="row y-gap-10 items-center justify-between">
                                            <div class="col-auto">
                                                <div class="d-flex items-center">
                                                    <div class="form-checkbox">
                                                        <input type="checkbox" name="villa_types" value="<?=$row->vt_id?>" onchange="filterList();"/>
                                                        <div class="form-checkbox__mark">
                                                            <div class="form-checkbox__icon icon-check"></div>
                                                        </div>
                                                    </div>

                                                    <div class="text-15 ml-10"><?=$row->vt_name?></div>
                                                </div>
                                            </div>

                                            <!-- <div class="col-auto">
                                                <div class="text-15 text-light-1">92</div>
                                            </div> -->
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="sidebar__item">
                                    <h5 class="text-18 fw-500 mb-10">Star Rating</h5>
                                    <div class="row x-gap-10 y-gap-10 pt-10">
                                        <?php for ($i=1; $i <= 7; $i++) {  ?>
                                        <div class="col-auto">
                                            <a href="javascript:void(0);" class="button -blue-1 bg-blue-1-05 text-blue-1 py-5 px-20 rounded-100 stars" star-val="<?=$i?>" onclick="clickStar(); filterList();"><?=$i?></a>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="sidebar__item">
                                    <h5 class="text-18 fw-500 mb-10">Transfer</h5>
                                    <div class="sidebar-checkbox">
                                        <?php foreach ($transferTypes as $row) { ?>
                                        <div class="row y-gap-10 items-center justify-between">
                                            <div class="col-auto">
                                                <div class="d-flex items-center">
                                                    <div class="form-checkbox">
                                                        <input type="checkbox" name="transfer_type" value="<?=$row->tras_id?>" onchange="filterList();"/>
                                                        <div class="form-checkbox__mark">
                                                            <div class="form-checkbox__icon icon-check"></div>
                                                        </div>
                                                    </div>

                                                    <div class="text-15 ml-10"><?=$row->transfer_type?></div>
                                                </div>
                                            </div>

                                            <!-- <div class="col-auto">
                                                <div class="text-15 text-light-1">92</div>
                                            </div> -->
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="sidebar__item">
                                    <h5 class="text-18 fw-500 mb-10">Atolls</h5>
                                    <div class="sidebar-checkbox">
                                        <?php foreach ($atollList as $row) { ?>
                                        <div class="row y-gap-10 items-center justify-between">
                                            <div class="col-auto">
                                                <div class="d-flex items-center">
                                                    <div class="form-checkbox">
                                                        <input type="checkbox" name="atoll_list" value="<?=$row->atoll_id?>" onchange="filterList();"/>
                                                        <div class="form-checkbox__mark">
                                                            <div class="form-checkbox__icon icon-check"></div>
                                                        </div>
                                                    </div>

                                                    <div class="text-15 ml-10"><?=$row->name?></div>
                                                </div>
                                            </div>

                                            <div class="col-auto">
                                                <div class="text-15 text-light-1"><?=str_pad($row->count, 2, '0', STR_PAD_LEFT)?></div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </aside>
                        </div>

                        <div class="col-xl-9 col-lg-8">
                            <div class="row y-gap-10 items-center justify-between">
                                <div class="col-auto">
                                    <div class="text-18">
                                        <span class="fw-500" id="total-properties"></span>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="row x-gap-20 y-gap-20">
                                        <!-- <div class="col-auto">
                                            <button
                                                class="button -blue-1 h-40 px-20 rounded-100 bg-blue-1-05 text-15 text-blue-1">
                                                <i class="icon-up-down text-14 mr-10"></i>
                                                Top picks for your search
                                            </button>
                                        </div> -->

                                        <div class="col-auto d-none lg:d-block">
                                            <button
                                                data-x-click="filterPopup"
                                                class="button -blue-1 h-40 px-20 rounded-100 bg-blue-1-05 text-15 text-blue-1">
                                                <i class="icon-up-down text-14 mr-10"></i>
                                                Filter
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="filterPopup bg-white"
                                data-x="filterPopup"
                                data-x-toggle="-is-active">
                                <aside class="sidebar -mobile-filter">
                                    <div data-x-click="filterPopup" class="-icon-close">
                                        <i class="icon-close"></i>
                                    </div>

                                    <div class="sidebar__item">
                                        <h5 class="text-18 fw-500 mb-10">
                                            Search by property name
                                        </h5>
                                        <div class="single-field relative d-flex items-center py-10">
                                            <input
                                                class="pl-50 border-light text-dark-1 h-50 rounded-8"
                                                type="email"
                                                placeholder="e.g. Best Western"/>
                                            <button class="absolute d-flex items-center h-full">
                                                <i class="icon-search text-20 px-15 text-dark-1"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="sidebar__item">
                                        <h5 class="text-18 fw-500 mb-10">Property types</h5>
                                        <div class="sidebar-checkbox">
                                            <?php foreach ($propertyTypes as $row) {?>
                                            <div class="row items-center justify-between">
                                                <div class="col-auto">
                                                    <div class="d-flex items-center">
                                                        <div class="form-checkbox">
                                                            <input type="checkbox" name="property_types" value="<?=$row->ht_id?>" onchange="filterList();"/>
                                                            <div class="form-checkbox__mark">
                                                                <div class="form-checkbox__icon icon-check"></div>
                                                            </div>
                                                        </div>
                                                        <div class="text-15 ml-10"><?=$row->name?></div>
                                                    </div>
                                                </div>

                                                <div class="col-auto">
                                                    <div class="text-15 text-light-1"><?=str_pad($row->count, 2, '0', STR_PAD_LEFT)?></div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    
                                    <div class="sidebar__item">
                                        <h5 class="text-18 fw-500 mb-10">Sort By</h5>
                                        <div class="sidebar-checkbox">
                                            <div class="row y-gap-10 items-center justify-between">
                                                <div class="col-auto">
                                                    <div class="form-radio d-flex items-center ">
                                                        <div class="radio">
                                                        <input type="radio" name="sort_by" value="by_name">
                                                        <div class="radio__mark">
                                                            <div class="radio__icon"></div>
                                                        </div>
                                                        </div>
                                                        <div class="ml-10">Name Ascending</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row y-gap-10 items-center justify-between">
                                                <div class="col-auto">
                                                    <div class="form-radio d-flex items-center">
                                                        <div class="radio">
                                                        <input type="radio" name="sort_by" value="by_price_low_to_high">
                                                        <div class="radio__mark">
                                                            <div class="radio__icon"></div>
                                                        </div>
                                                        </div>
                                                        <div class="ml-10">Price Low to High</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row y-gap-10 items-center justify-between">
                                                <div class="col-auto">
                                                    <div class="form-radio d-flex items-center">
                                                        <div class="radio">
                                                        <input type="radio" name="sort_by" value="by_price_high_to_low">
                                                        <div class="radio__mark">
                                                            <div class="radio__icon"></div>
                                                        </div>
                                                        </div>
                                                        <div class="ml-10">Price High to Low</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row y-gap-10 items-center justify-between">
                                                <div class="col-auto">
                                                    <div class="form-radio d-flex items-center ">
                                                        <div class="radio">
                                                        <input type="radio" name="sort_by" value="by_review">
                                                        <div class="radio__mark">
                                                            <div class="radio__icon"></div>
                                                        </div>
                                                        </div>
                                                        <div class="ml-10">Review High to Low</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sidebar__item pb-30">
                                        <h5 class="text-18 fw-500 mb-10">Nightly Price</h5>
                                        <div class="row x-gap-10 y-gap-30">
                                            <div class="col-12">
                                                <div class="js-price-rangeSlider">
                                                    <div class="text-14 fw-500"></div>

                                                    <div class="d-flex justify-between mb-20">
                                                        <div class="text-15 text-dark-1">
                                                            <span class="js-lower"></span>
                                                            -
                                                            <span class="js-upper"></span>
                                                        </div>
                                                    </div>

                                                    <div class="px-5">
                                                        <div class="js-slider"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sidebar__item">
                                        <h5 class="text-18 fw-500 mb-10">Villa Types</h5>
                                        <div class="sidebar-checkbox">
                                            <?php foreach ($villaTypes as $row) { ?>
                                            <div class="row items-center justify-between">
                                                <div class="col-auto">
                                                    <div class="d-flex items-center">
                                                        <div class="form-checkbox">
                                                            <input type="checkbox" name="villa_types" value="<?=$row->vt_id?>" onchange="filterList();"/>
                                                            <div class="form-checkbox__mark">
                                                                <div class="form-checkbox__icon icon-check"></div>
                                                            </div>
                                                        </div>

                                                        <div class="text-15 ml-10"><?=$row->vt_name?></div>
                                                    </div>
                                                </div>

                                                <!-- <div class="col-auto">
                                                    <div class="text-15 text-light-1">92</div>
                                                </div> -->
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="sidebar__item">
                                        <h5 class="text-18 fw-500 mb-10">Star Rating</h5>
                                        <div class="row y-gap-10 x-gap-10 pt-10">
                                            <?php for ($i=1; $i <= 7; $i++) {  ?>
                                            <div class="col-auto">
                                                <a href="javascript:void(0);" class="button -blue-1 bg-blue-1-05 text-blue-1 py-5 px-20 rounded-100 stars" star-val="<?=$i?>" onclick="clickStar(); filterList();"><?=$i?></a >
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="sidebar__item">
                                        <h5 class="text-18 fw-500 mb-10">Transfer</h5>
                                        <div class="sidebar-checkbox">
                                            <?php foreach ($transferTypes as $row) { ?>
                                            <div class="row items-center justify-between">
                                                <div class="col-auto">
                                                    <div class="d-flex items-center">
                                                        <div class="form-checkbox">
                                                            <input type="checkbox" name="transfer_type" value="<?=$row->tras_id?>" onchange="filterList();"/>
                                                            <div class="form-checkbox__mark">
                                                                <div class="form-checkbox__icon icon-check"></div>
                                                            </div>
                                                        </div>

                                                        <div class="text-15 ml-10"><?=$row->transfer_type?></div>
                                                    </div>
                                                </div>

                                                <!-- <div class="col-auto">
                                                    <div class="text-15 text-light-1">92</div>
                                                </div> -->
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="sidebar__item">
                                        <h5 class="text-18 fw-500 mb-10">Atolls</h5>
                                        <div class="sidebar-checkbox">
                                            <?php foreach ($atollList as $row) { ?>
                                            <div class="row items-center justify-between">
                                                <div class="col-auto">
                                                    <div class="d-flex items-center">
                                                        <div class="form-checkbox">
                                                            <input type="checkbox" name="atoll_list" value="<?=$row->atoll_id?>" onchange="filterList();"/>
                                                            <div class="form-checkbox__mark">
                                                                <div class="form-checkbox__icon icon-check"></div>
                                                            </div>
                                                        </div>

                                                        <div class="text-15 ml-10"><?=$row->name?></div>
                                                    </div>
                                                </div>

                                                <div class="col-auto">
                                                    <div class="text-15 text-light-1"><?=str_pad($row->count, 2, '0', STR_PAD_LEFT)?></div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </aside>
                            </div>

                            <div class="mt-30"></div>

                            <div class="row y-gap-30" id="searched-list"></div>
                            
                            <!-- Pagination -->
                            <div class="border-top-light mt-30 pt-30" id="pagination_div">
                                <div class="row x-gap-10 y-gap-20 justify-between md:justify-center" id="pagination_ul">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <input type="hidden" id="offset_field" value="0">
            <?php $this->load->view('includes/footer'); ?>
        </main>

        <div class="mapFilter" data-x="mapFilter" data-x-toggle="-is-active">
            <div class="mapFilter__overlay"></div>

            <div class="mapFilter__close">
                <button class="button -blue-1 size-40 bg-white shadow-2" data-x-click="mapFilter">
                <i class="icon-close text-15"></i>
                </button>
            </div>

            <div class="mapFilter__grid" data-x="mapFilter__grid" data-x-toggle="-filters-hidden">
            </div>
        </div>

        <?php $this->load->view('includes/js'); ?>
        <script src="<?=base_url()?>assets/js/toastr.min.js"></script>
        <script>
            $(document).ready(function() {
                const sType = '<?=$st?>';
                const sVal = '<?=$sv?>';
                if (sType != 0 && sVal != 0) {
                    const searchedNameValue = localStorage.getItem('searchedNameValue');
                    const searchedIcon = localStorage.getItem('searchedIcon');
                    const searchedCountry = localStorage.getItem('searchedCountry');

                    const dropdownListItem = `<div><button class="-link d-block col-12 text-left rounded-4 px-20 py-15 js-search-option dropdown-button" type="${sType}" value="${sVal}" name-value="${searchedNameValue}" icon="${searchedIcon}" country="${searchedCountry}">
                                                <div class="d-flex">
                                                <div class="${searchedIcon} text-light-1 text-20 pt-4"></div>
                                                <div class="ml-10">
                                                    <div class="text-15 lh-12 fw-500 js-search-option-target">${searchedNameValue}</div>
                                                    <div class="text-14 lh-12 text-light-1 mt-5">${searchedCountry}</div>
                                                </div>
                                                </div>
                                            </button></div>`;
                    $('.searchContent').append(dropdownListItem);

                    setTimeout(() => {
                        const $button = $("#searchContent").find(`button.dropdown-button[type="${sType}"][value="${sVal}"]`).first();
                        const selectedSearchValue = $button.find('div.js-search-option-target').text();
                        $('input[type="search"].js-search').val(selectedSearchValue);
                    }, 500);
                }

                // Set start and end dates
                const calendarStart = new Date('<?=$ssd?>');
                const calendarEnd = new Date('<?=$sed?>');

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

                $(`.table-calendar__grid div[date="<?=$ssd?>"]`).addClass('-is-active');
                dates.forEach(el => {
                    $(`.table-calendar__grid div[date="${el}"]`).addClass('-is-in-path');
                });
                $(`.table-calendar__grid div[date="<?=$sed?>"]`).addClass('-is-active');
            })
            document.addEventListener('DOMContentLoaded', function() {
                filterList();
            });
            const clickStar = () => {
                $('.stars').removeClass('star-active');
                $(event.target).addClass('star-active');
            }

            // when prices get change, filter function will be called here.
            $('.min-price, .max-price').on('change', function() {
                filterList();
            });

            $('#search-property-name').on('keyup', function () {
                const value = $(this).val(); // Get the current value of the input field
                const count = value.length; // Get the length of the input value
                if (count > 3 || count == 0) {
                    filterList();
                }
            });

            $('input[name="sort_by"]').on('change', function() {
                filterList();
            });

            const filterList = () => {
                const nameSearch = $('#search-property-name').val();
                const searchedType = '<?=$st?>';
                const searchedValue = '<?=$sv?>';
                const searchedStartDate = '<?=$ssd?>';
                const searchedEndDate = '<?=$sed?>';
                const adultCount = '<?=$ac?>';
                const childCount = '<?=$cc?>';
                const infantCount = '<?=$ic?>';
                const roomCount = '<?=$rc?>';

                const isLoggedIn = '<?=$this->session->userdata('logged_in')?>';

                const propertyList = $('input[name="property_types"]:checked').map(function() {
                    return this.value;
                }).get();
                
                const priceMin = parseFloat($('#price0').val());
                const priceMax = parseFloat($('#price1').val());

                const villaTypes = $('input[name="villa_types"]:checked').map(function() {
                    return this.value;
                }).get();

                const starVal = $('.stars.star-active').attr('star-val');

                const transerTypes = $('input[name="transfer_type"]:checked').map(function() {
                    return this.value;
                }).get();

                const atollList = $('input[name="atoll_list"]:checked').map(function() {
                    return this.value;
                }).get();

                const sortBy = $('input[name="sort_by"]:checked').val() ?? null;
                
                var limit = 15;
                var offset = parseInt($('#offset_field').val());

                const data = {
                    nameSearch,
                    searchedType,
                    searchedValue,
                    searchedStartDate,
                    searchedEndDate,
                    adultCount,
                    childCount,
                    infantCount,
                    roomCount,
                    priceMin,
                    priceMax,
                    propertyList,
                    villaTypes,
                    starVal,
                    transerTypes,
                    atollList,
                    sortBy,
                    limit,
                    offset
                }
                $.ajax({
                    url: '<?=base_url()?>filter-list',
                    type: 'POST',
                    data: data,
                    success: function(result) {
                        const resp = $.parseJSON(result);
                        var listItem = ``;
                        if (resp.result.length <= 0) {
                            $('#searched-list').html(`<h5 class="text-30 fw-500 mb-10 text-center">No matching data found.</h5>`);
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                            return;
                        }
                        $('#pagination_div').hide();
                        $('#pagination_ul').empty();

                        const propertyCount = numberWithCommas(resp.rowcount).padStart(2, '0');
                        $('#total-properties').html(`${propertyCount} Properties`);
                        resp.result.map((el) => {
                            const resortId = btoa(btoa(el.resort_id));
                            const sdate = btoa(btoa(searchedStartDate));
                            const edate = btoa(btoa(searchedEndDate));
                            const adults = btoa(btoa(adultCount));
                            const childs = btoa(btoa(childCount));
                            const infant = btoa(btoa(infantCount));
                            const rooms = btoa(btoa(roomCount));

                            const urlSearch = `rid=${resortId}&sd=${sdate}&ed=${edate}&ac=${adults}&cc=${childs}&rc=${rooms}&ic=${infant}`;

                            var wishListBtn = ``;
                            if (isLoggedIn) {
                                wishListBtn =   `<div class="cardImage__wishlist">
                                                    <button class="button -blue-1 bg-white size-30 rounded-full shadow-2" onclick="addToWishList('${el.resort_id}');">
                                                        <i class="icon-heart text-12"></i>
                                                    </button>
                                                </div>`;
                            }

                            var imageList = ``;
                            if (el.hotelImages.length > 1) {
                                imageList = `<div class="cardImage-slider rounded-4 overflow-hidden js-cardImage-slider">
                                                <div class="swiper-wrapper">`;
                                                    el.hotelImages.forEach(image => {
                                                        imageList+= `<div class="swiper-slide">
                                                                        <img class="col-12" src="<?=PHOTO_DOMAIN?>hotels/${image.photo_path}-std.jpg" alt="image"/>
                                                                    </div>`;
                                                    });
                                    imageList+=`</div>
                                                <div class="cardImage-slider__pagination js-pagination"></div>
                                                <div class="cardImage-slider__nav -prev">
                                                    <button class="button -blue-1 bg-white size-30 rounded-full shadow-2 js-prev">
                                                        <i class="icon-chevron-left text-10"></i>
                                                    </button>
                                                </div>

                                                <div class="cardImage-slider__nav -next">
                                                    <button class="button -blue-1 bg-white size-30 rounded-full shadow-2 js-next">
                                                        <i class="icon-chevron-right text-10"></i>
                                                    </button>
                                                </div>
                                            </div>`
                            } else {
                                el.hotelImages.forEach(image => {
                                    imageList += `<img class="rounded-4 col-12" src="<?=PHOTO_DOMAIN?>hotels/${image.photo_path}-std.jpg" alt="image"/>`
                                });
                            }

                            var includedTag = ``;
                            if (el.tag != '' && el.tag != undefined && el.tag != null) {
                                includedTag =   `<div class="cardImage__leftBadge">
                                                    <div class="py-5 px-15 rounded-right-4 text-12 lh-16 fw-500 uppercase bg-yellow-1 text-dark-1">
                                                        ${el.tag}
                                                    </div>
                                                </div>`;
                            }

                            const stars = '<i class="icon-star text-10 text-yellow-2"></i>'.repeat(parseInt(el.stars));
                            const child = el.child > 0 ? `& ${el.child} children` : ``
                            const pax = `${el.nightCount} night, ${el.adult} adult `+ child;
                            listItem += `<div class="col-12">
                                            <div class="border-top-light pt-30">
                                                <div class="row x-gap-20 y-gap-20">
                                                    <div class="col-md-auto">
                                                        <div class="cardImage ratio ratio-1:1 w-250 md:w-1/1 rounded-4">
                                                            <div class="cardImage__content">
                                                                ${imageList}
                                                            </div>
                                                            ${wishListBtn}
                                                            ${includedTag}
                                                        </div>
                                                    </div>

                                                    <div class="col-md">
                                                        <h3 class="text-18 lh-16 fw-500">
                                                            <a href="<?=base_url()?>detail?prs=${btoa(urlSearch)}">${el.hotel_name}<br class="lg:d-none"/>
                                                            </a>
                                                            <div class="d-inline-block">
                                                                ${stars}
                                                            </div>
                                                        </h3>

                                                        <div class="row x-gap-10 y-gap-10 items-center pt-10">
                                                            <div class="col-auto">
                                                                <p class="text-14">${el.atoll}, ${el.nicename}</p>
                                                            </div>

                                                            <div class="col-auto">
                                                                <button data-x-click="mapFilter" class="d-block text-14 text-blue-1 underline mapFilter${el.resort_id}" onclick="setMapSrc('${el.latitude}','${el.longitude}','mapFilter${el.resort_id}')">
                                                                    Show on map
                                                                </button>
                                                            </div>

                                                            <!-- <div class="col-auto">
                                                                <div class="size-3 rounded-full bg-light-1"></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <p class="text-14">2 km to city center</p>
                                                            </div>  -->
                                                        </div>

                                                        <div class="text-14 lh-15 mt-20">
                                                            <div class="fw-500">
                                                                ${el.room_title}
                                                            </div>
                                                            <div class="text-light-1 d-flex">
                                                                ${el.rb_title}
                                                                <div class="tooltip -right px-10 h-20">
                                                                    <i class="icon icon-award text-dark-2 text-12"></i>
                                                                    <div class="tooltip__content" style="width:400px;">
                                                                        <ul>`;
                                                                            if (el.room_title) {
                                                                                listItem += `<li>Accomodation in ${el.room_title}</li>`;
                                                                            }
                                                                            if (el.packageMealPlan) {
                                                                                listItem += `<li>${el.packageMealPlan} Basis</li>`;
                                                                            }
                                                                            if (el.transferType && el.transferVehicle) {
                                                                                listItem += `<li>${el.transferType} transfer by ${el.transferVehicle}</li>`;
                                                                            }
                                                                            if (el.packageTaxes) {
                                                                                listItem += `<li>${el.packageTaxes} included</li>`;
                                                                            }
                                                            listItem += `   <li>Arrival & Departure Assistance At Male International Airport</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="text-14 text-green-2 lh-15 mt-10">
                                                            <div class="fw-500">Free cancellation</div>
                                                            <div class="">
                                                                You can cancel later, so lock in this great price today.
                                                            </div>
                                                        </div>
                                                        <div style="float: left;" class="mt-10">
                                                            <div class="tooltip -right h-20 text-14 lh-14 fw-500">
                                                                AVAILABLE ROOMS
                                                                <div class="tooltip__content" style="width:300px;">
                                                                    <table class="table-4 mt-30">
                                                                        <thead class="bg-light-1">
                                                                            <tr>
                                                                                <th>Room</th>
                                                                                <th>Available Count</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>`;
                                                                        el.availableRooms.forEach(room => {
                                                                            listItem +=`<tr>
                                                                                            <td>${room.room_title}</td>
                                                                                            <td>${room.available_rooms}</td>
                                                                                        </tr>`;
                                                                        });
                                                            listItem +=`</tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row x-gap-10 y-gap-10 pt-20 mt-30">`;
                                                        el.hotelFacilities.map((fac) => {
                                                            listItem += `<div class="col-auto">
                                                                <div class="border-light rounded-100 py-5 px-20 text-14 lh-14">
                                                                    ${fac.facility_name}
                                                                </div>
                                                            </div>`;
                                                        });
                                            listItem += `</div>
                                                    </div>

                                                    <div class="col-md-auto text-right md:text-left">
                                                        <div class="row x-gap-10 y-gap-10 justify-end items-center md:justify-start">
                                                            <div class="col-auto">
                                                                <div class="text-14 lh-14 fw-500">Exceptional</div>
                                                                <div class="text-14 lh-14 text-light-1">
                                                                    ${el.review_count} reviews
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div class="flex-center text-white fw-600 text-14 size-40 rounded-4 bg-blue-1">
                                                                    ${parseFloat(el.stars).toFixed(1)}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="">
                                                            <div class="text-14 text-light-1 mt-50 md:mt-20">
                                                                ${pax}
                                                            </div>
                                                            <div class="text-22 lh-12 fw-600 mt-5"><?=$cur?>${el.actualPrice}</div>

                                                            <a href="<?=base_url()?>detail?prs=${btoa(urlSearch)}" class="button -md -dark-1 bg-blue-1 text-white mt-24">
                                                                See Availability
                                                                <div class="icon-arrow-top-right ml-15"></div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;
                        });
                        $('#searched-list').html(listItem);
                        cardImageSlider();

                        var pagination_str = ``;
                        var row_count = parseInt(resp.rowcount);
                        var pages = Math.ceil(row_count/limit);

                        if (1 < pages) {
                            var leftDisabled = ``;
                            if (0<=(offset-limit)) {
                                leftDisabled = `set_offset(${(offset-limit)})`;
                            }
                            pagination_str +=   `<div class="col-auto md:order-1">
                                                    <button class="button -blue-1 size-40 rounded-full border-light" onclick="${leftDisabled}">
                                                        <i class="icon-chevron-left text-12"></i>
                                                    </button>
                                                </div>
                                                <div class="col-md-auto md:order-3">
                                                    <div class="row x-gap-20 y-gap-20 items-center md:d-none">`;
                            if(1<((offset/limit)+1)){
                                pagination_str  +=  `<div class="col-auto">
                                                        <div class="size-40 flex-center rounded-full" onclick="set_offset(0)">1</div>
                                                    </div>`;
                            }
                            if(((offset/limit)+1)>3){
                                pagination_str  +=  `<div class="col-auto">
                                                        <div class="size-40 flex-center rounded-full">...</div>
                                                    </div>`;
                            }
                            if(((offset/limit)+1)>2){
                                pagination_str  +=  `<div class="col-auto">
                                                        <div class="size-40 flex-center rounded-full" onclick="set_offset(${(offset-limit)})">${(offset/limit)}</div>
                                                    </div>`;
                            }
                            pagination_str  +=  `<div class="col-auto">
                                                    <div class="size-40 flex-center rounded-full bg-dark-1 text-white">
                                                        ${((offset/limit)+1)}
                                                    </div>
                                                </div>`;
                            if(((offset/limit)+1)<(pages-1)){
                                pagination_str  +=  `<div class="col-auto">
                                                        <div class="size-40 flex-center rounded-full" onclick="set_offset(${(offset+limit)})">${((offset/limit)+2)}</div>
                                                    </div>`;
                            }
                            if(((offset/limit)+1)<(pages-2)){
                                pagination_str  +=  `<div class="col-auto">
                                                        <div class="size-40 flex-center rounded-full">...</div>
                                                    </div>`;
                            }
                            if(pages>((offset/limit)+1)){
                                pagination_str  +=  `<div class="col-auto">
                                                        <div class="size-40 flex-center rounded-full" onclick="set_offset(${((pages-1)*limit)})">${pages}</div>
                                                    </div>`;
                            }
                            var rightDisabled = '';
                            if ((offset+limit)<(pages*limit)) {
                                rightDisabled = `set_offset(${(offset+limit)})`;
                                
                            }
                            pagination_str  +=  `</div>
                                                    </div>
                                                    <div class="col-auto md:order-2">
                                                        <button class="button -blue-1 size-40 rounded-full border-light" onclick="${rightDisabled}">
                                                            <i class="icon-chevron-right text-12"></i>
                                                        </button>
                                                    </div>`;
                            $('#pagination_ul').append(pagination_str);
                            $('#pagination_div').show();
                        }

                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    },
                    error: function(result) {}
                })
            }
            
            function cardImageSlider() {
                new Swiper(".js-cardImage-slider", {
                    speed: 400,
                    loop: true,
                    lazy: {
                        loadPrevNext: true,
                    },
                    navigation: {
                        prevEl: ".js-prev",
                        nextEl: ".js-next",
                    },
                    pagination: {
                        el: ".js-pagination",
                        bulletClass: "pagination__item",
                        bulletActiveClass: "is-active",
                        bulletElement: "div",
                        clickable: true,
                    },
                });
            }

            function set_offset(value) {
                $('#offset_field').val(value);
                filterList();
            }

            const setMapSrc = (lat,long,targetClass) => {
                const targets = $("."+targetClass);
                if (!targets) return;

                const iframe = `<iframe class="map-bottom-2" src="https://maps.google.com/maps?q=${lat},${long}&hl=en&z=14&amp;output=embed" allowfullscreen="true" loading="lazy" referrerpolicy="no-referrer-when-downgrade" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></iframe>`
                $('.mapFilter__grid').html(iframe);

                const attributes = targets[0].getAttribute("data-x-click");
                const target = document.querySelector(`[data-x=${attributes}]`);
                targets[0].addEventListener("click", () => {
                    const toggleClass = target.getAttribute("data-x-toggle");
                    target.classList.toggle(toggleClass);
                });
            }

            const addToWishList = (productId) => {
                const isLoggedIn = '<?=$this->session->userdata('logged_in')?>';
                if (!isLoggedIn) {
                    return toastr.error("You aren't logged in to add the product to your wishlist.");
                }
                $.ajax({
                    type:'POST',
                    url:'<?=base_url()?>add-to-wishlist',
                    data:'productId='+productId,
                    success:function(result){
                        var resp = $.parseJSON(result);
                        if (resp.status == 'success') {
                            toastr.success(resp.message);
                        } else {
                            toastr.warning(resp.message);
                        }
                    },
                    error:function(result){
                        toastr.error('Something went wrong :(');
                    }
                });
            }
        </script>
    </body>
</html>