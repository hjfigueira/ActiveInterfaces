<?php
namespace ActiveInterfaces\Interfaces;

/**
 * Interface GenericPaginator
 *
 * Interface para regular a comunicação entre qualquer widget e as formas de paginação que podem ser criadas
 *
 */
interface GenericPaginator {

    /**
     * @param null $location string Define qual será a base da url utilizada nos link
     */
    public function __construct($location = null);

    /**
     * Método principal para a geração da paginação
     *
     * @param $queryParameter   Array Parametros das querys
     * @param $total            int Total de registros
     * @param $perPage          int Registros por página
     * @param int $page         int Página Atual
     * @return mixed
     */
    public function getPagination($queryParameter,$total,$perPage,$page = 1);

    /**
     * Método para recurar o HTML montado e formatado da paginação
     *
     * @return mixed
     */
    public function getHtml();
}