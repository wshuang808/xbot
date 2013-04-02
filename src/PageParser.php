<?php    
    include_once 'wsss/LIB_http.php';

    class PageParser
    {   
        ////////////////// PUBLIC FUNCTION //////////////////
        
        public static function getNodeByProto($url, $prototype)
        {
            $result = '';
            $doc = self::getHTMLDoc($url);

            if (isset($doc))
            {
                //$handler = self::getHandlerByType($type);
                $node = self::getNodeImp($doc, $prototype);
                
                if (isset($node))
                    $result = $doc->saveHTML($node);
            }
            
            return $result;
        }
        
        ////////////////// PRIVATE FUNCTION //////////////////
        
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
        public static function getDOMNodeFromProto($prototype)
        {
            $resultNode = NULL;
            libxml_use_internal_errors(TRUE);
            $doc = DOMDocument::loadXML($prototype);
            libxml_clear_errors();
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
        
        private static function getHTMLDoc($url)
        {
            $htmlContent = http_get($url, 'http://bot.google.com');
        
            libxml_use_internal_errors(TRUE);
            $doc = DOMDocument::loadHTML($htmlContent['FILE']);
            libxml_clear_errors();
            return $doc;
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