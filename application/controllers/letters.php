<?php

require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");

class Letters extends Secure_area implements iData_controller {

    function __construct()
    {
        parent::__construct('letters');

    }

    function index()
    {
        $data['controller_name'] = strtolower(get_class());
                    
        $this->load->view('letters/manage', $data);
    }

    function search(){

    }

    function suggest(){

    }

    function view($letter_id = -1){
           
        $letter_info = $this->letter->get_info($letter_id);

        $data['letter_id'] = $letter_id;

        $data['letter_info'] = $letter_info;

        $this->load->view('letters/form', $data);

    }

    function save($letter_id = -1){

        $letter_data = array(
            
            'subject' => $this->input->post('subject'),
            
            'address' => $this->input->post('address'),

            'message' => $this->input->post('message'),

            'created_by' => $this->input->post('created_by'),

            'date_created' => date('Y-m-d', strtotime($this->input->post('date_created')))
        );

        // transactional to make sure that everything is working well
        $this->db->trans_start();

        if ($this->letter->save($letter_data, $letter_id))
        {
            //New Payment
            if ($letter_id == -1)
            {
                
                echo json_encode(array('success' => true, 'message' => 'letter saved successfully', 'letter_id' => $letter_data['letter_id']));
            }
            else //previous apartment
            {
                
                echo json_encode(array('success' => true, 'message' => 'letter updated successfully', 'letter_id' => $letter_id));
            }
        }
        else//failure
        {
            echo json_encode(array('success' => false, 'message' => 'Failed! Error while updating letter', 'letter_id' => -1));
        }
        $this->db->trans_complete();

    }

    // Generate letter printOut

    function printIt($letter_id){

        $data['letter_info'] = $this->letter->get_info($letter_id);

        $filename = "letter_".date("ymdhis");

        $pdfFilePath = FCPATH . "/downloads/reports/$filename.pdf";

        $html = $this->load->view('letters/letter_design', $data, true);

        $pdf = $this->pdf->load('UTF-8', 'A4',9, 'calibri');

        $pdf->SetFooter('@ Rekimu Credit Ltd '.date('Y').'| |' . 'Mutungoni Bldg Rm. 32, Mwatu Wa Ngoma Strt'); 

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $pdf->Output($pdfFilePath, 'F'); // save to file because we can

        //end of pdf viewer
        $data['letter_design'] = "downloads/reports/$filename.pdf";

        $data['letter_id'] = $letter_id;

        $this->load->view("letters/form", $data);
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
        

        $letters = $this->letter->get_all();

        // var_dump($letters);

        $format_result = array();

        foreach ($letters as $letter)
        {

            $staff = $this->db->where("person_id", $letter->created_by)->get('people')->row();
            
            $format_result[] = array(
                "<input type='checkbox' name='chk[]' id='letter_'".$letter->letter_id."' value='" . $letter->letter_id . "'/>",

                "RC/".$letter->letter_id . "/". date('Y'),

                ucwords($letter->address),

                ucwords($letter->subject),

                ucwords($letter->message),

                ucwords($staff->first_name ." ". $staff->last_name),

                date("d M Y", strtotime($letter->date_created)),

                "<div class='text-center' style='display:flex;align-items:center'>".anchor('letters/view/' . $letter->letter_id, "<span class='fa fa-search-plus'></span>", array('class' => 'btn-success btn-sm effect-1', "title" => 'letter details'))."</div>"
            );
        }

        echo json_encode($format_result);
    }

    function get_row($letter_id = -1)
    {
        $letter = $this->db->where('letter_id', $letter_id)->get('letter')->row();

        echo json_encode($letter);
        exit;
    }

    function delete($letter_id = -1)
    {
        $letters_to_delete = $this->input->post('ids');
        
        if ($this->db->where_in('letter_id', $letters_to_delete)->delete('letters'))
        {
            echo json_encode(array('success' => true, 'message' => 'letter deleted successfully'));
        }
        else
        {
            echo json_encode(array('success' => false, 'message' => 'Sorrry, this letter cannot be deleted!'));
        }
        
    }

}

?>