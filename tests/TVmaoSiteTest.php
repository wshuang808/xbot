<?php
    include 'TVmaoSite.php';
    
    class TVmaoSiteTest extends PHPUnit_Framework_TestCase
    {
        private $site;
        
        protected function setUp()
        {
            $this->site = new TVmaoSite();
        }
        
        public function testGetRegionList()
        {
            $numRegion = count($this->site->getRegionList());
            
            $this->assertEquals(36, $numRegion);
        }
        
        public function testGetFullURL()
        {
            $url = $this->site->getFullURL('/abc');
            $this->assertEquals('http://tvmao.com/abc', $url);
        }
    }
?>