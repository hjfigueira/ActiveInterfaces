<?php

namespace ActiveInterfaces\Elements
{
    use ActiveInterfaces\Interfaces\GenericDatasource;

    /**
     * Classe para gerar objetos para serem usados nas views, esses objetos devem ser utilizados para repetir qualquer
     * fonte de dados que implemente a interface GenericDatasource, a área de repetição deve ser definida através de uma
     * função anonima.
     *
     * Não implementa paginação;
     *
     * @author Hélio Figueira Junior
     * @since 26/09/2014
     */
    class ActiveRepeater {

        //Coleção geral dos dados
        protected $collection     = null;

        //Metas dados sobre a coleção
        protected $total          = 0;      //Total de Itens
        protected $index          = 0;      //Indice atual dos Itens

        //Headers and Footers
        private $beforeList;                //Executada ou exibida antes da listagem
        private $afterList;                 //Executada ou exibida depois da listagem

        //Closures
        private $empty;                     //Mensagem padrão quando não existem itens
        private $beforeItem ;               //Executado ou exibido antes de cada item
        private $afterItem;                 // Executado ou exibido depois de cada item

        //Drivers
        protected  $dataSource;             //Fonte de dados @see GenericDatasource


        /**
         * Define qual o datasource padrão;
         * @param GenericDataSource $dataSource
         */
        public function setDatasource(GenericDatasource $dataSource)
        {
            $this->dataSource = $dataSource;
        }

        /**
         * Gera o collection através do GenericDatasource;
         */
        public function create()
        {
            $this->collection   = $this->dataSource->getArray();
            $this->total        = $this->dataSource->getTotal();
        }

        /**
         * Recebe uma função anonima como parametro para repetir
         * @param callable $repetable
         */
        public function setRepetable(\Closure $repetable)
        {

            if(count($this->collection) === 0)
            {
                $this->getEmpty();
            }
            else
            {
                $this->getBeforeList();
                foreach($this->collection as $index => $item)
                {
                    $this->index = $index;
                    $this->getBeforeItem($item,$index);
                    $repetable($item,$index);
                    $this->getAfterItem($item,$index);
                }
                $this->getAfterList();
            }

        }

        /**
         * Define qual será a mensagem a ser exibida , ou a função a ser chamada caso não existam itens
         * @param callable $function
         */
        public function setEmpty(\Closure $function)
        {
            $this->empty = $function;
        }

        /**
         * Executa ou exibe o que foi definido na variável empty
         */
        public  function getEmpty()
        {
            if(is_callable($this->empty) and $this->empty != null)
            {
                $this->empty;
            }
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        /**
         * Define uma função ser executada antes de cada item
         * @param callable $function
         */
        public function setBeforeItem(\Closure $function)
        {
            $this->beforeItem = $function;
        }

        /**
         * Executa/exiba o valor antes de cada item
         */
        public function getBeforeItem()
        {
            $this->beforeItem;
        }

        /**
         * Define uma função para ser executada antes de cada item
         * @param callable $function
         */
        public function setAfterItem(Closure $function)
        {
            $this->afterItem = $function;
        }

        /**
         * Executa/exiba o valor antes de cada item
         */
        public function getAfterItem()
        {
            $this->afterItem;
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        /**
         * Define uma função para ser executada antes da listagem
         * @param callable $function
         */
        public function setAfterList(Closure $function)
        {
            $this->afterList = $function;
        }

        /**
         * Executa/exiba o valor antes da listagem
         */
        public function getAfterList()
        {
            $afterList =& $this->afterList;
            if($afterList != null)
            {
                $afterList();
            }
        }

        /**
         * Define uma função para ser executada antes da listagem
         * @param callable $function
         */
        public function setBeforeList(Closure $function)
        {
            $this->beforeList = $function;
        }

        /**
         * Executa/exiba o valor antes da listagem
         */
        public function getBeforeList()
        {
            $beforeList =& $this->beforeList;
            if($beforeList != null)
            {
                $beforeList();
            }
        }


    }

}