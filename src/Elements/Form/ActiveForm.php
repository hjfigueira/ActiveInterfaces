<?php
/**
 * Created by PhpStorm.
 * User: Hélio
 * Date: 5/31/2015
 * Time: 6:14 PM
 */

namespace ActiveInterfaces\Elements\Form {

    use \ActiveInterfaces\Elements\Form\HtmlElement;
    use ActiveInterfaces\Interfaces\GenericRequest;

    class ActiveForm extends ActiveElement
    {

        public function __construct(GenericRequest $request = null)
        {
            parent::__construct();
            if($request != null)
            {
                $request->populate($this);
            }
        }

        protected function buildHtmlElement()
        {
            $this->html->setTag('form');
            $this->html->selfClosing(false);
        }

        protected function addElement(ActiveElement $element,$contextReference,$label = null)
        {
            $element->setName($this->getName().'['.$contextReference.']');
            if($label != null)
            {
                $element->setLabel($label);
            }
            $this->$contextReference                    = $element;
            $this->html->setContent($element,$contextReference);
        }

        protected function metaConfiguration(){
            return array();
        }

        public function render($action,$method,$extras = [],$closure)
        {
            $this->html->setProperty('id',$this->getName());
            $this->html->setProperty('action',$action);
            $this->html->setProperty('method',$method);

            foreach($extras as $key => $value)
            {
                $this->html->setProperty($key,$value);
            }

            $this->html->render();
            echo $this->html->getOpen();
            echo $closure($this->html->getContentRaw());
            echo $this->html->getClose();
        }

    }

}