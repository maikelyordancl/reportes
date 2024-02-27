<?php
/**
 * Created by PhpStorm.
 * User: wafle
 * Date: 28-11-17
 * Time: 04:45
 */

class Estado_cliente extends CI_Model
{

    private $intranet;
    /**
     * Estado_cliente constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->intranet = $this->load->database('intranet_aicapitals', true);
    }

    public function get()
    {
        return  $this->intranet->get("trabajo__estado_cliente")->result_array();
    }
}