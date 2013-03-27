<?php
    include 'PageParser.php';
    class PageParserTest extends PHPUnit_Framework_TestCase
    {
        public function testGetChannelList()
        {
            $channels = PageParser::getNodeByType('http://tvmao.com/program/SHHAI-DONGFANG1-w1.html', TYPE_CHANNEL);
            //echo $channels;
        }
        
        public function testGetStationList()
        {
            $stations = PageParser::getNodeByType('http://tvmao.com/program/SHHAI-DONGFANG1-w1.html', TYPE_STATION);
            //echo $stations;
        }
        
        public function testGetProgramList()
        {
            $programs = PageParser::getNodeByType('http://tvmao.com/program/SHHAI-DONGFANG1-w1.html', TYPE_PROGRAM);
            //echo $programs;
        }
        
        public function testGetDivisionList()
        {
            $divisions = PageParser::getNodeByType('http://tvmao.com/program/SHHAI-DONGFANG1-w1.html', TYPE_DIVISION);
            echo $divisions;
        }
    }
?>