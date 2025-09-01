<?php
class Front_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    
    public function fetchPage($id) {
        $this->db->where('page_id', $this->db->escape($id));
        $this->db->where('p.status', 0);
        $this->db->join('photo q', 'q.table="pages" AND q.field_id = p.page_id', 'left outer');
        $this->db->limit(1);
        $query = $this->db->get('pages p');
        return $query->row();
    }

    public function fetchPageManyPics($id,$limits=0) {
        $this->db->select('p.*');
        $this->db->from('photo p');
        $this->db->where('p.table', 'pages');
        $this->db->where('p.field_id', $id);
        $this->db->where('pg.status', 0);
        $this->db->join('pages pg', 'pg.page_id=p.field_id');
        if ($limits != 0) {
            $this->db->limit($limits);
        }
        $q = $this->db->get();
        return $q->result();
    }

    public function commonFetch($selects=[],$table='',$conditions=[],$limits=0,$groupBy='',$orderBy='',$whichOrder='ASC') {
        $this->db->select($selects);
        $this->db->from($table);
        if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        if ($limits != 0) {
            $this->db->limit($limits);
        }
        if ($groupBy != '') {
            $this->db->group_by($groupBy);
        }
        if ($orderBy != '') {
            $this->db->order_by($orderBy,$whichOrder);
        }
        $q = $this->db->get();
        $ret = $q->result();
        if ($limits == 1) {
            $ret = $q->row();
        }
        return $ret;
    }

    public function loadTopDealsX() {
        $this->db->select('ps.ps_id,ps.package_id as packId,ps.resort_id, ps.start_date,ps.end_date, h.hotel_name, h.stars, q.photo_path, ad.name as atoll, MIN(pp.price_poi) AS min_price, pp.adult, 
        (SELECT t.tag FROM package_tags pt JOIN tags t ON t.tag_id = pt.tag_id WHERE pt.p_id = ps.package_id ORDER BY RAND() LIMIT 1) AS tag'); // fetch only one tag randomly.
        $this->db->from('package_season ps');
        $this->db->join('hotels h', 'h.ho_id=ps.resort_id');
        $this->db->join('package_price pp', 'pp.season_id=ps.ps_id');
        $this->db->join('photo q', 'q.table="hotels" AND q.field_id = h.ho_id');
        $this->db->join('atoll_details ad', 'ad.atoll_id=h.atoll');
        $this->db->where('ps.start_date <=', date('Y-m-d'));
        $this->db->where('ps.end_date >=', date('Y-m-d'));
        $this->db->where('pp.is_baserate',1);
        $this->db->group_by('ps.ps_id');
        $this->db->having('min_price >', 0);
        $this->db->order_by('RAND()');
        $this->db->order_by('min_price', 'ASC');
        $this->db->limit(6);
        $query = $this->db->get();
        return $query->result();
    }

    public function loadTopDeals() {
        $this->db->select('ps.ps_id, ps.season, ps.package_id as packId,ps.resort_id, ps.start_date,ps.end_date, h.hotel_name, h.stars, q.photo_path, ad.name as atoll, pp.pp_id, pp.adult, pp.child, pp.infant,
        pp.adult_amount, pp.child_amount, pp.infant_amount, pp.price_poi as min_price, pm.pm_id as mealType, ptr.pts_id as transferType,
        (SELECT t.tag FROM package_tags pt JOIN tags t ON t.tag_id = pt.tag_id WHERE pt.p_id = ps.package_id ORDER BY RAND() LIMIT 1) AS tag,
        (
            SELECT pp_hotel_room.room_title 
            FROM hotel_rooms pp_hotel_room 
            JOIN package_price pphr ON pp_hotel_room.hr_id = pphr.villa_id 
            WHERE pphr.price_poi = MIN(pp.price_poi) 
            AND pphr.season_id = ps.ps_id 
            AND pphr.resort_id = ps.resort_id
            LIMIT 1
        ) AS room_title,

        (
            SELECT pp_hotel_room.hr_id 
            FROM hotel_rooms pp_hotel_room 
            JOIN package_price pphr ON pp_hotel_room.hr_id = pphr.villa_id 
            WHERE pphr.price_poi = MIN(pp.price_poi) 
            AND pphr.season_id = ps.ps_id 
            AND pphr.resort_id = ps.resort_id
            LIMIT 1
        ) AS hr_id'); // fetch only one tag randomly.
        $this->db->from('package_season ps');
        $this->db->join('hotels h', 'h.ho_id=ps.resort_id');
        $this->db->join('package_price pp', 'pp.season_id=ps.ps_id');
        $this->db->join('hotel_rooms hr', 'hr.hr_id=pp.villa_id');
        $this->db->join('photo q', 'q.table="hotels" AND q.field_id = h.ho_id');
        $this->db->join('atoll_details ad', 'ad.atoll_id=h.atoll');
        $this->db->join('packages p', 'p.p_id=ps.package_id');
        
        # Package default meal plan.
        $this->db->join('package_meal pm','pm.package_id=ps.package_id AND pm.is_default=1', 'left outer');
        $this->db->join('package_meal_plan_types pmpt','pmpt.id=pm.package_meal_type', 'left outer');

        # Package default tranfer.
        $this->db->join('package_transfers ptr','ptr.package_id=ps.package_id AND ptr.is_default=1', 'left outer');
        $this->db->join('transfer_types tt','tt.tt_id=ptr.type','left outer');
        $this->db->join('transfer tr','tr.tras_id=ptr.trans_by','left outer');

        $this->db->join('pack_valid_market pvm', 'pvm.p_id=ps.package_id');
        $this->db->join('package_market_countries pmc', 'pmc.market_id=pvm.market_id AND pmc.country_id = ' . $this->db->escape($this->userCountry)); // based on the market.

        $this->db->where('p.p_status', 1);
        $this->db->where('pp.is_baserate',1);
        $this->db->where('(ps.start_date <= "' . date('Y-m-d') . '" AND ps.end_date >= "' . date('Y-m-d') . '") OR (ps.start_date >= "' . date('Y-m-d') . '" AND ps.start_date <= "' . date('Y-m-d') . '")'); // Handle overlapping or exact date matches
        $this->db->group_by('ps.ps_id');
        $this->db->order_by('RAND()');
        $this->db->order_by('pp.price_poi', 'ASC');
        $this->db->limit(6);
        $query = $this->db->get();
        $main = $query->result();
        foreach ($main as $row) {
            $queryArr = array(
                'packageId' => $row->packId,
                'startDate' => date('Y-m-d'),
                'endDate' => date('Y-m-d', strtotime('+5 days')),
                'roomId' => $row->hr_id,
                'adults' => $row->adult,
                'children' => $row->child,
                'infant' => $row->infant,
                'roomCount' => 1,
                'nights' => $this->nightCount(date('Y-m-d', $this->nextWeekFirstDay),date('Y-m-d', $this->nextWeekFourthDay)),
                'mealType' => $row->mealType,
                'transferType' => $row->transferType,
                'resortId' => $row->resort_id
            );
            $calculatedItem = $this->calculatePackagePrice($queryArr);

            $row->calculated_per_night_price = $calculatedItem['calculatePerNightPrice']; // pass the per night price.
            $row->calculated_final_amount = $calculatedItem['calculatedPrice']; // pass the total price.
            $row->stay_night = $calculatedItem['stayNights']; 
            $row->payable_nights = $calculatedItem['payableNights'];
        }
        return $main;
    }

    public function loadPopularResorts() {
        $this->db->select('ps.ps_id, ps.season,ps.resort_id,ps.package_id as packId,h.ho_id, h.hotel_name, h.stars, h.review_count, q.photo_path, ad.name as atoll,c.nicename as country,pp.price_poi,
        pp.pp_id, pp.adult, pp.child, pp.infant, pp.adult_amount, pp.child_amount, pp.infant_amount, pm.pm_id as mealType, ptr.pts_id as transferType,
        (
            SELECT pp_hotel_room.room_title 
            FROM hotel_rooms pp_hotel_room 
            JOIN package_price pphr ON pp_hotel_room.hr_id = pphr.villa_id 
            WHERE pphr.price_poi = MIN(pp.price_poi) 
            AND pphr.season_id = ps.ps_id 
            AND pphr.resort_id = ps.resort_id
            LIMIT 1
        ) AS room_title,

        (
            SELECT pp_hotel_room.hr_id 
            FROM hotel_rooms pp_hotel_room 
            JOIN package_price pphr ON pp_hotel_room.hr_id = pphr.villa_id 
            WHERE pphr.price_poi = MIN(pp.price_poi) 
            AND pphr.season_id = ps.ps_id 
            AND pphr.resort_id = ps.resort_id
            LIMIT 1
        ) AS hr_id');
        $this->db->from('package_season ps');
        $this->db->join('hotels h', 'h.ho_id=ps.resort_id');
        $this->db->join('package_price pp', 'pp.season_id=ps.ps_id');
        $this->db->join('hotel_rooms hr', 'hr.hr_id=pp.villa_id');
        $this->db->join('photo q', 'q.table="hotels" AND q.field_id = h.ho_id');
        $this->db->join('atoll_details ad', 'ad.atoll_id=h.atoll');
        $this->db->join('packages p', 'ps.package_id=p.p_id');

        # Package default meal plan.
        $this->db->join('package_meal pm','pm.package_id=ps.package_id AND pm.is_default=1', 'left outer');
        $this->db->join('package_meal_plan_types pmpt','pmpt.id=pm.package_meal_type', 'left outer');

        # Package default tranfer.
        $this->db->join('package_transfers ptr','ptr.package_id=ps.package_id AND ptr.is_default=1', 'left outer');
        $this->db->join('transfer_types tt','tt.tt_id=ptr.type','left outer');
        $this->db->join('transfer tr','tr.tras_id=ptr.trans_by','left outer');

        $this->db->join('pack_valid_market pvm', 'pvm.p_id=ps.package_id');
        $this->db->join('package_market_countries pmc', 'pmc.market_id=pvm.market_id AND pmc.country_id = ' . $this->db->escape($this->userCountry)); // based on the market.

        $this->db->join('country c', 'c.country_id=h.country');
        $this->db->where('p.p_status', 1);
        $this->db->where('h.h_status',1);
        $this->db->where('h.h_popular',1);
        $this->db->where('h.hotel_type',2);
        $this->db->where('ps.start_date <=', date('Y-m-d'));
        $this->db->where('ps.end_date >=', date('Y-m-d'));
        $this->db->where('pp.is_baserate',1);
        $this->db->group_by('ps.ps_id');
        $this->db->order_by('RAND()');
        $this->db->limit(10);
        $query = $this->db->get();
        $main = $query->result();
        foreach ($main as $row) {
            $queryArr = array(
                'packageId' => $row->packId,
                'startDate' => date('Y-m-d'),
                'endDate' => date('Y-m-d', strtotime('+5 days')),
                'roomId' => $row->hr_id,
                'adults' => $row->adult,
                'children' => $row->child,
                'infant' => $row->infant,
                'roomCount' => 1,
                'nights' => $this->nightCount(date('Y-m-d', $this->nextWeekFirstDay),date('Y-m-d', $this->nextWeekFourthDay)),
                'mealType' => $row->mealType,
                'transferType' => null, // passing NULL here, because in the front no need to show the transfer calculation ––> $row->transferType.
                'resortId' => $row->resort_id
            );
            $calculatedItem = $this->calculatePackagePrice($queryArr);

            $row->calculated_per_night_price = $calculatedItem['calculatePerNightPrice'];
            $row->calculated_final_amount = $calculatedItem['calculatedPrice']; // pass the total price.
            $row->stay_night = $calculatedItem['stayNights']; 
            $row->payable_nights = $calculatedItem['payableNights']; 
        }
        return $main;
    }

    public function getAccomodations($selects=[], $conditions=[], $limits=0) {
        $this->db->select($selects);
        $this->db->from('hotels h');
        $this->db->join('photo q', 'q.table="hotels" AND q.field_id = h.ho_id');
        $this->db->join('atoll_details ad', 'ad.atoll_id=h.atoll');
        $this->db->join('country c', 'c.country_id=h.country');
        if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        if ($limits != 0) {
            $this->db->limit($limits);
        }
        $this->db->group_by('h.ho_id');
        $q = $this->db->get();
        return $q->result();
    }

    public function atollList() {
        $query = $this->db->query('SELECT a.*, COUNT(DISTINCT h.ho_id) as hotel_count, COUNT(DISTINCT hr.hr_id) as room_count, q.photo_path
                                    FROM atoll_details a
                                    INNER JOIN photo q ON q.table="atoll_details" AND q.field_id = a.atoll_id
                                    LEFT JOIN hotels h ON h.atoll = a.atoll_id AND h.hotel_type = 2
                                    LEFT JOIN hotel_rooms hr ON hr.ho_id = h.ho_id
                                    GROUP BY a.atoll_id
                                    ORDER BY RAND()
                                    LIMIT 6');
        return $query->result();
    }

    public function getOurTeam() {
        $this->db->select('s.fname, s.lname, s.user_pic, s.position, s.fb_link, s.email, s.ig_link, s.wa_phone');
        $this->db->from('staff_users s');
        $this->db->where('status', 0);
        $this->db->where('show_in_site', 1);
        $this->db->where('user_type', 0);
        $this->db->limit(20);
        $q = $this->db->get();
        $data = $q->result();
        return $data;
    }

    public function loadFaqsWithCategory() {
        $this->db->select('fc.fc_id,fc.faq_title,f.f_id,f.question,f.answer');
        $this->db->from('faq_categories fc');
        $this->db->join('faq f', 'fc.fc_id = f.fc_id', 'left');
        $q = $this->db->get();
        $result = $q->result();
    
        $main = [];
    
        foreach ($result as $row) {
            if (!isset($main[$row->fc_id])) {
                $main[$row->fc_id] = [
                    'fc_id' => $row->fc_id,
                    'faq_title' => $row->faq_title,
                    'faqs' => []
                ];
            }
    
            if ($row->f_id) {
                $main[$row->fc_id]['faqs'][] = [
                    'f_id' => $row->f_id,
                    'question' => $row->question,
                    'answer' => $row->answer
                ];
            }
        }
    
        return array_values($main);
    }

    public function loadFaqs() {
        $this->db->select('f.f_id,f.question,f.answer');
        $this->db->from('faq f');
        $q = $this->db->get();
        return $q->result();
    }

    public function getCountries() {
        return $this->db->get('country')->result();
    }

    function insert($table,$data){
		$this->db->insert($table, $data); 
		return  $this->db->insert_id();
	}

    public function getRecordByValue($value) {
        $q = $this->db->get_where('subscription_email', array('email' => $value), 1);
        return $q->num_rows() > 0;
    }

    public function loadTestimonials() {
        $this->db->select('t.*,h.hotel_name');
        $this->db->from('testimonials t');
        $this->db->join('hotels h', 'h.ho_id=t.ho_id');
        $this->db->where('t.status', 1);
        $this->db->order_by('t.ts_id', 'DESC');
        $q = $this->db->get();
        return $q->result();
    }

    public function getSearchRecord() {
        $this->db->select('h.ho_id,h.hotel_name,c.nicename');
        $this->db->from('hotels h');
        $this->db->where('h.h_status', 1);
        $this->db->join('country c', 'c.country_id=h.country');
        $this->db->order_by('RAND()');
        $q = $this->db->get();
        $hotels = $q->result();

        $this->db->select('a.atoll_id,a.name,c.nicename');
        $this->db->from('atoll_details a');
        $this->db->join('country c', 'c.country_id=a.country_id');
        $this->db->order_by('RAND()');
        $q2 = $this->db->get();
        $atolls = $q2->result();

        $_arr = [];
        foreach ($hotels as $hotel) {
            $h_arr = array(
                'id' => $hotel->ho_id,
                'name' => $hotel->hotel_name,
                'country' => $hotel->nicename,
                'type' => 1,
                'icon' => 'icon-bed',
            );
            $_arr[] = $h_arr;
        }

        foreach ($atolls as $atoll) {
            $a_arr = array(
                'id' => $atoll->atoll_id,
                'name' => $atoll->name,
                'country' => $atoll->nicename,
                'type' => 2,
                'icon' => 'icon-location-2',
            );
            $_arr[] = $a_arr;
        }
        return $_arr;
    }

    # Here this will return the min and max prices of the room of specific accom type (eg : resorts, hotels, yacht).
    public function fetchMinMaxRoomPrice() {
        $this->db->select('MIN(pp.price_poi) as min_price,MAX(pp.price_poi) as max_price');
        $this->db->from('package_price pp');
        $que = $this->db->get();
        return $que->row();
    }

    /* public function find_min_max_price($searchedStartDate,$searchedEndDate) {
        $nightCount = $this->nightCount($searchedStartDate,$searchedEndDate);

        $this->db->select('ps.*,pp.*,pm.pm_id as mealType,ptr.pts_id as transferTypeId');
        $this->db->from('package_season ps');
        $this->db->where('ps.start_date <=', $searchedStartDate);
        $this->db->where('ps.end_date >=', $searchedEndDate);
        $this->db->join('package_price pp', 'pp.season_id=ps.ps_id');

        # Package default meal plan.
        $this->db->join('package_meal pm','pm.package_id=ps.package_id AND pm.is_default=1', 'left outer');
        $this->db->join('package_meal_plan_types pmpt','pmpt.id=pm.package_meal_type', 'left outer');

        # Package default tranfer.
        $this->db->join('package_transfers ptr','ptr.package_id=ps.package_id AND ptr.is_default=1', 'left outer');
        $this->db->join('transfer_types tt','tt.tt_id=ptr.type','left outer');
        $this->db->join('transfer tr','tr.tras_id=ptr.trans_by','left outer');

        $this->db->order_by('pp.price_poi', 'ASC');
        $this->db->limit(1);
        $qMin = $this->db->get();
        $minRecord = $qMin->row();

        $minQueryArr = array(
            'packageId' => (int)$minRecord->package_id,
            'startDate' => $searchedStartDate,
            'endDate' => $searchedEndDate,
            'roomId' => $minRecord->villa_id,
            'adults' => $minRecord->adult,
            'children' => $minRecord->child,
            'infant' => $minRecord->infant,
            'roomCount' => 1,
            'nights' => $nightCount,
            'mealType' => null,
            'transferType' => null,
            'resortId' => $minRecord->resort_id
        );
        $minPriceItem = $this->calculatePackagePrice($minQueryArr); // calculated minimum price

        $this->db->select('ps.*,pp.*,pm.pm_id as mealType,ptr.pts_id as transferTypeId');
        $this->db->from('package_season ps');
        $this->db->where('ps.start_date <=', $searchedStartDate);
        $this->db->where('ps.end_date >=', $searchedEndDate);
        $this->db->join('package_price pp', 'pp.season_id=ps.ps_id');

        # Package default meal plan.
        $this->db->join('package_meal pm','pm.package_id=ps.package_id AND pm.is_default=1', 'left outer');
        $this->db->join('package_meal_plan_types pmpt','pmpt.id=pm.package_meal_type', 'left outer');

        # Package default tranfer.
        $this->db->join('package_transfers ptr','ptr.package_id=ps.package_id AND ptr.is_default=1', 'left outer');
        $this->db->join('transfer_types tt','tt.tt_id=ptr.type','left outer');
        $this->db->join('transfer tr','tr.tras_id=ptr.trans_by','left outer');

        $this->db->order_by('pp.price_poi', 'DESC');
        $this->db->limit(1);
        $qMax = $this->db->get();
        $maxRecord = $qMax->row();

        $maxQueryArr = array(
            'packageId' => (int)$maxRecord->package_id,
            'startDate' => $searchedStartDate,
            'endDate' => $searchedEndDate,
            'roomId' => $maxRecord->villa_id,
            'adults' => $maxRecord->adult,
            'children' => $maxRecord->child,
            'infant' => $maxRecord->infant,
            'roomCount' => 2,
            'nights' => $nightCount,
            'mealType' => $maxRecord->mealType,
            'transferType' => $maxRecord->transferTypeId,
            'resortId' => $maxRecord->resort_id
        );
        $maxPriceItem = $this->calculatePackagePrice($maxQueryArr); // calculated maximum price.

        return ['min_price' => $minPriceItem['calculatedPrice'], 'max_price' => $maxPriceItem['calculatedPrice']];
    } */

    public function find_min_max_price($searchedStartDate, $searchedEndDate) {
        $nightCount = $this->nightCount($searchedStartDate, $searchedEndDate);
    
        /** ---------------- MIN PRICE ---------------- **/
        $this->db->select('ps.*,pp.*,pm.pm_id as mealType,ptr.pts_id as transferTypeId');
        $this->db->from('package_season ps');
        $this->db->where('ps.start_date <=', $searchedEndDate);   // allow overlap
        $this->db->where('ps.end_date >=', $searchedStartDate);   // allow overlap
        $this->db->join('package_price pp', 'pp.season_id=ps.ps_id');
        $this->db->join('package_meal pm','pm.package_id=ps.package_id AND pm.is_default=1', 'left');
        $this->db->join('package_meal_plan_types pmpt','pmpt.id=pm.package_meal_type', 'left');
        $this->db->join('package_transfers ptr','ptr.package_id=ps.package_id AND ptr.is_default=1', 'left');
        $this->db->join('transfer_types tt','tt.tt_id=ptr.type','left');
        $this->db->join('transfer tr','tr.tras_id=ptr.trans_by','left');
        $this->db->order_by('pp.price_poi', 'ASC');
        $this->db->limit(1);
        $qMin = $this->db->get();
        $minRecord = $qMin->row();
    
        $minPrice = 0;
        if ($minRecord) {
            $minQueryArr = [
                'packageId'    => (int)$minRecord->package_id,
                'startDate'    => $searchedStartDate,
                'endDate'      => $searchedEndDate,
                'roomId'       => $minRecord->villa_id,
                'adults'       => $minRecord->adult,
                'children'     => $minRecord->child,
                'infant'       => $minRecord->infant,
                'roomCount'    => 1,
                'nights'       => $nightCount,
                'mealType'     => null,
                'transferType' => null,
                'resortId'     => $minRecord->resort_id
            ];
            $minPriceItem = $this->calculatePackagePrice($minQueryArr);
            $minPrice = $minPriceItem['calculatedPrice'];
        }
    
    
        /** ---------------- MAX PRICE ---------------- **/
        $this->db->select('ps.*,pp.*,pm.pm_id as mealType,ptr.pts_id as transferTypeId');
        $this->db->from('package_season ps');
        $this->db->where('ps.start_date <=', $searchedEndDate);
        $this->db->where('ps.end_date >=', $searchedStartDate);
        $this->db->join('package_price pp', 'pp.season_id=ps.ps_id');
        $this->db->join('package_meal pm','pm.package_id=ps.package_id AND pm.is_default=1', 'left');
        $this->db->join('package_meal_plan_types pmpt','pmpt.id=pm.package_meal_type', 'left');
        $this->db->join('package_transfers ptr','ptr.package_id=ps.package_id AND ptr.is_default=1', 'left');
        $this->db->join('transfer_types tt','tt.tt_id=ptr.type','left');
        $this->db->join('transfer tr','tr.tras_id=ptr.trans_by','left');
        $this->db->order_by('pp.price_poi', 'DESC');
        $this->db->limit(1);
        $qMax = $this->db->get();
        $maxRecord = $qMax->row();
    
        $maxPrice = 0;
        if ($maxRecord) {
            $maxQueryArr = [
                'packageId'    => (int)$maxRecord->package_id,
                'startDate'    => $searchedStartDate,
                'endDate'      => $searchedEndDate,
                'roomId'       => $maxRecord->villa_id,
                'adults'       => $maxRecord->adult,
                'children'     => $maxRecord->child,
                'infant'       => $maxRecord->infant,
                'roomCount'    => 2,
                'nights'       => $nightCount,
                'mealType'     => $maxRecord->mealType,
                'transferType' => $maxRecord->transferTypeId,
                'resortId'     => $maxRecord->resort_id
            ];
            $maxPriceItem = $this->calculatePackagePrice($maxQueryArr);
            $maxPrice = $maxPriceItem['calculatedPrice'];
        }
    
        return [
            'min_price' => $minPrice,
            'max_price' => $maxPrice
        ];
    }
    
    
    public function fetchPropertyTypes() {
        $this->db->select('ht.ht_id,ht.hotel_type as name, COUNT(h.ho_id) as count');
        $this->db->from('hotel_type ht');
        $this->db->where('ht.ht_status', 1);
        $this->db->join('hotels h', 'h.hotel_type = ht.ht_id');
        $this->db->group_by('ht.ht_id');
        $q = $this->db->get();
        return $q->result();
    }

    public function fetchAtolls() {
        $this->db->select('ad.atoll_id,ad.name, COUNT(h.ho_id) as count');
        $this->db->from('atoll_details ad');
        $this->db->join('hotels h', 'h.atoll = ad.atoll_id');
        $this->db->group_by('ad.atoll_id');
        $q = $this->db->get();
        return $q->result();
    }

    public function filterList($nameSearch='',$searchedType=0,$searchedValue=0,$searchedStartDate,$searchedEndDate,$adultCount=1,$childCount=0,$infantCount=0,$roomCount=1,$priceMin=0,$priceMax=0,$propertyList=[],$villaTypes=[],$starVal=0,$transerTypes=[],$atollList=[],$limit,$offset) {
        $this->db->select('ps.ps_id,ps.package_id as packId,ps.resort_id,ps.start_date,ps.end_date,h.hotel_name,h.stars,h.review_count,h.longitude, h.latitude,ht.hotel_type,ad.name as atoll,MIN(pp.price_poi) AS min_price,pp.adult,pp.child,pp.resort_id as ppResortId,pp.villa_id as ppVillaId,c.nicename,rb.rb_title,
        (SELECT t.tag FROM package_tags pt JOIN tags t ON t.tag_id = pt.tag_id WHERE pt.p_id = ps.package_id ORDER BY RAND() LIMIT 1) AS tag,pmpt.type_title as packageMealPlan,
        tt.transfer_type as transferType,tr.transfer_type as transferVehicle,pm.pm_id as mealType,ptr.pts_id as transferTypeId,
        
        (
            SELECT pp_hotel_room.room_title 
            FROM hotel_rooms pp_hotel_room 
            JOIN package_price pphr ON pp_hotel_room.hr_id = pphr.villa_id 
            WHERE pphr.price_poi = MIN(pp.price_poi) 
            AND pphr.season_id = ps.ps_id 
            AND pphr.resort_id = ps.resort_id
            LIMIT 1
        ) AS room_title,

        (
            SELECT pp_hotel_room.hr_id 
            FROM hotel_rooms pp_hotel_room 
            JOIN package_price pphr ON pp_hotel_room.hr_id = pphr.villa_id 
            WHERE pphr.price_poi = MIN(pp.price_poi) 
            AND pphr.season_id = ps.ps_id 
            AND pphr.resort_id = ps.resort_id
            LIMIT 1
        ) AS roomId
        ');
        $this->db->from('package_season ps');
        $this->db->join('hotels h', 'h.ho_id=ps.resort_id');
        $this->db->join('hotel_type ht', 'ht.ht_id=h.hotel_type');
        $this->db->join('country c', 'c.country_id=h.country');
        $this->db->join('package_price pp', 'pp.season_id=ps.ps_id');
        $this->db->join('packages p', 'p.p_id=ps.package_id');
        $this->db->join('atoll_details ad', 'ad.atoll_id=h.atoll');
        $this->db->join('hotel_rooms hr', 'hr.hr_id=pp.villa_id');
        $this->db->join('room_beds rb', 'rb.rb_id=hr.bed_type');
        $this->db->join('photo q', 'q.table="hotels" AND q.field_id = h.ho_id');

        # Package default meal plan.
        $this->db->join('package_meal pm','pm.package_id=ps.package_id AND pm.is_default=1', 'left outer');
        $this->db->join('package_meal_plan_types pmpt','pmpt.id=pm.package_meal_type', 'left outer');

        # Package default tranfer.
        $this->db->join('package_transfers ptr','ptr.package_id=ps.package_id AND ptr.is_default=1', 'left outer');
        $this->db->join('transfer_types tt','tt.tt_id=ptr.type','left outer');
        $this->db->join('transfer tr','tr.tras_id=ptr.trans_by','left outer');

        $this->db->join('pack_valid_market pvm', 'pvm.p_id=ps.package_id');
        $this->db->join('package_market_countries pmc', 'pmc.market_id=pvm.market_id AND pmc.country_id = ' . $this->db->escape($this->userCountry)); // based on the market.

        if ($nameSearch != '') {
            $this->db->like('h.hotel_name', $nameSearch);
        }
        $this->db->where('p.p_status', 1);
        $this->db->where('ps.start_date <=', $searchedStartDate);
        $this->db->where('ps.end_date >=', $searchedEndDate);
        $this->db->where('pp.adult', $adultCount);
        $this->db->where('pp.child', $childCount);
        $this->db->where('pp.infant', $infantCount);
        if ($searchedType == 2 && $searchedValue != 0) {
            $this->db->where('h.atoll', $searchedValue);
        }
        /* if ($priceMin != 0) {
            $this->db->where('pp.price_poi >=',$priceMin);
        }
        if ($priceMax != 0) {
            $this->db->where('pp.price_poi <=',$priceMax);
        } */
        if ($starVal != 0) {
            $this->db->where('h.stars', $starVal);
        }
        if (!empty($propertyList)) {
            $this->db->where_in('h.hotel_type', $propertyList);
        }
        if (!empty($villaTypes)) {
            $this->db->join('rooms_villas rv', 'rv.hr_id=hr.hr_id', 'left outer');
            $this->db->where_in('rv.vt_id', $villaTypes);
        }
        if (!empty($transerTypes)) {
            $this->db->join('package_transfers pt', 'pt.package_id=p.p_id', 'left outer');
            $this->db->where_in('pt.trans_by', $transerTypes);
        }
        if (!empty($atollList)) {
            $this->db->where_in('h.atoll', $atollList);
        }
        $this->db->group_by('ps.ps_id');
        $this->db->having('min_price >', 0);
        if ($searchedType == 1 && $searchedValue != 0) {
            $this->db->order_by("(CASE WHEN h.ho_id = $searchedValue THEN 0 ELSE 1 END), min_price ASC");
        } elseif ($searchedType == 2 && $searchedValue != 0) {
            $this->db->order_by("(CASE WHEN h.atoll = $searchedValue THEN 0 ELSE 1 END), min_price ASC");
        } else {
            $this->db->order_by('min_price', 'ASC');
        }
        $tempdb = clone $this->db;
        $main['rowcount'] = $tempdb->count_all_results();
        if ($limit != '') {
            $this->db->limit($limit,$offset);
        }
        $query = $this->db->get();
        $main['result'] = $query->result();
        
        $filteredResult = []; // initialize the final record array.
        foreach ($main['result'] as $row) {
            // get hotel facilities
            $this->db->select('hfac.fac_icon as facility_icon, hfac.fac_name as facility_name');
            $this->db->from('hotel_fac hf');
            $this->db->where('hf.ho_id', $row->resort_id);
            $this->db->join('hotel_facilities hfac', 'hfac.fac_id=hf.fac_id');
            $this->db->group_by('hfac.fac_id'); // added group by clause
            $this->db->limit(4);
            $qHotelFacilities = $this->db->get();
            $row->hotelFacilities = $qHotelFacilities->result();

            // hotel images
            $this->db->select('photo_path, file_ext, `table`');
            $this->db->from('photo');
            $this->db->where(['table' => 'hotels', 'field' => 'ho_id', 'field_id' => $row->resort_id]);
            $qHotelImages = $this->db->get();
            $row->hotelImages = $qHotelImages->result();

            // package Taxes
            $this->db->select('txty.tax_type');
            $this->db->from('package_tax ptx');
            $this->db->where('ptx.package_id',$row->packId);
            $this->db->join('tax_types txty','txty.tax_id=ptx.tax_type');
            $qTaxes = $this->db->get();
            $packageTaxes = $qTaxes->result();

            $taxTypes = array_column($packageTaxes, 'tax_type');
            $formattedTaxes = implode(', ', $taxTypes);

            if (count($taxTypes) > 1) {
                $lastTaxType = end($taxTypes);
                $formattedTaxes = implode(', ', array_slice($taxTypes, 0, -1)) . " & " . $lastTaxType;
            }
            $row->packageTaxes = $formattedTaxes;

            $nightCount = $this->nightCount($searchedStartDate,$searchedEndDate);
            $row->nightCount = $nightCount;
            $row->availableRooms = $this->availableRooms($row->resort_id,$searchedStartDate,$searchedEndDate);
            
            $queryArr = array(
                'packageId' => (int)$row->packId,
                'startDate' => $searchedStartDate,
                'endDate' => $searchedEndDate,
                'roomId' => $row->roomId,
                'adults' => $adultCount,
                'children' => $childCount,
                'infant' => $infantCount,
                'roomCount' => $roomCount,
                'nights' => $nightCount,
                'mealType' => $row->mealType,
                'transferType' => $row->transferTypeId,
                'resortId' => $row->resort_id
            );
            $calculatedItem = $this->calculatePackagePrice($queryArr);

            $row->calculated_per_night_price = $calculatedItem['calculatePerNightPrice'];
            $row->actualPrice = $calculatedItem['calculatedPrice']; // pass the total price.
            $row->stay_night = $calculatedItem['stayNights']; 
            $row->payable_nights = $calculatedItem['payableNights'];

            // Filter by price range
            if ($calculatedItem['calculatedPrice'] >= $priceMin && ($priceMax == 0 || $calculatedItem['calculatedPrice'] <= $priceMax)) {
                $filteredResult[] = $row;
            }
        }
        $main['result'] = $filteredResult;
        return $main;
    }

    public function getAccomodationDetail($startDate,$endDate,$resortId,$adults,$child) {
        $this->db->select('p.p_id,p.arrival_from as package_start,p.arrival_to as package_end,c.nicename, ad.atoll_id, ad.name as atoll, ht.hotel_type, h.ho_id, h.hotel_name, h.stars, h.description, h.important_notice as resort_policies, h.review_count, h.longitude, h.latitude, ps.ps_id as season_id, ps.package_id, MIN(packprice.price_poi) AS min_price,ps.start_date,ps.end_date,
            (
                SELECT CONCAT_WS(",",  pms.pms_id, pms.min_stay) 
                FROM package_min_stay pms
                LEFT OUTER JOIN package_season psm ON psm.package_id = pms.package_id
                WHERE pms.mnstart_date <= '.$this->db->escape($startDate).' 
                AND pms.mnend_date >= '.$this->db->escape($endDate).'
                ORDER BY pms.min_stay DESC 
                LIMIT 1
            ) AS package_min_stay
        ');
        $this->db->from('package_season ps');
        $this->db->join('package_price packprice', 'packprice.season_id=ps.ps_id');
        $this->db->join('packages p', 'p.p_id=ps.package_id');
        $this->db->join('hotels h', 'h.ho_id=ps.resort_id');
        $this->db->join('atoll_details ad', 'ad.atoll_id=h.atoll');
        $this->db->join('country c', 'c.country_id=h.country');
        $this->db->join('hotel_type ht', 'ht.ht_id=h.hotel_type');
        $this->db->where('ps.start_date <=', $startDate);
        $this->db->where('ps.end_date >=', $endDate);
        $this->db->where('h.ho_id', $resortId);
        $this->db->where('packprice.adult', $adults);
        $this->db->where('packprice.child', $child);

        $query = $this->db->get_compiled_select(); // Get the compiled SQL statement
        $query = $this->db->query($query, array($startDate, $endDate, $resortId,$adults,$child)); // Bind parameters to the SQL statement
        $main = $query->row();

        // get the hotel images
        $this->db->select('photo_path, file_ext, `table`');
        $this->db->from('photo');
        $this->db->where(['table' => 'hotels', 'field' => 'ho_id', 'field_id' => $main->ho_id]);
        $qHotelImages = $this->db->get();
        $main->hotelImages = $qHotelImages->result();


        // get hotel facilities
        $this->db->select('hfac.fac_icon as facility_icon, hfac.fac_name as facility_name');
        $this->db->from('hotel_fac hf');
        $this->db->where('hf.ho_id', $main->ho_id);
        $this->db->join('hotel_facilities hfac', 'hfac.fac_id=hf.fac_id');
        $this->db->group_by('hfac.fac_id'); // added group by clause
        $qHotelFacilities = $this->db->get();
        $main->hotelFacilities = $qHotelFacilities->result();

        // get the rooms of the hotel
        /* $this->db->select('hr.hr_id, hr.room_title, hr.room_count, pp.price_poi as price, pp.adult, pp.child, pp.is_baserate, vt.vt_name as roomType, mt.long_name as meal_plan_name');
        $this->db->from('hotel_rooms hr');
        $this->db->where('hr.ho_id', $main->ho_id);
        $this->db->where('pp.season_id', $main->season_id);
        if ($adults != 0) {
            $this->db->where('pp.adult', $adults);
        } else {
            $this->db->where('pp.is_baserate', 1);
        }
        if ($adults != 0 && $child != '') { // I checked adult here. I want to check child when adult is not = to zero.
            $this->db->where('pp.child', $child);
        }
        // $this->db->where('pp.is_baserate', 1);
        $this->db->join('package_price pp', 'pp.villa_id = hr.hr_id');
        $this->db->join('rooms_villas rv', 'rv.hr_id = hr.hr_id', 'left');
        $this->db->join('villa_types vt', 'vt.vt_id = rv.vt_id', 'left');
        $this->db->join('meal_types mt', 'mt.meal_id=pp.meal_plan', 'left');
        $this->db->group_by('hr.hr_id');
        $qHotelRooms = $this->db->get();
        $hotelRooms = $qHotelRooms->result(); */

        $minstayId = ($main->package_min_stay) ? explode(',', $main->package_min_stay)[0] : 0; // fetch the min stay ID. That will be presented 0th index.

        $hotelRooms = $this->getRoomsWithOffers($main->p_id,$main->ho_id,$main->season_id,$adults,$child,$startDate,$endDate,$minstayId); // fetch hotel rooms with the offer.

        // get room images
        $this->db->select('p.photo_path, p.file_ext, p.table, p.field_id');
        $this->db->from('photo p');
        $this->db->where('p.table', 'hotel_rooms');
        $this->db->where('p.field', 'hr_id');
        $this->db->where_in('p.field_id', array_column($hotelRooms, 'hr_id'));
        $qRoomImages = $this->db->get();
        $roomImages = $qRoomImages->result();

        // get room attributes
        $this->db->select('hra.icon as room_attr_icon,hra.value as room_attr_val,hrav.room_id');
        $this->db->from('hotel_room_attr_val hrav');
        $this->db->join('hotel_room_attributes hra', 'hra.hra_id=hrav.hra_id');
        $this->db->where_in('hrav.room_id', array_column($hotelRooms, 'hr_id'));
        $qRoomAttributes = $this->db->get();
        $roomAttributes = $qRoomAttributes->result();

        // assign images and attributes to each room
        foreach ($hotelRooms as &$room) {
            // filter images for the current room
            $room->roomImages = array_filter($roomImages, function($image) use ($room) {
                return $image->field_id == $room->hr_id;
            });
            
            // filter attributes for the current room
            $room->roomAttributes = array_filter($roomAttributes, function($attr) use ($room) {
                return $attr->room_id == $room->hr_id;
            });
        }

        // assign hotel rooms to main object
        $main->hotelRooms = $hotelRooms;
        // sort hotel room array in ascending order by price.
        usort($main->hotelRooms, function ($item1, $item2) {
            return $item1->calculatedPrice <=> $item2->calculatedPrice;
        });

        // get the activities
        $main->hotelExtra = $this->fetchHotelExtra($main->ho_id);
        
        // get hotel FAQs
        $main->hotelFaqs = $this->commonFetch(['faq_question','faq_answer'],'hotel_faq',['hotel_id' => $main->ho_id, 'hf_status' => 1]);

        // get related records.
        $main->relatedHotels = $this->relatedHotels($startDate,$endDate,$adults,$child,$main->atoll_id,4);

        $main->isTaxIncluded = $this->isTaxIncluded($main->package_id);

        return $main;
    }

    function getRoomsWithOffers($packageId,$hotelId,$seasonId,$adults,$child,$startDate,$endDate,$minstayId=0) : array {
        $this->db->select('hr.hr_id, hr.room_title, hr.room_count, pp.price_poi as price, pp.adult, pp.child, pp.infant, pp.is_baserate, vt.vt_name as roomType, mt.long_name as meal_plan_name,pt.pts_id as default_transfer_id,pms.min_stay as package_room_min_stay');
        
        $this->db->from('hotel_rooms hr');
        $this->db->where('hr.ho_id', $hotelId);
        $this->db->where('pp.season_id', $seasonId);
        if ($adults != 0) {
            $this->db->where('pp.adult', $adults);
        } else {
            $this->db->where('pp.is_baserate', 1);
        }
        if ($adults != 0 && $child != '') { // I checked adult here. I want to check child when adult is not = to zero.
            $this->db->where('pp.child', $child);
        }
        // $this->db->where('pp.is_baserate', 1);
        $this->db->join('package_price pp', 'pp.villa_id = hr.hr_id');
        $this->db->join('rooms_villas rv', 'rv.hr_id = hr.hr_id', 'left');
        $this->db->join('villa_types vt', 'vt.vt_id = rv.vt_id', 'left');
        $this->db->join('meal_types mt', 'mt.meal_id=pp.meal_plan', 'left');
        $this->db->join('package_transfers pt','pt.package_id=pp.p_id AND pt.is_default=1', 'left outer');

        $this->db->join('package_min_stay_villas pmsv', 'pmsv.villa_id=hr.hr_id', 'left outer');
        $this->db->join('package_min_stay pms', 'pms.pms_id=pmsv.pms_id AND pms.pms_id = '.$minstayId.'', 'left outer'); // get the package room wise minstay.

        $this->db->group_by('hr.hr_id');
        $qHotelRooms = $this->db->get();
        $main = $qHotelRooms->result();
        foreach ($main as $row) {
            $totalPax = (int)$adults + (int)$child;

            // $row->roomOffers = $this->fetchPackageOffers($packageId,$row->hr_id,$startDate,$endDate,$totalPax);
            $row->roomOffers = $this->load_offers($hotelId,$packageId,$row->hr_id,$startDate,$endDate,$totalPax,$this->userCountry);
            $row->nightCount = $this->nightCount($startDate,$endDate);

            $selectedMealType = $this->default_meal_of_the_room($row->hr_id,$packageId);
            
            // calculate the room final price.
            $queryArr = array(
                'packageId' => $packageId,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'roomId' => $row->hr_id,
                'adults' => $adults,
                'children' => $child,
                'infant' => $row->infant,
                'roomCount' => 1,
                'nights' => $this->nightCount($startDate,$endDate),
                'mealType' => ($selectedMealType) ? $selectedMealType->pm_id : false,
                'transferType' => $row->default_transfer_id,
                'resortId' => $hotelId
            );
            $calculatedItem = $this->calculatePackagePrice($queryArr);

            $row->calculatedPrice = $calculatedItem['calculatedPrice'];
            $row->priceIncludes = $calculatedItem['price_included'];
        }
        
        return $main;
    }

    // get the room's default meal
    private function default_meal_of_the_room($roomId,$packageId){
        $this->db->select('pm.*,pmpt.type_title as meal_name');
        $this->db->from('package_meal pm');
        $this->db->where('pm.package_id', $packageId);
        $this->db->group_start();
            $this->db->where('pm.villa_id', 1);
            $this->db->or_where('(pm.villa_id=0 AND pmv.villa_id='.$roomId.')');
            $this->db->join('package_meal_villas pmv', 'pmv.pm_id=pm.pm_id', 'left outer');
        $this->db->group_end();
        $this->db->where('pm.is_default',1);
        /* $this->db->where('pm.villa_id', 1);
        $this->db->or_where('pm.villa_id', 0);
        if ($this->db->where('pm.villa_id', 0)) {
            $this->db->join('package_meal_villas pmv', 'pmv.pm_id=pm.pm_id', 'left outer');
            $this->db->where('pmv.villa_id', $roomId);
        } */
        $this->db->join('package_meal_plan_types pmpt', 'pmpt.id=pm.package_meal_type');
        $this->db->limit(1);
        $q = $this->db->get();
        $ret = false;
        if ($q->num_rows() == 1) {
            $ret = $q->row();
        }
        return $ret;
    }

    // derive the number of nights between two dates
    public function nightCount($startDate,$endDate) {
        $date1 = new DateTime($startDate);
        $date2 = new DateTime($endDate);

        $interval = $date1->diff($date2);
        $nightsCount = $interval->days;
        return $nightsCount; // hotel booking night starts with start date night.
    }

    // get the commission value
    private function getTheCommission($percentage,$amount) {
		return floatval($percentage / 100) * floatval($amount);
	}

    // get the taxes
    private function getTaxes($packageId) {
        $this->db->select('pt.*,tt.tax_type as tax_name');
        $this->db->from('package_tax pt');
        $this->db->where('pt.package_id', $packageId);
        $this->db->join('tax_types tt','tt.tax_id=pt.tax_type');
        $q = $this->db->get();
        return $q->result();
    }

    // get the default transfer
    private function get_default_transfer($defaultTransferId,$totalPax){
        $this->db->select('pt.*,t.transfer_type as transfer_name,tt.transfer_type as transfer_mode');
        $this->db->from('package_transfers pt');
        $this->db->where('pt.pts_id', $defaultTransferId);
        $this->db->where('pt.min_pax <=', $totalPax);
        $this->db->where('pt.max_pax >=', $totalPax);
        $this->db->join('transfer t','t.tras_id=pt.trans_by');
        $this->db->join('transfer_types tt','tt.tt_id=pt.type');
        $this->db->limit(1);
        $q = $this->db->get();
        $ret = false;
        if ($q->num_rows() == 1) {
            $ret = $q->row();
        }
        return $ret;
    }

    private function fetchHotelExtra($hotelId) {
        $this->db->select('ae.*');
        $this->db->from('accomodation_extras ae');
        $this->db->order_by('ae.ae_id', 'ASC');
        $this->db->group_by('ae.ae_id');
        $q = $this->db->get();
        $main = $q->result();

        foreach ($main as $row) {
            $this->db->select('he.he_title,he.he_description,q.photo_path,q.file_ext');
            $this->db->from('hotel_extras he');
            $this->db->join('photo q', 'q.table="hotel_extras" AND q.field_id = he.he_id', 'left outer');
            $this->db->where('he.ho_id', $hotelId);
            $this->db->where('he.ae_id', $row->ae_id);
            $this->db->where('he.status', 1);
            $qChild = $this->db->get();
            $row->childContent = $qChild->result();
        }
        return $main;
    }

    public function relatedHotels($startDate,$endDate,$adults,$child,$accomAtoll,$limit='') {
        $query = "SELECT c.nicename, ad.name AS atoll, ht.hotel_type, h.ho_id, h.hotel_name, h.stars, h.review_count, ps.ps_id AS season_id, MIN(packprice.price_poi) AS min_price, ps.start_date, ps.end_date, packprice.adult, packprice.child,p.table AS photo_folder,p.photo_path,p.file_ext
        FROM package_season ps
        JOIN package_price packprice ON packprice.season_id = ps.ps_id
        JOIN hotels h ON h.ho_id = ps.resort_id
        JOIN atoll_details ad ON ad.atoll_id = h.atoll
        JOIN country c ON c.country_id = h.country
        JOIN hotel_type ht ON ht.ht_id = h.hotel_type
        JOIN photo p ON p.table='hotels' AND p.field_id=h.ho_id
        WHERE h.atoll = ? AND ps.start_date <= ? AND ps.end_date >= ? AND packprice.adult = ? AND packprice.child = ? AND h.h_status = 1
        GROUP BY h.ho_id
        ORDER BY h.hotel_name ASC
        LIMIT ?";
        $result = $this->db->query($query, array($accomAtoll, $startDate, $endDate, $adults, $child, $limit))->result();
        return $result;
    }

    private function isTaxIncluded($packageId) {
        $this->db->from('package_tax');
        $this->db->where('package_id', $packageId);
        $this->db->limit(1);
        $q = $this->db->get();
        $ret = false;
        if ($q->num_rows() > 0) {
            $ret = true;
        }
        return $ret;
    }

    public function check_value_exist($table,$conditions=[]) {
        $this->db->select('*');
        $this->db->from($table);
        if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->limit(1);
        $q = $this->db->get();
        if ($q->num_rows()==1) {
            return true;	
        }else{
            return false;
        }
    }

    public function loadAccomRooms($accomId) {
        $this->db->select('hr.hr_id,hr.room_title');
        $this->db->from('hotel_rooms hr');
        $this->db->where('hr.hr_status',1);
        $this->db->where('hr.ho_id',$accomId);
        $q = $this->db->get();
        return $q->result();
    }

    public function returnAccomSeoUrl($accomId) {
        $this->db->select('seo_url');
        $this->db->from('hotels');
        $this->db->where('h_status',1);
        $this->db->where('ho_id',$accomId);
        $this->db->limit(1);
        $q = $this->db->get();
        if ($q->num_rows() == 1) {
            return $q->row()->seo_url;
        }else{
            return false;
        }
    }

    public function getResortDetail($slug) {
        $this->db->select('h.ho_id,h.hotel_name,h.stars,h.description,h.atoll as atoll_id,h.review_count,c.nicename,at.name as atoll_name');
        $this->db->from('hotels h');
        $this->db->where('h.hotel_type',2);
        $this->db->where('h.seo_url',$slug);
        $this->db->join('country c','c.country_id=h.country');
        $this->db->join('atoll_details at','at.atoll_id=h.atoll');
        $this->db->limit(1);
        $q = $this->db->get();
        if ($q->num_rows() == 1) {
            $main = $q->row();
            $this->db->select('MIN(hr.room_rate) as min_price');
            $this->db->from('hotel_rooms hr');
            $this->db->where('hr.ho_id',$main->ho_id);
            $this->db->where('hr.hr_status',1);
            $que = $this->db->get();
            $main->min_price = $que->row()->min_price;
            $main->roomcount = $this->db->where('ho_id',$main->ho_id)->where('hr_status',1)->from('hotel_rooms')->count_all_results();
            $main->photos = $this->getAppropriatePhotos($main->ho_id,'hotels');
            $main->type = 'resorts';
        }else{
            $main = false;
        }
        return $main;
    }

    public function getVillaDetail($hr_id) {
        $this->db->select('hr.hr_id,hr.ho_id,hr.room_title,hr.room_size,hr.adults,hr.child,hr.room_rate,hr.description,rb.rb_title,h.atoll as atoll_id');
        $this->db->from('hotel_rooms hr');
        $this->db->where('hr.hr_status',1);
        $this->db->where('hr.hr_id',$hr_id);
        $this->db->join('room_beds rb','rb.rb_id=hr.bed_type','left outer');
        $this->db->join('hotels h','h.ho_id=hr.ho_id');
        $this->db->join('atoll_details at','at.atoll_id=h.atoll');
        $this->db->limit(1);
        $q = $this->db->get();
        if ($q->num_rows() == 1) {
            $main = $q->row();
            $main->pax = $main->adults + $main->child;
            $main->photos = $this->getAppropriatePhotos($main->hr_id,'hotel_rooms');
            $main->type = 'rooms';
        }else {
            $main = false;
        }
        return $main;
    }

    public function getAppropriatePhotos($accomId,$table) {
        $this->db->select('photo_path');
        $this->db->from('photo');
        $this->db->where('table',$table);
        $this->db->where('field_id',$accomId);
        $this->db->order_by('pid','RANDOM');
        $q = $this->db->get();
        return $q->result();
    }

    public function getAccomForMail($ho_id) {
        $this->db->select('h.ho_id,h.hotel_name,h.seo_url,h.child_min_age,h.child_max_age,h.has_infant_age,h.infant_min_age,h.infant_max_age,at.name as atoll_name,p.photo_path,c.nicename,h.stars,h.review_count');
        $this->db->from('hotels h');
        $this->db->where('h.hotel_type',2);
        $this->db->where('h.ho_id',$ho_id);
        $this->db->join('country c','c.country_id=h.country');
        $this->db->join('atoll_details at','at.atoll_id=h.atoll');
        $this->db->join('photo p','p.table="hotels" AND p.field_id=h.ho_id', 'left outer');
        $this->db->limit(1);
        $q = $this->db->get();
        if ($q->num_rows() == 1) {
            return $q->row();
        }else{
            return false;
        }
    }

    public function getVillaForMail($hr_id) {
        $this->db->select('hr.hr_id,hr.room_title,p.photo_path');
        $this->db->from('hotel_rooms hr');
        $this->db->where('hr.hr_status',1);
        $this->db->where('hr.hr_id',$hr_id);
        $this->db->join('photo p','p.table="hotel_rooms" AND p.field_id=hr.hr_id', 'left outer');
        $this->db->limit(1);
        $q = $this->db->get();
        if ($q->num_rows() == 1) {
            return $q->row();
        }else{
            return false;
        }
    }

    function update($conditions=[],$table,$data){
		if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
		$this->db->update($table, $data); 
	}

    public function delete($table,$conditions=[]){
        if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->delete($table);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }

    public function fetchPackageMealPlans($packageId) {
        $this->db->select('pm.pm_id,pm.is_default,pmpt.type_title,mt.long_name,mt.short_name');
        $this->db->from('package_meal pm');
        $this->db->where('pm.package_id',$packageId);
        $this->db->join('package_meal_plan_types pmpt', 'pmpt.id=pm.package_meal_type');
        $this->db->join('meal_types mt', 'mt.meal_id=pm.meal_type');
        $q = $this->db->get();
        return $q->result();
    }

    public function fetchPackageTransfers($packageId) {
        $this->db->select('pt.pts_id,pt.is_default,tt.transfer_type,t.transfer_type as transfer_vehicle');
        $this->db->from('package_transfers pt');
        $this->db->where('pt.package_id',$packageId);
        $this->db->join('transfer_types tt', 'tt.tt_id=pt.type');
        $this->db->join('transfer t', 't.tras_id=pt.trans_by');
        $q = $this->db->get();
        return $q->result();
    }

    public function fetchSeasonForCalc($packageId, $startDate, $endDate) {
        $this->db->select();
        $this->db->from('package_season ps');
        $this->db->where('ps.package_id', $packageId);
        $this->db->where('ps.start_date <=', $endDate);
        $this->db->where('ps.end_date >=', $startDate);
        $q = $this->db->get();
        return $q->result();
    }

    public function roomMeal($selectedMeal,$roomId) {
        $this->db->select();
        $this->db->from('package_meal pm');
        $this->db->where('pm.pm_id', $selectedMeal);
        $this->db->where('pm.villa_id', 1);
        $this->db->or_where('pm.villa_id', 0);
        if ($this->db->where('pm.villa_id', 0)) {
            $this->db->join('package_meal_villas pmv', 'pmv.pm_id=pm.pm_id', 'left outer');
            $this->db->where('pmv.villa_id', $roomId);
        }
        $this->db->limit(1);
        $q = $this->db->get();
        $ret = false;
        if ($q->num_rows() == 1) {
            $ret = $q->row();
        }
        return $ret;
    }

    public function fetchRoomPriceForCals($seasonId,$villaId,$adultCount,$childCount) {
        $this->db->select('pp.pp_id,pp.season_id,pp.villa_id,pp.adult,pp.child,pp.price,pp.commision_type,pp.com_amount,pp.price_poi');
        $this->db->from('package_price pp');
        $this->db->where('pp.season_id', $seasonId);
        $this->db->where('pp.villa_id', $villaId);
        $this->db->where('pp.adult', $adultCount);
        $this->db->where('pp.child', $childCount);
        $this->db->limit(1);
        $q = $this->db->get();
        $ret = false;
        if ($q->num_rows() == 1) {
            $ret = $q->row();
        }
        return $ret;
    }

    public function getBookingDetail($boookingId) {
        $this->db->select('b.*,h.hotel_name,h.stars,hr.room_title,mt.long_name as meal_plan,t.transfer_type,c.nicename as my_country,gc.nicename as guest_country,bs.title as special_request_title');
        $this->db->from('booking b');
        $this->db->where('b.bid', $boookingId);
        $this->db->join('booking_special_requests bs', 'bs.id=b.special_request', 'left outer');
        $this->db->join('hotels h', 'h.ho_id=b.ho_id');
        $this->db->join('hotel_rooms hr', 'hr.hr_id=b.room_id');
        $this->db->join('meal_types mt', 'mt.meal_id=b.meal_type_id', 'left outer');
        $this->db->join('transfer t', 't.tras_id=b.transfer_type_id', 'left outer');
        $this->db->join('country c', 'c.country_id=b.country_id','left outer');
        $this->db->join('country gc', 'gc.country_id=b.guest_country_id', 'left outer');
        $q = $this->db->get();
        $ret = false;
        if ($q->num_rows() == 1) {
            $ret = $q->row();
        }
        return $ret;
    }

    function getTheExactPax($ages_array,$hotelId) {
        // Query to get the hotel's age ranges
        $this->db->select('infant_min_age, infant_max_age, child_min_age, child_max_age, adult_age');
        $this->db->where('ho_id', $hotelId);
        $query = $this->db->get('hotels');
        $hotel_data = $query->row();

        // Initialize an associative array to store the category counts
        $category_counts = array(
            'child' => 0,
            'infant' => 0,
            'adult' => 0,
        );

        // Loop through each age in the $ages_array
        if ($ages_array) {
            foreach ($ages_array as $age) {

                // Check if the age falls within any of the defined ranges
                if ($age >= $hotel_data->infant_min_age && $age <= $hotel_data->infant_max_age) {
                    $category = 'infant';
                } elseif ($age >= $hotel_data->child_min_age && $age <= $hotel_data->child_max_age) {
                    $category = 'child';
                } elseif ($age >= $hotel_data->adult_age) {
                    $category = 'adult';
                }
    
                // Increment the count for the corresponding category
                $category_counts[$category]++;
            }
        }

        // Now $category_counts will contain the count of each category (child, infant, adult) based on the age ranges of the hotel and the ages in the $ages_array.
        return $category_counts;
    }

    public function fetchPackageOffers($packageId,$villaId,$startDate,$endDate,$totalPax) {
        $this->db->select('pso.po_id,pso.title,pso.valid_period_start,pso.valid_period_end,pso.min_pax,pso.max_pax,psot.offer_name as offer_type_name,
        pso.min_nights,pso.max_nights,pso.special_offers_type,pso.free_night_stay,pso.free_night_pay,pso.bill_credit_type as bill_charge_type,pso.adult_amount,pso.child_amount,pso.infant_amount');
        $this->db->select("CASE
                                WHEN pso.special_offers_type = '0' THEN 'Discount Offer'
                                WHEN pso.special_offers_type = '1' THEN 'Free Night Offer' 
                        END AS offer_kind", false);
        $this->db->from('package_special_offers pso');
        $this->db->where('pso.package_id', $packageId);
        // $this->db->where("pso.valid_period_start <= '$endDate' AND pso.valid_period_end >= '$startDate'"); // check the date range.
        $this->db->where('(pso.valid_period_start <= ' . $this->db->escape($startDate) . ' AND pso.valid_period_end >= ' . $this->db->escape($endDate) . ')');
        $this->db->or_where('(pso.valid_period_start >= ' . $this->db->escape($startDate) . ' AND pso.valid_period_start <= ' . $this->db->escape($endDate) . ')');
        $this->db->or_where('(pso.valid_period_end >= ' . $this->db->escape($startDate) . ' AND pso.valid_period_end <= ' . $this->db->escape($endDate) . ')');
        $this->db->where('pso.min_pax <=', $totalPax);
        $this->db->where('pso.max_pax >=', $totalPax);
        if ($villaId != '') {
            $this->db->where('pso.villa_id', 1);
            $this->db->or_where('pso.villa_id', 0);
            if ($this->db->where('pso.villa_id', 0)) {
                $this->db->join('package_special_offers_villas psov', 'psov.po_id=pso.po_id', 'left outer');
                $this->db->where('psov.villa_id', $villaId);
            }
        }
        $this->db->join('package_special_offer_types psot', 'psot.id=pso.offer_type', 'left outer');
        $q = $this->db->get();
        return $q->result();
    }

    # =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    # CALCULATION FOR THE ROOM PRICE ACCORDING TO THE SELECTED DATE RANGE, MEAL, TRANSFER, AND THE OFFERS.                                                        #
    # =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

    public function calculateActualPrice($packageId,$startDate,$endDate,$roomId,$adults,$children,$infant=0,$nights,$roomCount,$mealType='NO',$transferType='NO',$offerType='NO',$calculationFrom='HOME_PAGE') {
        try {
            $totalPax = (int)$adults + (int)$children;

            // fetch seasons for the selected date range and the package id.
            $packageSeasons = $this->getSeasons($packageId,$startDate,$endDate);
            if (empty($packageSeasons)) {
                throw new Exception("No season period for selected date range.");
            }

            // fetch package room meal according to the meal type.
            $packageMeals = ($mealType && $mealType != 'NO') ? $this->getRoomMeal($mealType,$roomId) : [];

            // fetch transfer list according the to the room and the package.
            $packageTransfer = ($transferType && $transferType != 'NO') ? $this->commonFetch(['pts_id','min_pax','max_pax','comision_type','adult','child','infant','adult_com','child_com','infant_com','service_charge'],'package_transfers',['pts_id'=> $transferType, 'min_pax <=' => $totalPax, 'max_pax >=' => $totalPax],1) : [];

            // fetch the taxes for the packages.
            $packageTaxes = $this->commonFetch(['*'],'package_tax',['package_id'=> $packageId]);

            // fetch offers --- DISCOUNT / FREE NIGHT
            $packageOffers = ($offerType && $offerType != 'NO') ? $this->commonFetch(['*'], 'package_special_offers', ['po_id' => $offerType],1) : [];

            /*
              - Loop the season
              - Load the amount season wise.
              - Do the calculation for that price with commission, tax and other things.
              - Final total payable amounts.
			*/
            $adultOfferAmount = $childOfferAmount = $infantOfferAmount = 0; // initialize the initial value.
            $seasonPrices = [];
            foreach ($packageSeasons as $key =>  $season) {
                $seasonMinPrice = $this->getPackageMinPrice($season->package_id,$season->ps_id,$roomId,$adults,$children);

                if (empty($seasonMinPrice)) {
                    if($calculationFrom === 'BOOKING_PAGE') {
                        $this->session->set_flashdata('no_room_for_pax', 'We regret to inform you that the selected room cannot accommodate the specified number of guests. Kindly submit an inquiry, and we will be pleased to assist you further.'); // show the error message in the inquiry form.
                        throw new Exception("SEND_INQUIRY");
                    } else {
                        throw new Exception("No amount rate for this period.");
                    }
                }

                $roomPrice = $seasonMinPrice->price; // price without commission.

                switch ($seasonMinPrice->commision_type) {
					case '0':
						$roomCom = $seasonMinPrice->com_amount;
						break;
					case '1':
						$roomCom = $this->getTheCommission($seasonMinPrice->com_amount,$roomPrice);
						break;
				}

                // Meal price calculation
                $totalMealPrice = 0; # Initialize the meal amount.
                if($packageMeals) {
                    $isMealApplicable = $this->checkMealApplicableForCurrentSeason($mealType,$season->start_date,$season->end_date); // True / False
                    if($isMealApplicable) {
                        $totalMealPrice = (floatval($packageMeals->adult) * (int)$adults) + (floatval($packageMeals->child) * (int)$children) + (floatval($packageMeals->infant) * (int)$infant);
                    }
                }

                // Transfer price calculation
                $totalTransferPrice = 0; # Initialize the final transfer amount.
                if ($packageTransfer) {
                    $isTransferApplicable = $this->checkTransferApplicableForCurrentSeason($transferType,$season->start_date,$season->end_date); // True / False

                    if($isTransferApplicable) {
                        switch ($packageTransfer->comision_type) {
                            case '1': // Percentate
                                $infantCom 	= $this->getTheCommission($packageTransfer->infant_com,$packageTransfer->infant);
                                $childCom 	= $this->getTheCommission($packageTransfer->child_com,$packageTransfer->child);
                                $adultCom 	= $this->getTheCommission($packageTransfer->adult_com,$packageTransfer->adult);
                                break;
                            case '0': // Flate rate
                                $infantCom 	= $packageTransfer->infant_com;
                                $childCom 	= $packageTransfer->child_com;
                                $adultCom 	= $packageTransfer->adult_com;
                                break;
                        }
                        $infantAmount = (floatval($packageTransfer->infant) + floatval($infantCom)) * (int)$infant; # calculate the infant amount and the comission with number of infants.
                        $childAmount = (floatval($packageTransfer->child) + floatval($childCom)) * (int)$children;  # calculate the children amount and the comission with number of children.
                        $adultAmount = (floatval($packageTransfer->adult) + floatval($adultCom)) * (int)$adults;  # calculate the adult amount and the comission with number of adults.
        
                        $totalTransferPrice = floatval($infantAmount) + floatval($childAmount) + floatval($adultAmount) + floatval($packageTransfer->service_charge);
                    }
                }

                // Offer price calculation
                $totalOfferDiscountAmount = 0; # Initialize the final offer amount.
                if($packageOffers) {
                    $isOfferApplicable = $this->checkOfferApplicableForCurrentSeason($offerType,$season->start_date,$season->end_date); // True / False
                    if ($isOfferApplicable) {
                        switch ($packageOffers->special_offers_type) {
                            case '0': # DISCOUNT OFFER
                                switch ($packageOffers->bill_credit_type) {
                                    case '1': # Percentage calculation.
                                        // adult calculation
                                        $adultOfferDiscountAmount = $this->getTheCommission($packageOffers->adult_amount,$roomPrice);
                                        $adultOfferAmount = (int)$adults * floatval($adultOfferDiscountAmount);

                                        // child calculation
                                        $childOfferDiscountAmount = $this->getTheCommission($packageOffers->child_amount,$roomPrice);
                                        $childOfferAmount = (int)$children * floatval($childOfferDiscountAmount);

                                        // infant calculation
                                        $infantOfferDiscountAmount = $this->getTheCommission($packageOffers->infant_amount,$roomPrice);
                                        $infantOfferAmount = (int)$infant * floatval($infantOfferDiscountAmount);
                                        break;

                                    case '2': # Flat amount calculation
                                        // adult calculation
                                        $adultOfferAmount = (int)$adults * floatval($packageOffers->adult_amount);

                                        // child calculation
                                        $childOfferAmount = (int)$children * floatval($packageOffers->child_amount);

                                        // infant calculation
								        $infantOfferAmount = (int)$infant * floatval($packageOffers->infant_amount);
                                        break;
                                }
                                $totalOfferAmount = floatval($adultOfferAmount) + floatval($childOfferAmount) + floatval($infantOfferAmount);

                                # check the offer amount deduct by the base rate or final amount. If it is from base rate, it will deduct from base rate, if not, this amount will be added as total offer amount to deduct after the final calculation.
                                if ($packageOffers->is_deduct_from_base_rate) {
                                    $roomPrice -= floatval($totalOfferAmount);
                                } else {
                                    $totalOfferDiscountAmount = floatval($totalOfferAmount); 
                                }
                                break;
                            
                            case '1': # FREE NIGHT OFFER
                                if ($nights == $packageOffers->free_night_stay) {
                                    $nights = $packageOffers->free_night_pay; // when the night count is equal to the stay count, payable night count applied.
                                } elseif($nights > $packageOffers->free_night_stay){
                                    $freeNightCount = (int)$packageOffers->free_night_stay - (int)$packageOffers->free_night_pay; // when the night count is greater than stay count, calculate the free night count and calculate the payable night count and applied.
                                    $nights -= $freeNightCount;
                                } else {
                                    $nights = $nights; // when the night count is less than to the stay count, same night count will be applied.
                                }
                                break;
                        }
                    }
                }
                $roomPriceWithCommission = floatval($roomPrice) + floatval($roomCom); // price with commission.
                $roomPriceWithOtherIncludes = floatval($roomPriceWithCommission) + floatval($totalMealPrice) + floatval($totalTransferPrice); // room price with transfer amount and the meal amount.
                $roomPriceAfterOfferDeducted = floatval($roomPriceWithOtherIncludes) - floatval($totalOfferDiscountAmount); // if offer didn't deducted from the base rate.
                $seasonPrices[] = floatval($roomPriceAfterOfferDeducted); // final calculated amounts inserted into the array for more calculation.
            }

            $finalPrice = array_sum($seasonPrices);

            // Tax amount calculation
			$finalTax = 0;
			foreach ($packageTaxes as $tax) {
				switch ($tax->charge_as) {
					case '1':
						$finalTax += $this->getTheCommission($tax->txamount,$finalPrice);
						break;
					
					case '2':
						$finalTax += $tax->txamount;
						break;
					
					case '3':
						$finalTax += floatval($tax->txamount) * floatval($totalPax);
						break;
					
					case '4':
						$finalTax += floatval($tax->txamount) * floatval($nights);
						break;
				}
			}

            // final amount with tax.
			$finalPriceWithTax = floatval($finalPrice) + floatval($finalTax);

            // after getting the final amount with tax and multiply the night count and room count.
			$finalAmountWithNightsAndRoomCount = (floatval($finalPriceWithTax) * (int)$nights) * (int)$roomCount;

            return $finalAmountWithNightsAndRoomCount;

        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    private function getSeasons($packageId,$startDate,$endDate) {
        $this->db->select('ps.ps_id,ps.package_id,ps.season,ps.resort_id,ps.start_date,ps.end_date');
        $this->db->from('package_season ps');
        $this->db->where('ps.package_id', $packageId);
        $this->db->where('(ps.start_date <= "' . $endDate . '" AND ps.end_date >= "' . $startDate . '") OR (ps.start_date >= "' . $startDate . '" AND ps.start_date <= "' . $endDate . '")'); // Handle overlapping or exact date matches
        $q = $this->db->get();
        return $q->result();
    }

    private function getRoomMeal($mealType,$roomId) {
        $this->db->select('pm.*,pmpt.type_title as meal_plan_name');
        $this->db->from('package_meal pm');
        $this->db->where('pm.pm_id', $mealType);

        $this->db->group_start();
            $this->db->where('pm.villa_id', 1);
            $this->db->or_where('(pm.villa_id=0 AND pmv.villa_id='.$roomId.')');
            $this->db->join('package_meal_villas pmv', 'pmv.pm_id=pm.pm_id', 'left outer');
        $this->db->group_end();
        $this->db->join('package_meal_plan_types pmpt', 'pmpt.id=pm.package_meal_type');
        /* $this->db->where('pm.villa_id', 1);
        $this->db->or_where('pm.villa_id', 0);
        if ($this->db->where('pm.villa_id', 0)) {
            $this->db->join('package_meal_villas pmv', 'pmv.pm_id=pm.pm_id', 'left outer');
            $this->db->where('pmv.villa_id', $roomId);
        } */

        $this->db->limit(1);
        $q = $this->db->get();
        $ret = false;
        if ($q->num_rows() == 1) {
            $ret = $q->row();
        }
        return $ret;
    }

    private function getPackageMinPrice($packageId,$seasonId,$villaId,$adult,$child) {
        $this->db->select('pp.pp_id,pp.price,pp.price_poi,pp.adult,pp.child,pp.infant,pp.is_baserate,pp.commision_type,pp.com_amount,pp.adult_amount,pp.child_amount,pp.infant_amount');
        $this->db->from('package_price pp');
        $this->db->where('pp.p_id', $packageId);
        $this->db->where('pp.season_id', $seasonId);
        $this->db->where('pp.villa_id', $villaId);
        $this->db->where('pp.adult', $adult);
        $this->db->where('pp.child', $child);
        $this->db->order_by('pp.price_poi', 'ASC');
        $this->db->limit(1);
        $q = $this->db->get();
        $ret = false;
        if($q->num_rows() == 1) $ret = $q->row();
        return $ret;
    }

    private function checkMealApplicableForCurrentSeason($mealId,$seasonStartDate,$seasonEndDate) {
        $this->db->select();
        $this->db->from('package_meal pm');
        $this->db->where('pm.pm_id', $mealId);
        $this->db->where('(pm.pmstart_date <= ' . $this->db->escape($seasonStartDate) . ' AND pm.pmend_date >= ' . $this->db->escape($seasonEndDate) . ')');
        $this->db->or_where('(pm.pmstart_date >= ' . $this->db->escape($seasonStartDate) . ' AND pm.pmstart_date <= ' . $this->db->escape($seasonEndDate) . ')');
        $this->db->or_where('(pm.pmend_date >= ' . $this->db->escape($seasonStartDate) . ' AND pm.pmend_date <= ' . $this->db->escape($seasonEndDate) . ')');
        $q = $this->db->get();
        $ret = false;
        if($q->num_rows() > 0) $ret = true;
        return $ret;
    }

    private function checkTransferApplicableForCurrentSeason($transferId,$seasonStartDate,$seasonEndDate) {
        $this->db->select();
        $this->db->from('package_transfers pt');
        $this->db->where('pt.pts_id', $transferId);
        $this->db->where('(pt.ptstart_date <= ' . $this->db->escape($seasonStartDate) . ' AND pt.ptend_date >= ' . $this->db->escape($seasonEndDate) . ')');
        $this->db->or_where('(pt.ptstart_date >= ' . $this->db->escape($seasonStartDate) . ' AND pt.ptstart_date <= ' . $this->db->escape($seasonEndDate) . ')');
        $this->db->or_where('(pt.ptend_date >= ' . $this->db->escape($seasonStartDate) . ' AND pt.ptend_date <= ' . $this->db->escape($seasonEndDate) . ')');
        $q = $this->db->get();
        $ret = false;
        if($q->num_rows() > 0) $ret = true;
        return $ret;
    }

    private function checkOfferApplicableForCurrentSeason($offerId,$seasonStartDate,$seasonEndDate) {
        $this->db->select();
        $this->db->from('package_special_offers pso');
        $this->db->where_in('pso.po_id', $offerId);
        // Apply validity checks for offers
        $this->db->group_start(); // Start a group of conditions
        // Conditions for offers with special_offers_type = 0 and validity criteria matching the provided start date
        $todayDate = date('Y-m-d');
        $this->db->where('(pso.special_offers_type = 0 AND 
                   (
                     (pso.validity_type = 1 AND 
                       (
                         pso.validity_type_value = "any" OR 
                         DATE_ADD(' . $this->db->escape($todayDate) . ', INTERVAL pso.validity_type_value DAY) <= ' . $this->db->escape($seasonStartDate) . '
                       )
                     ) OR 
                     (pso.validity_type = 2 AND 
                       STR_TO_DATE(pso.validity_type_value, "%d/%m/%Y") >= ' . $this->db->escape($seasonStartDate) . '
                     ) OR 
                     (pso.validity_type = 3 AND 
                       STR_TO_DATE(SUBSTRING_INDEX(pso.validity_type_value, " - ", 1), "%d/%m/%Y") <= ' . $this->db->escape($seasonStartDate) . ' AND 
                       STR_TO_DATE(SUBSTRING_INDEX(pso.validity_type_value, " - ", -1), "%d/%m/%Y") >= ' . $this->db->escape($seasonStartDate) . '
                     )
                   )
                 )');

        /* $this->db->where('(pso.special_offers_type = 0 AND ((pso.validity_type = 1 AND (pso.validity_type_value = "any" OR DATE_ADD(' . $this->db->escape($seasonStartDate) . ', INTERVAL pso.validity_type_value DAY) <= pso.valid_period_start)) OR 
                            (pso.validity_type = 2 AND STR_TO_DATE(pso.validity_type_value, "%d/%m/%Y") >= ' . $this->db->escape($seasonStartDate) . ') OR 
                            (pso.validity_type = 3 AND STR_TO_DATE(SUBSTRING_INDEX(pso.validity_type_value, " - ", 1), "%d/%m/%Y") <= ' . $this->db->escape($seasonStartDate) . ' AND STR_TO_DATE(SUBSTRING_INDEX(pso.validity_type_value, " - ", -1), "%d/%m/%Y") >= ' . $this->db->escape($seasonStartDate) . ')))'); */
        $this->db->or_where('pso.special_offers_type', 1); // Include free night offers (special_offers_type = 1) as an alternative condition
        $this->db->group_end(); // End the group of conditions
        $this->db->where('(pso.valid_period_start <= ' . $this->db->escape($seasonStartDate) . ' AND pso.valid_period_end >= ' . $this->db->escape($seasonEndDate) . ')');
        $this->db->or_where('(pso.valid_period_start >= ' . $this->db->escape($seasonStartDate) . ' AND pso.valid_period_start <= ' . $this->db->escape($seasonEndDate) . ')');
        $this->db->or_where('(pso.valid_period_end >= ' . $this->db->escape($seasonStartDate) . ' AND pso.valid_period_end <= ' . $this->db->escape($seasonEndDate) . ')');
        $q = $this->db->get();
        $ret = false;
        if($q->num_rows() > 0) $ret = true;
        return $ret;
    }

    // find the available room count after booked the rooms.
    public function availableRooms($resortId,$checkin_date, $checkout_date) {
        $this->db->select('hr.room_title, (hr.room_count - IFNULL(b.total_booked_rooms, 0)) as available_rooms', false);
        $this->db->from('hotel_rooms hr');
        $this->db->where('hr.ho_id', $resortId);
        $this->db->join('(SELECT room_id, COUNT(*) as total_booked_rooms FROM booking WHERE NOT (checkout_date < "' . $checkin_date . '" OR checkin_date > "' . $checkout_date . '") GROUP BY room_id) b', 'hr.hr_id = b.room_id', 'left');
        $query = $this->db->get();
        // Check if there are results
        if ($query->num_rows() > 0) {
            // Fetch available rooms
            $available_rooms = $query->result();
            
            // Return available rooms
            return $available_rooms;
        } else {
            return []; // No available rooms found.
        }
    }

    public function calculatePackagePrice($arr=[],$calculationFrom='HOME_PAGE') {
        try {
            $packageId = $arr['packageId'];
            $startDate = $arr['startDate'];
            $endDate = $arr['endDate'];
            $roomId = $arr['roomId'];
            $resortId = $arr['resortId'];
            $adults = $arr['adults'];
            $children = $arr['children'];
            $infant = $arr['infant'];
            $roomCount = $arr['roomCount'];
            $nights = $arr['nights'];
            $mealType = $arr['mealType'];
            $transferType = $arr['transferType'];

            $totalPax = (int)$adults + (int)$children;

            $packageSeasons = $this->getSeasons($packageId,$startDate,$endDate);
            if (empty($packageSeasons)) {
                throw new Exception("No season period for selected date range.");
            }

            $packageMeals = ($mealType) ? $this->getRoomMeal($mealType,$roomId) : [];

            $packageTransfer = ($transferType) ? $this->get_default_transfer($transferType,$totalPax) : [];

            $packageTaxes = $this->getTaxes($packageId);

            $packageOffers = $this->load_offers($resortId,$packageId,$roomId,$startDate,$endDate,$totalPax,$this->userCountry); # country ID should be passed from GEO IP.

            # =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
            #                                                       Package price calculation formula                                                                     #
            # =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
            /*
                - WITHOUT OFFER
                    - ((BR + (BR * GST%)) + (BR + (BR * GST%)) * ST% + ((BR + (BR * GST%)) + (BR + (BR * GST%)) * ST%) * COMM% + (GT * PAX)) * NYT + TRANSFER + (ML * NYT * PAX)

                - WITH SINGLE OFFER [DISCOUNT]
                    - ((BR + (BR * GST%)) + (BR + (BR * GST%)) * ST% + ((BR + (BR * GST%)) - (OFFERS) + ((BR + (BR * GST%)) * ST%) - (OFFERS)) * COMM% + (GT * PAX)) * NYT + TRANSFER + (ML * NYT * PAX)

                - WITH MULTIPLE OFFER [DISCOUNT + FREE NIGHT]
                    - ((BR + (BR * GST%)) + (BR + (BR * GST%)) * ST% + ((BR + (BR * GST%)) - (OFFERS) + ((BR + (BR * GST%)) * ST%) - (OFFERS)) * COMM%) * (NYT - FREE NIGHT) + (GT * PAX * NYT) + TRANSFER + (ML * NYT * PAX)
                
                Example: 
                    ~ adult: 100
                    ~ child: 50
                    ~ nights: 3
                    ~ service: 10%
                    ~ greenT: 6
                    ~ gst: 16%
                    ~ company commission: 10%
                    ~ adult count: 2
                    ~ child count: 1
                    ~ meal
                        - adult: 150
                        - child: 100
                    ~ transfer
                        - adult: 100
                        - child: 50
                    
                    ~ offer
                        - adult: 40%
                        - child: 20%
                    ~ free night: 1

                    BR: Adult Price x Adult Count + Child Price x Child Count
                        So, BR: 250
                    
                    # calculation WITHOUT OFFER

                        ((250 + (250 * 16%)) + ((250 + (250 * 16%)) * 10%)) + ((250 + (250 * 16%)) + ((250 + (250 * 16%)) * 10%)) * 10%) + (6 * 3)) * 3 + (100 * 2) + (50 * 1) + (150 * 2 * 3) + (100 * 1 * 3)

                        room rate with GST: 250 + (250 * 16%) = 290
                        room rate with ST: 290 + (290 * 10%) = 319
                        room rate with commission and GT: 319 + (319 * 10%) + (6 * 3) = 368.9
                        booking final amount = 368.9 * 3 + (100 * 2) + (50 * 1) + (150 * 2 * 3) + (100 * 1 * 3) = 2556.7

                    # calculation WITH ONLY OFFER
                    
                        room rate with GST: 250 + (250 * 16%) = 290
                        room rate with ST: 290 + (290 * 10%) = 319
                        discount offer: 319 - (319 * (40 + 20)%) = 127.6
                        room rate with commission and GT: 127.6 + (127.6 * 10%) + (6 * 3) = 158.36
                        booking final amount = 158.36 * 3 + (100 * 2) + (50 * 1) + (150 * 2 * 3) + (100 * 1 * 3) = 1925.08
                    
                    # calculation WITH OFFER + FREE NIGHT

                        room rate with GST: 250 + (250 * 16%) = 290
                        room rate with ST: 290 + (290 * 10%) = 319
                        discount offer: 319 - (319 * (40 + 20)%) = 127.6
                        freenight = 1
                        room rate with commission: 127.6 + (127.6 * 10%) = 158.36
                        only GT: (6 * 3 * 3) = 54
                        booking final amount = 158.36 * (3 - 1) + (100 * 2) + (50 * 1) + (150 * 2 * (3 - 1)) + (100 * 1 * (3 - 1)) + 54 = 1420.72
            */
            # =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

            $perSeasonPerNight = [];
            $perSeasonTotalPrice = [];


            $taxNames = []; # Initialize the tax names.
            $mealPlaneName = []; # Initialize the meal plan name.
            $transferMethodName = []; # Initialize the transfer type name.

            
            $payableNights = $nights; // assigning the nights count to the payable night count variable.
            foreach ($packageSeasons as $key => $season) {
                $seasonMinPrice = $this->getPackageMinPrice($season->package_id,$season->ps_id,$roomId,$adults,$children);
                if (empty($seasonMinPrice)) {
                    if($calculationFrom === 'BOOKING_PAGE') {
                        $this->session->set_flashdata('no_room_for_pax', 'We regret to inform you that the selected room cannot accommodate the specified number of guests. Kindly submit an inquiry, and we will be pleased to assist you further.'); // show the error message in the inquiry form.
                        throw new Exception("SEND_INQUIRY");
                    } else {
                        throw new Exception("No amount rate for this period.");
                    }
                }

                # calculate the tax amounts according to the adult, child, and infant.
                list($adultGST,$adultST,$childGST,$childST,$infantGST,$infantST,$greenTax,$taxNames) = $this->calculateTaxAmount($packageTaxes,$totalPax,$nights,['adult' => $seasonMinPrice->adult_amount, 'child' => $seasonMinPrice->child_amount, 'infant' => $seasonMinPrice->infant_amount]);

                # base rate calculation seperately with tax amounts. ---> [ adult, child, infant ]
                $adultBaseRate = $seasonMinPrice->adult_amount + $adultGST + $adultST;
                $childBaseRate = $seasonMinPrice->child_amount + $childGST + $childST;
                $infantBaseRate = $seasonMinPrice->infant_amount + $infantGST + $infantST;

                $offerType = array_column($packageOffers,'po_id');
                # check offer applicable of not.
                $isOfferApplicable = (!empty($packageOffers)) ? $this->checkOfferApplicableForCurrentSeason($offerType,$season->start_date,$season->end_date) : false; // True / False
                
                # if applicable calculate the offer amount and replace the current amount with the offer amount.
                if ($isOfferApplicable) {
                    $discountOffer = $this->offerChunk($packageOffers)['DISCOUNT'] ?? []; // get only the DISCOUNT offers.
                    
                    # re-arrange the discount offer array in ascending order according to the offer_type.
                    if($discountOffer) {
                        usort($discountOffer, function($a, $b) {
                            return $a->which_offer_type <=> $b->which_offer_type;
                        });

                        # calculate the offer amounts, reduced from the base rate and overwrite the base rate values.
                        list($adultBaseRate, $childBaseRate, $infantBaseRate) = $this->calculateOfferAmount($discountOffer,['adult' => $adultBaseRate, 'child' => $childBaseRate, 'infant' => $infantBaseRate]);
                    }

                    $freeNightOffers = $this->offerChunk($packageOffers)['FREE_NIGHT'] ?? []; // get only the FREE_NIGHT offers.
                    $payableNights = $freeNightOffers ? $this->getPayableNightCounts($freeNightOffers, $nights) : $nights;// get the payable nights after reducing the free nights.
                }

                # adding all the base rates after calculating the tax and the offer.
                $finalBaseRate = floatval($adultBaseRate) + floatval($childBaseRate) + floatval($infantBaseRate);

                # calculate the company commission.
                $companyCommission = ($seasonMinPrice->commision_type == 0) ? $seasonMinPrice->com_amount : $this->getTheCommission($seasonMinPrice->com_amount,$finalBaseRate);

                # apply the commission amount to the final base rate.
                $finalBaseRate += $companyCommission;

                # Transfer price calculation
                $isTransferApplicable = !empty($packageTransfer) && $this->checkTransferApplicableForCurrentSeason($transferType, $season->start_date, $season->end_date); // True / False

                $totalTransferPrice = 0; # Initialize the final transfer amount.

                if($isTransferApplicable) {
                    $transferMethodName[] = $packageTransfer->transfer_mode. ' Airport Transfers by ' .$packageTransfer->transfer_name;

                    $infantTransfer = $childTransfer = $adultTransfer = 0;
                    $infantCom = $childCom = $adultCom = 0;
                    switch ($packageTransfer->comision_type) {
                        case '1': // Percentate
                            $infantCom 	= $this->getTheCommission($packageTransfer->infant_com,$packageTransfer->infant);
                            $childCom 	= $this->getTheCommission($packageTransfer->child_com,$packageTransfer->child);
                            $adultCom 	= $this->getTheCommission($packageTransfer->adult_com,$packageTransfer->adult);
                            break;
                        case '0': // Flate rate
                            $infantCom 	= $packageTransfer->infant_com;
                            $childCom 	= $packageTransfer->child_com;
                            $adultCom 	= $packageTransfer->adult_com;
                            break;
                    }

                    $infantTransfer = ($packageTransfer->infant + $infantCom) * $infant; # calculate the infant amount and the comission with number of infants.
                    $childTransfer = ($packageTransfer->child + $childCom) * $children;  # calculate the children amount and the comission with number of children.
                    $adultTransfer = ($packageTransfer->adult + $adultCom) * $adults;  # calculate the adult amount and the comission with number of adults.

                    $totalTransferPrice = $infantTransfer + $childTransfer + $adultTransfer + $packageTransfer->service_charge; // total of transfer amount.
                }

                # Meal price calculation
                $totalMealPrice = 0; # Initialize the meal amount.
                $perNightMealPrice = 0; # Initialize per night meal amount.

                $isMealApplicable = !empty($packageMeals) && $this->checkMealApplicableForCurrentSeason($mealType,$season->start_date,$season->end_date); // True / False
                if ($isMealApplicable) {
                    # calculate the total meal price and find the total payable amount by payable night count.
                    $perNightMealPrice = (($packageMeals->adult * $adults) + ($packageMeals->child * $children) + ($packageMeals->infant * $infant));
                    $totalMealPrice = $perNightMealPrice * $payableNights;

                    $mealPlaneName[] = $packageMeals->meal_plan_name;
                }

                # season wise per night amount added to the array.
                $perSeasonPerNight[] = ($finalBaseRate * $roomCount) + ($greenTax / $nights) + $totalTransferPrice + $perNightMealPrice;

                # season wise total amount added to the array.
                $perSeasonTotalPrice[] = ($finalBaseRate * $payableNights * $roomCount) + $greenTax + $totalTransferPrice + $totalMealPrice;
            }
            
            # add per night amount
            $perNightPrice = round(bcdiv(array_sum($perSeasonPerNight), 1, 2), 0, PHP_ROUND_HALF_UP); // This gives you a value with two decimal places and Use the round function to round to the nearest integer

            # calculate the total final amount. Adding whole seasons' price together.
            $totalFinalPrice = round(bcdiv(array_sum($perSeasonTotalPrice), 1, 2), 0, PHP_ROUND_HALF_UP); // This gives you a value with two decimal places and Use the round function to round to the nearest integer
            

            $priceInclude = array(
                'taxes' => $taxNames,
                'default_meal_plan' => implode(',', $mealPlaneName),
                'default_transfer_name' => implode(',', $transferMethodName)
            );

            return [
                'calculatedPrice' => $totalFinalPrice, 
                'calculatePerNightPrice' => $perNightPrice, 
                'stayNights' => $nights, 
                'payableNights' => $payableNights,
                'price_included' => $priceInclude
            ];
        } catch (Exception $e) {
            // Differentiate error types
            if ($e->getMessage() === "SEND_INQUIRY") {
                $this->session->set_flashdata(
                    'error_message',
                    'We regret to inform you that the selected room cannot accommodate the specified number of guests. Kindly submit an inquiry.'
                );
                redirect('inquiry');
            } else {
                // For "No amount rate for this period." and other errors
                $this->session->set_flashdata('error_message', $e->getMessage());
                redirect('home');
            }
        }
    }

    public function load_offers($resortId,$packageId,$villaId,$startDate,$endDate,$totalPax,$countryId) {
        $this->db->select('pso.po_id,pso.title,pso.valid_period_start,pso.valid_period_end,pso.validity_type,pso.validity_type_value,pso.min_pax,pso.max_pax,pso.offer_type as which_offer_type,psot.offer_name as offer_type_name,
        pso.min_nights,pso.max_nights,pso.special_offers_type,pso.free_night_stay,pso.free_night_pay,pso.bill_credit_type as bill_charge_type,pso.adult_amount,pso.child_amount,pso.infant_amount');
        $this->db->select("CASE
                                WHEN pso.special_offers_type = '0' THEN 'Discount Offer'
                                WHEN pso.special_offers_type = '1' THEN 'Free Night Offer' 
                        END AS offer_kind", false);
        $this->db->from('package_special_offers pso');
        $this->db->where('pso.hotel_id', $resortId);

        # applicable villa check.
        $this->db->group_start();
        if($villaId != '') {
            $this->db->where('pso.villa_id', 1);
            $this->db->or_where('(pso.villa_id=0 AND psov.villa_id='.$villaId.')');
            $this->db->join('package_special_offers_villas psov', 'psov.po_id=pso.po_id', 'left outer');
        }
        $this->db->group_end();

        // Apply validity checks for offers
        $this->db->group_start(); // Start a group of conditions
        // Conditions for offers with special_offers_type = 0 and validity criteria matching the provided start date
        // get the night count
        $date1 = new DateTime($startDate);
        $date2 = new DateTime($endDate);

        $interval = $date1->diff($date2);
        $nightsCount = $interval->days;

        $todayDate = date('Y-m-d');
            // Discount offers fetching according to the condition.
            /* 
                if special_offers_type is 0,
                    if validity_type is 1 and validity_type_value is any or if has any day count, check the day count with current date.
                    if validity_type is 2 and validity_type_value has any particular date, check the start date with that date whether start date is less or equal.
                    if validity_type is 3 and validity_type_value has date range, check the selected date range included in that date range.
            */
            $this->db->group_start();
                $this->db->where('(pso.special_offers_type = 0 AND 
                    (
                        (pso.validity_type = 1 AND 
                            (
                                pso.validity_type_value = "any" OR 
                                DATE_ADD(' . $this->db->escape($todayDate) . ', INTERVAL pso.validity_type_value DAY) <= ' . $this->db->escape($startDate) . '
                            )
                        ) OR 
                        (pso.validity_type = 2 AND 
                            STR_TO_DATE(pso.validity_type_value, "%d/%m/%Y") >= ' . $this->db->escape($startDate) . '
                        ) OR 
                        (pso.validity_type = 3 AND 
                            STR_TO_DATE(SUBSTRING_INDEX(pso.validity_type_value, "-", 1), "%d/%m/%Y") <= ' . $this->db->escape($endDate) . ' AND 
                            STR_TO_DATE(SUBSTRING_INDEX(pso.validity_type_value, "-", -1), "%d/%m/%Y") >= ' . $this->db->escape($startDate) . '
                        )
                    )
                )');
                $this->db->where('pso.min_nights <=', $nightsCount);
                $this->db->where('pso.max_nights >=', $nightsCount);
            $this->db->group_end();

            /* $this->db->where('(pso.special_offers_type = 0 AND ((pso.validity_type = 1 AND (pso.validity_type_value = "any" OR DATE_ADD(' . $this->db->escape($startDate) . ', INTERVAL pso.validity_type_value DAY) <= pso.valid_period_start)) OR 
                                (pso.validity_type = 2 AND STR_TO_DATE(pso.validity_type_value, "%d/%m/%Y") >= ' . $this->db->escape($startDate) . ') OR 
                                (pso.validity_type = 3 AND STR_TO_DATE(SUBSTRING_INDEX(pso.validity_type_value, " - ", 1), "%d/%m/%Y") <= ' . $this->db->escape($startDate) . ' AND STR_TO_DATE(SUBSTRING_INDEX(pso.validity_type_value, " - ", -1), "%d/%m/%Y") >= ' . $this->db->escape($startDate) . ')))'); */

            // free night offer fetching according to the conditions.
            /* 
                if special_offers_type is 1,
                    if validity_type is 1 and validity_type_value is any or if has any day count, check the day count with current date.
                    if validity_type is 2 and validity_type_value has any particular date, check the start date with that date whether start date is less or equal.
                    if validity_type is 3 and validity_type_value has date range, check the selected date range included in that date range.
            */
            $this->db->or_group_start();
                // $this->db->or_where('pso.special_offers_type', 1); // Include free night offers (special_offers_type = 1) as an alternative condition
                $this->db->where('(pso.special_offers_type = 1 AND 
                    (
                        (pso.validity_type = 1 AND 
                            (
                                pso.validity_type_value = "any" OR 
                                DATE_ADD(' . $this->db->escape($todayDate) . ', INTERVAL pso.validity_type_value DAY) <= ' . $this->db->escape($startDate) . '
                            )
                        ) OR 
                        (pso.validity_type = 2 AND 
                            STR_TO_DATE(pso.validity_type_value, "%d/%m/%Y") >= ' . $this->db->escape($startDate) . '
                        ) OR 
                        (pso.validity_type = 3 AND 
                            STR_TO_DATE(SUBSTRING_INDEX(pso.validity_type_value, "-", 1), "%d/%m/%Y") <= ' . $this->db->escape($endDate) . ' AND 
                            STR_TO_DATE(SUBSTRING_INDEX(pso.validity_type_value, "-", -1), "%d/%m/%Y") >= ' . $this->db->escape($startDate) . '
                        )
                    )
                )');
                $this->db->where('pso.free_night_stay <=', $nightsCount);
            $this->db->group_end(); // End the group of conditions
        $this->db->group_end(); // End the group of conditions

        // Apply date range checks for all offers
        $this->db->group_start();
        $this->db->where('(pso.valid_period_start <= ' . $this->db->escape($startDate) . ' AND pso.valid_period_end >= ' . $this->db->escape($endDate) . ')');
        $this->db->or_where('(pso.valid_period_start >= ' . $this->db->escape($startDate) . ' AND pso.valid_period_start <= ' . $this->db->escape($endDate) . ')');
        $this->db->or_where('(pso.valid_period_end >= ' . $this->db->escape($startDate) . ' AND pso.valid_period_end <= ' . $this->db->escape($endDate) . ')');
        $this->db->group_end();

        $this->db->where('pso.min_pax <=', $totalPax);
        $this->db->where('pso.max_pax >=', $totalPax);
        $this->db->where('pso.package_id', $packageId);

        $this->db->join('package_special_offer_types psot', 'psot.id=pso.offer_type', 'left outer');
        $this->db->join('package_special_offers_countries psoc', 'psoc.po_id=pso.po_id');
        $this->db->join('package_market_countries pmc', 'pmc.market_id=psoc.market_id AND pmc.country_id = ' . $this->db->escape($countryId)); // based on the market.
        $this->db->group_by('pso.po_id');

        $q = $this->db->get();
        return $q->result();
    }

    // calculate only the tax amount by passing some values.
    private function calculateTaxAmount($taxArr,$totalPax,$nights,$packageAmount=[]) {
        # re-arrange the tax array according to the tax_type: ASC order.
        usort($taxArr, function($a, $b) {
            return $a->tax_type <=> $b->tax_type;
        });
        $taxNames = [];
        $adultGST = $adultST = $childGST = $childST = $infantGST = $infantST = $greenTax = 0;
        foreach ($taxArr as $tax) {
            $taxNames[] = $tax->tax_name;
            switch ($tax->tax_type) {
                case '1': # gst tax
                    $adultGST = $this->returnTaxAmount($tax->charge_as,$tax->txamount,$packageAmount['adult'],$totalPax,$nights); # adult gst amount calculate.
                    $childGST = $this->returnTaxAmount($tax->charge_as,$tax->txamount,$packageAmount['child'],$totalPax,$nights); # child gst amount calculate.
                    $infantST = $this->returnTaxAmount($tax->charge_as,$tax->txamount,$packageAmount['infant'],$totalPax,$nights); # infant gst amount calculate.
                    break;

                case '2': # service tax
                    $adultAmountWithGst = floatval($packageAmount['adult']) + floatval($adultGST); # adult amount added with calculated GST.
                    $childAmountWithGst = floatval($packageAmount['child']) + floatval($childGST); # child amount added with calculated GST.
                    $infantAmountWithGst = floatval($packageAmount['infant']) + floatval($infantGST); # infant amount added with calculated GST.

                    $adultST = $this->returnTaxAmount($tax->charge_as,$tax->txamount,$adultAmountWithGst,$totalPax,$nights); # adult service tax amount calculate.
                    $childST = $this->returnTaxAmount($tax->charge_as,$tax->txamount,$childAmountWithGst,$totalPax,$nights); # child service tax amount calculate.
                    $infantST = $this->returnTaxAmount($tax->charge_as,$tax->txamount,$infantAmountWithGst,$totalPax,$nights); # infant service tax amount calculate.
                    break;

                case '3': # green tax
                    $greenTax = $this->returnTaxAmount($tax->charge_as,$tax->txamount,$packageAmount,$totalPax,$nights); # green tax amount calculate.
                    break;
            }
        }
        return [$adultGST,$adultST,$childGST,$childST,$infantGST,$infantST,$greenTax,$taxNames]; # return all the tax amounts that calculated.
    }

    // calculate final tax amount by passing some values.
    private function returnTaxAmount($chargeAs,$taxAmount,$packageAmount,$totalPax,$nights) {
        $calculatedTaxAmount = 0;
        switch ($chargeAs) {
            case '1': # % rate
                $calculatedTaxAmount = $this->getTheCommission($taxAmount,$packageAmount);
                break;
            
            case '2': # Fixed amount per booking
                $calculatedTaxAmount = $taxAmount;
                break;
            
            case '3': # Per person per night
                $calculatedTaxAmount = floatval($taxAmount) * floatval($totalPax) * floatval($nights);
                break;
            
            case '4': # Fixed amount per night	
                $calculatedTaxAmount = floatval($taxAmount) * floatval($nights);
                break;
        }
        return $calculatedTaxAmount;
    }

    // seperate the offer by it's offer type. DISCOUNT or FREE_NIGHT
    private function offerChunk($originalArray=[]) {
        return array_reduce($originalArray, function($carry, $item) {
            // Extract special_offers_type value
            $type = $item->special_offers_type;
            
            // Determine the key based on special_offers_type value
            $key = $type == 0 ? 'DISCOUNT' : 'FREE_NIGHT';
            
            // Add the item to the appropriate group in $carry
            $carry[$key][] = $item;
            
            return $carry;
        }, []);
    }

    // calculate offer amount according to the pax type.
    private function calculateOfferAmount($offerArr, $packageAmount = []) {
        // Initialize current amounts
        $currentAmounts = [
            'adult' => $packageAmount['adult'],
            'child' => $packageAmount['child'],
            'infant' => $packageAmount['infant']
        ];
    
        // Iterate through each offer
        foreach ($offerArr as $off) {
            switch ($off->which_offer_type) {
                case '1': // Percentage discount
                    foreach ($currentAmounts as $key => &$amount) {
                        // Iterate over each element in $currentAmounts, where $key is the passenger type (adult, child, infant)
                        // and $amount is the corresponding current amount. $amount is passed by reference (&) to allow direct modification.
                        
                        // Calculate the offer amount based on the offer type and current amount for the passenger type
                        $discountAmount = $this->returnOfferAmount($off->bill_charge_type, $off->{$key . '_amount'}, $amount);

                        // Update the current amount by subtracting the offer amount
                        $amount -= floatval($discountAmount);
                    }
                    break;
    
                case '2': // Early bird discount
                case '3': // Fixed amount discount
                case '4': // Last minute discount
                    foreach ($currentAmounts as $key => &$amount) {
                        // Iterate over each element in $currentAmounts, where $key is the passenger type (adult, child, infant)
                        // and $amount is the corresponding current amount. $amount is passed by reference (&) to allow direct modification.
                        
                        // Calculate the offer amount based on the offer type and current amount for the passenger type
                        $offerAmount = $this->returnOfferAmount($off->bill_charge_type, $off->{$key . '_amount'}, $amount);

                        // Update the current amount by subtracting the offer amount
                        $amount -= floatval($offerAmount);
                    }
                    break;
            }
        }
    
        return [$currentAmounts['adult'], $currentAmounts['child'], $currentAmounts['infant']];
    }

    // single offer amount returning after checking the percentage or fixed rate.
    private function returnOfferAmount($billType,$offerAmount,$packageAmount) {
        return ($billType == 1) ? $this->getTheCommission($offerAmount,$packageAmount) : $offerAmount;
    }

    private function getPayableNightCounts($offerArr, $nights) {
        foreach ($offerArr as $key => $off) {
            if ($nights == $off->free_night_stay) {
                $nights = $off->free_night_pay; // when the night count is equal to the stay count, payable night count applied.
            } elseif($nights > $off->free_night_stay){
                $freeNightCount = (int)$off->free_night_stay - (int)$off->free_night_pay; // when the night count is greater than stay count, calculate the free night count and calculate the payable night count and applied.
                $nights -= $freeNightCount;
            } else {
                $nights = $nights; // when the night count is less than to the stay count, same night count will be applied.
            }
        }
        return $nights;
    }

    public function get_user_country_id($iso) {
        $this->db->select('country_id');
        $this->db->from('country');
        $this->db->where('iso', $iso);
        $this->db->limit(1);
        $q = $this->db->get();
        return $q->row()->country_id;
    }

    # =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    #                                                                                                                                                             #
    # =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

    /* public function relatedHotels($startDate,$endDate,$adults,$child,$accomAtoll,$limit='') {
        $this->db->select('c.nicename, ad.name as atoll, ht.hotel_type, h.ho_id, h.hotel_name, h.stars, h.review_count, ps.ps_id as season_id, MIN(packprice.price_poi) AS min_price,ps.start_date,ps.end_date');
        $this->db->from('package_season ps');
        $this->db->join('package_price packprice', 'packprice.season_id=ps.ps_id');
        $this->db->join('hotels h', 'h.ho_id=ps.resort_id');
        $this->db->join('atoll_details ad', 'ad.atoll_id=h.atoll');
        $this->db->join('country c', 'c.country_id=h.country');
        $this->db->join('hotel_type ht', 'ht.ht_id=h.hotel_type');
        $this->db->where('h.atoll',$accomAtoll);
        $this->db->where('ps.start_date <=', $startDate);
        $this->db->where('ps.end_date >=', $endDate);
        $this->db->where('packprice.adult', $adults);
        $this->db->where('packprice.child', $child);
        $this->db->order_by('h.hotel_name','asc');
        if ($limit != '') {
            $this->db->limit($limit);
        }
        $q = $this->db->get();
        return $q->result();
    } */

    // SHOULD HAVE TO DELETE THIS FUNCTION AFTER DEVELOPMENT IS COMPLETED.
    public function get_data_by_id($id, $passId) {
        $query = $this->db->get_where('package_price', array('season_id' => $id));
        if ($query->num_rows() > 0) {
            $data = $query->result();
            foreach ($data as $row) {
                $datas = array(
                    'p_id' => $row->p_id,
                    'season_id' => $passId,
                    'resort_id' => $row->resort_id,
                    'villa_id' => $row->villa_id,
                    'packtype' => $row->packtype,
                    'adult' => $row->adult,
                    'child' => $row->child,
                    'infant' => $row->infant,
                    'price'=> $row->price,
                    'extra_adult' => $row->extra_adult,
                    'extra_child' => $row->extra_child,
                    'is_baserate' => $row->is_baserate,
                    'meal_plan' => $row->meal_plan,
                    'commision_type' => $row->commision_type,
                    'com_amount'=> $row->com_amount,
                    'price_poi'=> $row->price_poi,
                );
                $this->db->insert('package_price', $datas);
            }
            return true;
        }
        return false;
    }
    // =========================================================================
}