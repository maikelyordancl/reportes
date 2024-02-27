<?php
/**
 * Created by PhpStorm.
 * User: ezepeda
 * Date: 10/26/18
 * Time: 5:01 PM
 */

class Monedavalor extends CI_Model
{
    public static $table_name = "trabajo__monedas_valor";

    const UF = 1;
    const CLP = 2;
    const USD = 3;
    const EUR = 4;

    public $id;
    public $rel_moneda_id;
    public $fecha;
    public $valor;

    public function __construct()
    {
        parent::__construct();
        $this->intranet = $this->load->database('intranet_aicapitals', true);
    }

    /**
     * Transforma desde la base de datos un objeto de tipo stdClass
     * hacia un objeto de tipo MonedaValor
     * @param stdClass $stdClass
     * @return Monedavalor
     */
    public static function castFromDB(stdClass $stdClass)
    {
        $instance = new self();
        $instance->id = $stdClass->id;
        $instance->rel_moneda_id = $stdClass->rel_moneda_id;
        $instance->fecha = $stdClass->fecha;
        $instance->valor = $stdClass->valor;
        return$instance;
    }

    /**
     * Obtiene un arreglo de tipo MonedaValor con todas las monedas que existen
     * @return array
     */
    public function all()
    {
        $results = $this->intranet->get(Monedavalor::$table_name)->result_object();
        if(empty($results)){
            return $results;
        }

        $monedas = array();
        foreach ($results as $result) {
            $monedas[] = Monedavalor::castFromDB($result);
        }
        return $monedas;
    }

    /**
     * Obtiene el tipo de Moneda que se encuentra en la base de datos
     * @return Moneda
     */
    public function getMoneda()
    {
        $this->load->model('intranet/moneda');
        $result = $this->intranet->get_where(Moneda::$table_name, array('id' => $this->rel_moneda_id))->result_object();
        if(empty($result))
            return $result;
        return Moneda::castFromDB($result[0]);
    }

    /**
     * Obtiene un arreglo de MonedasValor, de acuerdo a la fecha ingresada
     * @param $date
     * @return array
     */
    public function getByDate(DateTime $date)
    {
        $results = $this->intranet->get_where(Monedavalor::$table_name, array('fecha' => $date->format('Y-m-d')))->result_object();
        if(empty($results))
            return $results;

        $monedas = array();
        foreach ($results as $result){
            $monedas[] = Monedavalor::castFromDB($result);
        }
        return $monedas;
    }

    /**
     * Obtiene la última moneda valor ingresada en el sistema
     * @return Monedavalor
     */
    public function getLast()
    {
        $this->intranet->select('*');
        $this->intranet->from(Monedavalor::$table_name);
        $this->intranet->order_by('id', 'desc');
        $this->intranet->limit(1);

        return self::castFromDB($this->intranet->get()->result_object()[0]);

    }

    /**
     * @param null $id
     * @param int $tipo_moneda
     * @param null $date_start
     * @param null $date_end
     * @return mixed
     */
    public function get($id = NULL, $tipo_moneda = 1, $date_start = NULL, $date_end = NULL)
    {
        if(!is_null($date_start)){
            return $this->intranet->get_where(MonedaValor::$table_name, array(
                    "fecha" => $date_start,
                    "rel_moneda_id" => $tipo_moneda)
            )->result_object();
        }else{
            return $this->intranet->get_where(MonedaValor::$table_name, array("id" => $id))->result_object();
        }
    }

}