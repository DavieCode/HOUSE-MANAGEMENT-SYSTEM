<?php

class Payment extends CI_Model {
    /*
      Determines if a given payment_id is a payment
     */

    function exists($payment_id)
    {
        $this->db->from('payments');
        $this->db->where('payment_id', $payment_id);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    function get_all($limit = 10000, $offset = 0, $search = "", $order = array(), $sel_user = false)
    {
        $user_id = $this->staff->get_logged_in_staff_info()->person_id;
        
        $sorter = array(
            "date_paid",
            "payment_id",
            "tenant.first_name",
            "amount",
            "people.first_name"
        );

        $select = "payments.*, CONCAT(tenant.first_name, ' ', tenant.last_name) as tenant_name, 
                   CONCAT(people.first_name, ' ',people.last_name) as teller_name, 
                   payments.amount, apartments.name as apartment_name";

        $this->db->select($select, FALSE);
        $this->db->from('payments');
        $this->db->join('people as tenant', 'tenant.person_id = payments.tenant_id', 'LEFT');
        $this->db->join('tenants as my_tenant', 'my_tenant.person_id = payments.tenant_id', 'LEFT');
        $this->db->join('people as people', 'people.person_id = payments.teller_id', 'LEFT');
        $this->db->join('houses', 'houses.house_id = payments.house_id', 'LEFT');  
        $this->db->join('apartments', 'apartments.apartment_id = houses.apartment_id', 'LEFT');  
        //$this->db->join('apartment_types as apartment_types', 'apartment_types.apartment_type_id = apartments.apartment_type_id', 'LEFT');


        if ($search !== "")
        {
            $this->db->where("tenant.first_name LIKE '%" . $search . "%' OR
                people. last_name LIKE '%" . $search . "%' OR
                payment_method LIKE '%" . $search . "%' OR
                payments.tenant_id LIKE '%" . $search . "%' OR
                date_paid LIKE '%" . $search . "%'");
        }

        if (count($order) > 0 && $order['index'] < count($sorter))
        {
            //echo $sorter[$order['index']];
            $this->db->order_by('date_paid', 'desc');
        }
        else
        {
            $this->db->order_by("date_paid", "desc");
        }

        $this->db->where('payments.delete_flag', 0);
        
        $user_id = ($sel_user) ? $sel_user : $user_id;
        
        //$this->db->where('my_tenant.added_by', $user_id);

        // $this->db->limit($limit);
        // $this->db->offset($offset);
        return $this->db->get();
    }

    function get_overdues(){

        $select = "payments.payment_id, houses.rent as amount_payable, payments.paid_for as month, tenants.person_id as accnt, CONCAT(people.first_name,' ', people.last_name) as tenant_name , apartments.name as apartment_name, 
        tenants.date_moved, payments.amount as amount_paid, tenants.deleted as tenant_delete_flag, payments.delete_flag as payment_delete_flag";

        $this->db->select($select, FALSE);

        $this->db->from('tenants');

        $this->db->join('houses', 'houses.house_id = tenants.house_id', 'LEFT');

        $this->db->join('apartments', 'apartments.apartment_id = houses.apartment_id', 'LEFT');

        $this->db->join('payments', 'payments.tenant_id = tenants.person_id', 'LEFT');

        $this->db->join('people', 'people.person_id = tenants.person_id', 'LEFT');

        return $this->db->get();

    }

    function count_all()
    {
        $this->db->where("payments.delete_flag", 0);
        $this->db->from('payments');
        return $this->db->count_all_results();
    }

    /*
      Gets information about a particular apartment
     */

    function get_info($payment_id)
    {
        $select = "payments.*, CONCAT(tenant.first_name, ' ', tenant.last_name) as tenant_name, 
                   CONCAT(people.first_name, ' ',people.last_name) as teller_name, 
                   payments.amount, apartments.name as apartment_name, houses.house_no, houses.rent, houses.house_type";

        $this->db->select($select, FALSE);
        $this->db->from('payments');
        $this->db->join('people as tenant', 'tenant.person_id = payments.tenant_id', 'LEFT');
        $this->db->join('tenants as my_tenant', 'my_tenant.person_id = payments.tenant_id', 'LEFT');
        $this->db->join('people as people', 'people.person_id = payments.teller_id', 'LEFT');
        $this->db->join('houses', 'houses.house_id = payments.house_id', 'LEFT');  
        $this->db->join('apartments', 'apartments.apartment_id = houses.apartment_id', 'LEFT'); 
        // $this->db->join('apartments', 'apartments.apartment_id = payments.apartment_id', 'LEFT');
        //$this->db->join('apartment_types', 'apartment_types.apartment_type_id = apartments.apartment_type_id', 'LEFT');
        $this->db->where('payment_id', $payment_id);

        $query = $this->db->get();

        if ($query->num_rows() == 1)
        {
            return $query->row();
        }
        else
        {
            //Get empty base parent object, as $apartment_id is NOT a apartment
            $payment_obj = new stdClass();

            //Get all the fields from items table
            $fields = $this->db->list_fields('payments');

            foreach ($fields as $field)
            {
                $payment_obj->$field = '';
            }

            $payment_obj->payment_id = -1;
            $payment_obj->tenant_name = '';

            return $payment_obj;
        }
    }

    /*
      Gets information about multiple apartments
     */

    function get_multiple_info($apartments_ids)
    {
        $this->db->from('payments');
        $this->db->where_in('item_kit_id', $apartments_ids);
        $this->db->order_by("account", "asc");
        return $this->db->get();
    }

    /*
      Inserts or updates a payment
     */

    function save(&$payment_data, $payment_id = false)
    {
        if (!$payment_id or ! $this->exists($payment_id))
        {
            if ($this->db->insert('payments', $payment_data))
            {
                $payment_data['payment_id'] = $this->db->insert_id();
                return true;
            }
            return false;
        }

        $payment_data['date_modified'] = date('Y-m-d', time());

        $this->db->where('payment_id', $payment_id);

        return $this->db->update('payments', $payment_data);
    }

    /*
      Deletes one payment
     */

    function delete($payment_id)
    {
        $this->db->where('payment_id', $payment_id);
        return $this->db->update('payments', array('delete_flag' => 1));
    }

    /*
      Deletes a list of apartments
     */

    function delete_list($payment_ids)
    {
        $this->db->where_in('payment_id', $payment_ids);
        return $this->db->update('payments', array("delete_flag" => 1));
    }

    /*
      Get search suggestions to find apartments
     */

    function get_search_suggestions($search, $limit = 25)
    {
        $suggestions = array();

        $this->db->from('payments');
        $this->db->like('account', $search);
        $this->db->order_by("account", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row)
        {
            $suggestions[] = $row->account;
        }

        //only return $limit suggestions
        if (count($suggestions > $limit))
        {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function get_apartment_search_suggestions($search, $limit = 25)
    {
        $suggestions = array();

        $this->db->from('payments');
        $this->db->like('account', $search);
        $this->db->order_by("account", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row)
        {
            $suggestions[] = 'payment ' . $row->item_kit_id . '|' . $row->name;
        }

        //only return $limit suggestions
        if (count($suggestions > $limit))
        {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    /*
      Preform a search on apartments
     */

    function search($search)
    {
        $this->db->from('apartments');
        $this->db->where("account LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		description LIKE '%" . $this->db->escape_like_str($search) . "%'");
        $this->db->order_by("account", "asc");
        return $this->db->get();
    }

    function get_apartments($tenant_id)
    {
        
        $this->db->where("person_id", $tenant_id);
        $this->db->join('houses', 'houses.house_id = tenants.house_id');
        $this->db->join('apartments', 'apartments.apartment_id = houses.apartment_id');

        // $this->db->where("delete_flag", 0);

        $result = $this->db->get('tenants');


        return  $result;

    }

    // Get total sum of all payments in a period of time

    function get_total_by_range($startDate, $endDate){

        $startDate2 = $startDate - ($endDate - $startDate);

        $this->db->where("DATE_FORMAT(date_paid , '%Y-%m-%d') > ", $startDate);

        $this->db->where("DATE_FORMAT(date_paid , '%Y-%m-%d') <= ", $endDate);

        $this->db->where('delete_flag', 0);

        $query = $this->db->get('payments')->result();

        $payment_total = $principal = $interest = $renewal = $penalty = 0;

        foreach ($query as $rec) {
            
            $payment_total += $rec->amount;

            $breakdown = json_decode($rec->breakdown);

            $principal += $breakdown->principal;

            $interest += $breakdown->interest;

            $renewal += $breakdown->renewal;

            $penalty += $breakdown->penalty;

        }

        $income = $interest + $renewal + $penalty;

        $previous_week = $this->db->select_sum('amount')->where("DATE_FORMAT(date_paid , '%Y-%m-%d') <= ", $startDate)->where("DATE_FORMAT(date_paid , '%Y-%m-%d') > ", $startDate2)->where('delete_flag', 0)->get('payments')->row()->amount;

        $diff = $payment_total - $previous_week;

        $increase = ($diff/$payment_total)*100;

        $status = "increase";

        if($diff < 0){

            $status = "decrease";

        }

        $payment_breakdown = array('principal' => to_currency($principal, true, 0), 'interest' => to_currency($interest, true, 0), 'penalty' => to_currency($penalty, true, 0), 'renewal' => to_currency($renewal, true, 0) );

        return json_encode(array($payment_total, abs(round($increase)), $status, $payment_breakdown, $income) );

    }


    public function getTotalPayments()
    {

        $this->db->where('delete_flag', 0);

        $payments = $this->db->select_sum('amount')->get('payments')->row()->amount;

        return $payments;
    }

}

?>