<?php


class Fipinfoextra extends CI_Model
{
    public static $table_name = "trabajo__fipinfoextra";

    public $id;
    public $fecha_inicio;
    public $fecha_inicio_inversionista;
    public $fecha_primer_aporte_inversionista;
    public $fecha_inicio_obra;
    public $duracion_invitacion;
    public $fecha_estimada_termino_obra;
    public $fecha_estimada_cierre;
    public $fecha_real_proyectada_cierre;
    public $duracion_real_proyectada_cierre;
    public $atraso_meses;
    public $avance_meses;
    public $avance_porcentaje;
    public $plazo_liq_meses;
    public $fecha_ultimo_informativo;
    public $mostrar_rojo;
    public $mostrar_grafico_cartola;
    public $fecha_actualizacion;
    public $periodo_cartola;
    public $roe_serie_a;
    public $roe_serie_b;
    public $roe_serie_c;
    public $roe_serie_d;
    public $mostrar_roe;
    public $rel_fip_id;
    public $call;
    public $gestor;
    public $rel_indicador_fip_id;
    public $uf_estimada;

    private $intranet;
    /**
     * Fip constructor.
     */

    public function __construct()
    {
        parent::__construct();
        $this->intranet = $this->load->database('intranet_aicapitals', true);
    }

    /**
     * Castea un objeto de tipo de base de datos a un objeto de tipo codeigniter
     * Para que el framework pueda trabajar sin problemas
     * @param stdClass $stdClass
     * @return Fipinfoextra
     */
    public static function castFromDB(stdClass $stdClass)
    {
        $instance = new self();        
        $instance->fecha_real_proyectada_cierre = $stdClass->fecha_real_proyectada_cierre;
        $instance->fecha_inicio = $stdClass->fecha_inicio;
        $instance->fecha_inicio_inversionista = $stdClass->fecha_inicio_inversionista;
        $instance->fecha_primer_aporte_inversionista = $stdClass->fecha_primer_aporte_inversionista;
        $instance->fecha_inicio_obra = $stdClass->fecha_inicio_obra;
        $instance->duracion_invitacion = $stdClass->duracion_invitacion;
        $instance->fecha_estimada_termino_obra = $stdClass->fecha_estimada_termino_obra;
        $instance->fecha_estimada_cierre = $stdClass->fecha_estimada_cierre;
        $instance->duracion_real_proyectada_cierre = $stdClass->duracion_real_proyectada_cierre;
        $instance->atraso_meses = $stdClass->atraso_meses;
        $instance->avance_meses = $stdClass->avance_meses;
        $instance->avance_porcentaje = $stdClass->avance_porcentaje;
        $instance->plazo_liq_meses = $stdClass->plazo_liq_meses;
        $instance->fecha_ultimo_informativo = $stdClass->fecha_ultimo_informativo;
        $instance->mostrar_rojo = $stdClass->mostrar_rojo;
        $instance->mostrar_grafico_cartola = $stdClass->mostrar_grafico_cartola;
        $instance->rel_fip_id = $stdClass->rel_fip_id;
        $instance->fecha_actualizacion = $stdClass->fecha_actualizacion;
        $instance->periodo_cartola = $stdClass->periodo_cartola;
        $instance->roe_serie_a = $stdClass->roe_serie_a;
        $instance->roe_serie_b = $stdClass->roe_serie_b;
        $instance->roe_serie_c = $stdClass->roe_serie_c;
        $instance->roe_serie_d = $stdClass->roe_serie_d;
        $instance->mostrar_roe = $stdClass->mostrar_roe;
        $instance->call = $stdClass->call;
        $instance->gestor = $stdClass->gestor;
        $instance->rel_indicador_fip_id = $instance->rel_indicador_fip_id;
        $instance->uf_estimada = $stdClass->uf_estimada;

        


        return $instance;
    }

    /**
     * Obtiene un objeto tipo Fipinfoextra, mediante el id
     * @param $id
     * @return array|Fipinfoextra
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
     * Retorna el último registro ingresado
     * correspondiente a la información extra del fondo
     * @param $id_fip
     * @return array|Fipinfoextra
     */
    public function getLastInfoExtraForFip($id_fip, $call = null, $returnArray = false){
        $this->intranet->select('*');
        $this->intranet->from(self::$table_name);
        $this->intranet->where('rel_fip_id', $id_fip);
        if(!is_null($call)){
            $this->intranet->where('call', $call);
        }
        $this->intranet->order_by('id','desc');
        $this->intranet->limit(1);

        if($returnArray){
            $results = $this->intranet->get()->result_array();
            return $results;
        }else{
            $results = $this->intranet->get()->result_object();
        }

        if(count($results) > 0){
            return self::castFromDB($results[0]);
        }else{
            return $results;
        }
    }
}