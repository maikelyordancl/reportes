<?php
/**
 * Created by PhpStorm.
 * User: wafle
 * Date: 11-12-17
 * Time: 15:01
 */

class Fip extends CI_Model
{

    public static $name_table = "trabajo__fip";
    public static $name_table_estado_ventas = "trabajo__estado_ventas";
    public static $name_table_banco = "trabajo__banco";


    public $id;
    public $id_fip;
    public $rel_estado_id;
    public $rel_categoria_id;
    public $moneda_id;
    public $nombre_fondo;
    public $nombre_comercial;
    public $meta;
    public $inicio;
    public $termino;
    public $minimo_inversion;
    public $series;
    public $rentabilidad_esperada;
    public $rentabilidad_final;
    public $direccion;
    public $duracion_estimada;
    public $duracion_real;
    public $longitud;
    public $latitud;
    public $comuna;
    public $ciudad;
    public $rubro;
    public $slug;
    public $logo;
    public $descripcion;
    public $slogan;
    public $rut;
    public $dv;
    public $por_cerrar;
    public $pdf_presentacion;
    public $pdf_reglamento;
    public $pdf_contrato_borrador;
    public $nombre_largo;
    public $cantidad;
    public $mes_fip;
    public $slug_fip;
    public $descripcion_principal;
    public $rel_estado_venta_id;
    public $cantidad_vendidos;
    public $mes_fip_manual;
    public $fecha_citacion;
    public $hora_citacion;
    public $fecha_citacion_2;
    public $hora_citacion_2;
    public $banco;
    public $cuenta_corriente;
    public $email_prueba;
    public $cantidad_citacion;
    public $motivo_asamblea;
    public $pagare;
    public $tipo_citacion;
    public $enviar_cartola;
    public $pdf_pagare_borrador;
    public $ppt_presentacion;
    public $rel_banco_id;
    public $rel_fip_indicador_id;
    public $is_multi_calls;


    private $intranet;
    /**
     * Fip constructor.
     */

    public function __construct()
    {
        parent::__construct();
        $this->intranet = $this->load->database('intranet_aicapitals', true);
    }

    public function getForOption()
    {
        $query = "select trabajo__fip.id,
                      trabajo__fip.nombre_fondo||' - '|| trabajo__estado_fip.estado_fip as nombre_fondo
                  from trabajo__fip
                 INNER JOIN trabajo__estado_fip
                        ON trabajo__fip.rel_estado_id = trabajo__estado_fip.id
                ORDER BY trabajo__fip.id DESC";

        return $this->intranet->query($query)->result_array();
    }

    public static function castFromDB(stdClass $stdClass)
    {
        $instance = new self();
        $instance->id = $stdClass->id;
        $instance->id_fip = $stdClass->id_fip;
        $instance->rel_estado_id = $stdClass->rel_estado_id;
        $instance->rel_categoria_id = $stdClass->rel_categoria_id;
        $instance->moneda_id = $stdClass->moneda_id;
        $instance->nombre_fondo = $stdClass->nombre_fondo;
        $instance->nombre_comercial = $stdClass->nombre_comercial;
        $instance->meta = $stdClass->meta;
        $instance->inicio = $stdClass->inicio;
        $instance->termino = $stdClass->termino;
        $instance->minimo_inversion = $stdClass->minimo_inversion;
        $instance->series = $stdClass->series;
        $instance->rentabilidad_esperada = $stdClass->rentabilidad_esperada;
        $instance->rentabilidad_final = $stdClass->rentabilidad_final;
        $instance->direccion = $stdClass->direccion;
        $instance->duracion_estimada = $stdClass->duracion_estimada;
        $instance->duracion_real = $stdClass->duracion_real;
        $instance->longitud = $stdClass->longitud;
        $instance->latitud = $stdClass->latitud;
        $instance->comuna = $stdClass->comuna;
        $instance->ciudad = $stdClass->ciudad;
        $instance->rubro = $stdClass->rubro;
        $instance->slug = $stdClass->slug;
        $instance->logo = $stdClass->logo;
        $instance->descripcion = $stdClass->descripcion;
        $instance->slogan = $stdClass->slogan;
        $instance->rut = $stdClass->rut;
        $instance->dv = $stdClass->dv;
        $instance->por_cerrar = $stdClass->por_cerrar;
        $instance->pdf_presentacion = $stdClass->pdf_presentacion;
        $instance->pdf_reglamento = $stdClass->pdf_reglamento;
        $instance->pdf_contrato_borrador = $stdClass->pdf_contrato_borrador;
        $instance->nombre_largo = $stdClass->nombre_largo;
        $instance->cantidad = $stdClass->cantidad;
        $instance->mes_fip = $stdClass->mes_fip;
        $instance->slug_fip = $stdClass->slug_fip;
        $instance->descripcion_principal = $stdClass->descripcion_principal;
        $instance->rel_estado_venta_id = $stdClass->rel_estado_venta_id;
        $instance->cantidad_vendidos = $stdClass->cantidad_vendidos;
        $instance->mes_fip_manual = $stdClass->mes_fip_manual;
        $instance->fecha_citacion = $stdClass->fecha_citacion;
        $instance->hora_citacion = $stdClass->hora_citacion;
        $instance->fecha_citacion_2 = $stdClass->fecha_citacion_2;
        $instance->hora_citacion_2 = $stdClass->hora_citacion_2;
        $instance->banco = $stdClass->banco;
        $instance->cuenta_corriente = $stdClass->cuenta_corriente;
        $instance->email_prueba = $stdClass->email_prueba;
        $instance->cantidad_citacion = $stdClass->cantidad_citacion;
        $instance->motivo_asamblea = $stdClass->motivo_asamblea;
        $instance->pagare = $stdClass->pagare;
        $instance->tipo_citacion = $stdClass->tipo_citacion;
        $instance->enviar_cartola = $stdClass->enviar_cartola;
        $instance->pdf_pagare_borrador = $stdClass->pdf_pagare_borrador;
        $instance->ppt_presentacion = $stdClass->ppt_presentacion;
        $instance->rel_banco_id = $stdClass->rel_banco_id;
        $instance->rel_fip_indicador_id = $stdClass->rel_fip_indicador_id;
        $instance->is_multi_calls = $stdClass->is_multi_calls;
        return $instance;
    }

    /**
     * Retorna las Series del Fondo
     * @return array
     */
    public function getSeries(){
        $this->load->model('intranet/Serie');
        return (new Serie())->getByFip($this->id);
    }

    /**
     * Retorna la informacion adicional correspondiente
     * fondo de inversion
     * @return array|Fipinfoextra
     */
    public function getInfoExtra(){
        $this->load->model('intranet/Fipinfoextra');
        return (new Fipinfoextra())->getById($this->id);
    }

    /**
     * Obtiene un objeto tipo Fip, mediante el id
     * @param $id
     * @return Fip
     */
    public function getById($id)
    {
        $result = $this->intranet->get_where(Fip::$name_table, array('id' => $id))->result_object();
        if(!empty($result)) {
            return Fip::castFromDB($result[0]);
        }else{
            return $result;
        }
    }

    /**
     * Retorna la moneda con la que funciona el fondo de inversion
     * @return Moneda
     */
    public function getMoneda()
    {
        $this->load->model('intranet/Moneda');
        return (new Moneda())->getById($this->moneda_id);
    }

    /**
     * Retorna el indicador asociado al fondo de inversión que previaente estará parametrizado en el sistema
     * @return Fipindicador|null
     */
    public function getIndicador(){
        $this->load->model('intranet/Fipindicador');
        return (new Fipindicador())->getById($this->rel_fip_indicador_id);
    }
}