<?php 
    // Get the current path from the URL
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // Explode the path into an array of parts
    $pathParts = array_filter(explode('/', $currentPath));

    // Check if "search" or "details" exist in the array
    $hasSearch = in_array('search', $pathParts);
    $hasDetails = in_array('detail', $pathParts);
    
    $start_date = date('D j M', $nextWeekFirstDay);
    $endDate = date('D j M', $nextWeekFourthDay);
    $commonAdultCount = 2;
    $commonChildCount = 0;
    $commonRoomCount = 1;
    $commonInfantCount = 0;

    if ($hasSearch) {
        $start_date = date('D j M', strtotime($ssd));
        $endDate = date('D j M', strtotime($sed));
        $commonAdultCount = $ac;
        $commonChildCount = $cc;
        $commonRoomCount = $rc;
        $commonInfantCount = $ic;
    }

    // THIS IS WRONG DATE SHOWING
    if ($hasDetails) {
        $start_date = date('D j M', strtotime($startDate));
        $endDate = date('D j M', strtotime($end_date));
        $commonAdultCount = $adultCount;
        $commonChildCount = $childCount;
        $commonRoomCount = $roomCount;
        $commonInfantCount = $infantCount;
    }
?>
<div class="col-12">
    <div class="mainSearch bg-white px-10 py-10 lg:px-20 lg:pt-5 lg:pb-20 rounded-4">
        <div class="button-grid items-center">
            <div class="searchMenu-loc pl-10 pr-30 lg:py-20 lg:px-0 js-form-dd js-liverSearch">
                <div data-x-dd-click="searchMenu-loc">
                    <h4 class="text-15 fw-500 ls-2 lh-16">Location</h4>
                    <div class="text-15 text-light-1 ls-2 lh-16">
                        <input autocomplete="off" type="search" placeholder="Where are you going?" class="js-search js-dd-focus">
                    </div>
                </div>
                <div class="searchMenu-loc__field shadow-2 js-popup-window" data-x-dd="searchMenu-loc" data-x-dd-toggle="-is-active">
                    <div class="bg-white px-30 py-30 sm:px-0 sm:py-15 rounded-4">
                        <div class="y-gap-5 js-results searchContent" id="commonSearchContent">
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
                        <span class="js-first-date"><?=$start_date?></span>
                        -
                        <span class="js-last-date"><?=$endDate?></span>
                    </div>
                </div>
                <div class="searchMenu-date__field shadow-2" data-x-dd="searchMenu-date" data-x-dd-toggle="-is-active">
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
            <div class="searchMenu-guests px-30 lg:py-20 lg:px-0 js-form-dd js-form-counters">
                <div data-x-dd-click="searchMenu-guests">
                    <h4 class="text-15 fw-500 ls-2 lh-16">Guest</h4>
                    <div class="text-15 text-light-1 ls-2 lh-16">
                        <span class="js-count-adult"><?=$commonAdultCount?></span>
                        adults -
                        <span class="js-count-child"><?=$commonChildCount?></span>
                        children -
                        <span class="js-count-room"><?=$commonRoomCount?></span>
                        room
                    </div>
                </div>
                <div class="searchMenu-guests__field shadow-2" data-x-dd="searchMenu-guests" data-x-dd-toggle="-is-active">
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
                                        <div class="text-15 js-count common-adult-count"><?=$commonAdultCount?></div>
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
                                        <div class="text-15 js-count common-child-count"><?=$commonChildCount?></div>
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
                                        <div class="text-15 js-count common-infant-count"><?=$commonInfantCount?></div>
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
                                        <div class="text-15 js-count common-room-count"><?=$commonRoomCount?></div>
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
                <button class="mainSearch__submit button -dark-1 py-15 px-40 col-12 rounded-4 bg-blue-1 text-white common-search">
                    <i class="icon-search text-20 mr-10"></i>
                    Search
                </button>
            </div>
        </div>
    </div>
</div>