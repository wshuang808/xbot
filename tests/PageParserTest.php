<?php
    include 'PageParser.php';
    class PageParserTest extends PHPUnit_Framework_TestCase
    {
        private $pageParser;
        
        public function setUp()
        {
            $testHTML = <<<EOD
<!doctype html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<div class="chlsnav">
  <div class="btt">上海电视台频道列表</div>
  <a href="/program/DFMV"><div class="plst"><b>东方电影电视台</b></div></a><div class="pbar"><b>上海电视台</b></div><ul class="r"><li><b>东方卫视</b><span></span></li><li><a href="/program/SHHAI-TOONMAX1-w4.html">上海炫动卡通卫视</a><span></span></li><li><a href="/program/SHHAI-SHHAI1-w4.html">上视新闻频道</a><span></span></li><li><a href="/program/SHHAI-SHHAI2-w4.html">第一财经</a><span></span></li><li><a href="/program/SHHAI-SHHAI3-w4.html">上视生活时尚频道</a><span></span></li><li><a href="/program/SHHAI-SHHAI4-w4.html">上视电视剧频道</a><span></span></li><li><a href="/program/SHHAI-SHHAI5-w4.html">上海体育频道</a><span></span></li><li><a href="/program/SHHAI-SHHAI6-w4.html">上视纪实频道</a><span></span></li><li><a href="/program/SHHAI-SHHAI7-w4.html">上视娱乐频道</a><span></span></li><li><a href="/program/SHHAI-SHHAI8-w4.html">上视艺术人文频道</a><span></span></li><li><a href="/program/SHHAI-SHHAI9-w4.html">上视外语频道</a><span></span></li><li><a href="/program/SHHAI-SHHAI10-w4.html">东方购物频道</a><span></span></li><li><a href="/program/SHHAI-SHHAI11-w4.html">上视东方哈哈少儿频道</a><span></span></li></ul><a href="/program/SHEDU"><div class="plst"><b>上海教育电视台</b></div></a><a href="/program/SITV"><div class="plst"><b>SITV电视台</b></div></a>
  <div class="ad mt5" style="text-align:center"><!-- KG_190_190_VAR -->
<a href="http://www.mvgod.com/dianyingquan/kangou/" target="_blank"><img src="http://drmcmm.baidu.com/media/id=PjD3rHnsnH6&amp;gp=401&amp;time=nHnznWRdPHDvrf.jpg"></a>
</div>
</div>
</body>
EOD;
            $this->pageParser = new PageParser($testHTML);
        }
        
        public function testGetOtherGroupItems()
        {
            $groupItems = $this->pageParser->getOtherGroupItems();
            $this->assertEquals(3, count($groupItems));
            $this->assertEquals('<a href="/program/DFMV"><div class="plst"><b>东方电影电视台</b></div></a>', $groupItems[0]);
            $this->assertEquals('<a href="/program/SHEDU"><div class="plst"><b>上海教育电视台</b></div></a>', $groupItems[1]);
            $this->assertEquals('<a href="/program/SITV"><div class="plst"><b>SITV电视台</b></div></a>', $groupItems[2]);
        }
        
        public function testGetChannelItems()
        {
            $channelItems = $this->pageParser->getChannelItems();
            $this->assertEquals(13, count($channelItems));
            $this->assertEquals('东方卫视', $channelItems[0]->getName());
            $this->assertEquals('上视东方哈哈少儿频道', $channelItems[12]->getName());
        }
    }
?>