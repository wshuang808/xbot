<?php
    include 'Region.php';
    
    class RegionTest extends PHPUnit_Framework_TestCase
    {
        private $region;
        
        protected function setUp()
        {
            $this->region = new Region('北京','http://tvmao.com/program/BTV-BTV1-w7.html');
        }

        public function testGetStationList()
        {
            $stationList = $this->region->getStationList();
            $this->assertEquals(2, count($stationList));
        }
    }
?>