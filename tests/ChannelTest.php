<?php
    include("Channel.php");
    class ChannelTest extends PHPUnit_Framework_TestCase
    {
        public function testConstructor()
        {
            $channel1 = new Channel('<li><b>东方卫视</b><span></span></li>');
            $this->assertEquals('东方卫视', $channel1->getName());
            $this->assertTrue($channel1->is_selected());
            $this->assertEquals('', $channel1->getLink());
            
            $channel2 = new Channel('<li><a href="/program/SHHAI-TOONMAX1-w3.html">上海炫动卡通卫视</a><span></span></li>');
            $this->assertEquals('上海炫动卡通卫视', $channel2->getName());
            $this->assertFalse($channel2->is_selected());
            $this->assertEquals('/program/SHHAI-TOONMAX1-w3.html', $channel2->getLink());
        }
        
        /**
         * @expectedException InvalidArgumentException
         */
        public function testConstructorException1()
        {
            $channel = new Channel('');
        }
        
        /**
         * @expectedException InvalidArgumentException
         */
        public function testConstructorException2()
        {
            $channel = new Channel('<a align="left">上海炫动卡通卫视</a>');
        }
    }
?>