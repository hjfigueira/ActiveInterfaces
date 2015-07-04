<?php
/**
 * Created by PhpStorm.
 * User: Hélio
 * Date: 6/2/2015
 * Time: 2:12 PM
 */

namespace ActiveInterfaces\Elements\Form{

    abstract class ActiveElement
    {
        /**
         * @var HtmlElement
         */
        public $html    = null;
        public $label   = null;

        public function __construct()
        {
            $this->html = new HtmlElement();
            $this->buildHtmlElement();
        }

        protected function buildHtmlElement()
        {
            $this->html->setContent(
                "You're using an undefined field type, this class exists and extends ActiveElement, but
                you need to overwrite the buildHtmlElement method");
        }

        public function setLabel($label)
        {
            $labelElement = new HtmlElement(false,'label');
            $labelElement->setProperty('for',$this->html->getProperty('name'));
            $labelElement->setContent($label);
            $this->label = $labelElement;
        }

        public function setValue($value = null)
        {

        }

        public function setName($name)
        {
            $this->html->setProperty('name',$name);
            $this->html->setProperty('id',$name);
        }

        public function getName(){
            return 'undefined';
        }

        public function __toString()
        {
            return (string)$this->label.$this->html;
        }

    }

}