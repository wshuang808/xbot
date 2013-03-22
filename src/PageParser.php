<?php    
    include_once 'wsss/LIB_parse.php';
    define('CHANNEL_GROUP_CLASS_NAME', 'chlsnav');
    define('CHANNEL_GROUP_TAG_NAME', 'div');
    define('CHANNEL_LIST_TAG_NAME', 'ul');
    define('CHANNEL_LIST_CLASS_NAME', 'r');
    define('CHANNEL_LIST_LINK_TAG', 'a');
    define('CHANNEL_TAG_NAME', 'li');
    
    class PageParser
    {   
        private $doc;
        
        public function __construct($html)
        {
            try{
                libxml_use_internal_errors(TRUE);
                $this->doc = DOMDocument::loadHTML($html);
                libxml_clear_errors();
            }
            catch (Exception $e)
            {
                echo $e->getMessage();
            }
        }
        
        public function getOtherGroupItems()
        {
            $otherGroups = array();
        
            if (isset($this->doc))
            {
                $otherGroupNodes = $this->getOtherGroupNodes();
                foreach ($otherGroupNodes as $node)
                {
                    $groupHTML = $this->doc->saveHTML($node);
                    array_push($otherGroups, $groupHTML);
                }
            }
        
            return $otherGroups;
        }        
        
        public function getChannelItems()
        {
            $currentGroup = $this->getCurrentGroupNode();
            $channelNodes = $this->getChannelListInGroup($currentGroup);
            
            $channels = array();
            if (isset($this->doc))
            {
                foreach($channelNodes as $channelNode)
                {
                    $channelHTML = $this->doc->saveHTML($channelNode);
                    array_push($channels, $channelHTML);
                }
            }
            
            return $channels;
        }

        ////////////////////////////////////////////////////////////////////////////////
        
        private function getChannelGroupsNode()
        {
            if (isset($this->doc))
            {
                $possibleNodes = $this->doc->getElementsByTagName(CHANNEL_GROUP_TAG_NAME);
                foreach ($possibleNodes as $node)
                {
                    if ($this->isChannelGroupNode($node))
                    {
                        $channelGroupNode = $node;
                        break;
                    }
                }
            }

            return $channelGroupNode;
        } 

        private function getCurrentGroupNode()
        {
            $channelGroupsNode = $this->getChannelGroupsNode();
            
            if (isset($channelGroupsNode) && $channelGroupsNode->hasChildNodes())
            {
                foreach ($channelGroupsNode->childNodes as $node)
                {
                    if ($this->isChannelListNode($node))
                    {
                        $currentGroupNode = $node;
                        break;
                    }
                }
            }
            
            return $currentGroupNode;
        }
        
        private function getOtherGroupNodes()
        {
            $resultNodes = array();
        
            $channelGroupsNode = $this->getChannelGroupsNode();
        
            if (isset($channelGroupsNode) && $channelGroupsNode->hasChildNodes())
            {
                foreach ($channelGroupsNode->childNodes as $node)
                {
                    if ($this->isChannelGroupLink($node))
                    {
                        array_push($resultNodes, $node);
                    }
                }
            }
        
            return $resultNodes;
        }    

        private function getChannelListInGroup($groupNode)
        {
            $channels = array();
        
            if ($groupNode->hasChildNodes())
            {
                foreach ($groupNode->childNodes as $node)
                {
                    if ($this->isChannelNode($node))
                        array_push($channels, $node);
                }
            }
        
            return $channels;
        } 
        
        private function isChannelGroupNode($node)
        {
            return CHANNEL_GROUP_CLASS_NAME == $node->getAttribute('class');
        }  

        private function isChannelGroupLink($node)
        {
            return CHANNEL_LIST_LINK_TAG == $node->nodeName;
        }
        
        private function isChannelListNode($node)
        {
            return CHANNEL_LIST_TAG_NAME == $node->nodeName && 
                    CHANNEL_LIST_CLASS_NAME == $node->getAttribute('class');
        }
        
        private function isChannelNode($node)
        {
            return CHANNEL_TAG_NAME == $node->nodeName;
        }
        
    }
?>