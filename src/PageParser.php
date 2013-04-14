<?php    
    include_once 'wsss/LIB_http.php';

    class PageParser
    {   
        ////////////////// PUBLIC FUNCTION //////////////////
        
        /**
         * Get the $prototype specific html node from $url 
         * 
         * @param unknown $url
         * @param unknown $prototype
         * @return string
         */
        public static function getNodeByProto($url, $prototype)
        {
            $result = NULL;
            $htmlContent = http_get($url, 'http://bot.google.com');
            $doc = self::getDocFromHTML($htmlContent['FILE']);;

            if (isset($doc))
            {
                //$handler = self::getHandlerByType($type);
                $result = self::getNodeImp($doc, $prototype);
            }
            
            return $result;
        }
        
        ////////////////// PRIVATE FUNCTION //////////////////
        
        private static function getDocFromXML($xml)
        {
            libxml_use_internal_errors(TRUE);
            $doc = DOMDocument::loadXML($xml);
            libxml_clear_errors();
        
            return $doc;
        }
        
        private static function getDocFromHTML($html)
        {
            libxml_use_internal_errors(TRUE);
            $doc = DOMDocument::loadHTML($html);
            libxml_clear_errors();
        
            return $doc;
        }
        
        /**
         * Get the first node in $docObj which matches $prototype
         * @param unknown $docObj
         * @param unknown $prototype
         * @return NULL
         */
        private static function getNodeImp($docObj, $prototype)
        {
            $resultNode = NULL;
            $protoNode = self::getDOMNodeFromProto($prototype);
            
            if (isset($protoNode))
            {
                $targetTag = $protoNode->nodeName;
                $possibleNodes = $docObj->getElementsByTagName($targetTag);
                foreach ($possibleNodes as $possibleNode)
                {
                    if (self::isTargetNode($possibleNode, $protoNode))
                    {
                        $resultNode = $possibleNode;
                        break;
                    }
                }
            }
            
            return $resultNode;
        }
        
        /**
         * @param $prototype is an html node header. e.g. <ul class ="r" />
         */
        private static function getDOMNodeFromProto($prototype)
        {
            $resultNode = NULL;
            $doc = self::getDocFromXML($prototype);
            if (isset($doc))
            {
                $resultNode = $doc->firstChild;
            }
            else
            {
                echo "Warning: invalid prototype";
            }
            return $resultNode;
        }
        
        private static function isTargetNode($node, $protoNode)
        {
            $result = FALSE;
            if ($node->nodeName == $protoNode->nodeName)
            {
                $result = TRUE;
                $attributes = $protoNode->attributes;
                foreach ($attributes as $attribute)
                {
                    $attributeName = $attribute->nodeName;
                    $attributeValue = $attribute->nodeValue;
                    if ($node->getAttribute($attributeName) != $attributeValue)
                    {
                        $result = FALSE;
                        break;
                    }
                }
            }
            
            return $result;
        }
    }
?>