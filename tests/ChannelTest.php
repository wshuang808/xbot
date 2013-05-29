<?php
    include 'Channel.php';
    class ChannelTest extends PHPUnit_Framework_TestCase
    {
        private $channel;
        
        protected function setUp()
        {
            $this->channel = new Channel('湖北都市频道', 'http://tvmao.com/program/HUBEI-HUBEI6-w5.html');
        }
        
        public function testGetProgramList()
        {
            $programList = $this->channel->getProgramList();
            $this->assertEquals(9, count($programList));
        }
    }
?>