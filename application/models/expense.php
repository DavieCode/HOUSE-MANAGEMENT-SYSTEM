<?php

class Expense extends CI_Model {

    /*
      Determines if a given expense_id is an expense
     */

    function exists($expense_id)
    {
        $this->db->where('expense_id', $expense_id);

        $query = $this->db->get('expenses');

        return ($query->num_rows() > 0);
    }

    /*
      Returns all the expenses
     */

    function get_all($limit = 10000, $offset = 0, $search = "", $order = array())
    {
        //$sorter = array("", "expense_id", "description", "added_by", "date");

        $this->db->from('expenses');
        $this->db->where('delete_flag', 0);


        if ($search !== "")
        {
            $this->db->where('description LIKE ', '%' . $search . '%');
            $this->db->or_where('date LIKE', '%' . $search . '%');
            $this->db->or_where('added_by LIKE', '%' . $search . '%');
            $this->db->or_where('amount LIKE', '%' . $search . '%');
        }

        $this->db->order_by("date", "desc");        

        // $this->db->limit($limit);

        // $this->db->offset($offset);

        return $this->db->get()->result();
    }

    function count_all()
    {
        $this->db->where('delete_flag', 0);

        return $this->db->count_all_results('expenses');
    }

    /*
      Gets information about a particular expense
     */

    function get_info($expense_id)
    {

        $this->db->from('expenses');
        $this->db->where('expense_id', $expense_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            return $query->row();
        }

    }

    /*
      Gets information about multiple expenses
     */

    function get_multiple_info($expense_ids)
    {
        $this->db->from('expenses');
        $this->db->where_in('expense_id', $expense_ids);
        $this->db->order_by("date", "asc");
        return $this->db->get();
    }

    /*
      Inserts or updates an expense
     */

    function save($expense_data, $expense_id = false)
    {
        
        if ($expense_id == -1)
        {
            if ($this->db->insert('expenses', $expense_data))
            {
                $expense_data['expense_id'] = $this->db->insert_id();

                return true;
            }

            return false;

        }

        $this->db->where('expense_id', $expense_id);

        return $this->db->update('expenses', $expense_data);

    }

    /*
      Deletes one expense
     */

    function delete($expense_id)
    {
        $this->db->where('expense_id', $expense_id);
        return $this->db->update('expenses', array('delete_flag' => 1));
    }

    /*
      Deletes a list of expenses
     */

    function delete_list($expense_ids)
    {
        $this->db->where_in('expense_id', $expense_ids);
        return $this->db->update('expenses', array('delete_flag' => 1));
    }

    /*
      Preform a search on expenses
     */

    function search($search)
    {
        $this->db->from('expenses');
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

        $query = $this->db->get('expenses');

        $res = $query->row();

        $previous_week = $this->db->select_sum('amount')->where("DATE_FORMAT(date , '%Y-%m-%d') <= ", $startDate)->where("DATE_FORMAT(date , '%Y-%m-%d') > ", $startDate2)->where('delete_flag', 0)->get('expenses')->row()->amount;

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

        $expense_breakdown = $this->db->group_by('category')->get('expenses')->result();

        $brk_down = array();

        foreach ($expense_breakdown as $rec) {

            $record = array(ucwords($rec->category), to_currency($rec->amount, true, 0) );
            
            array_push($brk_down, $record);

        }

        return json_encode(array($res->amount, abs(round($increase)), $status, $brk_down) );
    }

    public function get_expense_total()
    {
        $query = $this->db->get('expenses');

        $res = $this->db->select_sum('amount')->get('expenses')->row()->amount;

        return $res;
    }

    function summary(){
        $name = "Malindi Wambua";
    }

    public function getTotalExpenses()
    {

        $this->db->where('delete_flag', 0);

        $expenses = $this->db->select_sum('amount')->get('expenses')->row()->amount;

        return $expenses;
    }

}

?>
