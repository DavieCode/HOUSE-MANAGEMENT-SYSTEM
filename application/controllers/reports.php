<?php

require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");

class Reports extends Secure_area{

    function __construct()
    {
        parent::__construct('reports');

    }

    function index()
    {       

        $data['controller_name'] = strtolower(get_class());

        $data['report_types'] = array('staffs', 'apartments', 'payments', 'tenants');

        $this->load->view('reports/manage', $data);
    }

    public function staffs($from = '', $to = '')
    {
        $this->db->from('staffs');

        $this->db->join('people', 'people.person_id = staffs.person_id');

        
        $data['data'] = $this->db->get()->result();

        //var_dump($data['data']);

        $this->load->view('reports/manage', $data);
    }




    function printIt($type = 'apartments')
    {

        $data['teller'] = $person->first_name . " " . $person->last_name;

        $data['report_types'] = array('staffs', 'apartments', 'payments', 'tenants');

        $filename = $type."_".date("ymdhis");
        // As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
        $pdfFilePath = FCPATH . "/downloads/reports/$filename.pdf";

        ini_set('memory_limit', '32M'); // boost the memory limit if it's low <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">

        if ($type == 'tenants' || $type == 'staffs') {

            $this->db->from('people');

            $this->db->join($type, $type.'.person_id = people.person_id');

            $data['data'] = $this->db->get()->result();
        
        }else if($type == 'apartments'){

            $apartments = $this->db->get('apartments')->result();

            $Output = '';

            $count=1;

            foreach ($apartments as $apartment){

                $tenant = $this->db->where('person_id', $apartment->tenant_id)->get('people')->row();
            
                // PAYABLE AMOUNT

                $amount_paid = $this->db->select_sum('amount')->where('apartment_id', $apartment->apartment_id)->get('payments')->row()->amount;

                $interest = (($apartment->monthly_rate) * $apartment->apartment_amount) * round((strtotime($apartment->payment_date) - strtotime($apartment->date_applied))/(30*24*60*60));

                $to_pay = $apartment->apartment_amount + $interest;

                $data['apartment_balance'] = $to_pay - $amount_paid;

                //PAYMENT STATUS

                if($data['apartment_balance'] < $to_pay && $data['apartment_balance'] > 0){

                    $apartment_status = 'On payment';

                }else if($data['apartment_balance'] == 0){

                    $apartment_status = 'Paid';

                }else if($data['apartment_balance'] == $to_pay){

                    $apartment_status = 'Unpaid';
                }

                $Output .= '<tr>

                    <td width="30">'.$count.'</td>

                    <td width="140">'.$tenant->first_name.' '.$tenant->last_name.'</td>

                    <td width="100">'.to_currency($apartment->apartment_amount, true, 0).'</td>

                    <td width="100">'.to_currency($interest, true, 0).'</td>

                    <td width="100">'.$apartment->date_applied.'</td>

                    <td width="100">'.$apartment->payment_date.'</td>

                    <td width="100">'.$apartment_status.'</td>

                    </tr>';

                $count++;

            }

            $data['apartment_data'] = $Output;

        }else if($type == 'payments'){

                $payments = $this->db->get('payments')->result();

                $Output = '';

                $count = 1;

                foreach ($payments as $payment) {
                    
                    $apartment = $this->db->where('apartment_id', $payment->apartment_id)->get('apartments')->row();
                    $person = $this->db->where('person_id', $payment->teller_id)->get('people')->row();
                    $tenant = $this->db->where('person_id', $apartment->tenant_id)->get('people')->row();

                    $tenant = ucwords($tenant->first_name." ".$tenant->last_name);

                    // apartment DETAILS

                    $amount_paid = $this->db->select_sum('amount')->where('apartment_id', $payment->apartment_id)->where('UNIX_TIMESTAMP(date_paid) >=', strtotime($payment->date_paid))->get('payments')->row()->amount;

                    $apartment_interest = (($apartment->monthly_rate) * $apartment->apartment_amount) * round((strtotime($apartment->payment_date) - strtotime($apartment->date_applied))/(30*24*60*60));

                    $apartment_balance = ($apartment->apartment_amount + $apartment_interest ) - $amount_paid;

                    $amount_paid = to_currency($amount_paid, true);

                    $trans_date = date("d/m/Y", strtotime($payment->date_paid));


                    $teller = $person->first_name . " " . $person->last_name;

                    $Output .= '<tr>

                        <td width="30">'.$count.'</td>

                        <td width="140">'.$tenant.'</td>

                        <td width="100">'.to_currency($apartment->apartment_amount, true, 0).'</td>

                        <td width="100">'.to_currency($payment->amount, true, 0).'</td>

                        <td width="100">'.to_currency($apartment_balance, true, 0).'</td>

                        <td width="100">'.$trans_date.'</td>

                        <td width="100">'.$teller.'</td>

                        </tr>';

                    $count++;
                }

                $data['payment_data'] = $Output;

        }

        $data['type'] = $type;

        $html = $this->load->view('reports/people_report', $data, true); // render the view into HTML

        $this->load->library('pdf');

        $pdf = $this->pdf->load();

        $pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}|' . date(DATE_RFC822)); 

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $pdf->Output($pdfFilePath, 'F'); // save to file because we can

        //end of pdf viewer
        //$data['pdf_file'] = FCPATH ."/downloads/reports/$filename.pdf";
        $data['pdf_file'] = "downloads/reports/$filename.pdf";


        $this->load->view("reports/manage", $data);
    }

}

?>