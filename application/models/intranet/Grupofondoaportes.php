<?php


class Grupofondoaportes extends CI_Model
{
    public static $table_name = "trabajo__grupo_fondo_aportes";

    public $id;
    public $rel_aportes_fip_id;
    public $fecha_ingreso;
    public $rel_usuario_id;
    public $rel_grupo_fondo_id;

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
        $instance->rel_aportes_fip_id = $stdClass->rel_aportes_fip_id;
        $instance->fecha_ingreso = $stdClass->fecha_ingreso;
        $instance->rel_usuario_id = $stdClass->rel_usuario_id;
        $instance->rel_grupo_fondo_id = $stdClass->rel_grupo_fondo_id;
        return $instance;
    }

    /**
     * Agrega un Grupoaportes y se retorna el mismo con todos los datos
     * @return Grupofondoaportes $this|null
     */
    public function add()
    {
        try{
            $this->id = $this->getMaxId() + 1;
            $this->fecha_ingreso = (new DateTime())->format('Y-m-d H:i:s');
            $this->intranet->insert(self::$table_name, $this);
            return $this;
        }catch (Exception $e)
        {
            log_message('error', $e->getMessage());
            return null;
        }
    }

    /**
     * Edita un Grupoaportes del sistema
     * @param Grupofondoaportes $obj
     * @return bool
     */
    public function edit(Grupofondoaportes $obj)
    {
        try{
            $this->intranet->where('id', $obj->id);
            $this->intranet->update(self::$table_name, $obj);
            return true;
        }catch (Exception $e) {
            log_message('error', $e->getMessage());
            return false;
        }
    }

    /**
     * Borra un Grupoaportes del sistema
     * @param Grupofondoaportes $obj
     * @return bool
     */
    public function delete(Grupofondoaportes $obj){
        try{
            $this->intranet->delete(self::$table_name,array('id' => $obj->id));
            return true;
        }catch (Exception $exception){
            log_message('error', $exception->getMessage());
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getMaxId()
    {
        $this->intranet->select_max('id');
        $query = $this->intranet->get(self::$table_name);
        $array = $query->result_array();
        return $array[0]['id'];
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        $result = $this->intranet->get_where(self::$table_name, array('id' => $id))->result_object();
        if(count($result) == 1){
            return self::castFromDB($result[0]);
        }else{
            return null;
        }
    }

    /**
     *
     * Retorna un litado de grupos dependiendo del fondo de inversion que esta relacionado al grupo de aportes.
     * @param $id_grupo_fondo
     * @return array|null
     */
    public function getByGrupoFondo($id_grupo_fondo){
        $results = $this->intranet->get_where(self::$table_name, array('rel_grupo_fondo_id' => $id_grupo_fondo))->result_object();

        if(count($results) > 0){
            $listGrupoFondo = array();
            foreach($results as $result){
                $listGrupoFondo[] = self::castFromDB($result);
            }

            return $listGrupoFondo;
        }else{
            return null;
        }
    }

    /**
     * @param $id_aporte
     * @return array|null
     */
    public function getByIdAporte($id_aporte){
        $results = $this->intranet->get_where(Grupofondoaportes::$table_name, array('rel_aportes_fip_id' => $id_aporte))->result_object();
        if(count($results) > 0){
            foreach ($results as $result) {
                return self::castFromDB($result);
            }
        }else{
            return null;
        }
    }

    /**
     * Retorna el Aporte ligado al registro
     * @return mixed
     */
    public function getAporte(){
        $this->load->model('intranet/Aportesfip');
        return (new Aportesfip())->getById($this->rel_aportes_fip_id);
    }

    /**
     * Retorna un tipo Usuario para tener la información de quién hizo el registro
     * @return array|User
     */
    public function getUserCreated()
    {
        $this->load->model('User');
        return (new User())->getById($this->rel_usuario_id);
    }

    /**
     * Obtiene el grupo de fondo de un determinado aporte (MATCH)
     * @return Grupofondo|null
     */
    public function getGrupofondo(){
        $this->load->model('intranet/Grupofondo');
        return (new Grupofondo())->getByID($this->rel_grupo_fondo_id);
    }

}