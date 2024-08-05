<?php

require_once ("secure_area.php");

class Config extends Secure_area {

    function __construct()
    {
        parent::__construct('config');

        $this->load->helper('file');

        $this->load->helper('download');

        $this->load->library('zip');
    }

    function index()
    {

        $data = array();

        //$data["smtp_info"] = $this->Email->get_smtp_info();
        $this->load->view("config", $data);
    }

    function save()
    {
        $batch_save_data = array(
            'company' => $this->input->post('company'),
            'address' => $this->input->post('address'),
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'fax' => $this->input->post('fax'),
            'website' => $this->input->post('website'),
            'currency_symbol' => $this->input->post('currency_symbol'),
            'currency_side' => $this->input->post('currency_side'),
            'language' => $this->input->post('language'),
            'timezone' => $this->input->post('timezone')
        );
        
        $smtp_data = [            
            "smtp_id" => $this->input->post("smtp_id"),
            "smtp_host" => $this->input->post("smtp_host"),
            "smtp_port" => $this->input->post("smtp_port"),
            "smtp_user" => $this->input->post("smtp_user"),
            "smtp_pass" => $this->input->post("smtp_pass"),
        ]; 

        if ($this->Appconfig->batch_save($batch_save_data))
        {
            // saving SMTP settings             
            // $this->Email->save_smtp($smtp_data);
            echo json_encode(array('success' => true, 'message' => 'Configurations saved successfully'));
        }
    }
    
    function upload()
    {
        $directory = FCPATH . "uploads/logo/";
        $this->load->library('uploader');
        $data = $this->uploader->upload($directory);

        $this->Appconfig->save("logo", $data['filename']);
        $data['company_name'] = strtolower(preg_replace('/\s+/', '', $this->config->item('company')));

        echo json_encode($data);
        exit;
    }

    function backup()
    {
        $this->load->dbutil();

        $format = array('format' => 'zip', 'file_name' => 'jk_db_backup.sql;');

        $backup = & $this->dbutil->backup($format);

        $db_name = "jk_".date('dmYhi').".zip";

        $save = "downloads/".$db_name;

        if(write_file($save, $backup)){

            $str = file_get_contents("backup_logs.json", true);

            $logs = json_decode($str);

            $file_dits = array('name' => $db_name , 'time_stamp' => time(), "backup_by" => $this->session->userdata('person_id'));

            array_push($logs, $file_dits);

            $new_logs = json_encode($logs);

            file_put_contents("backup_logs.json", $new_logs);

            force_download($db_name, $backup);

        }
    }

}

?>