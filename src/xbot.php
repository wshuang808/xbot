<?php
    include("wsss/LIB_http.php");
    include("HTMLParser.php");
    
    $target = "http://tvmao.com/program/SHHAI";
    $ref = "";
    
    // Get raw html text
    $return_array = http_get($target, $ref);
    $html = $return_array['FILE'];
    
    $channels = HTMLParser::get_channel_list($html);
    
    /*
    foreach($channels as $channel)
    {
        retrive_programs($channel);
    }
    */


?>