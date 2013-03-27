<?php    
    include_once 'wsss/LIB_http.php';
    define('DIVISION_NODE_TAG_NAME', 'div');
    define('DIVISION_NODE_CLASS_NAME', 'pgnav_wrap');
    define('STATION_NODE_TAG_NAME', 'div');
    define('STATION_NODE_CLASS_NAME', 'chlsnav');
    define('CHANNEL_LIST_TAG_NAME', 'ul');
    define('CHANNEL_LIST_CLASS_NAME', 'r');
    define('PROGRAM_LIST_TAG_NAME', 'div');
    define('PROGRAM_LIST_CLASS_NAME', 'epg mt10 mb10');
    //define('CHANNEL_LIST_LINK_TAG', 'a');
    //define('CHANNEL_TAG_NAME', 'li');
    
    define('TYPE_DIVISION', 0);
    define('TYPE_STATION', 1);
    define('TYPE_CHANNEL', 2);
    define('TYPE_PROGRAM', 3);
    
    class PageParser
    {   
        private static $nodeTags = array(
            TYPE_DIVISION => DIVISION_NODE_TAG_NAME,
            TYPE_STATION => STATION_NODE_TAG_NAME,
            TYPE_CHANNEL => CHANNEL_LIST_TAG_NAME,
            TYPE_PROGRAM => PROGRAM_LIST_TAG_NAME,
        );
        
        private static $nodeClasses = array(
            TYPE_DIVISION => DIVISION_NODE_CLASS_NAME,
            TYPE_STATION => STATION_NODE_CLASS_NAME,
            TYPE_CHANNEL => CHANNEL_LIST_CLASS_NAME,
            TYPE_PROGRAM => PROGRAM_LIST_CLASS_NAME,
        );
        
        ////////////////// PUBLIC FUNCTION //////////////////
        
        public static function getNodeByType($url, $type)
        {
            $result = '';
            $doc = self::getHTMLDoc($url);
            
            if (isset($doc))
            {
                //$handler = self::getHandlerByType($type);
                $node = self::getNodeImp($doc, $type);
                
                if (isset($node))
                    $result = $doc->saveHTML($node);
            }
            
            return $result;
        }
        
        ////////////////// PRIVATE FUNCTION //////////////////
        
        private static function getNodeImp($docObj, $type)
        {
            $resultNode = NULL;
            
            $targetNodeTag = self::getNodeTagByType($type);
            $targetNodeClass = self::getNodeClassByType($type);
            
            $possibleNodes = $docObj->getElementsByTagName($targetNodeTag);
            foreach ($possibleNodes as $node)
            {
                if (self::isTargetNode($node, $targetNodeTag, $targetNodeClass))
                {
                    $resultNode = $node;
                    break;
                }
            }
            
            return $resultNode;
        }
        
        private static function getNodeTagByType($type)
        {
            return self::$nodeTags[$type];
        }
        
        private static function getNodeClassByType($type)
        {
            return self::$nodeClasses[$type];
        }
        
        private static function getHTMLDoc($url)
        {
            $htmlContent = http_get($url, 'http://bot.google.com');
            libxml_use_internal_errors(TRUE);
            $doc = DOMDocument::loadHTML($htmlContent['FILE']);
            libxml_clear_errors();
        
            return $doc;
        }
        
        private static function isTargetNode($node, $targetTag, $targetClass)
        {
            return $targetTag == $node->nodeName &&
            $targetClass == $node->getAttribute('class');
        }
    }
?>