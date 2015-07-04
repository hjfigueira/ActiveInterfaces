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

    class CodeigniterDataRequest implements GenericRequest
    {
        private $ci;

        public function __construct()
        {
            $this->ci       = new \ArrayObject();
        }

        public function getPost()
        {
            return $this->ci->input->post();
        }

        public function getGet()
        {
            return $this->ci->input->get();
        }

        public function populate(ActiveForm $form)
        {

        }

    }

}