<?php
    include 'PageParser.php';
    
    define('PROTOTYPE_CHANNEL', '<ul class="r" />');
    define('PROTOTYPE_PROGRAM', '<ul id="pgrow" />');
    define('PROTOTYPE_STATION', '<div class="chlsnav" />');
    define('PROTOTYPE_DIVISION', '<table class="pgnav" />');
    
    class PageParserTest extends PHPUnit_Framework_TestCase
    {
//         public function testGetChannelList()
//         {
//             $channels = PageParser::getNodeByProto('http://tvmao.com/program/SHHAI-DONGFANG1-w1.html', PROTOTYPE_CHANNEL);
//             echo $channels;
//         }
        
        
//         public function testGetStationList()
//         {
//             $stations = PageParser::getNodeByProto('http://tvmao.com/program/SHHAI-DONGFANG1-w1.html', PROTOTYPE_STATION);
//             echo $stations;
//         }
        

//         public function testGetProgramList()
//         {
//             $programs = PageParser::getNodeByProto('http://tvmao.com/program/SHHAI-DONGFANG1-w1.html', PROTOTYPE_PROGRAM);
//             echo $programs;
//         }
        
        public function testGetDivisionList()
        {
            $divisions = PageParser::getNodeByProto('http://tvmao.com/program/SHHAI-DONGFANG1-w1.html', PROTOTYPE_DIVISION);
            echo $divisions;
        }
    }
?>