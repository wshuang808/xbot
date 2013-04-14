<?php
    include 'Station.php';
    
    class StationTest extends PHPUnit_Framework_TestCase
    {
        private $site;
        private $station;
        
        protected function setUp()
        {
            $site = new TVmaoSite();
            $this->station = new Station($site, '北京电视台', 'http://tvmao.com/program/BTV-BTV1-w7.html');
        }
        
        public function testGetChannelList()
        {
            $channelList = $this->station->getChannelList();
            $this->assertEquals(12, count($channelList));
        }
    }
?>