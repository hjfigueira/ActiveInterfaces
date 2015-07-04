<?php

namespace Drivers\Pagination;
use ActiveInterfaces\Interfaces\GenericPaginator;

/**
 * Created by PhpStorm.
 * User: agencia110
 * Date: 25/09/14
 * Time: 14:59
 */

class IgniterBootstrapPaginator implements  GenericPaginator {

    public $paginationHtml = '';
    public $location;

    public function __construct($location = null)
    {
        $this->location  = $location;
    }

    public function getPagination($queryParameter,$total,$perPage,$page = 1)
    {
        $ci =& get_instance();
        $ci->load->library('pagination');

        $config['base_url'] = $this->location.'/?';
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = $queryParameter;
        $config['total_rows'] = $total;

        $config['per_page'] = $perPage;

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li title="Anterior">';
        $config['prev_tag_close'] = '</li>';

        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li title="Próximo">';
        $config['next_tag_close'] = '</li>';

        $config['first_link'] = '<i class="glyphicon glyphicon-fast-backward"></i>';
        $config['first_tag_open'] = '<li title="Primeira página">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = '<i class="glyphicon glyphicon-fast-forward"></i>';
        $config['last_tag_open'] = '<li title="Última página">';
        $config['last_tag_close'] = '</li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $ci->pagination->initialize($config);
        $this->paginationHtml = $ci->pagination->create_links();
    }


    public function getHtml()
    {
        return $this->paginationHtml;
    }

} 