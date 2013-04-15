<?php
    include 'Station.php';
    
    class StationTest extends PHPUnit_Framework_TestCase
    {
        private $station;
        
        protected function setUp()
        {
            $this->station = new Station('北京电视台', 'http://tvmao.com/program/BTV-BTV1-w7.html');
        }
        
        public function testGetChannelList()
        {
            $channelList = $this->station->getChannelList();
            $this->assertEquals(12, count($channelList));
        }
    }
?>