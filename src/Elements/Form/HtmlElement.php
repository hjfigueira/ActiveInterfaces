<?php
/**
 * Created by PhpStorm.
 * User: Hélio
 * Date: 5/31/2015
 * Time: 6:15 PM
 */

namespace ActiveInterfaces\Elements\Form {

    class HtmlElement
    {
        private $properties = array();
        private $selfClosing = true;
        private $taganame = false;

        private $open = '';
        private $close = '';
        private $content = array();

        public function __construct($selfClosing = true, $tagname = null, $properties = array())
        {
            if (!(empty($tagname))) {
                $this->setTag($tagname);
                $this->selfClosing($selfClosing);
                foreach ($properties as $item => $valor) {
                    $this->setProperty($item, $valor);
                }
            }
        }

        public function selfClosing($is = true)
        {
            $this->selfClosing = $is;
        }

        public function setTag($tagname)
        {
            $this->taganame = $tagname;
        }

        public function setProperty($name, $value)
        {
            $this->properties[$name] = $value;
        }

        public function getProperty($name)
        {
            return isset($this->properties[$name]) ? $this->properties[$name] : null;
        }

        public function unsetProperty($name)
        {
            unset($this->properties[$name]);
        }

        public function hasProperty($name,$value = null)
        {
            if(isset($this->properties[$name]))
            {
                return true;
            }
            if($value != null and isset($this->properties[$name]) and $this->properties[$name] = $value)
            {
                return true;
            }

            return false;
        }

        public function setContent($content,$contextReference = null)
        {
            if($contextReference != null)
            {
                $this->content[$contextReference] = $content;
            }
            else
            {
                if(is_array($content))
                {
                    $this->content = $content;
                }
                else{
                    $this->content[] = $content;
                }
            }
        }

        public function render()
        {
            $html = '<' . $this->taganame;
            foreach ($this->properties as $key => $value) {
                $html .= ' ' . $key . '="' . $value . '"';
            }

            if ($this->selfClosing) {
                $html .= ' />';

            } else {
                $html .= ' >';

            }
            $this->open = $html;
            $this->close = '</' . $this->taganame . '>';

            $html = $this->open;
            if (!$this->selfClosing) {
                $html .= $this->getContent() . $this->close;
            }
            return $html;
        }

        public function getOpen()
        {
            return $this->open;
        }

        public function getClose()
        {
            return $this->close;
        }

        public function getContent($contextReference = null)
        {
            if($contextReference != null)
            {
                return $this->content[$contextReference];
            }
            else
            {
                return implode(null, $this->content);
            }
        }

        public function getContentRaw()
        {
            return $this->content;
        }

        public function getContentByProperty($property,$value)
        {
            $return = array();
            foreach($this->content as $htmlContent)
            {
                if($htmlContent->hasProperty($property,$value))
                {
                    $return[] = $htmlContent;
                }
            }
            return $return;
        }

        /**
         * @return array HtmlElement
         */
        public function getContentArray()
        {
            return $this->content;
        }

        public function __toString()
        {
            $html = $this->render();
            return (string)$html;
        }

    }
}