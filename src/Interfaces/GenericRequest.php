<?php

namespace ActiveInterfaces\Interfaces
{

    use ActiveInterfaces\Elements\Form\ActiveForm;

    interface GenericRequest {

        public function getPost($indexBase);

        public function getGet($indexBase);

        public function populate(ActiveForm $form);
    }
}