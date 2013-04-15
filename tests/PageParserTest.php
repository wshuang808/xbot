<?php
    include 'SiteFormatConst.php';
    include 'PageParser.php';
    
    class PageParserTest extends PHPUnit_Framework_TestCase
    {
        public function testGetChannelList()
        {
            $channelNode = PageParser::getNodeByProto('http://tvmao.com/program/SHHAI-DONGFANG1-w1.html', PROTOTYPE_CHANNEL);
            $class = $channelNode->getAttribute('class');
            $this->assertEquals('r', $class);
        }
        
        
        public function testGetStationList()
        {
            $stationNode = PageParser::getNodeByProto('http://tvmao.com/program/SHHAI-DONGFANG1-w1.html', PROTOTYPE_STATION);
            $class = $stationNode->getAttribute('class');
            $this->assertEquals('chlsnav', $class);
        }
        

        public function testGetProgramList()
        {
            $programNode = PageParser::getNodeByProto('http://tvmao.com/program/SHHAI-DONGFANG1-w1.html', PROTOTYPE_PROGRAM);
            $id = $programNode->getAttribute('id');
            $this->assertEquals('pgrow', $id);
        }
        
        public function testGetRegionList()
        {
            $regionNode = PageParser::getNodeByProto('http://tvmao.com/program/SHHAI-DONGFANG1-w1.html', PROTOTYPE_REGION);
            $class = $regionNode->getAttribute('class');
            $this->assertEquals('pgnav', $class);
        }
    }
?>