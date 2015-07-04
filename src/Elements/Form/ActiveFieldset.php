<?php
/**
 * Created by PhpStorm.
 * User: Hélio
 * Date: 5/31/2015
 * Time: 6:15 PM
 */

namespace ActiveInterfaces\Elements\Form {

    class ActiveFieldset extends ActiveElement
    {

        private $activeElements = array();

        /**
         * Contians the spefici information of how to render this element
         * @return HtmlElement
         */
        protected function buildHtmlElement()
        {
            $this->html->setTag('fieldset');
            $this->html->selfClosing(false);
        }

        public function render($extras = [],$closure)
        {
            foreach($extras as $key => $value)
            {
                $this->html->setProperty($key,$value);
            }

            $this->html->render();
            echo $this->html->getOpen();
            echo $closure($this->html->getContentRaw());
            echo $this->html->getClose();
        }

        public function addElement(ActiveElement $element,$contextReference,$label)
        {
            $element->setName($this->getName().'['.$contextReference.']');
            if($label != null)
            {
                $element->setLabel($label);
            }

            $this->$contextReference = $element;
            $this->html->setContent($element,$contextReference);
        }

        public function setLabel($label)
        {
            $labelElement = new HtmlElement(false,'legend');
            $labelElement->setContent($label);
            $this->html->setContent($labelElement,'legend');
        }

        public function setName($name)
        {
            $this->html->setProperty('id',$name);
        }

    }
}