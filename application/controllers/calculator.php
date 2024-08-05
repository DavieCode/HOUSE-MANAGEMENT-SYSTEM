<?php

require_once ("secure_area.php");

class Calculator extends Secure_area {

    function __construct()
    {
        parent::__construct('letters');

    }

    function index()
    {
        $data['controller_name'] = strtolower(get_class());
                    
        $this->load->view('apartments/calculator');

        $this->load->view('partial/footer');
    }
}