<?php


class Fipindicador extends CI_Model
{
    public static $name_table = "trabajo__fip_indicador";

    const INDICADOR_TIR = 1;
    const INDICADOR_ROE = 2;

    public $id;
    public $nombre;
    public $descripcion;

    private $intranet;
    public function __construct()
    {
        parent::__construct();
        $this->intranet = $this->load->database('intranet_aicapitals', true);
    }

    public static function castFromDB(stdClass $stdClass)
    {
        $instance = new self();
        $instance->id = $stdClass->id;
        $instance->nombre = $stdClass->nombre;
        $instance->descripcion = $stdClass->descripcion;
        return $instance;
    }

    /**
     * @return Fipindicador
     * @throws Exception
     */
    public function add()
    {
        $this->id = $this->getMaxId() + 1;
        $this->intranet->insert(self::$name_table, $this);
        return $this->getById($this->id);
    }

    /**
     * Obtiene el ID Máximo registrado en la base de datos
     * @return mixed
     */
    public function getMaxId()
    {
        $this->intranet->select_max('id');
        $query = $this->intranet->get(self::$name_table);
        $array = $query->result_array();
        return $array[0]['id'];
    }

    /**
     * Obtiene la lista de objetos que se encuentran en la tabla
     * @return array
     */
    public function all()
    {
        $this->intranet->select('*');
        $this->intranet->from(self::$name_table);
        $this->intranet->order_by('id', 'desc');
        $results = $this->intranet->get()->result_object();
        $listOjb = array();
        if(count($results) > 0){
            foreach ($results as $result) {
                $listOjb[] = self::castFromDB($result);
            }
        }
        return $listOjb;

    }

    /**
     * Retorna un indicador a través de un id asignado en la funcion
     * @param $id_indicador
     * @return Fipindicador|null
     */
    public function getById($id_indicador){
        $results = $this->intranet->get_where(self::$name_table, array('id' => $id_indicador ))->result_object();
        if(count($results) > 0){
            return self::castFromDB($results[0]);
        }
        return null;
    }
}