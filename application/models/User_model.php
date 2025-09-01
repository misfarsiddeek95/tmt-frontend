<?php

class User_model extends Front_model {
    public function __construct() {
        parent::__construct();
    }

    public function fetch_bookings($userId,$recent=false) {
        $this->db->select('b.bid,b.booking_number,b.total_amount,b.checkin_date,b.checkout_date,b.created_at,h.hotel_name');
        $this->db->from('booking b');
        $this->db->where('b.user_id', $userId);
        if ($recent) {
            $this->db->where('MONTH(b.created_at)', date('m'));
        }
        $this->db->join('hotels h', 'h.ho_id=b.ho_id');
        $this->db->order_by('b.created_at', 'DESC');
        $q = $this->db->get();
        return $q->result();
    }

    /* public function fetch_wishlist_products($userId) {
        $this->db->select('ps.ps_id,ps.resort_id,ps.start_date,ps.end_date,h.hotel_name,h.stars,h.review_count,h.longitude,h.latitude,ht.hotel_type,ad.name as atoll,MIN(pp.price_poi) AS min_price,pp.adult,pp.child,c.nicename,q.photo_path');
        $this->db->from('wishlist_products w');
        $this->db->where('w.user_id', $userId);
        $this->db->join('hotels h', 'h.ho_id=w.resort_id');
        $this->db->join('hotel_type ht', 'ht.ht_id=h.hotel_type');
        $this->db->join('country c', 'c.country_id=h.country');
        $this->db->join('package_season ps', 'ps.resort_id=w.resort_id');
        $this->db->join('package_price pp', 'pp.season_id=ps.ps_id');
        $this->db->join('packages p', 'p.p_id=ps.package_id');
        $this->db->join('atoll_details ad', 'ad.atoll_id=h.atoll');
        $this->db->join('photo q', 'q.table="hotels" AND q.field_id = h.ho_id');
        $query = $this->db->get();
        $main = $query->result();
        foreach ($main as $row) {
            // get hotel facilities
            $this->db->select('hfac.fac_icon as facility_icon, hfac.fac_name as facility_name');
            $this->db->from('hotel_fac hf');
            $this->db->where('hf.ho_id', $row->resort_id);
            $this->db->join('hotel_facilities hfac', 'hfac.fac_id=hf.fac_id');
            $this->db->group_by('hfac.fac_id'); // added group by clause
            $this->db->limit(4);
            $qHotelFacilities = $this->db->get();
            $row->hotelFacilities = $qHotelFacilities->result();
        }
        return $main;
    } */

    public function fetch_wishlist_products($userId) {
        $this->db->select('w.wp_id,ps.ps_id,ps.resort_id,ps.start_date,ps.end_date,h.hotel_name,h.stars,h.review_count,h.longitude,h.latitude,ht.hotel_type,ad.name as atoll,MIN(IF(ps.start_date <= NOW() AND ps.end_date >= NOW(), pp.price_poi, NULL)) AS min_price,pp.adult,pp.child,c.nicename,q.photo_path');
        $this->db->from('wishlist_products w');
        $this->db->where('w.user_id', $userId);
        $this->db->join('hotels h', 'h.ho_id=w.resort_id');
        $this->db->join('hotel_type ht', 'ht.ht_id=h.hotel_type');
        $this->db->join('country c', 'c.country_id=h.country');
        $this->db->join('package_season ps', 'ps.resort_id=w.resort_id');
        $this->db->join('package_price pp', 'pp.season_id=ps.ps_id');
        $this->db->join('packages p', 'p.p_id=ps.package_id');
        $this->db->join('atoll_details ad', 'ad.atoll_id=h.atoll');
        $this->db->join('photo q', 'q.table="hotels" AND q.field_id = h.ho_id');
        $this->db->group_by('w.wp_id');
        $this->db->order_by('w.created_at', 'DESC');
        $query = $this->db->get();
        $main = $query->result();
        foreach ($main as $row) {
            // get hotel facilities
            $this->db->select('hfac.fac_icon as facility_icon, hfac.fac_name as facility_name');
            $this->db->from('hotel_fac hf');
            $this->db->where('hf.ho_id', $row->resort_id);
            $this->db->join('hotel_facilities hfac', 'hfac.fac_id=hf.fac_id');
            $this->db->group_by('hfac.fac_id'); // added group by clause
            $this->db->limit(4);
            $qHotelFacilities = $this->db->get();
            $row->hotelFacilities = $qHotelFacilities->result();
        }
        return $main;
    }

    public function fetch_user_detail($userId) {
        $this->db->select('s.user_id,s.fname,s.lname,s.email,s.phone,s.username,s.user_pic,s.dob');
        $this->db->from('staff_users s');
        $this->db->where('s.user_id', $userId);
        $this->db->limit(1);
        $q = $this->db->get();
        $ret = false;
        if ($q->num_rows() == 1) {
            $ret = $q->row();
        }
        return $ret;
    }
    
    public function booking_detail($booking_number) {
        $this->db->select('b.*,h.hotel_name,hr.room_title,mt.long_name as meal_plan,t.transfer_type,c.nicename as my_country,gc.nicename as guest_country,bs.title as special_request_title');
        $this->db->from('booking b');
        $this->db->where('b.booking_number', $booking_number);
        $this->db->join('booking_special_requests bs', 'bs.id=b.special_request', 'left outer');
        $this->db->join('hotels h', 'h.ho_id=b.ho_id');
        $this->db->join('hotel_rooms hr', 'hr.hr_id=b.room_id');
        $this->db->join('meal_types mt', 'mt.meal_id=b.meal_type_id', 'left outer');
        $this->db->join('transfer t', 't.tras_id=b.transfer_type_id', 'left outer');
        $this->db->join('country c', 'c.country_id=b.country_id', 'left outer');
        $this->db->join('country gc', 'gc.country_id=b.guest_country_id', 'left outer');
        $q = $this->db->get();
        $ret = false;
        if ($q->num_rows() == 1) {
            $ret = $q->row();
        }
        return $ret;
    }
}