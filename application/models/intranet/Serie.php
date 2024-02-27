<?php


class Serie extends CI_Model
{
    public static $table_name = "trabajo__series";

    public $id;
    public $rel_fip_id;
    public $serie;
    public $minimo;
    public $maximo;
    public $factor;
    public $rentabilidad;

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
        $instance->rel_fip_id = $stdClass->rel_fip_id;
        $instance->serie = $stdClass->serie;
        $instance->minimo = $stdClass->minimo;
        $instance->maximo = $stdClass->maximo;
        $instance->factor = $stdClass->factor;
        $instance->rentabilidad = $stdClass->rentabilidad;
        return $instance;
    }


    /**
     * Obtiene un objeto tipo Serie, mediante el id
     * @param $id
     * @return array|Serie
     */
    public function getById($id)
    {
        $result = $this->intranet->get_where(self::$table_name, array('id' => $id))->result_object();
        if(!empty($result)) {
            return self::castFromDB($result[0]);
        }else{
            return $result;
        }
    }

    /**
     * @return Fip
     */
    public function getFip()
    {
        $this->load->model('intranet/Fip');
        return (new Fip())->getById($this->rel_fip_id);
    }

    /**
     * Obtiene la lista de series de un determinado fondo
     * @param $id_fip
     * @return array
     */
    public function getByFip($id_fip){

        $this->intranet->select('*');
        $this->intranet->from(self::$table_name);
        $this->intranet->where('rel_fip_id', $id_fip);
        $this->intranet->order_by('minimo','asc');
        $results = $this->intranet->get()->result_object();

        if(count($results) > 0){
            $list = array();
            foreach ($results as $result) {
                $list[] = self::castFromDB($result);
            }
            return $list;
        }else{
            return $results;
        }
    }
}