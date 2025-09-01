<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Base_Controller extends MY_Controller {
    public function __construct() {
        parent::__construct();
		$this->load->model('Front_model');

        $countryIso = 'LK';
        $this->userCountry = $this->Front_model->get_user_country_id($countryIso);

        // Get the current timestamp
        $today = time();
        // Calculate the timestamp for the second Monday (first day of next week)
        $nextMonday = strtotime('second Monday', $today);
        // Calculate the timestamp for the fourth day of next week
        $fourthDayOfNextWeek = strtotime('+4 days', $nextMonday);

        $minMaxPriceRecord = (object) $this->Front_model->find_min_max_price(date('Y-m-d', $nextMonday), date('Y-m-d', $fourthDayOfNextWeek));

        $availabeAllViews = array(
            'cur' => '$',
            'company_name' => 'Travel X Maldives',
            // 'minMaxRoomPrices' => $this->Front_model->fetchMinMaxRoomPrice(),
            'minMaxRoomPrices' => $minMaxPriceRecord,
            'nextWeekFirstDay' => $nextMonday,
            'nextWeekFourthDay' => $fourthDayOfNextWeek
        );
        $this->currency = '$';
        $this->load->vars($availabeAllViews);
        $this->folder = $_SERVER['DOCUMENT_ROOT'] . "/tmt-backend";

        $this->nextWeekFirstDay = $nextMonday;
        $this->nextWeekFourthDay = $fourthDayOfNextWeek;

        // Format the timestamps as "Y-m-d" strings
        /* $firstDay = date('Y-m-d', $nextMonday);
        $fourthDay = date('Y-m-d', $fourthDayOfNextWeek); */
    }
}