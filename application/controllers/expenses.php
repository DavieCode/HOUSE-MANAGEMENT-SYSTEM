<?php

require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");

class Expenses extends Secure_area implements iData_controller {

    function __construct()
    {
        parent::__construct('expenses');

    }

    function index()
    {
        $data['controller_name'] = strtolower(get_class());
                    
        $this->load->view('expenses/manage', $data);
    }

    function search(){

    }

    function suggest(){

    }

    function view($expense_id = -1){

        if ($expense_id > 0) {
            
            $expense_info = $this->expense->get_info($expense_id);

        }

        $data['expense_id'] = $expense_id;

        $data['expense_info'] = $expense_info;

        $this->load->view('expenses/form', $data);

    }

    function save($expense_id = -1){

        $expense_data = array(
            
            'category' => $this->input->post('category'),
            
            'description' => $this->input->post('description'),

            'amount' => $this->input->post('amount'),

            'added_by' => $this->input->post('added_by'),

            'date' => date('Y-m-d', strtotime($this->input->post('date')))
        );

        // transactional to make sure that everything is working well
        $this->db->trans_start();

        if ($this->expense->save($expense_data, $expense_id))
        {
            //New Payment
            if ($expense_id == -1)
            {
                
                echo json_encode(array('success' => true, 'message' => 'Expense added successfully', 'expense_id' => $expense_data['expense_id']));
            }
            else //previous apartment
            {
                
                echo json_encode(array('success' => true, 'message' => 'Expense updated successfully', 'expense_id' => $expense_id));
            }
        }
        else//failure
        {
            echo json_encode(array('success' => false, 'message' => 'Failed! Error while updating expense', 'expense_id' => -1));
        }
        $this->db->trans_complete();

    }

    public function save_categories()
    {
        $categories = json_encode($this->input->post("categories"));

        if ($this->Appconfig->save("expense_categories", $categories))
        {
            echo json_encode(array('success' => true, 'message' => 'Expense categories updated'));

        }else{

            echo json_encode(array('success' => false, 'message' => 'Failed! Error while Saving category'));
        }
    }


    /*
      get the width for the add/edit form
     */

    function get_form_width()
    {
        return 360;
    }

    function data()
    {
        
        $sel_user = '';
        $index = isset($_GET['order'][0]['column']) ? $_GET['order'][0]['column'] : 1;
        $dir = isset($_GET['order'][0]['dir']) ? $_GET['order'][0]['dir'] : "asc";
        $order = array("index" => $index, "direction" => $dir);
        $length = isset($_GET['length'])?$_GET['length']:50;
        $start = isset($_GET['start'])?$_GET['start']:0;
        $key = isset($_GET['search']['value'])?$_GET['search']['value']:"";


        $expenses = $this->expense->get_all($length, $start, $key, $order, $sel_user);

        //var_dump($expenses);

        $format_result = array();

        foreach ($expenses as $expense)
        {

            $staff = $this->db->where("person_id", $expense->added_by)->get('people')->row();
            
            $format_result[] = array(
                "<input type='checkbox' name='chk[]' id='expense_'".$expense->expense_id."' value='" . $expense->expense_id . "'/>",

                $expense->expense_id,

                ucwords($expense->category),

                ucwords($expense->description),

                to_currency($expense->amount, true , 0),

                ucwords($staff->first_name ." ". $staff->last_name),

                date("d M Y", strtotime($expense->date)),

                "<div class='text-center' style='display:flex;align-items:center'>".anchor('expenses/view/' . $expense->expense_id, "<span class='fa fa-search-plus'></span>", array('class' => 'btn-success btn-sm effect-1', "title" => 'Expense details'))."</div>"
            );
        }

        echo json_encode($format_result);
        exit;
    }

    function get_row($expense_id = -1)
    {
        $expense = $this->db->where('expense_id', $expense_id)->get('expense')->row();

        echo json_encode($expense);
        exit;
    }

    function delete($expense_id = -1)
    {
        $expenses_to_delete = $this->input->post('ids');
        
        if ($this->db->where_in('expense_id', $expenses_to_delete)->delete('expenses'))
        {
            echo json_encode(array('success' => true, 'message' => 'Expense deleted successfully'));
        }
        else
        {
            echo json_encode(array('success' => false, 'message' => 'Sorrry, this Expense cannot be deleted!'));
        }
        
    }

}

?>