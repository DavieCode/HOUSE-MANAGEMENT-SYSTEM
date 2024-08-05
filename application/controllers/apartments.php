<?php

require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");

class apartments extends Secure_area implements iData_controller {

    function __construct()
    {
        parent::__construct('apartments');
    }

    function index()
    {
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();

        $data['staffs'] = $res;

        $this->load->view('apartments/manage', $data);
    }

    function search()
    {
       
    }

    /*
      Gives search suggestions based on what is being searched for
     */

    function suggest()
    {
        $suggestions = $this->apartment->get_search_suggestions($this->input->get('query'), 30);
        $data = $tmp = array();

        foreach ($suggestions as $suggestion):
            $t = explode("|", $suggestion);
            $tmp = array("value" => $t[1], "data" => $t[0]);
            $data[] = $tmp;
        endforeach;

        echo json_encode(array("suggestions" => $data));
        exit;

    }

    function get_row()
    {
        
    }

    function view($apartment_id = -1)
    {
        $data['apartment_info'] = $this->apartment->get_info($apartment_id);
       
        $apartment = $this->apartment->get_info($apartment_id);
        
        $data['houses'] = $this->house->get_all($apartment_id)->result();
        

        $staffs = $this->staff->get_all()->result();

        $emps = array();

        foreach ($staffs as $staff)
        {
            $emps[$staff->person_id] = $staff->first_name . " " . $staff->last_name;
        }

        $data['staffs'] = $emps;

        $this->load->view("apartments/form", $data);
    }

    private function _get_files($ids, $file)
    {
        $tmp = array();
        if (is_array($ids))
        {
            foreach ($ids as $id):
                $tmp[] = $file[$id];
            endforeach;
        }

        return $tmp;
    }


    function save($apartment_id = -1)
    {
        $apartment_data = array(
            'name' => $this->input->post('inp-apartment'),
            'description' => $this->input->post('description'),
            'location' => $this->input->post('location'),
            'floors' => $this->input->post('floors'),       
            'date_added' => time(),
            'agent_id' => $this->input->post('agent')
        );


        //echo $this->input->post('payment_date');

        if ($this->apartment->save($apartment_data, $apartment_id))
        {
            //New apartment
            if ($apartment_id == -1)
            {
                echo json_encode(array('success' => true, 'message' => 'Hostel added successfully', 'apartment_id' => $apartment_data['apartment_id']));
                $apartment_id = $apartment_data['apartment_id'];
            }
            else //previous apartment
            {
                echo json_encode(array('success' => true, 'message' => 'Hostel updated successfully', 'apartment_id' => $apartment_id));
            }

        }
        else//failure
        {
            echo json_encode(array('success' => false, 'message' => 'Error while saving changes', 'apartment_id' => -1));
        }
    }

    function delete()
    {
        $apartments_to_delete = $this->input->post('ids');

        if ($this->apartment->delete_list($apartments_to_delete))
        {
            echo json_encode(array('success' => true, 'message' => 'apartment deleted successfully'));
        }
        else
        {
            echo json_encode(array('success' => false, 'message' => 'Sorrry, this apartment cannot be deleted!'));
        }
    }

    /*
      get the width for the add/edit form
     */

    function get_form_width()
    {
        return 360;
    }

    function data($status = "")
    {

        $sel_user = $this->input->get("staff_id");

      
        $apartments = $this->apartment->get_all($_GET['length'], $_GET['start'], $_GET['search']['value'], $order, $status, $sel_user);

        $format_result = array();

        foreach ($apartments->result() as $apartment){            
            
            $format_result[] = array(
                "<input type='checkbox' name='chk[]' id='apartment_$apartment->apartment_id' value='" . $apartment->apartment_id . "'/>",
                $apartment->apartment_id,
                $apartment->name,
                $apartment->description,
                date("d, M Y", $apartment->date_added),
                "<div style='display:flex; align-items:center'>".anchor('apartments/view/' . $apartment->apartment_id, '<span class="fa fa-search-plus"></span>', array('class' => 'btn-success btn-sm effect-1', 'title' => 'apartment details')).anchor('apartments/printIt/' . $apartment->apartment_id, '<span class="fa fa-print"></span>', array('class' => 'btn-warning btn-sm effect-1', "title" => "Print statement", 'style'=>'border-radius:50%'))."</div>"
            );
            	
        }
        echo json_encode($format_result);
        
        exit;
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