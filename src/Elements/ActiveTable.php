<?php
namespace ActiveInterfaces\Elements
{
    class ActiveTable extends ActivePageRepeater {

        private $header;
        private $footer;


        public function create()
        {
            $this->paginaAtual  = $this->getParameter('page',1);
            $this->porPagina    = $this->getParameter('perPage',$this->porPagina);

            $this->dataSource->setPage($this->paginaAtual);
            $this->dataSource->setPerPage($this->porPagina);

            $field = isset($this->params['order']) ? array_keys($this->params['order'])[0] : null;
            $order = isset($this->params['order']) ? array_values($this->params['order'])[0] :null ;

            $this->dataSource->setOrder($field,$order);

            if((isset($this->params['findIn']) and count($this->params['findIn']) > 0))
            {
                foreach($this->params['findIn'] as $field => $value)
                {
                    $this->dataSource->setWhere($field,'=',$value);
                }
            }

            $this->collection   = $this->dataSource->getArray();
            $this->total        = $this->dataSource->getTotal();

            $this->paginator->getPagination('page',$this->total,$this->porPagina,$this->paginaAtual);
        }

        /**
         * Getters e Setters dos cabecalhos
         * @param array $headers
         */
        public function setHeader($headers)
        {
            $this->header = $headers;
        }

        public function getHeader()
        {
            echo '<thead><tr>';
            if(count($this->header) > 0)
            {
                foreach($this->header as $field => $header)
                {
                    $width = isset($header['width']) ? $header['width'] : '';
                    $fieldOrder     = isset($this->params['order']) ? array_keys($this->params['order'])[0] : null;
                    $directionOrder = isset($this->params['order']) ? array_values($this->params['order'])[0] : null ;

                    if(isset($header['sortable']) and $header['sortable'] === true)
                    {
                        $link = '<a href="?order['.$field.']=asc">';
                        $icon = '';
                        $linkClose = '</a>';
                    }
                    else
                    {
                        $link = '';
                        $icon = '';
                        $linkClose = '';
                    }


                    echo '<th width="'.$width.'" >';

                    if($fieldOrder === $field and strtoupper($directionOrder) == 'ASC')
                    {
                        $link = '<a href="?order['.$field.']=desc">';
                        $icon = '<i class="glyphicon glyphicon-sort-by-attributes"></i>';
                    }
                    elseif($fieldOrder === $field and strtoupper($directionOrder) == 'DESC')
                    {
                        $link = '<a href="">';
                        $icon = '<i class="glyphicon glyphicon-sort-by-attributes-alt"></i>';
                    }

                    echo $link;
                    echo $icon;

                    echo isset($header['label']) ? $header['label'] : 'Undefined Label';

                    echo $linkClose;

                    echo '</th>';
                }

            }
            echo '</tr></thead>';
        }

        /**
         * Getters e Setters dos Footers
         * @param callable $footer
         */
        public function setFooter(Closure $footer)
        {
            $this->footer = $footer;
        }

        public function getFooter()
        {
            $footer =& $this->footer;

            echo '<tfoot><tr>';
            if(isset($this->footer))
            {
                $footer($this);
            }
            else
            {
                //Default
            }
            echo '</tr></tfoot>';

        }


        /**
         * Define qual será o código a ser repetido
         * @param callable $repetable Função anonima que vem da view.
         */
        public function setRepetable(Closure $repetable,$id = '',$class = 'table table-striped table-hover')
        {
            echo '<table id="'.$id.'" class="'.$class.'">';
            $this->getHeader();

            echo '<tbody>';
            if(count($this->collection) == 0)
            {
                $this->getEmpty();
            }
            else
            {
                $this->getBeforeList();
                foreach($this->collection as $index => $item)
                {
                    echo '<tr>';
                    $this->index = $index;
                    $this->getBeforeItem($item,$index);
                    $repetable($item,$index);
                    $this->getAfterItem($item,$index);
                    echo '</tr>';
                }
                $this->getAfterList();
            }
            echo '</tbody>';

            $this->getFooter();
            echo '</table>';
        }
    }
}