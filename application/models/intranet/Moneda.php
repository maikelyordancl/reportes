<?php
/**
 * Created by PhpStorm.
 * User: ezepeda
 * Date: 10/26/18
 * Time: 5:06 PM
 */

class Moneda extends CI_Model
{
    public static $table_name = "trabajo__monedas";

    const UF = 1;
    const CLP = 2;
    const USD = 3;
    const EUR = 4;

    public $id;
    public $moneda;

    public function __construct()
    {
        parent::__construct();
        $this->intranet = $this->load->database('intranet_aicapitals', true);
    }

    /**
     * Convierte un objeto de tipo BD a Tipo Moneda
     * @param stdClass $stdClass
     * @return Moneda
     */
    public static function castFromDB(stdClass $stdClass)
    {
        $instance = new self();
        $instance->id = $stdClass->id;
        $instance->moneda = $stdClass->moneda;
        return $instance;
    }

    /**
     * Obtiene todos los tipos de monedas
     * @return array
     */
    public function all()
    {
        $results = $this->intranet->get(Moneda::$table_name)->result_object();
        if(empty($results)){
            return $results;
        }

        $monedas = array();
        foreach ($results as $result){
            $monedas[] = Moneda::castFromDB($result);
        }

        return $monedas;
    }

    /**
     * Retorna un objeto de Tipo Moneda en base a una búsqueda por ID
     * @param $id
     * @return Moneda
     */
    public function getById($id)
    {
        return Moneda::castFromDB($this->intranet->get_where(Moneda::$table_name, array('id' => $id))->result_object()[0]);
    }
}