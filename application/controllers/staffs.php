<?php

require_once ("person_controller.php");

class Staffs extends Person_controller {
    
    function __construct()
    {
        parent::__construct('staffs'); 
    }

    function index()
    {
        $config['base_url'] = site_url('/staffs/index');
        $config['total_rows'] = $this->staff->count_all();
        $config['per_page'] = '20';
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);

        $data['staffs'] = $res;
        
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['manage_table'] = get_people_manage_table($this->staff->get_all($config['per_page'], $this->uri->segment($config['uri_segment'])), $this);
        $this->load->view('people/staff', $data);
    }   

    /*
      Returns staff table data rows. This will be called with AJAX.
     */

    function search()
    {
        $search = $this->input->post('search');
        $data_rows = get_people_manage_table_data_rows($this->staff->search($search), $this);
        echo $data_rows;
    }

    /*
      Gives search suggestions based on what is being searched for
     */

    function suggest()
    {
        $suggestions = $this->staff->get_search_suggestions($this->input->post('q'), $this->input->post('limit'));
        echo implode("\n", $suggestions);
    }

    /*
      Loads the staff edit form
     */

    function view($staff_id = -1)
    {
        $data['person_info'] = $this->staff->get_info($staff_id);
        //$data['all_modules'] = $this->Module->get_all_modules();
        
        $this->load->view("staffs/form", $data);
    }

    /*
      Inserts/updates an staff
     */

    function save($staff_id = -1)
    {
        $person_data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('email'),
            'phone_number' => $this->input->post('phone_number'),
            'home_address' => $this->input->post('home_address'),
            'id_number' => $this->input->post('id_number'),      
        );

        //Password has been changed OR first time password set
        if ($this->input->post('password') != '')
        {
            $staff_data = array(
                'username' => $this->input->post('username'),
                'password' => md5($this->input->post('password'))
            );
        }
        else //Password not changed
        {
            $staff_data = array('username' => $this->input->post('username'));
        }

        if ($this->staff->save($person_data, $staff_data, $staff_id))
        {
            //New staff
            if ($staff_id == -1)
            {
                echo json_encode(array('success' => true, 'message' => 'staff successfully added ' .
                    $person_data['first_name'] . ' ' . $person_data['last_name'], 'person_id' => $staff_data['person_id']));
            }
            else //previous staff
            {
                echo json_encode(array('success' => true, 'message' => 'staff updated successfully ' .
                    $person_data['first_name'] . ' ' . $person_data['last_name'], 'person_id' => $staff_id));
            }
        }
        else//failure
        {
            echo json_encode(array('success' => false, 'message' => 'Oooops! An error occured while updating data ' .
                $person_data['first_name'] . ' ' . $person_data['last_name'], 'person_id' => -1));
        }
    }

    /*
      This deletes staffs from the staffs table
     */

    function delete()
    {
        $staffs_to_delete = $this->input->post('ids');

        if ($this->staff->delete_list($staffs_to_delete))
        {
            echo json_encode(array('success' => true, 'message' => "Staff(s) deleted successfully", 'ids' => $staffs_to_delete));
        }
        else
        {
            echo json_encode(array('success' => false, 'message' => "Failure!!! Staff(s) could not be deleted", 'ids' => $staffs_to_delete));
        }
    }

    /*
      get the width for the add/edit form
     */

    function get_form_width()
    {
        return 650;
    }

    function data()
    {
        $index = isset($_GET['order'][0]['column']) ? $_GET['order'][0]['column'] : 1;
        $dir = isset($_GET['order'][0]['dir']) ? $_GET['order'][0]['dir'] : "asc";
        $order = array("index" => $index, "direction" => $dir);
        $length = isset($_GET['length']) ? $_GET['length'] : 50;
        $start = isset($_GET['start']) ? $_GET['start'] : 0;
        $key = isset($_GET['search']['value']) ? $_GET['search']['value'] : "";

        $people = $this->staff->get_all($length, $start, $key, $order);

        $format_result = array();

        $width = 50;

        foreach ($people->result() as $person)
        {

            if($this->staff->get_logged_in_staff_info()->role == "mgmt"){

                if($person->username != 'admin'){

                    $format_result[] = array(
                        "<input type='checkbox' name='chk[]' id='person_$person->person_id' value='" . $person->person_id . "'/>",
                        $person->person_id,
                        $person->last_name,
                        $person->first_name,
                        $person->phone_number,
                        $person->username,
                        $person->id_number,
                        $person->email,
                        "<div style='display:flex; align-items:center'>".anchor('staffs/view/' . $person->person_id, '<span class="fa fa-pencil"></span>', array('class' => 'btn-success btn-sm effect-1'))."</div>"
                    );
                }

            }else{

                if($person->person_id == $this->staff->get_logged_in_staff_info()->person_id){

                    $format_result[] = array(
                        "<input type='checkbox' name='chk[]' id='person_$person->person_id' value='" . $person->person_id . "'/>",
                        $person->person_id,
                        $person->last_name,
                        $person->first_name,
                        $person->phone_number,
                        $person->username,
                        $person->id_number,
                        $person->email,
                        "<div style='display:flex; align-items:center'>".anchor('staffs/view/' . $person->person_id, '<span class="fa fa-pencil"></span>', array('class' => 'btn-success btn-sm effect-1'))."</div>"
                    );
                }

            }
        }

        echo json_encode($format_result);
        exit;
    }
    
    function staff_search()
    {
        $suggestions = $this->staff->get_staff_search_suggestions($this->input->get('query'), 30);
        $data = $tmp = array();

        foreach ($suggestions as $suggestion):
            $t = explode("|", $suggestion);
            $tmp = array("value" => $t[1], "data" => $t[0], "email" => $t[2]);
            $data[] = $tmp;
        endforeach;

        echo json_encode(array("suggestions" => $data));
        exit;
    }

}

?>