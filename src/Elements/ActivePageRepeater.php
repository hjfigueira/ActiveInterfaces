<?php

namespace ActiveInterfaces\Elements
{
    use ActiveInterfaces\Interfaces\GenericDatasource;
    use ActiveInterfaces\Interfaces\GenericPaginator;

    /**
     * Classe para gerar objetos para serem usados nas views, esses objetos devem ser utilizados para repetir qualquer
     * fonte de dados que implemente a interface GenericDatasource, a área de repetição deve ser definida através de uma
     * função anonima.
     *
     * Esse objeto suporta paginações
     *
     * @author Hélio Figueira Junior
     * @since 26/09/2014
     */
    class ActivePageRepeater extends ActiveRepeater{

        //Metas dados sobre a coleção
        protected $paginaAtual    = 1;
        protected $porPagina;
        protected $params         = null;

        //Drivers
        protected  $paginator      = null;


        /**
         * Construtor
         *
         * @param $porPagina    int Define a quantidade de registros por páginas
         */
        public function __construct($porPagina)
        {
            $this->porPagina = $porPagina;
        }

        /**
         * Setter dos parametros
         * @param array $arrayParams array Utilizado para armazenar os parametros.
         */
        public function setParameters($arrayParams = array())
        {
            $this->params = $arrayParams;
        }

        /**
         * Setter da fonte de dados
         * @param GenericDataSource $dataSource
         */
        public function setDatasource(GenericDatasource $dataSource)
        {
            $dataSource->setPerPage($this->porPagina);
            $dataSource->setPage($this->paginaAtual);
            $this->dataSource = $dataSource;
        }

        /**
         * Getter e Setters dos paginadores.
         * @param GenericPaginator $paginator
         */
        public function setPaginator(GenericPaginator $paginator)
        {
            $this->paginator = $paginator;
        }

        public function getPaginator()
        {
            return $this->paginator->getHtml();
        }

        /**
         * Prepara a consulta ao datasource e parametros para a exibição da tabela
         */
        public function create()
        {
            $this->paginaAtual = isset($this->params['page']) ? $this->params['page'] : 1;

            $this->dataSource->setPage($this->paginaAtual);
            $this->dataSource->setPerPage($this->porPagina);


            $field = isset($this->params['order']) ? array_keys($this->params['order']) : null;
            $order = isset($this->params['order']) ? array_values($this->params['order']) :null ;

            $this->dataSource->setOrder($field,$order);

            if((isset($this->params['findIn']) and count($this->params['findIn']) > 0))
            {

                foreach($this->params['findIn'] as $field => $value)
                {
                    $this->dataSource->setWhere($field,$value);
                }

            }

            $this->collection   = $this->dataSource->getArray();
            $this->total        = $this->dataSource->getTotal();

            $this->paginator->getPagination('page',$this->total,$this->porPagina,$this->paginaAtual);
        }

        /**
         * Define qual será o código a ser repetido
         * @param callable $repetable Função anonima que vem da view.
         */
        public function setRepetable(\Closure $repetable)
        {

            if(count($this->collection) == 0)
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
         * Método para tratamente e recuperação dos valores passados nos parametros do objeto.
         *
         * @param $paramName            string  Nome do parametro para recuperar
         * @param null $valueDefault    mixed   Se não houver o parametro, esse será o valor de retorno
         * @param null $valueOverwrite  mixed   Se houver o parametro, esse será o valor de retorno
         * @return null mixed Retorno do conteudo do parametro, ou dos valores sobrescritos/padrões
         */
        protected function getParameter($paramName, $valueDefault = null, $valueOverwrite = null)
        {
            $value = isset($this->params[$paramName]) ? $this->params[$paramName] : $valueDefault;

            if(($valueOverwrite != null) and isset($this->params[$paramName]))
            {
                $value = $valueOverwrite;
            }

            return $value;
        }
    }
}