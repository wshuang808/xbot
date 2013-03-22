<?php
    include 'SiteParser.php';
    class PageParserTest extends PHPUnit_Framework_TestCase
    {
        public function testGetChannels()
        {
            $url = 'http://tvmao.com/program/SITV';
            $siteParser = new SiteParser($url);
            $siteParser->parseSite();
            $channels = $siteParser->getChannels();
            

            foreach ($channels as $channel)
            {
                echo $channel->getName().' '.$channel->getLink()."\n";
            }

            
            $this->assertEquals(51, count($channels));
        }
    }
?>