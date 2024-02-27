<?php
/**
 * Created by PhpStorm.
 * User: ezepeda
 * Date: 10/16/18
 * Time: 3:56 PM
 */

class Call extends CI_Model
{
    public static $name_table = "trabajo__call_fip";

    public $id;
    public $nombre;
    public $fecha_inicio;
    public $fecha_fin;
    public $capacidad;
    public $created_by;
    public $created_date;
    public $rel_fip_id;
    public $estado;

    private $intranet;
    /**
     * Fip constructor.
     */

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
        $instance->fecha_inicio = $stdClass->fecha_inicio;
        $instance->fecha_fin = $stdClass->fecha_fin;
        $instance->capacidad = $stdClass->capacidad;
        $instance->created_by = $stdClass->created_by;
        $instance->created_date = $stdClass->created_date;
        $instance->rel_fip_id = $stdClass->rel_fip_id;
        $instance->estado = $stdClass->estado;
        return $instance;
    }

    /**
     * Obtiene un resultado de Tipo Call
     *
     * @param int $id
     * @return Call|null
     */
    public function getById($id){
        $this->intranet->select();
        $this->intranet->from(self::$name_table);
        $this->intranet->where('id', $id);

        $results = $this->intranet->get()->result_object();
        if(isset($results[0])){
            return self::castFromDB($results[0]);
        }else{
            return null;
        }
    }

    /**
     * Retorna los calls pertenecientes a un determinado FIP
     *
     * @param int $id_fip
     * @return array
     */
    public function getByFipId($id_fip){
        $this->db->select();
        $this->db->from(self::$name_table);
        $this->db->where('rel_fip_id', $id_fip);
        $this->db->order_by('fecha_inicio', 'asc');
        $results = $this->db->get()->result_object();
        $arr_calls = array();
        if(count($results) > 0){
            foreach($results as $result){
                $arr_calls[] = self::castFromDB($result);
            }
            return $arr_calls;
        }else{
            return $arr_calls;
        }
    }


    /**
     * Obtiene el máximo id del Objeto
     *
     * @return int
     */
    public function getMaxId()
    {
        $this->db->select_max('id');
        $query = $this->db->get(self::$name_table);
        $array = $query->result_array();
        return $array[0]['id'];
    }


    /**
     * Permite agregar un objeto
     * @return Call
     * @throws Exception
     */
    public function add()
    {
        $this->id = $this->getMaxId() + 1;
        $this->created_date = (new DateTime())->format('Y-m-d H:i:s');
        $this->db->insert(self::$name_table, $this);

        $this->actualizarMetaFip();

        return $this->getById($this->id);
    }    

    /**
     * Permite editar un objeto
     * @param Call $obj
     * @return bool
     */
    public function edit(Call $obj)
    {
        $status = $this->db->update(self::$name_table, $obj, array('id' => $obj->id));
        if($status){
            $this->actualizarMetaFip();
        }
        
        return $status;
    }

    /**
     * GetSeries obtienen las series que corresponden al CALL
     *
     * @return array
     */
    public function getSeries()
    {
        $this->load->model('intranet/Callserie');
        return (new Callserie())->getByCallId($this->id);
    }

    /**
     * Obtiene el fip que está relacionado al call
     *
     * @return Fip
     */
    public function getFip()
    {
        $this->load->model('intranet/Fip');
        return (new Fip())->getById($this->rel_fip_id);
    }

    /**
     * Obtiene el usuario quien creo el registro
     *
     * @return User
     */
    public function getUserCreated()
    {
        $this->load->model('User');
        return (new User())->getById($this->created_by);
    }

    /**
     * Obtiene el último call correspondiente al fondo de inversión
     *
     * @param int $id_fip
     * @return Call|ResultsObject
     */
    public function getLastByFipId($id_fip)
    {
        $this->intranet->select('*');
        $this->intranet->from(self::$name_table);
        $this->intranet->where('rel_fip_id', $id_fip);
        $this->intranet->order_by('fecha_inicio', 'DESC');
        $results = $this->intranet->get()->result_object();
        if(count($results) > 0){
            return self::castFromDb($results[0]);
        }

        return null;
    }

    /**
     * Actualiza la capacidad del fondo dependiendo de la cantidad de calls 
     * que tiene en el caso que sea un multicalls
     * @return void
     */
    private function actualizarMetaFip(){
        $fip = $this->getFip();
        $array_calls = $fip->getCalls();
        if($fip->is_multi_calls){
            if(count($array_calls) > 0){
                $total_capacidad = 0;
                foreach($array_calls as $call){
                    $total_capacidad = $total_capacidad + $call->capacidad;
                }                
                $fip->meta = $total_capacidad;
                $fip->edit($fip);
            }
        }
    }

    public function getLikeByNombreInfoExtra($string_nombre = null){
        $this->intranet->select();
        $this->intranet->from(self::$name_table);
        $this->intranet->where('rel_fip_id', $this->rel_fip_id);
        if(is_null($string_nombre)){
            $this->intranet->like('nombre', $this->nombre);
        }else{
            $this->intranet->like('nombre', $string_nombre);
        }        
        $results = $this->intranet->get()->result_object();
        if(count($results) > 0){
            return self::castFromDb($results[0]);
        }
    }
}