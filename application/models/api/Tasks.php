<?php
/**
 * Created by PhpStorm.
 * User: ezepeda
 * Date: 15-02-18
 * Time: 18:12
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Model
{
    public $id;
    public $name;
    public $platform;
    public $date;
    public $date_executed;
    public $user_id;
    public $status;
    public $other;
    public $type;

    private $webservices;

    public function __construct()
    {
        parent::__construct();
        $this->webservices = $this->load->database('webservices', TRUE);
    }

    public function get($id)
    {
        return $this->db->get_where("tasks", array("id" => $id))->result_object;
    }

    public function get_single_task_created()
    {
        return $this->db->get_where("tasks", array("status"=> "created"), 1)->result_object();
    }

}