<?php
/**
 * Created by PhpStorm.
 * User: ezepeda
 * Date: 10/16/18
 * Time: 12:31 PM
 */

class Aportesfip extends CI_Model
{
    public static $table_name = 'trabajo__aportes_fip';
    public static $table_name_estado_contrato = 'trabajo__estado_contrato';

    const Contrato_No_Firmado = 1;
    const Contrato_Firmado = 2;
    const Contrato_Faltan_Datos = 3;
    const Contrato_Pendiente_Cliente = 4;

    const Aportado = '1';
    const Comprometido = '2';
    const Incompletos = '3';
    const Liquidados = '4';
    const Caidos = '5';
    const Duplicados = '6';

    const tipo_aporte_cliente = 1;
    const tipo_aporte_reinvierte = 2;

    /**
     * Arreglo de Estados al que corresponde el aporte
     * @var array
     */
    public static $estados_pago = array(
        Aportesfip::Aportado        => array( 'name' => 'Aportado', 'color' => 'success'),
        Aportesfip::Comprometido    => array( 'name' => 'Comprometido', 'color' => 'warning'),
        Aportesfip::Incompletos     => array( 'name' => 'Incompletos', 'color' => 'dark') ,
        Aportesfip::Liquidados      => array( 'name' => 'Liquidado', 'color' => 'light'),
        Aportesfip::Caidos          => array( 'name' => 'Caidos', 'color' => 'danger') ,
        Aportesfip::Duplicados      => array( 'name' => 'Duplicado', 'color' => 'danger')
    );

    public $id;
    public $rel_aporte_fip_id;
    public $rel_cliente_id;
    public $rel_estado_contrato_id;
    public $rel_tipo_contrato_id;
    public $id_contrato;
    public $comprometido;
    public $comprometido_clp;
    public $fecha;
    public $aportado;
    public $observacion;
    public $fecha_firma;
    public $fecha_pago;
    public $contrato;
    public $rel_tipo_aporte_id;
    public $id_referido;
    public $id_ejecutivo;
    public $comision_referido;
    public $comision_ejecutivo;
    public $fecha_pago_referido;
    public $fecha_pago_ejecutivo;
    public $key_encriptada;
    public $rel_usuario_id;
    public $fecha_ingreso;
    public $fecha_uf;
    public $fecha_liquidar;
    public $monto_liquidar;
    public $compra_cuotas;
    public $venta_cuotas;
    public $rel_apoderado_1_id;
    public $rel_apoderado_2_id;
    public $aportado_clp;
    public $aportado_uf;
    public $estado_pago;
    public $saldo_cuotas;
    public $saldo_pagare;
    public $valor_contable;
    public $fecha_legal;
    public $rel_serie_id;
    public $cheque;
    public $fecha_cheque;
    public $credito_fiscal;
    public $id_aporte_cesion;
    public $rel_call_id;

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
        $instance->rel_aporte_fip_id = $stdClass->rel_aporte_fip_id;
        $instance->rel_cliente_id = $stdClass->rel_cliente_id;
        $instance->rel_estado_contrato_id = $stdClass->rel_estado_contrato_id;
        $instance->rel_tipo_contrato_id = $stdClass->rel_tipo_contrato_id;
        $instance->id_contrato = $stdClass->id_contrato;
        $instance->comprometido = $stdClass->comprometido;
        $instance->comprometido_clp = $stdClass->comprometido_clp;
        $instance->fecha = $stdClass->fecha;
        $instance->aportado = $stdClass->aportado;
        $instance->observacion = $stdClass->observacion;
        $instance->fecha_firma = $stdClass->fecha_firma;
        $instance->fecha_pago = $stdClass->fecha_pago;
        $instance->contrato = $stdClass->contrato;
        $instance->rel_tipo_aporte_id = $stdClass->rel_tipo_aporte_id;
        $instance->id_referido = $stdClass->id_referido;
        $instance->id_ejecutivo = $stdClass->id_ejecutivo;
        $instance->comision_referido = $stdClass->comision_referido;
        $instance->comision_ejecutivo = $stdClass->comision_ejecutivo;
        $instance->fecha_pago_referido = $stdClass->fecha_pago_referido;
        $instance->fecha_pago_ejecutivo = $stdClass->fecha_pago_ejecutivo;
        $instance->key_encriptada = $stdClass->key_encriptada;
        $instance->rel_usuario_id = $stdClass->rel_usuario_id;
        $instance->fecha_ingreso = $stdClass->fecha_ingreso;
        $instance->fecha_uf = $stdClass->fecha_uf;
        $instance->fecha_liquidar = $stdClass->fecha_liquidar;
        $instance->monto_liquidar = $stdClass->monto_liquidar;
        $instance->compra_cuotas = $stdClass->compra_cuotas;
        $instance->venta_cuotas = $stdClass->venta_cuotas;
        $instance->rel_apoderado_1_id = $stdClass->rel_apoderado_1_id;
        $instance->rel_apoderado_2_id = $stdClass->rel_apoderado_2_id;
        $instance->aportado_clp = $stdClass->aportado_clp;
        $instance->aportado_uf = $stdClass->aportado_uf;
        $instance->estado_pago = $stdClass->estado_pago;
        $instance->saldo_cuotas = $stdClass->saldo_cuotas;
        $instance->saldo_pagare = $stdClass->saldo_pagare;
        $instance->valor_contable = $stdClass->valor_contable;
        $instance->fecha_legal = $stdClass->fecha_legal;
        $instance->rel_serie_id = $stdClass->rel_serie_id;
        $instance->cheque = $stdClass->cheque;
        $instance->fecha_cheque = $stdClass->fecha_cheque;
        $instance->credito_fiscal = $stdClass->credito_fiscal;
        $instance->id_aporte_cesion = $stdClass->id_aporte_cesion;
        $instance->rel_call_id = $stdClass->rel_call_id;

        return $instance;
    }

    /**
     * @return mixed
     */
    public function getMaxId()
    {
        $this->intranet->select_max('id');
        $query = $this->intranet->get(Aportesfip::$table_name);
        $array = $query->result_array();
        return $array[0]['id'];
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        $result = $this->intranet->get_where(Aportesfip::$table_name, array('id' => $id))->result_object()[0];
        return Aportesfip::castFromDB($result);
    }

    public function getByFipId($fip_id)
    {
        $results = $this->intranet->get_where(Aportesfip::$table_name, array('rel_aporte_fip_id' => $fip_id))->result_object();
        if(empty($results))
            return $results;

        $aportes = array();
        foreach ($results as $result){
            $aportes[] = Aportesfip::castFromDB($result);
        }
        return $aportes;
    }

    /**
     * Agrega un AportesFip y se retorna el mismo
     * @return Aportesfip $this|null
     */
    public function add()
    {
        try{
            $this->id = $this->getMaxId() + 1;
            $this->fecha_ingreso = (new DateTime())->format('Y-m-d H:i:s');
            $this->key_encriptada = md5((new DateTime())->format('Y-m-d H:i:ss'));
            $this->intranet->insert(Aportesfip::$table_name, $this);
            return $this;
        }catch (Exception $e)
        {
            log_message('error', $e->getMessage());
            return null;
        }
    }

    /**
     * Edita un Aporte
     * @param Aportesfip $aportesObj
     * @return bool
     */
    public function edit(Aportesfip $aportesObj)
    {
        try{
            $this->intranet->where('id', $aportesObj->id);
            $this->intranet->update(Aportesfip::$table_name, $aportesObj);
            return true;
        }catch (Exception $e) {
            log_message('error', $e->getMessage());
            return false;
        }
    }

    /**
     * Otiene el estado del contrato del Aporte
     * @return mixed
     */
    public function getEstadoContrato()
    {

        return $this->intranet->get_where(Aportesfip::$table_name_estado_contrato, array('id' => $this->rel_estado_contrato_id))->result_object()[0];
    }

    /**
     * Obtiene un objeto de tipo fondo de Inversión
     * @return Fip
     */
    public function getFip()
    {
        $this->load->model('fip','',true);
        $fip = new Fip();
        return $fip->getById($this->rel_aporte_fip_id);
    }

    /**
     * Retorna una lista de los pagos relacionados a un determinado aporte
     * @return array
     */
    public function getPagos()
    {
        $this->load->model('pago', '', true);
        return (new Pago())->getListByAporte($this);
    }

    /**
     * Retorna una lista de las devoluciones de un determinado aporte
     * @return array
     */
    public function getDevoluciones()
    {
        $this->load->model('devolucion', '', true);
        return (new Devolucion())->getListByAporte($this->id);
    }

    /**
     * Cantidad de Aportados
     * @return mixed
     */
    public function getCountAportados()
    {
        $this->intranet->select('COUNT(*) as count');
        $this->intranet->from(Aportesfip::$table_name);
        $this->intranet->where('estado_pago', self::Aportado);
        $this->intranet->where('rel_aporte_fip_id', $this->rel_aporte_fip_id);
        return $this->intranet->get()->result_object()[0]->count;
    }

    /**
     * Retorna el estado de pago correspondiente
     * @return mixed
     */
    public function getEstadoPago(){return self::$estados_pago[$this->estado_pago];}

    /**
     * Retorna el cliente del aporte
     * @return Contact
     */
    public function getCliente()
    {
        $this->load->model('contact');
        return (new Contact())->getById($this->rel_cliente_id);
    }

    /**
     * Retorna el cliente del aporte
     * @return Contact
     */
    public function getContact(){ return $this->getCliente();}

    /**
     * Problema de sincronización de conceptos con el portal de clientes
     * @return mixed
     */
    public function getClient(){return $this->getCliente();}


    /**
     * Obtiene el listado de monedas que tiene esa fecha
     * @return array
     * @throws Exception
     */
    public function getMonedaValor()
    {
        $this->load->model('Monedavalor');
        $monedaValor = (new Monedavalor())->getByDate(new DateTime($this->fecha_uf));
        return $monedaValor;
    }

    /**
     * Obtiene un objeto AportesFip buscando la key_encriptada.
     * @param $key_encriptada
     * @return Aportesfip|array
     */
    public function getByKeyEncriptada($key_encriptada)
    {
        $result = $this->intranet->get_where(Aportesfip::$table_name, array('key_encriptada' => $key_encriptada))->result_object();
        if(empty($result))
            return $result;
        return Aportesfip::castFromDB($result[0]);
    }

    /**
     * @param $fip_id
     * @return mixed
     */
    public function generateCorrelativo($fip_id)
    {
        $query = "select generar_correlativo_contrato as id_contrato from generar_correlativo_contrato(".$fip_id.");";
        return $this->intranet->query($query)->result_object()[0]->id_contrato;
    }


    /**
     * Retorna un array de todos los documentos asociados al aporte.
     * @return array
     */
    public function getDocumentos()
    {
        $this->load->model('documentoaporte');
        return (new Documentoaporte())->getByAporte($this->id);
    }


    /**
     * Obtiene la cantidad de aportes que ha tenido la persona en el fondo y determina si reinvierte o es cliente nuevo.
     * @param $id_cliente
     * @return bool
     */
    public function isReinvierte($id_cliente = NULL)
    {
        $this->intranet->select("*");
        $this->intranet->from(Aportesfip::$table_name);
        if(is_null($id_cliente)) {
            $this->intranet->where(Aportesfip::$table_name . '.rel_cliente_id', $this->rel_cliente_id);
        }else{
            $this->intranet->where(Aportesfip::$table_name . '.rel_cliente_id', $id_cliente);
        }
        $this->intranet->where_not_in(Aportesfip::$table_name.'.estado_pago', array(
            Aportesfip::Duplicados,
            Aportesfip::Caidos,
            Aportesfip::Incompletos));
        $results = $this->intranet->get()->result_object();
        if(count($results) > 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Obtiene todos los documentos de un aporte con el filtro de que
     * solo el cliente puede ver estos archivos.
     * @return array
     */
    public function getDocumentosVisiblesCliente()
    {
        $this->load->model('documentoaporte');
        return (new Documentoaporte())->getDocumentsVisiblesCliente($this->id);
    }

    /**
     * Función que obtiene un aporte a través de un contacto
     * este puede ser filtrado a travez del where_in y además del id del fondo
     * @param $id_contact
     * @param array $where_in
     * @param $id_fip
     * @return array
     */
    public function getByContact($id_contact, $where_in = array(), $id_fip = null){
        $this->intranet->select('*');
        $this->intranet->from(self::$table_name);
        $this->intranet->where('rel_cliente_id', $id_contact);

        if(!empty($where_in)){
            $this->intranet->where_in($where_in['key'], $where_in['values']);
        }

        if(!is_null($id_fip)){
            $this->intranet->where('rel_aporte_fip_id', $id_fip);
        }

        $this->intranet->order_by('id', 'DESC');
        $results = $this->intranet->get()->result_object();

        if(count($results) > 0){
            $list = array();
            foreach ($results as $result){
                $list[] = self::castFromDB($result);
            }
            return $list;
        }

        return $results;
    }

    /**
     * Obtiene el log del aporte
     * @return array|null
     */
    public function getLogs()
    {
        $this->load->model('Gestiones');
        return (new Gestiones())->getByAporteId($this->id);
    }

    /**
     * Eliminar unr registro de tipo Aporte
     * @return int
     */
    public function deleteSingle(){
        $this->intranet->delete(self::$table_name, array("id" => $this->id));
        return $this->intranet->affected_rows();
    }

    /**
     * Retorno del grupo aporte fondo si corresponde al aporte
     * @return array|null
     */
    public function getGrupofondoaporte(){
        $this->load->model('intranet/Grupofondoaportes');
        return (new Grupofondoaportes())->getByIdAporte($this->id);
    }

    /**
     * Obtiene el call que pertenece 
     *
     * @return Call
     */
    public function getCallByFipMulticalls()
    {
        $this->load->model('intranet/Call');
        return (new Call())->getById($this->rel_call_id);
    }

    /**
     * Obtiene el call que pertenece 
     *
     * @return Call
     */
    public function getCall()
    {
        return $this->getCallByFipMulticalls();
    }

    public function tieneMasDeUnAporte(){
        $query = "select taf.*
        from trabajo__fip tf
        inner join trabajo__aportes_fip  taf on taf.rel_aporte_fip_id = tf.id
        inner join trabajo__cliente tc on taf.rel_cliente_id = tc.id
        inner join trabajo__call_fip tcf on tcf.id = taf.rel_call_id
        where tc.id = '".$this->rel_cliente_id."'
         and tf.id = ".$this->rel_aporte_fip_id." order by tcf.nombre asc;";
        $results = $this->intranet->query($query)->result_object();

        if(count($results) > 0){
            $list = array();
            foreach ($results as $result){
                $list[] = self::castFromDB($result);
            }
            return $list;
        }

        return $results;
    }
}