<?php

Class Houses extends CI_Controller
{
    function view($house_id) {
        if($house_id != -1) {
            
        $house['house_info'] = $this->house->get_details($house_id);

        $this->load->view('houses/form', $house);

        }

        $this->load->view('houses/form');
    }

    function house_info($house_id = 2) {
            
        $house = $this->house->get_details($house_id);

        echo json_encode($house);

    }
    
    // Add a new house and update an existing house
    
    function save($house_id = -1)
    {        
            
        $house_data = array(
            'house_no' => $this->input->post('house_no'),
            'house_type' => $this->input->post('house_type'),
            'description' => $this->input->post('house_description'),        
            'status' => $this->input->post('status'),
            'rent' => $this->input->post('rent'),
            'features' => json_encode($this->input->post('features')),
            'apartment_id' => $this->input->post('apartment_id')
        );
            
        if ($this->house->save($house_data, $house_id))
        {
            //New house
            if ($house_id == -1)
            {
                echo json_encode(array('success' => true, 'message' => 'house added successfully', 'house_id' => $house_data['house_id']));
                $id = $house_data['house_id'];
            }
            else //previous house
            {
                echo json_encode(array('success' => true, 'message' => 'house updated successfully', 'house_id' => $id));
            }

        }
        else//failure
        {
            echo json_encode(array('success' => false, 'message' => 'Error while saving changes', 'house_id' => -1));
        }

    }
}