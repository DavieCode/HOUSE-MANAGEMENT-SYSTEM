<?php

class Letter extends CI_Model {

    /*
      Determines if a given letter_id is an letter
     */

    function exists($letter_id)
    {
        $this->db->where('letter_id', $letter_id);

        $query = $this->db->get('letters');

        return ($query->num_rows() > 0);
    }

    /*
      Returns all the letters
     */

    function get_all()
    {
        $this->db->from('letters');
        $this->db->where('delete_flag', 0);

        $this->db->order_by("date_created", "desc");        

        return $this->db->get()->result();
    }

    function count_all()
    {
        $this->db->where('delete_flag', 0);

        return $this->db->count_all_results('letters');
    }

    /*
      Gets information about a particular letter
     */

    function get_info($letter_id = -1)
    {
        $this->db->from('letters');
        $this->db->where('letter_id', $letter_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            return $query->row();
        }

    }

    /*
      Gets information about multiple letters
     */

    function get_multiple_info($letter_ids)
    {
        $this->db->from('letters');
        $this->db->where_in('letter_id', $letter_ids);
        $this->db->order_by("date", "asc");
        return $this->db->get();
    }

    /*
      Inserts or updates an letter
     */

    function save($letter_data, $letter_id = false)
    {
        
        if ($letter_id == -1)
        {
            if ($this->db->insert('letters', $letter_data))
            {
                $letter_data['letter_id'] = $this->db->insert_id();

                return true;
            }

            return false;

        }

        $this->db->where('letter_id', $letter_id);

        return $this->db->update('letters', $letter_data);

    }

    /*
      Deletes one letter
     */

    function delete($letter_id)
    {
        $this->db->where('letter_id', $letter_id);
        return $this->db->update('letters', array('delete_flag' => 1));
    }

    /*
      Deletes a list of letters
     */

    function delete_list($letter_ids)
    {
        $this->db->where_in('letter_id', $letter_ids);
        return $this->db->update('letters', array('delete_flag' => 1));
    }

    /*
      Preform a search on letters
     */

    function search($search)
    {
        $this->db->from('letters');
        $this->db->where("(description LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		date LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		amount LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		added_by LIKE '%" . $this->db->escape_like_str($search) . "%') and delete_flag=0");

        $this->db->order_by("date", "desc");

        return $this->db->get();
    }

    function get_total_by_range($startDate, $endDate){

        $startDate2 = $startDate - ($endDate - $startDate);

        $this->db->select_sum("amount");

        $this->db->where("DATE_FORMAT(date , '%Y-%m-%d') > ", $startDate);

        $this->db->where("DATE_FORMAT(date , '%Y-%m-%d') <= ", $endDate);

        $this->db->where("delete_flag", "0");

        $query = $this->db->get('letters');

        $res = $query->row();

        $previous_week = $this->db->select_sum('amount')->where("DATE_FORMAT(date , '%Y-%m-%d') <= ", $startDate)->where("DATE_FORMAT(date , '%Y-%m-%d') > ", $startDate2)->where('delete_flag', 0)->get('letters')->row()->amount;

        $diff = $res->amount - $previous_week;

        $increase = ($diff/$res->amount)*100;

        $status = "increase";

        if($diff < 0){

            $status = "decrease";

        }

        $this->db->select_sum('amount')->select('category');

        $this->db->where("DATE_FORMAT(date , '%Y-%m-%d') > ", $startDate);

        $this->db->where("DATE_FORMAT(date , '%Y-%m-%d') <= ", $endDate);

        $this->db->where("delete_flag", "0");

        $letter_breakdown = $this->db->group_by('category')->get('letters')->result();

        $brk_down = array();

        foreach ($letter_breakdown as $rec) {

            $record = array(ucwords($rec->category), to_currency($rec->amount, true, 0) );
            
            array_push($brk_down, $record);

        }

        return json_encode(array($res->amount, abs(round($increase)), $status, $brk_down) );
    }

}

?>
