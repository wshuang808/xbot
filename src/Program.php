<?php
    class Program
    {
        private $time;
        private $name;
        private static $exceptionList = array('剧情','剧照','演员表');
        
        public function __construct($programNode)
        {
            $childNodes = $programNode->childNodes;
            $name = '';
            
            foreach ($childNodes as $childNode)
            {
                if ($this->isTimeNode($childNode))
                {
                    $this->time = $childNode->nodeValue;
                }
                else if(!$this->isExceptionNode($childNode))
                {
                    $this->name .= $childNode->nodeValue;
                }
            }
        }
        
        private function isTimeNode($node)
        {
            return $node->nodeName == TAG_PROGRAM_TIME;
        }
        
        private function isExceptionNode($node)
        {
            $result = FALSE;
            
            if ($node->nodeName == TAG_PROGRAM_EXCPTION)
            {
                $result = TRUE;
            }
            else
            {
                foreach (self::$exceptionList as $exception)
                {
                    if ($node->nodeValue == $exception)
                    {
                        $result = TRUE;
                        break;
                    }
                }
            }
            
            return $result;
        }
    }
?>