<?php

require_once ("secure_area.php");

class Home extends Secure_area {

    function __construct()
    {
        parent::__construct('home');
    }

    function index($startDate = '' , $endDate = '', $duration = '')
    {   

        $data['payments'] = $this->payment->getTotalPayments();

        $data['expenses'] = $this->expense->getTotalExpenses();

        $data['hostels_count'] = $this->apartment->count_all();

        $data['income'] = $this->payment->getTotalPayments() - $this->expense->getTotalExpenses();

        $this->load->view("home", $data);
    }

    function logout()
    {
        $this->staff->logout();
    }

    public function getTotalExpenses()      
    {
        $expenses = $this->expense->get_expense_total();

        var_dump($expenses);
    }

    function getStats($timestamp = ''){

        $apartments = 0;

        $payments = 0;

        $expenses = 0;

        $stats = "";

        if (!strtotime($timestamp)) {
            
            $timestamp = date('Y-m-d', time());

        }

        $apartments = $this->db->select_sum('apartment_amount')->where('date_applied', $timestamp)->where('delete_flag', 0)->get('apartments')->row()->apartment_amount;

        $stats .= "<tr><td>apartments </td><td>".to_currency($apartments, true, 0)."</td></tr>";

        $payment = $this->db->where('date_paid', $timestamp)->where('delete_flag', 0)->get('payments')->result();

        $payments = $principal = $interest = $renewal = $penalty = $income = 0 ;

        foreach ($payment as $record) {

            $payments += $record->amount;

            $breakdown = json_decode($record->breakdown);

            $principal += $breakdown->principal;

            $interest += $breakdown->interest;

            $renewal += $breakdown->renewal;

            $penalty += $breakdown->penalty;
            
        }

        $income = $interest + $renewal + $penalty;

        // var_dump($payment);

        $stats .='<tr><td>Payments 

                    <span class="dropdown badge badge" style="background: transparent;" title="More Info.">

                        <span class="dropdown-toggle fa fa-plus-circle text-success" style="font-size: 13px; position: absolute;top: -3.5px" data-toggle="dropdown" aria-expanded="true">
                        </span>

                        <ul class="dropdown-menu m-t-xs" style="border-radius: 0px; pointer-events: none;z-index: 2002">

                            <li><a href="#"><strong>Payment summary</a></strong></li>

                            <li class="divider"></li>

                            <li><a href="#">Principal : '.to_currency($principal, true, 0).'</a></li>

                            <li><a href="#">Interest : '.to_currency($interest, true, 0) .'</a></li>

                            <li><a href="#">Penalty : '.to_currency($penalty, true, 0) .'</a></li>

                            <li><a href="#">Appraisal : '.to_currency($renewal, true, 0) .'</a></li>

                        </ul>

                    </span>

        </td><td>'.to_currency($payments, true, 0)."</td></tr>";

        $expense_breakdown = $this->db->select_sum('amount')->select('category')->where('date', $timestamp)->where('delete_flag', 0)->group_by('category')->get('expenses')->result();

        $expense_total = $this->db->select_sum('amount')->where('date', $timestamp)->where('delete_flag', 0)->get('expenses')->row()->amount;

        $profit = $income - $expense_total;

        $exp_brkdn = '';

        foreach ($expense_breakdown as $exp) {

            $exp_brkdn .= '<li><a href="#">'. ucwords($exp->category).' : '.to_currency($exp->amount, true, 0).'</a></li>';
            
        }

        $stats .='<tr><td>Expenses 

                    <span class="dropdown badge badge" style="background: transparent;" title="More Info.">

                        <span class="dropdown-toggle fa fa-plus-circle text-success" style="font-size: 13px; position: absolute;top: -3.5px" data-toggle="dropdown" aria-expanded="true">
                        </span>

                        <ul class="dropdown-menu m-t-xs" style="border-radius: 0px; pointer-events: none;z-index: 2002">

                            <li><a href="#"><strong>Expense summary</a></strong></li>

                            <li class="divider"></li>

                            '.$exp_brkdn.'

                        </ul>

                    </span>

        </td><td>'.to_currency($expense_total, true, 0)."</td></tr>";
        $stats .="<tr><td> </td><td></td></tr>";
        $stats .="<tr><td>Income </td><td>".to_currency($income, true, 0)."</td></tr>";
        $stats .="<tr><td>Profit </td><td>".to_currency($profit, true, 0)."</td></tr>";

        $date = date('d M, Y', strtotime($timestamp));

        $res = array('date' => $date, 'data' => $stats);

        echo json_encode($res);
    }

    function printIt($startDate = '' , $endDate = '', $duration = ''){

        $data["total_apartments"] = json_decode($this->apartment->get_total_apartments_by_range($startDate , $endDate))[0];


        $data["expense"] = json_decode($this->expense->get_total_by_range($startDate , $endDate))[0];

        $expense_breakdown = json_decode($this->expense->get_total_by_range($startDate , $endDate))[3];


        $data["payment_total"] = json_decode($this->payment->get_total_by_range($startDate , $endDate))[0];

        $payment_breakdown = json_decode($this->payment->get_total_by_range($startDate , $endDate))[3];


        // income = payments

        $income = json_decode($this->payment->get_total_by_range($startDate , $endDate))[4];

        $data['income'] = $income;

        // expenses = apartments + expenses

        $expenditure = $data['expense'];

        $data['expenditure'] = $expenditure;

        $data['expense_breakdown'] = $expense_breakdown;

        $data['payment_breakdown'] = $payment_breakdown;

        $data['date_range'] = date("d M, Y", strtotime($startDate)). " - ". date("d M, Y", strtotime($endDate));

        // profit = income - expenses

        $profit = $income - $expenditure;

        $data['profit'] = $profit;

        $filename = "gen_report_".date("ymdhis");

        // As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
        $pdfFilePath = FCPATH . "/downloads/reports/$filename.pdf";
        
        $html = $this->load->view('gen_report', $data, true); // render the view into HTML

        $pdf = $this->pdf->load('UTF-8', 'A4',9, 'calibri');

        $pdf->SetFooter('@ Rekimu Credit Ltd '.date('Y').'<br><small style="color:#eee; font-family:ocrb"> - Generated by apam </small>|{PAGENO}|' . 'Mutungoni Bldg Rm. 32, Mwatu Wa Ngoma Strt'); 

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $pdf->Output($pdfFilePath, 'F'); // save to file because we can

        //end of pdf viewer
        //$data['pdf_file'] = FCPATH ."/downloads/reports/$filename.pdf";

        $data['pdf_file'] = "downloads/reports/$filename.pdf";


        $this->load->view("home", $data);
    }

}

?>