<?php
    include 'Channel.php';
    class ChannelTest extends PHPUnit_Framework_TestCase
    {
        private $channel;
        
        protected function setUp()
        {
            $this->channel = new Channel('北京卫视', 'http://tvmao.com/program/BTV-BTV1-w1.html');
        }
        
        public function testGetProgramList()
        {
            $programList = $this->channel->getProgramList();
            $this->assertEquals(34, count($programList));
        }
    }
?>