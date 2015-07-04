<?php require('vendor\autoload.php');

use \ActiveInterfaces\Elements\Form\ActiveForm;
use \ActiveInterfaces\Drivers\Request\RawDataRequest;
use \ActiveInterfaces\Elements\Form\ActiveInput;
use \ActiveInterfaces\Elements\Form\ActiveFieldset;

class FormExemplo extends ActiveForm
{
    /**
     * @var ActiveInput
     */
    public $nome;

    /**
     * @var ActiveFieldset
     */
    public $formset;

    public function getName()
    {
        return 'login';
    }

    protected function buildHtmlElement()
    {
        parent::buildHtmlElement();

        $this->addElement(new ActiveInput(),'nome','Nome');
        $this->addElement(new ActiveInput(),'senha','Senha');
    }

}

//Controller exibição form.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    echo '<h1>POST</h1>';
    $formExemplo    = new FormExemplo(new RawDataRequest());

    echo 'Nome  : '.$formExemplo->nome->getValue().'<br>';
    echo 'Senha : '.$formExemplo->senha->getValue();
    echo '</br></br>';
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    echo '<h1>GET</h1>';
    $formExemplo    = new FormExemplo();
    $formExemplo->nome->setValue('HUEHUE');

}

?>

<?php $formExemplo->render('','POST',['class' => 'form'],function($campos){ ?>

    <?php echo $campos['nome'] ?>

    <?php echo $campos['senha'] ?>

    <button type="submit" >Enviar</button>
    <button type="reset" >Reset</button>

<?php }); ?>