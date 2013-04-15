<?php
include 'Program.php';
include 'Channel.php';

class ProgramTest extends PHPUnit_Framework_TestCase
{
    private $program;
    protected function setUp()
    {
        $channel = new Channel('北京卫视', 'http://tvmao.com/program/BTV-BTV1-w1.html');
        $programList = $channel->getProgramList();
        $this->program = $programList[0];
    }
    
    public function testGetFormatData()
    {
        echo $this->program->getFormatData();
    }
}
?>
