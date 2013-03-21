<?php
    include 'Channel.php';
    class ChannelTest extends PHPUnit_Framework_TestCase
    {
        public function testConstructor()
        {
            $channel1 = Channel::createChannel('<li><b>东方卫视</b><span></span></li>');
            $this->assertEquals('东方卫视', $channel1->getName());
            $this->assertTrue($channel1->isSelected());
            $this->assertEquals('', $channel1->getLink());
            
            $channel2 = Channel::createChannel('<li><a href="/program/SHHAI-TOONMAX1-w3.html">上海炫动卡通卫视</a><span></span></li>');
            $this->assertEquals('上海炫动卡通卫视', $channel2->getName());
            $this->assertFalse($channel2->isSelected());
            $this->assertEquals('/program/SHHAI-TOONMAX1-w3.html', $channel2->getLink());
        
            $channel3 = Channel::createChannel('');
            $this->assertEquals(NULL, $channel3);
            
            $channel4 = Channel::createChannel('<a align="left">上海炫动卡通卫视</a>');
            $this->assertEquals(NULL, $channel4);
        }
    }
?>