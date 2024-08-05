<?php

Class House extends CI_Model 
{

    function exists($house_id)
    {
        $this->db->from('houses');
        $this->db->where('house_id', $house_id);
        $query = $this->db->get();
        return ($query->num_rows() == 1);
    } 


    function get_details($id)
    {
        // $this->db->join('people as agent', 'agent.person_id = apartments.agent_id', 'LEFT');
        $this->db->where('house_id', $id);

        $query = $this->db->get('houses');

        return $query->row();

    }

    function get_all($apartment_id, $hse_status = "") 
    {
        $staff_id = $this->staff->get_logged_in_staff_info()->person_id;

        // $select = "houses.*, 
        //            CONCAT(agent.first_name, ' ',agent.last_name) as agent_name";

        // $this->db->select($select, FALSE);
       
        // $this->db->join('people as agent', 'agent.person_id = apartments.agent_id', 'LEFT');

        // $staff_id = ($sel_user) ? $sel_user : $staff_id;

        $this->db->where('apartment_id', $apartment_id);

        if($hse_status != ""){

            $this->db->where('status', $hse_status);
        }
        
        $result = $this->db->get("houses");
        
        return $result;

    }

    // Insert a new house else update

    function save(&$house_data, $house_id = false)
    {

        if (!$house_id or ! $this->exists($house_id))
        {
            if ($this->db->insert('houses', $house_data))
            {
                $house['house_id'] = $this->db->insert_id();

                return true;
            }
            return false;
        }

        $this->db->where('house_id', $house_id);
        
        return $this->db->update('houses', $house_data);
        
    }

    public function vacate($house_id)
    {
        
        $house_data['status'] = "Vacant";

        $this->db->where('house_id', $house_id);

        return $this->db->update('houses', $house_data);
    }
}