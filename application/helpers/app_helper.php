<?php

function getDomain()
{
    $CI = & get_instance();
    return str_replace("index.php", "", site_url()); 
}
