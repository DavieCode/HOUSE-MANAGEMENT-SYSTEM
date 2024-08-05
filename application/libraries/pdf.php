<?php

class pdf {

    function pdf()
    {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }

    function load($param = "")
    {

        include_once APPPATH . '/third_party/mpdf/mpdf.php';

        if ($param == "")
        {
            $param = array("en-GB","A4-L","9","ocrb",10,10,10,10,6,3);
        }

        return new mPDF($param);
    }

}

?>
