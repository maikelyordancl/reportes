<?php
/**
 * Created by PhpStorm.
 * User: ezepeda
 * Date: 15-02-18
 * Time: 18:13
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Tareas extends \CI_Controller
{
    public function index()
    {
        echo file_get_contents($this->config->item('server')['api'].'index.php/tareas/get/');
    }

}