<!DOCTYPE html>
<html lang="en" data-x="html" data-x-toggle="html-overflow-hidden">

  <head>
    <meta content="<?=$pageMain->seo_keywords != '' ? $pageMain->seo_keywords : '' ?>" name="keywords">
    <meta content="<?=$pageMain->seo_description != '' ? $pageMain->seo_description : '' ?>" name="description">
    <title><?=$pageMain->seo_title != '' ? $pageMain->seo_title : 'Inquiry' ?></title>
    <?php $this->load->view('includes/head'); ?>
    <style>
      .date-disabled:hover {
        background-color: #eee;
      }
      /* Chrome, Safari, Edge, Opera */
      input::-webkit-outer-spin-button,
      input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
      }

      /* Firefox */
      input[type=number] {
        -moz-appearance: textfield;
      }
      /* Default style for all screen sizes */
      label.error {
        display: block;
        color: red;
      }

      /* below line is for the calendar. It moves the calendar from left. */
      .searchMenu-date.-right .searchMenu-date__field {
        left: 0 !important;
      }
    </style>
  </head>

  <body>
    <?php $this->load->view('includes/preloader'); ?>
      <main>
        <?php $this->load->view('includes/header'); ?>

        <section class="pt-40 layout-pb-md">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 col-lg-8">
                      <?php if($this->session->flashdata('no_room_for_pax') != '') { ?>
                      <div class="d-flex items-center justify-between bg-error-1 pl-30 pr-20 py-30 rounded-8">
                        <div class="text-error-2 lh-1 fw-500"><?=$this->session->flashdata('no_room_for_pax')?></div>
                        <div class="text-error-2 text-14 icon-close"></div>
                      </div>
                      <?php } ?>
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
                      
                      <form class="needs-validation" method="POST">
                        <h2 class="text-22 fw-500 md:mt-24">Accommodation Information</h2>

                        <div class="row x-gap-20 y-gap-20 pt-20">
                            <div class="col-md-6">
                              <div class="select js-select js-liveSearch" data-select-value="">
                                <button type="button" class="select__button js-button">
                                    <span class="js-button-title" id="resort-title">Select a Resort</span>
                                    <i class="select__icon" data-feather="chevron-down"></i>
                                </button>

                                <div class="select__dropdown js-dropdown">
                                    <input type="text" placeholder="Search" class="select__search js-search"/>

                                    <div class="select__options js-options">
                                        <?php foreach ($accomodations as $row) { ?>
                                        <div class="select__options__button" data-value="<?=strtolower($row->hotel_name)?>" ho-id="<?=$row->ho_id?>" onclick="selectAccommodation('<?=$row->ho_id?>');">
                                          <?=$row->hotel_name?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="select js-select js-liveSearch" data-select-value="">
                                <button type="button" class="select__button js-button">
                                    <span class="js-button-title" id="selected-room-name">Select a villa</span>
                                    <i class="select__icon" data-feather="chevron-down"></i>
                                </button>

                                <div class="select__dropdown js-dropdown">
                                    <input type="text" placeholder="Search" class="select__search js-search"/>

                                    <div class="select__options js-options" id="room">
                                        
                                    </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="searchMenu-date px-20 py-10 border-light rounded-4 -right js-form-dd js-calendar">
                                <div data-x-dd-click="searchMenu-date">
                                    <h4 class="text-15 fw-500 ls-2 lh-16">Check in - Check out</h4>

                                    <div class="text-15 text-light-1 ls-2 lh-16">
                                        <span class="js-first-date"><?=isset($ssd) ? date('D j M', strtotime($ssd)) : date('D j M', $nextWeekFirstDay)?></span>
                                        -
                                        <span class="js-last-date"><?=isset($sed) ? date('D j M', strtotime($sed)) : date('D j M', $nextWeekFourthDay)?></span>
                                    </div>
                                    <input type="hidden" name="input_start_date" id="input_start_date" value="<?=isset($ssd) ? date('Y-m-d', strtotime($ssd)) : date('Y-m-d', $nextWeekFirstDay)?>" required />
                                    <input type="hidden" name="input_end_date" id="input_end_date" value="<?=isset($sed) ? date('Y-m-d', strtotime($sed)) : date('Y-m-d', $nextWeekFourthDay)?>" required />
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
                            <div class="col-md-6">
                              <div class="select js-select js-liveSearch" data-select-value="">
                                <button type="button" class="select__button js-button">
                                    <span class="js-button-title">Meal Plan</span>
                                    <i class="select__icon" data-feather="chevron-down"></i>
                                </button>

                                <div class="select__dropdown js-dropdown">
                                    <input type="text" placeholder="Search" class="select__search js-search"/>

                                    <div class="select__options js-options" >
                                        <?php foreach ($meal_plan as $row) { ?>
                                        <div class="select__options__button" data-value="<?=strtolower($row->type_title)?>" meal-id="<?=$row->id?>" onclick="selectDropdownValue('<?=$row->id?>', 'input_meal');">
                                          <?=$row->type_title?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="select js-select js-liveSearch" data-select-value="">
                                <button type="button" class="select__button js-button">
                                    <span class="js-button-title">Transfer Type</span>
                                    <i class="select__icon" data-feather="chevron-down"></i>
                                </button>

                                <div class="select__dropdown js-dropdown">
                                    <input type="text" placeholder="Search" class="select__search js-search"/>

                                    <div class="select__options js-options" >
                                        <?php foreach ($transfer as $row) { ?>
                                        <div class="select__options__button" data-value="<?=strtolower($row->transfer_type)?>" transfer-id="<?=$row->tras_id?>" onclick="selectDropdownValue('<?=$row->tras_id?>', 'input_transfer');">
                                          <?=$row->transfer_type?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-input ">
                                <input type="number" name="nights" min="0" max="100" step="1" onkeydown="return event.keyCode !== 69" />
                                <label class="lh-1 text-16 text-light-1">Number of nights</label>
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
                            </div>
                        </div>

                        <div class="border-top-light mt-30 mb-20"></div>

                        <h2 class="text-22 fw-500 md:mt-24">Holiday Information</h2>

                        <div class="row x-gap-20 y-gap-20 pt-20">
                          <div class="col-md-6">
                            <div class="select js-select js-liveSearch" data-select-value="">
                              <button type="button" class="select__button js-button">
                                  <span class="js-button-title">Category</span>
                                  <i class="select__icon" data-feather="chevron-down"></i>
                              </button>

                              <div class="select__dropdown js-dropdown">
                                  <input type="text" placeholder="Search" class="select__search js-search"/>

                                  <div class="select__options js-options" >
                                      <?php foreach ($celebrate as $row) { ?>
                                      <div class="select__options__button" data-value="<?=strtolower($row->hcc_title)?>" cate-id="<?=$row->hcc_id?>" onclick="selectDropdownValue('<?=$row->hcc_id?>', 'input_cate');">
                                        <?=$row->hcc_title?>
                                      </div>
                                      <?php } ?>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="select js-select js-liveSearch" data-select-value="">
                              <button type="button" class="select__button js-button">
                                  <span class="js-button-title">Price range</span>
                                  <i class="select__icon" data-feather="chevron-down"></i>
                              </button>

                              <div class="select__dropdown js-dropdown">
                                  <input type="text" placeholder="Search" class="select__search js-search"/>

                                  <div class="select__options js-options" >
                                    <div class="select__options__button" data-value="USD 2,000 - 3,000" inq-amount="USD 2,000 - 3,000"  onclick="selectDropdownValue('USD 2,000 - 3,000', 'input_price');">
                                      USD 2,000 - 3,000
                                    </div>
                                    <div class="select__options__button" data-value="USD 3,000 - 4,000" inq-amount="USD 3,000 - 4,000"  onclick="selectDropdownValue('USD 3,000 - 4,000', 'input_price');">
                                      USD 3,000 - 4,000
                                    </div>
                                    <div class="select__options__button" data-value="USD 4,000 - 5,000" inq-amount="USD 4,000 - 5,000"  onclick="selectDropdownValue('USD 4,000 - 5,000', 'input_price');">
                                      USD 4,000 - 5,000
                                    </div>
                                    <div class="select__options__button" data-value="USD 5,000 - 6,000" inq-amount="USD 5,000 - 6,000"  onclick="selectDropdownValue('USD 5,000 - 6,000', 'input_price');">
                                      USD 5,000 - 6,000
                                    </div>
                                    <div class="select__options__button" data-value="USD 6,000 - 8,000" inq-amount="USD 6,000 - 8,000"  onclick="selectDropdownValue('USD 6,000 - 8,000', 'input_price');">
                                      USD 6,000 - 8,000
                                    </div>
                                    <div class="select__options__button" data-value="USD 8,000 - 10,000" inq-amount="USD 8,000 - 10,000"  onclick="selectDropdownValue('USD 8,000 - 10,000', 'input_price');">
                                      USD 8,000 - 10,000
                                    </div>
                                    <div class="select__options__button" data-value="USD 10,000 - 15,000" inq-amount="USD 10,000 - 15,000"  onclick="selectDropdownValue('USD 10,000 - 15,000', 'input_price');">
                                      USD 10,000 - 15,000
                                    </div>
                                    <div class="select__options__button" data-value="USD 15,000 - 20,000" inq-amount="USD 15,000 - 20,000"  onclick="selectDropdownValue('USD 15,000 - 20,000', 'input_price');">
                                      USD 15,000 - 20,000
                                    </div>
                                    <div class="select__options__button" data-value="USD 20,000 - 30,000" inq-amount="USD 20,000 - 30,000"  onclick="selectDropdownValue('USD 20,000 - 30,000', 'input_price');">
                                      USD 20,000 - 30,000
                                    </div>
                                    <div class="select__options__button" data-value="USD 30,000 - 50,000" inq-amount="USD 30,000 - 50,000"  onclick="selectDropdownValue('USD 30,000 - 50,000', 'input_price');">
                                      USD 30,000 - 50,000
                                    </div>
                                    <div class="select__options__button" data-value="USD 50,000 &amp; Above" inq-amount="USD 50,000 &amp; Above"  onclick="selectDropdownValue('USD 50,000 &amp; Above', 'input_price');">
                                      USD 50,000 &amp; Above
                                    </div>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="select js-select js-liveSearch" data-select-value="">
                              <button type="button" class="select__button js-button">
                                  <span class="js-button-title" id="room-title">Rooms</span>
                                  <i class="select__icon" data-feather="chevron-down"></i>
                              </button>

                              <div class="select__dropdown js-dropdown">
                                  <input type="text" placeholder="Search" class="select__search js-search"/>

                                  <div class="select__options js-options" >
                                      <?php 
                                        for($x = 1; $x <= 20; $x++) { 
                                          if ($x == 1) {
                                            $roomText = 'Room';
                                          }else{
                                            $roomText = 'Rooms';
                                          }
                                      ?>
                                      <div class="select__options__button" data-value="<?=strtolower($x)?>" room-count="<?=$x?>" onclick="selectDropdownValue('<?=$x?>', 'input_rooms');">
                                        <?=str_pad($x, 2, "0", STR_PAD_LEFT).' '.$roomText?>
                                      </div>
                                      <?php } ?>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="select js-select js-liveSearch" data-select-value="">
                              <button type="button" class="select__button js-button">
                                  <span class="js-button-title" id="adult-title">Adults</span>
                                  <i class="select__icon" data-feather="chevron-down"></i>
                              </button>

                              <div class="select__dropdown js-dropdown">
                                  <input type="text" placeholder="Search" class="select__search js-search"/>

                                  <div class="select__options js-options" >
                                      <?php 
                                        for($x = 1; $x <= 12; $x++) { 
                                          if ($x == 1) {
                                            $adult = 'Adult';
                                          }else{
                                            $adult = 'Adults';
                                          }
                                      ?>
                                      <div class="select__options__button" data-value="<?=strtolower($x)?>" adult-count="<?=$x?>" onclick="selectDropdownValue('<?=$x?>', 'input_adults');">
                                        <?=str_pad($x, 2, "0", STR_PAD_LEFT).' '.$adult?>
                                      </div>
                                      <?php } ?>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="select js-select js-liveSearch" data-select-value="">
                              <button type="button" class="select__button js-button">
                                  <span class="js-button-title" id="child-title">Child</span>
                                  <i class="select__icon" data-feather="chevron-down"></i>
                              </button>

                              <div class="select__dropdown js-dropdown">
                                  <input type="text" placeholder="Search" class="select__search js-search"/>

                                  <div class="select__options js-options" >
                                      <?php 
                                        for($x = 0; $x <= 8; $x++) { 
                                          if ($x == 1 || $x == 0) {
                                            $child = 'Child';
                                          }else{
                                            $child = 'Children';
                                          }
                                      ?>
                                      <div class="select__options__button" data-value="<?=strtolower($x)?>" child-count="<?=$x?>" onclick="selectDropdownValue('<?=$x?>', 'input_childs');">
                                        <?=str_pad($x, 2, "0", STR_PAD_LEFT).' '.$child?>
                                      </div>
                                      <?php } ?>
                                  </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="border-top-light mt-30 mb-20"></div>

                        <h2 class="text-22 fw-500 md:mt-24">Let us know who you are</h2>

                        <div class="row x-gap-20 y-gap-20 pt-20">
                            <div class="col-12">
                              <div class="form-input ">
                                <input type="text" required="" id="name" name="name" />
                                <label class="lh-1 text-16 text-light-1" for="name">Full Name</label>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-input ">
                                <input type="email" required="" id="email" name="email" />
                                <label class="lh-1 text-16 text-light-1" for="email">Email</label>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-input ">
                                <input type="text" id="phone" name="phone" />
                                <label class="lh-1 text-16 text-light-1" for="phone">Phone Number</label>
                              </div>
                            </div>

                            <div class="col-12">
                              <div class="form-input ">
                                <textarea rows="6" id="comment" name="comment" style="overflow: hidden; overflow-wrap: break-word; height: 51px;"></textarea>
                                <label class="lh-1 text-16 text-light-1" for="comment">Special Requests</label>
                              </div>
                            </div>

                            <div class="col-12">
                              <div class="row y-gap-20 items-center justify-between">
                                <div class="col-auto">
                                  <div class="text-14 text-light-1">
                                    By proceeding with this booking, I agree to GoTrip Terms of Use and Privacy
                                    Policy.
                                  </div>
                                </div>
                                <input type="hidden" id="inquire_for" name="inquire_for" value="3">
                                <div class="col-auto">
                                  <button type="submit" class="button h-60 px-24 -dark-1 bg-blue-1 text-white" id="submitText">
                                    Submit
                                    <div class="icon-arrow-top-right ml-15"></div>
                                  </button>
                                </div>
                              </div>
                            </div>
                        </div>
                      </form>
                    </div>

                    <div class="col-xl-5 col-lg-4">
                      <div class="ml-80 lg:ml-40 md:ml-0">
                        <div class="px-30 py-30 border-light rounded-4" id="accomodation-div"></div>

                        <div class="px-30 py-30 border-light rounded-4 mt-30" id="contact-info-div">
                          <div class="text-20 fw-500 mb-20">Contact Information</div>

                          <div class="row y-gap-5 justify-between">
                            <div class="col-auto">
                              <div class="text-15 fw-500">Address</div>
                            </div>
                            <div class="col-auto">
                              <div class="text-15"><?=$pageContactInfo->headline?> <?=$pageContactInfo->second_title?></div>
                            </div>
                          </div>

                          <div class="row y-gap-5 justify-between pt-5">
                            <div class="col-auto">
                              <div class="text-15 fw-500">Email</div>
                            </div>
                            <div class="col-auto">
                              <div class="text-15"><?=$pageContactInfo->seo_keywords?></div>
                            </div>
                          </div>

                          <div class="row y-gap-5 justify-between pt-5">
                            <div class="col-auto">
                              <div class="text-15 fw-500">Phone</div>
                            </div>
                            <div class="col-auto">
                              <div class="text-15"><?=$pageContactInfo->seo_title?></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- FORM DROPDOWN SELECTED VALUES -->
        <input type="hidden" name="input_meal" id="input_meal" value="0" />
        <input type="hidden" name="input_transfer" id="input_transfer" value="0" />
        <input type="hidden" name="input_cate" id="input_cate" value="0" />
        <input type="hidden" name="input_price" id="input_price" value="0" />
        <input type="hidden" name="input_rooms" id="input_rooms" value="0" />
        <input type="hidden" name="input_adults" id="input_adults" value="0" />
        <input type="hidden" name="input_childs" id="input_childs" value="0" />
        <input type="hidden" name="input_country" id="input_country" value="0" />
        <input type="hidden" name="input_room_id" id="input_room_id" value="0" />
        <!-- ----------------------------- -->

        <?php $this->load->view('includes/subscribe'); ?>
        <?php $this->load->view('includes/footer'); ?>
      </main>

      <?php $this->load->view('includes/js'); ?>
      <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
      <script>
        $(document).ready(function() {
          $('#accomodation-div,#error-message-div,#success-message-div').hide();
          
          localStorage.setItem('inqResortId',0);
          localStorage.setItem('inqRoomId',0);
          
          <?php if (isset($ssd) || isset($sed) || isset($ac) || isset($cc) || isset($rc) || isset($rid)) { ?>
            $('div[ho-id="<?=$rid?>"]').click();
            $('#resort-title').text($('div[ho-id="<?=$rid?>"]').text());

            highlightDate('<?=$ssd?>','<?=$sed?>');
            
            $('div[room-count="<?=$rc?>"]').click();
            $('#room-title').text($('div[room-count="<?=$rc?>"]').text());

            $('div[adult-count="<?=$ac?>"]').click();
            $('#adult-title').text($('div[adult-count="<?=$ac?>"]').text());

            $('div[child-count="<?=$cc?>"]').click();
            $('#child-title').text($('div[child-count="<?=$cc?>"]').text());
          <?php } else { ?>
            const start = '<?=date('Y-m-d',$nextWeekFirstDay)?>';
            const end = '<?=date('Y-m-d', $nextWeekFourthDay)?>';
            highlightDate(start,end);
          <?php } ?>
          
        });

        const highlightDate = (start,end) => {
          
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
        }

        const selectAccommodation = (resortId) => {
          localStorage.setItem("inqResortId", resortId);
          setSelectedDetail();
          $.ajax({
            type:'POST',
            url:'<?=base_url()?>load-accom-rooms',
            data:'accomId='+resortId,
            success:function(result){
              var resp = $.parseJSON(result);
              var opt = ``;
              for (let i = 0; i < resp.length; i++) {
                  opt += `<div class="select__options__button" data-value="${resp[i].room_title.toLowerCase()}" room-id="${resp[i].hr_id}" onclick="selectRoom('${resp[i].hr_id}', '${resp[i].room_title}')">
                            ${resp[i].room_title}
                          </div>`;
              }
              $('#room').html(opt);
            },
            error:function(result){}
          });
        }

        const selectRoom = (roomId,roomName) => {
          localStorage.setItem('inqRoomId',roomId);
          $('#input_room_id').val(roomId);
          $('#selected-room-name').html(roomName);
          setSelectedDetail('ROOM');
        }

        const setSelectedDetail = (from='RESORT') => {
          $('#contact-info-div').hide();
          const getInqResortId = localStorage.getItem('inqResortId');
          let getRoomId = 0;
          if (from === 'ROOM') {
            getRoomId = localStorage.getItem('inqRoomId');
          }
          $.ajax({
            type:'POST',
				    url:'<?=base_url()?>get-specific-detail',
            data:'accomId='+getInqResortId+'&roomId='+getRoomId,
            success:function(result){
              var resp = $.parseJSON(result);

              if (resp == null || resp == undefined) {
                $('#contact-info-div').show();
                return;
              }
              var detail_list = ``;
              if (resp.type === 'resorts') {
                var imageList = ``;
                if (resp.photos.length > 1) {
                    imageList = `<div class="cardImage-slider rounded-4 overflow-hidden js-cardImage-slider">
                                    <div class="swiper-wrapper">`;
                                        resp.photos.forEach(image => {
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
                } else if (resp.photos.length == 1) {
                    resp.photos.forEach(image => {
                        imageList += `<img class="rounded-4 col-12" src="<?=PHOTO_DOMAIN?>hotels/${image.photo_path}-std.jpg" alt="image"/>`;
                    });
                } else {
                  imageList += `<img class="rounded-4 col-12" src="<?=PHOTO_DOMAIN?>default.jpg" alt="image"/>`;
                }
                const stars = '<i class="icon-star text-10 text-yellow-2"></i>'.repeat(parseInt(resp.stars));
                detail_list += `<div class="row x-gap-15 y-gap-20">
                                  <div class="col-auto" style="margin: 0 auto;">
                                    <div class="cardImage ratio ratio-1:1 w-250 md:w-1/1 rounded-4">
                                      <div class="cardImage__content">
                                        ${imageList}
                                      </div>
                                    </div>
                                  </div>

                                  <div class="col-auto">
                                      <div class="d-flex x-gap-5 pb-10">
                                        ${stars}
                                      </div>

                                      <div class="lh-17 fw-500">${resp.hotel_name}</div>
                                      <div class="text-14 lh-15 mt-5">${resp.atoll_name}, ${resp.nicename}</div>

                                      <div class="row x-gap-10 y-gap-10 items-center pt-10">
                                          <div class="col-auto">
                                              <div class="d-flex items-center">
                                                  <div class="size-30 flex-center bg-blue-1 rounded-4">
                                                      <div class="text-12 fw-600 text-white">${parseFloat(resp.stars).toFixed(1)}</div>
                                                  </div>

                                                  <div class="text-14 fw-500 ml-10">Exceptional</div>
                                              </div>
                                          </div>

                                          <div class="col-auto">
                                              <div class="text-14">${resp.review_count} reviews</div>
                                          </div>
                                      </div>
                                  </div>
                                </div>

                                <div class="border-top-light mt-30 mb-20"></div>

                                <div class="row y-gap-20 justify-between">
                                  <p class="text-14">${striptag(resp.description)}</p>
                                </div>

                                <div class="border-top-light mt-30 mb-20"></div>`;
                
                $('#accomodation-div').html(detail_list);
              } else if (resp.type === "rooms") {
                var imageList = ``;
                if (resp.photos.length > 1) {
                    imageList = `<div class="cardImage-slider rounded-4 overflow-hidden js-cardImage-slider">
                                    <div class="swiper-wrapper">`;
                                        resp.photos.forEach(image => {
                                            imageList+= `<div class="swiper-slide">
                                                            <img class="col-12" src="<?=PHOTO_DOMAIN?>hotel_rooms/${image.photo_path}-std.jpg" alt="image"/>
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
                } else if(resp.photos.length == 1) {
                    resp.photos.forEach(image => {
                        imageList += `<img class="rounded-4 col-12" src="<?=PHOTO_DOMAIN?>hotel_rooms/${image.photo_path}-std.jpg" alt="image"/>`;
                    });
                } else {
                  imageList += `<img class="rounded-4 col-12" src="<?=PHOTO_DOMAIN?>default.jpg" alt="image"/>`;
                }
                detail_list += `<div class="row x-gap-15 y-gap-20">
                                  <div class="col-auto" style="margin: 0 auto;">
                                    <div class="cardImage ratio ratio-1:1 w-250 md:w-1/1 rounded-4">
                                      <div class="cardImage__content">
                                        ${imageList}
                                      </div>
                                    </div>
                                  </div>
                                  <div class="lh-17 fw-500">${resp.room_title}</div>
                                  <div class="row x-gap-10 y-gap-10 items-center pt-10">
                                    <div class="col-sm-4">
                                      <div class="d-flex items-center">
                                        <i class="icon-user"></i>
                                        <div class="text-14 ml-10">Up to ${resp.pax}</div>
                                      </div>
                                    </div>
                                    <div class="col-sm-4">
                                      <div class="d-flex items-center">
                                        <i class="icon-transmission"></i>
                                        <div class="text-14 ml-10">${resp.room_size}</div>
                                      </div>
                                    </div>
                                    <div class="col-sm-4">
                                      <div class="d-flex items-center">
                                        <i class="icon-bed"></i>
                                        <div class="text-14 ml-10">${resp.rb_title}</div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="border-top-light mt-30 mb-20"></div>
                                <div class="row y-gap-20 justify-between">
                                  <p class="text-14">${striptag(resp.description)}</p>
                                </div>
                                <div class="border-top-light mt-30 mb-20"></div>`;
                
                $('#accomodation-div').html(detail_list);
              }
              cardImageSlider();
              $('#accomodation-div').show();
            },
            error: function(result){}
          });
        }

        const striptag = (html) => {
          return html.replace(/<[^>]+>/g, '');
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

        const selectDropdownValue = (value,elementId) => {
          $(`#${elementId}`).val(value);
        }

        $('form.needs-validation').validate({
          // Validation rules for each input field
          rules: {
            name: {
              required: true
            },
            email: {
              required: true,
              email: true
            },
            input_start_date: {
              required: true
            },
            input_end_date: {
              required: true
            }
          },
          // Validation messages for each input field
          messages: {
              name: {
                required: "Please enter your full name"
              },
              email: {
                required: "Please enter your email address",
                email: "Please enter a valid email address"
              },
              input_start_date: {
                required: "Please enter start date of your arrival",
              },
              input_end_date: {
                required: "Please enter end date of your arrival",
              }
          },
          errorPlacement: function(error, element) {
              error.insertAfter(element);
          },
          // Submit handler for the form
          submitHandler: function(form) {
            $('#error-message-div,#success-message-div').hide();
            $('#submitText').attr('disabled', 'disabled');
            $('#submitText').text('Loading...');

            const resort = localStorage.getItem('inqResortId');
            const room = $('#input_room_id').val();
            const hcc_id = $('#input_cate').val();
            const price_range = $('#input_price').val();
            const room_count = $('#input_rooms').val();
            const adult = $('#input_adults').val();
            const child = $('#input_childs').val();
            const meal_plan = $('#input_meal').val();
            const transfer = $('#input_transfer').val();
            const country = $('#input_country').val();

            const otherData = [
              {name: "resort", value: resort},
              {name: "room", value: room},
              {name: "hcc_id", value: hcc_id},
              {name: "price_range", value: price_range},
              {name: "room_count", value: room_count},
              {name: "adult", value: adult},
              {name: "child", value: child},
              {name: "meal_plan", value: meal_plan},
              {name: "transfer", value: transfer},
              {name: "country", value: country},
            ];

            // Serialize the form data
            var formData = $(form).serializeArray();
            formData.push(...otherData);
            $.ajax({
              type: 'POST',
              url: '<?=base_url()?>send-main-inquiry',
              data: formData,
              success: function(result) {
                const resp = $.parseJSON(result);
                if (resp.status == 'success') {
                  $('#success-message').html(resp.message);
                  $('#success-message-div').show();
                  setTimeout(() => {
                    location.href = '<?=base_url('inquiry/main/internet-inquiry')?>';
                  }, 3000);
                } else {
                  $('#error-message').html(resp.message);
                  $('#error-message-div').show();
                  $('#submitText').removeAttr('disabled');
                  $('#submitText').html('Submit <div class="icon-arrow-top-right ml-15"></div>');
                }
                window.scrollTo({ top: 0, behavior: 'smooth' });
              },
              error: function(result) {}
            })
          }
        });

      </script>
  </body>
</html>