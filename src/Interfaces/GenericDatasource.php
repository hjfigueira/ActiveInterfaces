<?php
namespace ActiveInterfaces\Interfaces;

/**
 * Interface GenericDatasource
 *
 * Interface para definir um padrão para qualquer classe que seja uma fonte de dados para a seua utilização em qualquer
 * Widget, sacou ?
 */

interface GenericDatasource
{

    /**
     * Define a quantidade de registos por página
     *
     * @param $perPage int Quantidade de registros
     * @return mixed
     */
    public function setPerPage($perPage = 1);

    /**
     * Define qual a página atual
     *
     * @param $page int Página atual;
     * @return mixed
     */
    public function setPage($page);

    /**
     * Inclui uma condição para ser processa durante a execução da consulta.
     *
     * @param $field string Campo para executar a consulta
     * @param $operacao string Operação que será executada
     * @param $value string/int Valor para comparação
     * @return mixed
     */
    public function setWhere($field, $operacao, $value);

    /**
     *Define a ordem para ser utilizada na listagem
     *
     * @param null $field
     * @param null $order
     * @return mixed
     */
    public function setOrder($field = null,$order = null);

    /**
     * Retorna um array dos dados, sejam quais for.
     *
     * @return mixed
     */
    public function getArray();

    /**
     * Retorna um int com a quantidade de registros
     *
     * @return mixed
     */
    public function getTotal();

}