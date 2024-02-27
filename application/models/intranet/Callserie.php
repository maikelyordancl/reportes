<?php
/**
 * Created by PhpStorm.
 * User: ezepeda
 * Date: 10/16/18
 * Time: 3:56 PM
 */

class Callserie extends CI_Model
{
    public static $name_table = "trabajo__call_serie";

    public $id;
    public $serie;
    public $minimo;
    public $maximo;
    public $factor;
    public $rentabilidad;
    public $rel_call_fip_id;

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
        $instance->serie = $stdClass->serie;
        $instance->minimo = $stdClass->minimo;
        $instance->maximo = $stdClass->maximo;
        $instance->factor = $stdClass->factor;
        $instance->rentabilidad = $stdClass->rentabilidad;
        $instance->rel_call_fip_id = $stdClass->rel_call_fip_id;
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
     * Obtiene la lista de series de un determinado call
     *
     * @param int $id_call
     * @return array
     */
    public function getByCallId(int $id_call)
    {
        $this->intranet->select();
        $this->intranet->from(self::$name_table);
        $this->intranet->where('rel_call_fip_id', $id_call);
        $this->intranet->order_by('minimo', 'asc');
        $results = $this->intranet->get()->result_object();
        $arr_result = array();
        
        if(count($results) > 0){
            foreach($results as $result){
                $arr_result[] = self::castFromDB($result);
            }

            return $arr_result;
        }
        return $arr_result;

    }

    /**
     * @return Callserie
     * @throws Exception
     */
    public function add()
    {
        $this->id = $this->getMaxId() + 1;
        $this->intranet->insert(self::$name_table, $this);
        return $this->getById($this->id);
    }

    /**
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
     * @param Callserie $obj
     * @return bool
     */
    public function edit(Callserie $obj)
    {
        return $this->intranet->update(self::$name_table, $obj, array('id' => $obj->id));
    }

    /**
     * Elimina un objeto de tipo Callserie de la base de datos
     * @return mixed
     */
    public function delete(){
        $this->intranet->delete(self::$name_table, array('id' => $this->id));
        return $this->intranet->affected_rows();
    }

    /**
     * Obtiene el Call que corresponde a la serie
     *
     * @return Call
     */
    public function getCall()
    {
        $this->load->model('intranet/Call');
        return (new Call())->getById($this->rel_call_fip_id);
    }

}
