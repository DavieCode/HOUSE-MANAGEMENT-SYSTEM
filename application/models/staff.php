<?php

class staff extends Person {
    /*
      Determines if a given person_id is an staff
     */

    function exists($person_id)
    {
        $this->db->from('staffs');
        $this->db->join('people', 'people.person_id = staffs.person_id');
        $this->db->where('staffs.person_id', $person_id);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    /*
      Returns all the staffs
     */

    function get_all($limit = 10000, $offset = 0, $search = "", $order = array())
    {
        $user_id = $this->staff->get_logged_in_staff_info()->person_id;

        $sorter = array("staffs.person_id", "staffs.person_id", "last_name", "first_name", "email", "phone_number");

        $this->db->from('staffs');
        $this->db->join('people', 'staffs.person_id=people.person_id');
        $this->db->where('deleted', 0);

        if ($search !== "")
        {
            $this->db->where('first_name LIKE ', '%' . $search . '%');
            $this->db->or_where('last_name LIKE', '%' . $search . '%');
            $this->db->or_where('email LIKE', '%' . $search . '%');
            $this->db->or_where('id_number LIKE', '%' . $search . '%');
            $this->db->or_where('phone_number LIKE', '%' . $search . '%');
        }

        if (isset($_GET['staff_id']) && $_GET['staff_id'] > 0)
        {
            $user_id = $_GET['staff_id'];
        }
    
        if (count($order) > 0 && $order['index'] < count($sorter))
        {
            $this->db->order_by($sorter[$order['index']], $order['direction']);
        }
        else
        {
            $this->db->order_by("staffs.person_id", "desc");
        }

        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function count_all()
    {
        $this->db->from('staffs');
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }

    /*
      Gets information about a particular staff
     */

    function get_info($staff_id)
    {
        $this->db->from('staffs');
        $this->db->join('people', 'people.person_id = staffs.person_id');
        $this->db->where('staffs.person_id', $staff_id);
        $query = $this->db->get();

        if ($query->num_rows() == 1)
        {
            return $query->row();
        }
        else
        {
            //Get empty base parent object, as $staff_id is NOT an staff
            $person_obj = parent::get_info(-1);

            //Get all the fields from staff table
            $fields = $this->db->list_fields('staffs');

            //append those fields to base parent object, we we have a complete empty object
            foreach ($fields as $field)
            {
                $person_obj->$field = '';
            }

            return $person_obj;
        }
    }

    /*
      Gets information about multiple staffs
     */

    function get_multiple_info($staff_ids)
    {
        $this->db->from('staffs');
        $this->db->join('people', 'people.person_id = staffs.person_id');
        $this->db->where_in('staffs.person_id', $staff_ids);
        $this->db->order_by("last_name", "asc");
        return $this->db->get();
    }

    /*
      Inserts or updates an staff
     */

    function save(&$person_data, &$staff_data, $staff_id = false)
    {
        $success = false;

        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();

        if (parent::save($person_data, $staff_id))
        {
            $staff_data["added_by"] = $this->staff->get_logged_in_staff_info()->person_id;
            
            if (!$staff_id or ! $this->exists($staff_id))
            {
                $staff_data['person_id'] = $staff_id = $person_data['person_id'];

                $success = $this->db->insert('staffs', $staff_data);
            }
            else
            {
                $this->db->where('person_id', $staff_id);
                
                $success = $this->db->update('staffs', $staff_data);
            }

           
        }

        $this->db->trans_complete();
        return $success;
    }

    /*
      Deletes one staff
     */

    function delete($staff_id)
    {
        $success = false;

        //Don't let staff delete their self
        if ($staff_id == $this->get_logged_in_staff_info()->person_id)
            return false;

        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();

        $this->db->trans_complete();
        return $success;
    }

    /*
      Deletes a list of staffs
     */

    function delete_list($staff_ids)
    {
        $success = false;

        //Don't let staff delete their self
        if (in_array($this->get_logged_in_staff_info()->person_id, $staff_ids)){

             return false;
        }

        //Run these queries as a transaction, we want to make sure we do all or nothing
        // $this->db->trans_start();

        $this->db->where_in('person_id', $staff_ids);

        $success = $this->db->update('staffs', array('deleted' => 1));
        
        // $this->db->trans_complete();
        return $success;
    }

    /*
      Get search suggestions to find staffs
     */

    function get_search_suggestions($search, $limit = 5)
    {
        $suggestions = array();

        $this->db->from('staffs');
        $this->db->join('people', 'staffs.person_id=people.person_id');
        $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
        $this->db->order_by("last_name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row)
        {
            $suggestions[] = $row->first_name . ' ' . $row->last_name;
        }

        $this->db->from('staffs');
        $this->db->join('people', 'staffs.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("email", $search);
        $this->db->order_by("email", "asc");
        $by_email = $this->db->get();
        foreach ($by_email->result() as $row)
        {
            $suggestions[] = $row->email;
        }

        $this->db->from('staffs');
        $this->db->join('people', 'staffs.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("username", $search);
        $this->db->order_by("username", "asc");
        $by_username = $this->db->get();
        foreach ($by_username->result() as $row)
        {
            $suggestions[] = $row->username;
        }


        $this->db->from('staffs');
        $this->db->join('people', 'staffs.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("phone_number", $search);
        $this->db->order_by("phone_number", "asc");
        $by_phone = $this->db->get();
        foreach ($by_phone->result() as $row)
        {
            $suggestions[] = $row->phone_number;
        }


        //only return $limit suggestions
        if (count($suggestions > $limit))
        {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    /*
      Preform a search on staffs
     */

    function search($search)
    {
        $this->db->from('staffs');
        $this->db->join('people', 'staffs.person_id=people.person_id');
        $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		username LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
        $this->db->order_by("last_name", "asc");

        return $this->db->get();
    }

    /*
      Attempts to login staff and set session. Returns boolean based on outcome.
     */

    function login($username, $password)
    {
        $query = $this->db->get_where('staffs', array('username' => $username, 'password' => md5($password), 'deleted' => 0), 1);
        if ($query->num_rows() == 1)
        {
            $row = $query->row();

            $this->session->set_userdata('person_id', $row->person_id);

            return true;
        }
        
        return false;
    }

    /*
      Logs out a user by destorying all session data and redirect to login
     */

    function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }

    /*
      Determins if a staff is logged in
     */

    function is_logged_in()
    {
        return $this->session->userdata('person_id') != false;
    }

    /*
      Gets information about the currently logged in staff.
     */

    function get_logged_in_staff_info()
    {
        if ($this->is_logged_in())
        {
            return $this->get_info($this->session->userdata('person_id'));
        }

        return false;
    }


    /*
      Get search suggestions to find tenants
     */

    function get_staff_search_suggestions($search, $limit = 25)
    {
        $suggestions = array();

        $user_id = $this->staff->get_logged_in_staff_info()->person_id;
        $add_where = '';
        if ($user_id > 1)
        {
            $add_where = " and added_by = " . $user_id . " ";
        }

        $this->db->from('staffs');
        $this->db->join('people', 'staffs.person_id=people.person_id');
        $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0
                    " . $add_where . "
                    ");
        $this->db->order_by("last_name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row)
        {
            $suggestions[] = $row->person_id . '|' . $row->first_name . ' ' . $row->last_name . '|' . $row->email;
        }
       
        return $suggestions;
    }
}

?>
