<?php

class tenant extends Person {
    /*
      Determines if a given person_id is a tenant
     */

    function exists($person_id, $email = false)
    {
        $this->db->from('tenants');
        $this->db->join('people', 'people.person_id = tenants.person_id');
        $this->db->where('tenants.person_id', $person_id);
        $this->db->from('houses');
        $this->db->join('apartments','houses.apartment_id = apartments.apartment_id');
        if ($email)
        {
            $this->db->or_where('people.email', $email);
        }
        $query = $this->db->get();

        return ($query->num_rows() > 0);
    }


    /*
      Returns all the tenants
     */

    function get_all($limit = 10000, $offset = 0, $search = "", $order = array(), $sel_user = false)
    {
        $sorter = array("", "tenants.person_id", "last_name", "first_name", "email", "phone_number");

        $this->db->from('tenants');
        $this->db->join('people', 'tenants.person_id=people.person_id');
        $this->db->where('deleted', 0);

        $staff_id = $this->session->userdata('person_id');

        $staff_id = ($sel_user) ? $sel_user : $staff_id;


        if ($search !== "")
        {
            $this->db->where('first_name LIKE ', '%' . $search . '%');
            $this->db->or_where('last_name LIKE', '%' . $search . '%');
            $this->db->or_where('email LIKE', '%' . $search . '%');
            $this->db->or_where('id_number LIKE', '%' . $search . '%');
            $this->db->or_where('phone_number LIKE', '%' . $search . '%');
            $this->db->or_where('tenants.person_id LIKE', '%' . $search . '%');
        }

        if (count($order) > 0 && $order['index'] < count($sorter))
        {
            $this->db->order_by($sorter[$order['index']], $order['direction']);
        }
        else
        {
            $this->db->order_by("last_name", "asc");
        }

        //$this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function count_all()
    {
        $this->db->from('tenants');
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }

    /*
      Gets information about a particular tenant
     */

    function get_info($tenant_id)
    {

        $this->db->from('tenants');
        $this->db->select('tenants.*');
        $this->db->select('people.*');
        $this->db->select('houses.house_no, houses.house_id');
        $this->db->select('apartments.apartment_id, apartments.name as apartment_name');
        $this->db->join('people', 'people.person_id = tenants.person_id');
        $this->db->join('houses', 'houses.house_id = tenants.house_id');
        $this->db->join('apartments', 'apartments.apartment_id = houses.apartment_id');
        $this->db->where('tenants.person_id', $tenant_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            return $query->row();
        }
        else
        {
            //Get empty base parent object, as $tenant_id is NOT an tenant
            $person_obj = parent::get_info(-1);

            //Get all the fields from tenant table
            $fields = $this->db->list_fields('tenants');

            //append those fields to base parent object, we have a complete empty object
            foreach ($fields as $field)
            {
                $person_obj->$field = '';
            }

            return $person_obj;
        }
    }

    /*
      Gets information about multiple tenants
     */

    function get_multiple_info($tenant_ids)
    {
        $this->db->from('tenants');
        $this->db->join('people', 'people.person_id = tenants.person_id');
        $this->db->where_in('tenants.person_id', $tenant_ids);
        $this->db->order_by("last_name", "asc");
        return $this->db->get();
    }

    function get_attachments($tenant_id)
    {
        $this->db->from('attachments');
        $this->db->where('tenant_id', $tenant_id);
        $query = $this->db->get();

        return $query->result();
    }

    /*
      Inserts or updates a tenant
     */

    function save(&$person_data, &$tenant_data, $tenant_id = false)
    {
        $success = false;
        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();

        if (parent::save($person_data, $tenant_id))
        {
            $staff_id = $this->staff->get_logged_in_staff_info()->person_id;

            $house_data['status'] = "occupied";

            //NEW tenant

            if ($tenant_id == -1 or ! $this->exists($tenant_id))
            {

                $tenant_data['person_id'] = $person_data['person_id'];

                $tenant_data['added_by'] = $staff_id;

                $success = $this->db->insert('tenants', $tenant_data) && $this->db->where('house_id',$tenant_data['house_id'])->update('houses', $house_data);

                $this->move_attachments($tenant_data);
            }
            else // UPDATE tenant
            {
                $this->db->where('person_id', $tenant_id);

                $tenant_data['added_by'] = $staff_id;

                //var_dump($tenant_data);

                $this->db->where('person_id', $tenant_id);

                $success = $this->db->update('tenants', $tenant_data) && $this->db->where('house_id',$tenant_data['house_id'])->update('houses', $house_data);
            }
        }

        $this->db->trans_complete();
        return $success;
    }

    function move_attachments($tenant_data)
    {
        $linker = $this->session->userdata('linker');

        $this->db->from('attachments');
        $this->db->where('session_id', $linker);
        $query = $this->db->get();

        $this->db->where('session_id', $linker);
        $this->db->update('attachments', array("tenant_id" => $tenant_data['person_id']));

        $attachments = $query->result();
        foreach ($attachments as $attachment)
        {
            $tmp_dir = FCPATH . "uploads/tenant-/";
            $user_dir = FCPATH . "uploads/tenant-" . $tenant_data['person_id'] . "/";

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
      Deletes one tenant
     */

    function delete($tenant_id)
    {
        $this->db->where('person_id', $tenant_id);
        return $this->db->update('tenants', array('deleted' => 1));
    }

    /*
      Deletes a list of tenants
     */

    function delete_list($tenant_ids)
    {
        $this->db->where_in('person_id', $tenant_ids);
        return $this->db->update('tenants', array('deleted' => 1));
    }

    /*
      Get search suggestions to find tenants
     */

    function get_search_suggestions($search, $limit = 25)
    {
        $suggestions = array();

        $this->db->from('tenants');
        $this->db->join('people', 'tenants.person_id=people.person_id');
        $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
        $this->db->order_by("last_name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row)
        {
            $suggestions[] = $row->first_name . ' ' . $row->last_name;
        }

        $this->db->from('tenants');
        $this->db->join('people', 'tenants.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("email", $search);
        $this->db->order_by("email", "asc");
        $by_email = $this->db->get();
        foreach ($by_email->result() as $row)
        {
            $suggestions[] = $row->email;
        }

        $this->db->from('tenants');
        $this->db->join('people', 'tenants.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("phone_number", $search);
        $this->db->order_by("phone_number", "asc");
        $by_phone = $this->db->get();
        foreach ($by_phone->result() as $row)
        {
            $suggestions[] = $row->phone_number;
        }

        $this->db->from('tenants');
        $this->db->join('people', 'tenants.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("account_number", $search);
        $this->db->order_by("account_number", "asc");
        $by_account_number = $this->db->get();
        foreach ($by_account_number->result() as $row)
        {
            $suggestions[] = $row->account_number;
        }

        //only return $limit suggestions
        if (count($suggestions > $limit))
        {
            $suggestions = array_slice($suggestions, 0, $limit);
        }

        return $suggestions;
    }

    /*
      Get search suggestions to find tenants
     */

    function get_tenant_search_suggestions($search, $limit = 25)
    {

            $suggestions = array();

            $user_id = $this->staff->get_logged_in_staff_info()->person_id;
            $add_where = '';

            $this->db->from('tenants');
            $this->db->join('people', 'tenants.person_id=people.person_id');
            $this->db->where('tenants.date_moved', '0');
            
            $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
            last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
            CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0
                        " . $add_where . "
                        ");
            $this->db->order_by("first_name", "asc");
            $by_name = $this->db->get();
            
            foreach ($by_name->result() as $row)
            {
                $suggestions[] = $row->person_id . '|' . $row->first_name . ' ' . $row->last_name . '|' . $row->email;
            }

            // $this->db->from('tenants');
            // $this->db->join('people', 'tenants.person_id=people.person_id');
            // $this->db->where('deleted', 0);
            // $this->db->like("people.first_name", $search);
            // $this->db->order_by("people.first_name", "asc");
            // $by_account_number = $this->db->get();

            // foreach ($by_account_number->result() as $row)
            // {
            //     $suggestions[] = $row->person_id ;
            // }

            //only return $limit suggestions
            if (count($suggestions > $limit))
            {
                $suggestions = array_slice($suggestions, 0, $limit);

                //var_dump($suggestions);
            }
            return $suggestions;
    }

    /*
      Preform a search on tenants
     */

    function search($search)
    {
        $this->db->from('tenants');
        $this->db->join('people', 'tenants.person_id=people.person_id');
        $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		 
		CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
        $this->db->order_by("last_name", "asc");

        return $this->db->get();
    }
    
    function save_profile_pic($tenant_id, &$data)
    {
        if ($tenant_id > 0)
        {
            $save_data["photo_url"] = $data["filename"];
            $this->db->where("person_id", $tenant_id);
            $this->db->update("people", $save_data);
            return true;
        }
    }

    function save_attachments($tenant_id, &$data)
    {
        if ($tenant_id > 0)
        {
            if ($this->db->insert('attachments', array("filename" => $data['filename'], "tenant_id" => $tenant_id)))
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

    public function get_payment_ids($tenant_id='')
    {
        $this->db->select("payment_id");

        return $this->db->where("tenant_id", $tenant_id)->get("payments")->result_array();
    }

    public function vacate($tenant_id)
    {
        $tenant_data['date_moved'] = time();

        $this->db->where('person_id', $tenant_id);

        return $this->db->update('tenants', $tenant_data);
    }

}

?>
