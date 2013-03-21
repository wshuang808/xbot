<?php
    include 'ChannelList.php';
    class ChannelListTest extends PHPUnit_Framework_TestCase
    {
        public function testConstructor()
        {
            $channelList = ChannelList::create('<ul class="r"><li><b>东方卫视</b><span></span></li><li><a href="/program/SHHAI-TOONMAX1-w4.html">上海炫动卡通卫视</a><span></span></li><li><a href="/program/SHHAI-SHHAI1-w4.html">上视新闻频道</a><span></span></li><li><a href="/program/SHHAI-SHHAI2-w4.html">第一财经</a><span></span></li><li><a href="/program/SHHAI-SHHAI3-w4.html">上视生活时尚频道</a><span></span></li><li><a href="/program/SHHAI-SHHAI4-w4.html">上视电视剧频道</a><span></span></li><li><a href="/program/SHHAI-SHHAI5-w4.html">上海体育频道</a><span></span></li><li><a href="/program/SHHAI-SHHAI6-w4.html">上视纪实频道</a><span></span></li><li><a href="/program/SHHAI-SHHAI7-w4.html">上视娱乐频道</a><span></span></li><li><a href="/program/SHHAI-SHHAI8-w4.html">上视艺术人文频道</a><span></span></li><li><a href="/program/SHHAI-SHHAI9-w4.html">上视外语频道</a><span></span></li><li><a href="/program/SHHAI-SHHAI10-w4.html">东方购物频道</a><span></span></li><li><a href="/program/SHHAI-SHHAI11-w4.html">上视东方哈哈少儿频道</a><span></span></li></ul>');
        }
    }
?>