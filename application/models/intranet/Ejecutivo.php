<?php
/**
 * Created by PhpStorm.
 * User: wafle
 * Date: 28-11-17
 * Time: 04:57
 */

class Ejecutivo extends CI_Model
{

    private $intranet;
    /**
     * Ejecutivo constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->intranet = $this->load->database('intranet_aicapitals', true);
    }

    public function get()
    {
        return  $this->intranet->get("vw_ejecutivos")->result_array();
    }
}