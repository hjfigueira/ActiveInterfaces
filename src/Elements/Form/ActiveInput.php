<?php

namespace ActiveInterfaces\Elements\Form
{
    class ActiveInput extends ActiveElement {

        /**
         * Contains the spefici information of how to render this element
         * @return HtmlElement
         */
        protected function buildHtmlElement()
        {
            $this->html->setTag('input');
        }

        /**
         * Contains the specific information fo how to set the value to an element
         * @param $value
         */
        public function setValue($value = null)
        {
            $this->html->setProperty('value',$value);
        }


        /**
         * Contains the specific information fo how to return the value of an item
         * @param $value
         */
        public function getValue()
        {
            return $this->html->getProperty('value');
        }
    }

}