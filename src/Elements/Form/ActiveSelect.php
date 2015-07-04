<?php

namespace ActiveInterfaces\Elements\Form
{
    class ActiveSelect extends ActiveElement {

        public function addOption($value, $label, $properties = array())
        {
            $option = new HtmlElement(false,'option',$properties);
            $option->setProperty('value',$value);
            $option->setContent($label);
            $this->html->setContent($option,$value);
        }

        /**
         * Contians the spefici information of how to render this element
         * @return HtmlElement
         */
        protected function buildHtmlElement()
        {
            $this->html->selfClosing(false);
            $this->html->setTag('select');
        }

        /**
         * Contains the specific information fo how to set the value to an element
         * @param $value
         */
        public function setValue($value = null)
        {
            $this->clearValues();
            if($value != null)
            {
                $options = $this->html->getContentArray();
                if(isset($options[$value]))
                {
                    $options[$value]->setProperty('selected','selected');
                }
            }
        }

        /**
         * Contains the specific information fo how to set the value to an element
         * @param $value
         */
        public function clearValues()
        {
            $options = $this->html->getContentByProperty('selected','selected');
            foreach($options as $option)
            {
                $option->unsetProperty('selected');
            }
        }
    }

}