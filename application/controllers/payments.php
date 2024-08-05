<?php

require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");

class Payments extends Secure_area implements iData_controller {

    function __construct()
    {
        parent::__construct('payments');
    }

    function index()
    {
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
            
        $this->load->view('payments/manage', $data);
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

    function view($payment_id = -1)
    {
        $payment_info = $this->payment->get_info($payment_id);

        $data['payment_info'] = $payment_info;

        $res = $this->db->where('delete_flag', 0)->get("apartments")->result();

        $data['breakdown'] = null;

        $data['paid_for'] = null;

        if(json_decode($payment_info->breakdown)){

            $data['breakdown'] = json_decode($payment_info->breakdown);
        }

        if(json_decode($payment_info->paid_for)){

            $data['paid_for'] = json_decode($payment_info->paid_for);
        }

        $this->load->view("payments/form", $data);
    }

    function printReceipt($payment_id = -1)
    {
        $payment = $this->payment->get_info($payment_id);
        $apartment = $this->apartment->get_info($payment->apartment_id);
        $person = $this->Person->get_info($payment->teller_id);
        $user = $this->Person->get_info($this->session->userdata('person_id'));
        $tenant = $this->Person->get_info($payment->tenant_id);

        // pdf viewer 
        $data['payment_id'] = $payment->payment_id;

        $data['client'] = ucwords($tenant->first_name." ".$tenant->last_name);

        $data['account'] = $tenant->person_id;

        $data['apartment_id'] = $payment->apartment_id;

        $data['amount_paid'] = to_currency($payment->amount, true, 0);

        $data['trans_date'] = date("d/m/Y", strtotime($payment->date_paid));

        $data['paid_by'] = ucwords($payment->paid_by);

        $data['method'] = ucwords($payment->payment_method);

        $data['breakdown'] = json_decode($payment->breakdown);

        $data['teller'] = strtoupper($person->first_name);
        

        $filename = "payments_".date("ymdhis");

        // As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/

        $pdf = $this->pdf->load();

        $pdfFilePath = FCPATH . "/downloads/reports/$filename.pdf";
        
        $html = $this->load->view('payments/receipt', $data, true); // render the view into HTML

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $pdf->setAuthor('Vintex technologies');

        $pdf->setTitle('Payment Receipt');

        $pdf->setSubject('Receipt');

        $pdf->Output($pdfFilePath, 'F'); // save to file because we can

        //end of pdf viewer

        $data['pdf_file'] = "downloads/reports/$filename.pdf";


        $this->load->view("payments/manage", $data);
    }


    function printIt($payment_id = -1)
    {
        $payment = $this->payment->get_info($payment_id);
        $apartment = $this->apartment->get_info($payment->apartment_id);
        $person = $this->Person->get_info($payment->teller_id);
        $tenant = $this->Person->get_info($payment->tenant_id);


        // pdf viewer 
        $data['payment_id'] = $payment->apartment_payment_id;

        $data['client'] = ucwords($tenant->first_name." ".$tenant->last_name);

        $data['account'] = $apartment->tenant_id;

        $data['apartment_id'] = $payment->apartment_id;

        // apartment DETAILS

        $amount_paid = $this->db->select_sum('amount')->where('apartment_id', $payment->apartment_id)->where('UNIX_TIMESTAMP(date_paid) >', strtotime($payment->date_paid))->where('delete_flag', 0)->get('payments')->row()->amount;

        $apartment_interest = (($apartment->monthly_rate/30) * $apartment->apartment_amount) * round((time() - strtotime($apartment->date_applied))/(24*60*60));

        $data['apartment_balance'] = ($apartment->apartment_amount + $apartment_interest ) - $amount_paid;

        $data['amount_paid'] = to_currency($amount_paid, true);

        //apartment DETAILS

        $data['apartment_amount'] = to_currency($apartment->apartment_amount, true);

        $data['interest'] = to_currency($apartment_interest, true);

        $data['expected_payment'] = to_currency($apartment_interest + $apartment->apartment_amount, true);

        $data['paid'] = to_currency($payment->amount, true);

        $data['trans_date'] = date("d/m/Y", strtotime($payment->date_paid));


        $data['new_balance'] = to_currency($data['apartment_balance'] - $payment->amount, true);


        $data['teller'] = $person->first_name . " " . $person->last_name;

        $filename = "payments_".date("ymdhis");
        // As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
        $pdfFilePath = FCPATH . "/downloads/reports/$filename.pdf";
        
        $html = $this->load->view('payments/pdf_report', $data, true); // render the view into HTML

        $pdf = $this->pdf->load('UTF-8', 'A4',9, 'calibri');

        $pdf->SetFooter('@ Rekimu Credit Ltd '.date('Y').'<br><small style="color:#eee; font-family:ocrb"> - Generated by apam </small>|{PAGENO}|' . 'Mutungoni Bldg Rm. 32, Mwatu Wa Ngoma Strt'); 


        $pdf->WriteHTML(file_get_contents('css/style.css'), 1); 

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $pdf->Output($pdfFilePath, 'F'); // save to file becase we can

        //end of pdf viewer
        //$data['pdf_file'] = FCPATH ."/downloads/reports/$filename.pdf";
        $data['pdf_file'] = "downloads/reports/$filename.pdf";


        $this->load->view("payments/manage", $data);
    }

    function save($payment_id = -1)
    {

        $breakdown = array('deposit' => $this->input->post('deposit'), 'rent' => $this->input->post('rent'));

        $paid_for = array('month' => $this->input->post('month'), 'year' => $this->input->post('year'));

        $payment_data = array(
            'house_id' => $this->input->post('house_id'),
            'tenant_id' => $this->input->post('tenant'),
            'amount' => $this->input->post('amount'),
            'breakdown' => json_encode($breakdown),
            'paid_for' => json_encode($paid_for),
            'payment_method' => $this->input->post('payment_method'),
            'paid_by' => $this->input->post('paid_by'),
            'date_paid' => date('Y-m-d', strtotime($this->input->post('date_paid'))),
            'remarks' => $this->input->post('remarks'),
            'teller_id' => $this->input->post('teller')
        );

        if ($this->input->post("apartment_payment_id") > 0)
        {
            $payment_data['apartment_payment_id'] = $this->input->post('apartment_payment_id');
        }

        // transactional to make sure that everything is working well
        $this->db->trans_start();

        if ($this->payment->save($payment_data, $payment_id))
        {
            //New Payment
            if ($payment_id == -1)
            {
                
                echo json_encode(array('success' => true, 'message' => 'Payment saved successfully', 'apartment_payment_id' => $payment_data['apartment_payment_id']));
                $payment_id = $payment_data['apartment_payment_id'];
            }
            else //previous apartment
            {
                
                echo json_encode(array('success' => true, 'message' => 'Payment updated successfully', 'apartment_payment_id' => $payment_id));
            }
        }
        else//failure
        {
            echo json_encode(array('success' => false, 'message' => 'Failed! Error while updating payment', 'apartment_payment_id' => -1));
        }
        
        $this->db->trans_complete();
    }

    function delete()
    {
        $payments_to_delete = $this->input->post('ids');

        if ($this->payment->delete_list($payments_to_delete))
        {
            echo json_encode(array('success' => true, 'message' => 'Payment(s) successfully deleted ' .' ' . $this->lang->line('payments_one_or_multiple')));
        }
        else
        {
            echo json_encode(array('success' => false, 'message' => 'Sorry! Payment(s) cannot be deleted'));
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
        $sel_user = $this->input->get("staff_id");
        $index = isset($_GET['order'][0]['column']) ? $_GET['order'][0]['column'] : 1;
        $dir = isset($_GET['order'][0]['dir']) ? $_GET['order'][0]['dir'] : "asc";
        $order = array("index" => $index, "direction" => $dir);
        $length = isset($_GET['length'])?$_GET['length']:50;
        $start = isset($_GET['start'])?$_GET['start']:0;
        $key = isset($_GET['search']['value'])?$_GET['search']['value']:"";

        $payments = $this->payment->get_all($length, $start, $key, $order, $sel_user);

        $format_result = array();

        foreach ($payments->result() as $payment)
        {
            $apartment = $this->apartment->get_info($payment->apartment_id);

            $breakdown = json_decode($payment->breakdown);

            $format_result[] = array(

                "<input type='checkbox' name='chk[]' id='payment_'".$payment->payment_id."' value='" . $payment->payment_id . "'/>",

                $payment->payment_id,

                $payment->tenant_id,

                ucwords($payment->tenant_name),

                ucwords($payment->apartment_name),

                to_currency($payment->amount, true, 0),

                ($payment->paid_by != "") ? $payment->paid_by : "N/A",

                '<span class="dropdown" title="view More">

                    <a href="#" class="dropdown-toggle fa fa-plus-circle" style="color: #e9573f; font-size: 16px; " data-toggle="dropdown" aria-expanded="true">
                    </a>

                    <ul class="dropdown-menu m-t-xs" style="border-radius: 0px; pointer-events: none;">

                        <li><a href="#"><strong>Payment Summary</a></strong></li>

                        <li class="divider"></li>

                        <li><a href="#">Deposit : '. to_currency($breakdown->deposit, true, 0) .'</a></li>

                        <li><a href="#">Rent : '. to_currency($breakdown->rent, true, 0) .'</a></li>

                    </ul>

                </span>',

                date("d M Y", strtotime($payment->date_paid)),

                ucwords(preg_replace("/_/", " ", $payment->payment_method)),
                "<div style='display:flex;align-items:center'>".anchor('payments/view/' . $payment->payment_id, "<span class='fa fa-search-plus'></span>", array('class' => 'btn-success btn-sm effect-1', "title" => 'Payment details')).
                anchor('payments/printReceipt/' . $payment->payment_id, "<span class='fa fa-print'></span>", array('class' => 'modal_link btn-warning btn-sm effect-1 pull-right',  "title" => 'Print Receipt'))."</div>"
            );
        }

        echo json_encode($format_result);
        exit;
    }

    function get_apartments($tenant_id)
    {

        $apartments = $this->payment->get_apartments($tenant_id);

        // $array_result = array();

        // foreach ($apartments as $apartment)
        // {
            
        //     // $amount_paid = $this->db->select_sum('amount')->where('apartment_id', $apartment->apartment_id)->where('delete_flag', 0)->get('payments')->row()->amount;

        //     $apartment_balance = $this->apartment->get_apartment_balance($apartment->apartment_id);

        //     $apartment->date_applied = date("d M, Y", strtotime($apartment->date_applied));
        //     $apartment->payment_date = date("d M, Y", strtotime($apartment->payment_date));
        //     $apartment->apartment_type = (trim($apartment->apartment_type) !== "")? $apartment->apartment_type : "";

        //     if($apartment_balance > 0){

        //         array_push($array_result, $apartment);

        //     }
        // }

        echo json_encode($apartments->row());
    }

    function get_tenant($tenant_id)
    {
        $tenant = $this->tenant->get_info($tenant_id);
        $suggestion['data'] = $tenant->person_id;
        $suggestion['value'] = $tenant->first_name . " " . $tenant->last_name;

        echo json_encode($suggestion);

        exit;
    }    

    function tenant_search()
    {
        $suggestions = $this->tenant->get_tenant_search_suggestions($this->input->get('query'), 30);
        $data = $tmp = array();

        foreach ($suggestions as $suggestion):
            $t = explode("|", $suggestion);
            $tmp = array("value" => $t[1], "data" => $t[0]);
            $data[] = $tmp;
        endforeach;

        echo json_encode(array("suggestions" => $data));
        exit;
    }

   

}

?>