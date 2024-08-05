<?php

class apartment extends CI_Model {
    /*
      Determines if a given apartment_id is a apartment
     */

    function exists($apartment_id)
    {
        $this->db->from('apartments');
        $this->db->where('apartment_id', $apartment_id);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }    


    function get_all($limit = 10000, $offset = 0, $search = "", $order = array(), $status = "", $sel_user = false)
    {
        $staff_id = $this->staff->get_logged_in_staff_info()->person_id;

        $select = "apartments.*, 
                   CONCAT(agent.first_name, ' ',agent.last_name) as agent_name";

        $this->db->select($select, FALSE);
        // $this->db->join('people as tenant', 'tenant.person_id = apartments.tenant_id', 'LEFT');
        $this->db->join('people as agent', 'agent.person_id = apartments.agent_id', 'LEFT');

        $staff_id = ($sel_user) ? $sel_user : $staff_id;

        if ($search !== "")
        {
            // hard coded the kpos_apartments table here might bug in the future
            $this->db->where("(      
                agent.first_name LIKE '%" . $search . "%' OR
                agent.last_name LIKE '%" . $search . "%' OR 
                CONCAT(agent.first_name, ' ', agent.last_name) LIKE '%" . $search . "%'
                )");
        }

        // $this->db->limit(0,$limit);
        // $this->db->offset($offset);
        $this->db->where("delete_flag", 0);
        $result = $this->db->get('apartments', $limit,0);

        return $result;
    }

    function count_all()
    {
        $this->db->from('apartments');
        $this->db->where("delete_flag", 0);
        return $this->db->count_all_results();
    }

    /*
      Gets information about a particular apartment
     */

    function get_info($apartment_id)
    {
        
        // $this->db->join('people as tenant', 'tenant.person_id = apartments.tenant_id', 'LEFT');
        $this->db->join('people as agent', 'agent.person_id = apartments.agent_id', 'LEFT');
        $this->db->where('apartment_id', $apartment_id);

        $query = $this->db->get('apartments');

        if ($query->num_rows() == 1)
        {
            return $query->row();
        }
        else
        {
            //Get empty base parent object, as $apartment_id is NOT a apartment
            $apartment_obj = new stdClass();

            //Get all the fields from items table
            $fields = $this->db->list_fields('apartments');

            foreach ($fields as $field)
            {
                $apartment_obj->$field = '';
            }

            $apartment_obj->apartment_id = -1;
            $apartment_obj->apartment_name = '';
            $apartment_obj->apartment_status = 'pending';

            return $apartment_obj;
        }
    }

    /*
      Gets information about multiple apartments
     */

    function get_multiple_info($apartment_ids = array())
    {

        return $this->db->where_in("apartment_id", $apartment_ids)->order_by("date_applied", "desc")->get("apartments")->result();
    }

    /*
      Inserts or updates a apartment
     */

    function save(&$apartment_data, $apartment_id = false, $has_payment = false)
    {
        
        if (!$apartment_id or ! $this->exists($apartment_id))
        {
            if ($this->db->insert('apartments', $apartment_data))
            {
                $apartment_data['apartment_id'] = $this->db->insert_id();

                //$this->move_attachments($apartment_data);

                return true;
            }
            return false;
        }

        $this->db->where('apartment_id', $apartment_id);
        return $this->db->update('apartments', $apartment_data);
    }


    /*
     * Move attachment to the right location
     */

    function move_attachments($apartment_data)
    {
        $linker = $this->session->userdata('linker');

        $this->db->from('attachments');
        $this->db->where('session_id', $linker);
        $query = $this->db->get();

        $this->db->where('session_id', $linker);
        $this->db->update('attachments', array("apartment_id" => $apartment_data['apartment_id']));

        $attachments = $query->result();
        foreach ($attachments as $attachment)
        {
            $tmp_dir = FCPATH . "uploads/apartment--1/";
            $user_dir = FCPATH . "uploads/apartment-" . $apartment_data['apartment_id'] . "/";

            if (!file_exists($user_dir))
            {
                // temporary set to full access
                @mkdir($user_dir);
            }

            $target_dist = $user_dir . $attachment->filename;

            if (file_exists($tmp_dir . $attachment->filename))
            {
                copy($tmp_dir . $attachment->filename, $target_dist);
                unlink($tmp_dir . $attachment->filename);
            }
        }
    }

    /*
      Deletes one apartment
     */

    function delete($apartment_id)
    {
        $this->db->where('apartment_id', $apartment_id);
        return $this->db->delete('apartments', array('delete_flag' => 1));
    }

    /*
      Deletes a list of apartments
     */

    function delete_list($apartment_ids)
    {
        $this->db->where_in('apartment_id', $apartment_ids);
        return $this->db->update('apartments', array("delete_flag" => 1));
    }

    /*
      Get search suggestions to find apartments
     */

    function get_search_suggestions($search, $limit = 25)
    {

        $suggestions = array();
        // $this->db->select('apartment_id, name');
        $this->db->from('apartments');
        $this->db->like('name', $search);
        $this->db->order_by("name", "asc");
        $by_name = $this->db->get();

        foreach ($by_name->result() as $row)
        {
            $suggestions[] = $row->apartment_id."|".$row->name;
        }

        //only return $limit suggestions
        if (count($suggestions > $limit))
        {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    public function get_apartment_balance($apartment_id = -1)
    {

        $payments = $this->db->where('apartment_id', $apartment_id)->where('delete_flag', 0)->order_by('date_paid', 'asc')->get('payments')->result();

        $apartment = $this->apartment->get_info($apartment_id);

        $principal = $apartment->apartment_amount;

        $start_time = strtotime($apartment->date_applied);

        $outstanding_interest = $paid_penalty = $days_late = $outstanding_penalty = 0;

        $count = 1;

        if(sizeof($payments) > 0){

            foreach ($payments as $payment) {

                $end_time =  strtotime($payment->date_paid);

                $penalty_start_time = strtotime($apartment->payment_date);

                $duration = round(($end_time - $start_time)/(24*60*60));

                $duration = ($duration > 0) ? $duration : 0;

                $interest = round($principal * $duration * ($apartment->monthly_rate/30));

                $outstanding_interest += $interest;

                // echo "<p>Outstanding Principal ".$count.": ".$principal;

                $breakdown = json_decode($payment->breakdown);

                $outstanding_interest -= $breakdown->interest;

                if (strtotime(date('Y-m-d')) > strtotime($apartment->payment_date)) {

                    if ($breakdown->penalty > 0) {

                        $days_late = round(($end_time - $penalty_start_time)/(24*60*60));

                        // $days_late = ($days_late > 0) ? $days_late : 0;

                        $chargeable_interest = round($principal * $days_late * ($apartment->monthly_rate/30));

                        $penalty = $apartment->penalty_rate * $chargeable_interest;

                        $outstanding_penalty += $penalty;

                        $outstanding_penalty -= $breakdown->penalty;

                        // echo "<br>penalty_start_time : ".date("d M, Y", $penalty_start_time);

                        // echo "<br>penalty_end_time : ".date("d M, Y",$end_time);

                        $penalty_start_time = $end_time; 

                    } 

                } 

                $principal -= $breakdown->principal;

                // echo "<br>Duration ".$count.": ".$duration." Days";

                // echo "<br>From : ".date("d M, Y", $start_time);

                $start_time = $end_time;

                // echo "<br>To : ".date("d M, Y",$end_time);

                // echo "<br>penalty paid : ". $breakdown->penalty;

                // echo "<br>Interest ".$count.": ".to_currency($outstanding_interest, true, 0);

                // echo "<br>Amount Paid ".$count.": ".to_currency($payment->amount, true, 0);

                // echo "<br>Days Late : ". $days_late;

                // echo "<br>penalty : ". to_currency($outstanding_penalty, true, 0);

                $count++;

            }

            //CALCULATE FIGURES FOR THE LAST INSTALLMENT

            $days_late = $duration = 0;

            $duration = round((strtotime(date('Y-m-d')) - $start_time)/(24*60*60));

            $duration = ($duration > 0) ? $duration : 0;

            $interest = round($principal * $duration * ($apartment->monthly_rate/30));

            $outstanding_interest += $interest;

            if (strtotime(date('Y-m-d')) > strtotime($apartment->payment_date)) {

                $days_late = round((strtotime(date('Y-m-d')) - $penalty_start_time)/(24*60*60));

                $days_late = ($days_late > 0) ? $days_late : 0;

                $chargeable_interest =  round($principal * $days_late * ($apartment->monthly_rate/30));

                $penalty = $apartment->penalty_rate * $chargeable_interest;

                $outstanding_penalty += $penalty;         

            }

            // echo "<p>Outstanding Principal ".$count.": ".$principal;

            // echo "<br>Duration ".$count.": ".$duration." Days";

            // echo "<br>From : ".date("d M, Y", $start_time);

            // echo "<br>To : ".date("d M, Y", time());

            // echo "<br>Interest ".$count.": ".to_currency($interest, true, 0);

            // echo "<br>Chargeable Interest ".$count.": ".to_currency($chargeable_interest, true, 0);

            // echo "<br>Days Late : ". $days_late;

            // echo "<br>penalty : ". to_currency($outstanding_penalty, true, 0);
            
        }else{

            $end_time = strtotime($payment->date_paid);

            $duration = round((strtotime(date('Y-m-d')) - $start_time)/(24*60*60));

            $duration = ($duration > 0) ? $duration : 0;

            $interest = round($principal * $duration * ($apartment->monthly_rate/30));

            $outstanding_interest += $interest;

            if (strtotime(date('Y-m-d')) > strtotime($apartment->payment_date)) {

                $days_late = round((strtotime(date('Y-m-d')) - $end_time)/(24*60*60));

                $penalty = $apartment->penalty_rate * $interest;

                $outstanding_penalty += $penalty;        

            }else{

                $days_late = 0;

                $penalty = 0;

            }

        }

        $apartment_balance = ($principal + $outstanding_interest + $outstanding_penalty);


        return round($apartment_balance);
    }

    function get_apartment_search_suggestions($search, $limit = 25)
    {
        $suggestions = array();

        $this->db->from('apartments');
        $this->db->like('account', $search);
        $this->db->order_by("account", "desc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row)
        {
            $suggestions[] = 'apartment ' . $row->item_kit_id . '|' . $row->name;
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
    
    function _get_count_payments($apartment_id)
    {
        $this->db->where("apartment_id", $apartment_id);
        $cnt = $this->db->count_all_results("payments");
        return $cnt;
    }

    /*
     * Perform update/insert balance
     */

    function update_balance($amount, $apartment_id)
    {
        $apartment = $this->get_info($apartment_id);

        $apartment_data['apartment_type_id'] = $apartment->apartment_type_id;
        $apartment_data['apartment_applied_date'] = time();

        if ($apartment->apartment_type_id > 0)
        {
            $due_date = $this->_get_apartment_payment_date($apartment_data);
        }
        else
        {
            $c_payment_scheds = json_decode($apartment->payment_scheds, TRUE);
            $count_payments = $this->_get_count_payments($apartment->apartment_id);

            $due_date = time();
            if (isset($c_payment_scheds["payment_breakdown"]["schedule"][1]))
            {
                $due_date = strtotime($c_payment_scheds["payment_breakdown"]["schedule"][1]);
            }
            
            if ( isset($c_payment_scheds["payment_breakdown"]["schedule"][$count_payments + 1]) )
            {
                $due_date = strtotime($c_payment_scheds["payment_breakdown"]["schedule"][$count_payments + 1]);
            }
        }

        $this->db->trans_start();

        $new_balance = $apartment->apartment_balance - $amount;
        $apartment_data['apartment_amount'] = $new_balance;
        $new_balance = $this->_get_apartment_balance($apartment_data);

        $data = array(
            'apartment_balance' => $new_balance,
            'apartment_payment_date' => $due_date
        );
        $this->db->where('apartment_id', $apartment_id);
        $this->db->update('apartments', $data);
        $this->db->trans_complete();
    }

    function save_attachments($apartment_id, &$data)
    {
        if ($apartment_id > 0)
        {
            if ($this->db->insert('attachments', array("filename" => $data['filename'], "apartment_id" => $apartment_id)))
            {
                $data['attachment_id'] = $this->db->insert_id();
                return true;
            }
        }

        $session_id = $data['params']['linker'];
        $this->load->library('session');
        $this->session->set_userdata(array("linker" => $session_id));
        if ($this->db->insert('attachments', array("filename" => $data['filename'], "session_id" => $session_id)))
        {
            $data['attachment_id'] = $this->db->insert_id();
            return true;
        }
    }
    
    function save_attach_desc($id, $desc)
    {
        $this->db->where('attachment_id', $id);
        return $this->db->update('attachments', array("descriptions" => $desc));
    }

    function get_attachments($apartment_id)
    {
        $this->db->from('attachments');
        $this->db->where('apartment_id', $apartment_id);
        $query = $this->db->get();

        return $query->result();
    }

    function remove_file($file_id)
    {
        $this->db->from('attachments');
        $this->db->where('attachment_id', $file_id);
        $query = $this->db->get();
        $res = $query->row();

        $user_dir = FCPATH . "uploads/apartment--1/";
        if ($res->apartment_id > 0)
        {
            $user_dir = FCPATH . "uploads/apartment-" . $res->apartment_id . "/";
        }

        if (file_exists($user_dir . $res->filename))
        {
            unlink($user_dir . $res->filename);
        }

        return $this->db->delete('attachments', array('attachment_id' => $file_id));
    }


}

?>