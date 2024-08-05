<?php

require_once ("person_controller.php");

class tenants extends Person_controller {

    function __construct()
    {
        parent::__construct('tenants');

    }

    function index()
    {
        $config['base_url'] = site_url('/tenants/index');
        $config['total_rows'] = $this->tenant->count_all();
        $config['per_page'] = '20';
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        

        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['manage_table'] = get_people_manage_table($this->tenant->get_all($config['per_page'], $this->uri->segment($config['uri_segment'])), $this);
        $this->load->view('people/manage', $data);
    }

    /*
      Returns tenant table data rows. This will be called with AJAX.
     */

    function search()
    {
        $search = $this->input->post('search');
        $data_rows = get_people_manage_table_data_rows($this->tenant->search($search), $this);
        echo $data_rows;
    }

    /*
      Gives search suggestions based on what is being searched for
     */

    function suggest()
    {
        //$suggestions = $this->tenant->get_search_suggestions($this->input->post('q'), $this->input->post('limit'));
        $suggestions = $this->tenant->get_search_suggestions($this->input->post('query'), 30);
        //echo implode("\n", $suggestions);

        $data = $tmp = array();

        foreach ($suggestions as $suggestion):
            $t = explode("|", $suggestion);
            $tmp = array("value" => $t[1], "data" => $t[0]);
            $data[] = $tmp;
        endforeach;

        echo json_encode(array("suggestions" => $data));
        exit;
    }

    public function get_payment_history($tenant_id =- 1)
    {
        $payment_ids = $this->tenant->get_payment_ids($tenant_id);

        $ids = array();

        foreach ($payment_ids as $id) {
            
            array_push($ids, $id["payment_id"]);

        }

        if (sizeof($ids) > 0) {
            
            $payment_history = $this->payment->get_multiple_info($ids);

            $i = 0;
        }

        return $payment_history;
    }

    /*
      Loads the tenant edit form
     */

    function view($tenant_id = -1)
    {
        $data['person_info'] = $this->tenant->get_info($tenant_id);

        $data['controller'] = $this;

        // $data['payment_history'] = $this->get_payment_history($tenant_id);

        $file = array();

        foreach ($attachments as $attachment)
        {
            $file[] = $this->_get_formatted_file($attachment->attachment_id, $attachment->filename);
        }

        $data['attachments'] = $file;

        $data['tenant_id'] = $tenant_id;

        $this->load->view("tenants/form", $data);
    }

    function get_houses($apartment_id, $hse_status = ""){

        $houses = $this->house->get_all($apartment_id, $hse_status);

        echo json_encode($houses->result()) ;

    }
    
    /*
      Inserts/updates a tenant
     */

    function save($tenant_id = -1)
    {

        $person_data['first_name'] = $this->input->post('first_name');

        $person_data['last_name'] = $this->input->post('last_name');

        $person_data['email'] = $this->input->post('email');

        $person_data['id_number'] = $this->input->post('id_number');

        $person_data['phone_number'] = $this->input->post('phone_number');

        $person_data['home_address'] = $this->input->post('home_address');
        

        $tenant_data['house_id'] = $this->input->post('house_id');  
             
        if ($this->tenant->save($person_data, $tenant_data, $tenant_id))
        {
            //New tenant
            if ($tenant_id == -1)
            {
                echo json_encode(array('success' => true, 'message' => 'Student added successfully', 'person_id' => $tenant_data['person_id']));
            }
            else //previous tenant
            {
                echo json_encode(array('success' => true, 'message' => 'Student updated successfully', 'person_id' => $tenant_id));
            }
        }
        else//failure
        {
            echo json_encode(array('success' => false, 'message' => 'Error while updating student details!', 'person_id' => -1));
        }
    }

    /*
      This deletes tenants from the tenants table
     */

    function delete()
    {
        $tenants_to_delete = $this->input->post('ids');

        if ($this->tenant->delete_list($tenants_to_delete))
        {
            echo json_encode(array('success' => true, 'message' => $this->lang->line('tenants_successful_deleted') . ' ' .
                count($tenants_to_delete) . ' ' . $this->lang->line('tenants_one_or_multiple')));
        }
        else
        {
            echo json_encode(array('success' => false, 'message' => $this->lang->line('tenants_cannot_be_deleted')));
        }
    }

    function excel()
    {
        $data = file_get_contents("import_tenants.csv");
        $name = 'import_tenants.csv';
        force_download($name, $data);
    }

    /*
      get the width for the add/edit form
     */

    function get_form_width()
    {
        return 350;
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

        $people = $this->tenant->get_all($length, $start, $key, $order, $sel_user);

        $format_result = array();

        foreach ($people->result() as $person)
        {
            $format_result[] = array(
                "<input type='checkbox' name='chk[]' id='person_$person->person_id' value='" . $person->person_id . "'/>",
                $person->last_name,
                $person->first_name,
                $person->id_number,
                $person->email,
                $person->phone_number,
                $person->home_address,
                ($person->date_moved == 0) ? "<span class='badge badge-info' >Resident</span>" : " <span class='badge badge-danger'>Moved </span>"."",
                "<div style='display:inline-flex; align-items:center'>".anchor('tenants/view/' . $person->person_id, '<span class="fa fa-search-plus"></span>', array('class' => 'btn-success btn-sm effect-1', "title" => "View tenant", 'style'=>'border-radius:50%'))."</div>"
            );
        }

        echo json_encode($format_result);
        exit;
    }
    
    function upload_profile_pic()
    {
        $directory = FCPATH . 'uploads/profile-' . $_REQUEST["user_id"] . "/";
        $this->load->library('uploader');
        $data = $this->uploader->upload($directory);

        $this->tenant->save_profile_pic($data['params']['user_id'], $data);

        echo json_encode(["status" => "OK"]);
        exit;
    }
    
    function upload_attachment()
    {
        $directory = FCPATH . 'uploads/tenant-' . $_REQUEST["tenant_id"] . "/";
        $this->load->library('uploader');
        $data = $this->uploader->upload($directory);

        $this->tenant->save_attachments($data['params']['tenant_id'], $data);

        $file = $this->_get_formatted_file($data['attachment_id'], $data['filename']);
        $file['tenant_id'] = $data['params']['tenant_id'];

        echo json_encode($file);
        exit;
    }

    function tenant_search()
    {
        $suggestions = $this->tenant->get_tenant_search_suggestions($this->input->get('query'), 30);
        $data = $tmp = array();

        foreach ($suggestions as $suggestion):
            $t = explode("|", $suggestion);
            $tmp = array("value" => $t[1], "data" => $t[0], "email" => $t[2]);
            $data[] = $tmp;
        endforeach;

        echo json_encode(array("suggestions" => $data));
        exit;
    }

    function printIt($tenant_id){

        $tenant = $this->Person->get_info($tenant_id);

        $data['occupation'] = $this->db->where('person_id', $tenant_id)->get('tenants')->row()->occupation;

        $data['payment_history'] = $this->get_payment_history($tenant_id);

        // pdf viewer 
        $data['tenant'] = $tenant;    

        $filename = "tenant_".date("ymdhis");
        // As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
        $pdfFilePath = FCPATH . "/downloads/reports/$filename.pdf";
        
        $html = $this->load->view('tenants/pdf_report', $data, true); // render the view into HTML

        $pdf = $this->pdf->load('', 'A4',9, 'raleway');

        $pdf->SetFooter('@ Rekimu Credit Ltd '.date('Y').'<br><small style="color:#eee; font-family:ocrb"> - Generated by apam </small>|{PAGENO}|' . 'Mutungoni Bldg Rm. 12, Mwatu Wa Ngoma Strt'); 

        // $pdf->WriteHTML(file_get_contents('css/style.css'), 1); 

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $pdf->Output($pdfFilePath, 'F'); // save to file because we can

        //end of pdf viewer
        //$data['pdf_file'] = FCPATH ."/downloads/reports/$filename.pdf";
        $data['pdf_file'] = "downloads/reports/$filename.pdf";


        $data['person_info'] = $this->tenant->get_info($tenant_id);
        
        // Data for the form view

        $data['apartment_history'] = $this->get_apartment_history($tenant_id);

        $data['attachments'] = $file;

        $data['tenant_id'] = $tenant_id;

        $this->load->view("tenants/form", $data);
    }

    function vacate ($tenant_id, $house_id){

        if($this->tenant->vacate($tenant_id) && $this->house->vacate($house_id)){

            echo json_encode(array('success' => true, 'message' => 'Tenant Vacated successfully', 'person_id' => $tenant_id));

        }else{

            echo json_encode(array('success' => false, 'message' => 'Could not Vacate Tenant!', 'person_id' => $tenant_id));
        }
        
    }
}

?>