<?php
/**
 * Created by PhpStorm.
 * User: ezepeda
 * Date: 15-02-18
 * Time: 18:12
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Messages extends CI_Model
{
    /**
     * @var Messages $id id autoincrement
     */
    public $id;
    /**
     * @var Tasks $tasks_id tarea de donde proviene
     */
    public $tasks_id;
    /**
     * @var Messages $type Tipo sms o mail
     */
    public $type;
    public $date;
    public $date_delivery;
    public $message;
    public $contact_from;
    public $contact_to;
    public $user_id;
    public $status;
    public $status_desc;


    private $webservices;

    public function __construct()
    {
        parent::__construct();
        $this->webservices = $this->load->database('webservices', TRUE);
    }

    /**
     * @param $id
     * @return mixed Obtiene el mensaje en base al ID o un grupo de mensajes en base a la tarea.
     */
    public function getMessage($id)
    {
        return $this->webservices->get_where('messages', array("id" => $id))->result_object();
    }

    public function getMessagesFromTask($task_id)
    {
        return $this->webservices->get_where('messages', array("tasks_id" => $task_id, "status" => "waiting"))->result_object();
    }

}