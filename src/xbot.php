<?php
    include_once 'HTMLParser.php';
    
    $url = "http://tvmao.com/program/SHHAI";  
    
    $parser = new PageParser($html, $url);
    $channels = $parser->getAllChannels();
    foreach ($channels as $channel)
    {
        $channel->syncToFile();
    }
?>