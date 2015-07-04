<?php

namespace ActiveInterfaces\Elements\Form
{
    class ActiveTextarea extends ActiveElement {

        /**
         * Contians the spefici information of how to render this element
         * @return HtmlElement
         */
        protected function buildHtmlElement()
        {
            $this->html->selfClosing(false);
            $this->html->setTag('textarea');
        }

        /**
         * Contains the specific information fo how to set the value to an element
         * @param $value
         */
        public function setValue($value = null)
        {
            $this->html->setContent($value);
        }

    }

}