<?php
/**
 * Created by PhpStorm.
 * User: Hélio
 * Date: 6/4/2015
 * Time: 2:54 PM
 */

namespace ActiveInterfaces\Drivers\Request{

    use ActiveInterfaces\Elements\Form\ActiveForm;
    use ActiveInterfaces\Interfaces\GenericRequest;

    class RawDataRequest implements GenericRequest
    {

        public function getPost($indexBase)
        {
            return $_POST[$indexBase];
        }

        public function getGet($indexBase)
        {
            return $_GET[$indexBase];
        }

        public function populate(ActiveForm $form)
        {
            foreach($this->getPost($form->getName()) as $index => $value)
            {
                if(is_array($value))
                {
                    //Recursive Iteration
                }
                else
                {
                    $form->$index->setValue($value);
                }
            }
        }

    }

}