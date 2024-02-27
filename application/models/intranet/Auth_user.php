<?php
/**
 * Created by PhpStorm.
 * User: wafle
 * Date: 28-11-17
 * Time: 02:40
 */

class Auth_user extends CI_Model
{
    private $id;
    private $username;
    private $first_name;
    private $last_name;
    private $tipo_usuario_id;
    private $email;

    private $intranet;

    public function __construct()
    {
        parent::__construct();
        $this->intranet = $this->load->database('intranet_aicapitals', true);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getTipoUsuarioId()
    {
        return $this->tipo_usuario_id;
    }

    /**
     * @param mixed $tipo_usuario_id
     */
    public function setTipoUsuarioId($tipo_usuario_id)
    {
        $this->tipo_usuario_id = $tipo_usuario_id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }


    public function get($id = NULL, $mail = NULL)
    {
        if(!is_null($id) and is_null($mail)){
            return  $this->intranet->get_where("auth_user", array("id" => $id))->result_array();
        }else{
            return  $this->intranet->get_where("auth_user", array("email" => $mail))->result_array();
        }
    }

}