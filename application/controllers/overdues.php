<?php

require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");

class Overdues extends Secure_area implements iData_controller {

    function __construct()
    {
        parent::__construct('overdues');
    }

    function index()
    {
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();

        $this->load->view('payments/overdues', $data);
    }

    function search()
    {
        
    }

    /*
      Gives search suggestions based on what is being searched for
     */

    function suggest()
    {
        
    }

    function get_row()
    {
        
    }

    function view($apartment_id = -1)
    {
       
        $data['staffs'] = $emps;

        $this->load->view("apartments/form", $data);
    }

    function save($apartment_id = -1)
    {
    }

    function delete()
    {
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

        // $sel_user = $this->input->get("staff_id");

        $payments = $this->payment->get_overdues()->result();

        // var_dump($payments);

        $format_result = array();

        // //GET LATEST PRINCIPAL AND INTEREST
        
        foreach ($payments as $payment) {

            $months = array(
                '1'=>'January',
                '2'=>'February',
                '3'=>'March',
                '4'=>'April',
                '5'=>'May',
                '6'=>'June',
                '7'=>'July',
                '8'=>'August',
                '9'=>'September',
                '10'=>'October',
                '11'=>'November',
                '12'=>'December',
            );

            $due_date = date("5, M,y");

            $balance = ($payment->amount_payable - $payment->amount_paid);

            $month = json_decode($payment->month);

            $de = $month->month;

            $due_month = $months[$de];

            if($payment->date_moved == 0){

                $status = "resident";

            }else{

                $status = "moved";

            }

            if($status == "resident" && $balance > 0 && $payment->tenant_delete_flag == 0 && $payment->payment_delete_flag == 0){

                    $format_result[] = array(
                    "<input type='checkbox' name='chk[]' id='payment_$payment->payment_id' value='" . $payment->payment_id . "'/>",
                    $payment->accnt,
                    ucwords($payment->tenant_name),
                    ucwords($payment->apartment_name),
                    to_currency($payment->amount_payable, true, 0),
                    to_currency($payment->amount_paid, true, 0),
                    to_currency($balance, true, 0),
                    $due_date,
                    $due_month,
                    "<div style='display:flex; align-items:center'>".anchor('payments/view/' . $payment->payment_id, '<span class="fa fa-search-plus"></span>', array('class' => 'btn-success btn-sm effect-1', 'title' => 'payment details'))."</div>"
                );

                // var_dump($payment->tenant_name);

                // var_dump($balance);

            }

           
        }
                

        echo json_encode($format_result);
        
        exit;
    }


    function select_tenant()
    {
        $tenant_id = $this->input->post("tenant");
        $this->sale_lib->set_tenant($tenant_id);
        $this->_reload();
    }

    function upload()
    {
        $directory = FCPATH . 'uploads/apartment-' . $_REQUEST["apartment_id"] . "/";
        $this->load->library('uploader');
        $data = $this->uploader->upload($directory);

        $this->apartment->save_attachments($data['params']['apartment_id'], $data);

        $file = $this->_get_formatted_file($data['attachment_id'], $data['filename'], "");
        $file['apartment_id'] = $data['params']['apartment_id'];
        $file['id'] = $data["attachment_id"];

        echo json_encode($file);
        exit;
    }

    function remove_file()
    {
        $file_id = $this->input->post("file_id");
        echo json_encode(array("status" => $this->apartment->remove_file($file_id)));
        exit;
    }

    function attach_desc()
    {
        $id = $this->input->post("attach_id");
        $desc = $this->input->post("desc");
        $this->apartment->save_attach_desc($id, $desc);
        echo json_encode(array("success" => TRUE));
        exit;
    }

    function attachments($apartment_id, $select_type)
    {
        $data['apartment_info'] = $this->apartment->get_info($apartment_id);
        $attachments = $this->apartment->get_attachments($apartment_id);

        $file = array();
        foreach ($attachments as $attachment)
        {
            $file[] = $this->_get_formatted_file($attachment->attachment_id, $attachment->filename, $attachment->descriptions);
        }

        $data["select_type"] = $select_type;
        $data['attachments'] = $file;
        $this->load->view("apartments/attachments", $data);
    }

}

?>