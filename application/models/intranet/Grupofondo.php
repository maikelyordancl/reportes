<?php


class Grupofondo extends CI_Model
{
    public static $table_name = 'trabajo__grupo_fondo';

    public $id;
    public $id_fondo;
    public $id_usuario_creacion;
    public $fecha_creacion;
    public $codigo_color;
    public $nombre;

    private $intranet;

    public function __construct()
    {
        parent::__construct();
        $this->intranet = $this->load->database('intranet_aicapitals', true);
    }

    public static function castFromDb(stdClass $stdClass){
        $instance = new self();
        $instance->id = $stdClass->id;
        $instance->id_fondo = $stdClass->id_fondo;
        $instance->id_usuario_creacion = $stdClass->id_usuario_creacion;
        $instance->fecha_creacion = $stdClass->fecha_creacion;
        $instance->codigo_color = $stdClass->codigo_color;
        $instance->nombre = $stdClass->nombre;
        return $instance;
    }

    /**
     * Agrega un Grupofondo y se retorna el mismo con todos los datos
     * @return Grupofondo $this|null
     */
    public function add()
    {
        try{
            $this->id = $this->getMaxId() + 1;
            $this->fecha_creacion = (new DateTime())->format('Y-m-d H:i:s');
            $this->intranet->insert(self::$table_name, $this);
            return $this;
        }catch (Exception $e)
        {
            log_message('error', $e->getMessage());
            return null;
        }
    }

    /**
     * Edita un Grupofondo del sistema
     * @param Grupofondo $obj
     * @return bool
     */
    public function edit(Grupofondo $obj)
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
     * Borra un Grupofondo del sistema
     * @param Grupofondo $obj
     * @return bool
     */
    public function delete(Grupofondo $obj){
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
     * Retorna un determinado grupo a traves del id
     * @param $id_grupo
     * @return Grupofondo|null
     */
    public function getByID($id_grupo){
        $results = $this->intranet->get_where(self::$table_name, array('id' => $id_grupo))->result_object();

        if(count($results) > 0){
            return self::castFromDb($results[0]);
        }else{
            return null;
        }
    }

    /**
     * Retorna un lista de grupos dependiendo del fondo de inversión que esté asociado
     * @param $id_fip
     * @return array|null
     */
    public function getByIdFip($id_fip){
        $results = $this->intranet->get_where(self::$table_name, array('id_fondo' => $id_fip))->result_object();

        if(count($results) > 0){
            $listGrupos = array();

            foreach($results as $result){
                $listGrupos[] = self::castFromDb($result);
            }

            return $listGrupos;
        }else{
            return null;
        }
    }

    /**
     * Retorna un fondo de inversión asociado al grupo relacionado
     * @return Fip
     */
    public function getFip(){
        $this->load->model('Fip');
        return (new Fip())->getById($this->id_fondo);
    }

    /**
     * Obtiene un listado de grupos de aportes
     * @return array|null
     */
    public function getGrupoAportes(){
        $this->load->model('Grupofondoaportes');
        return (new Grupofondoaportes())->getByGrupoFondo($this->id);
    }

    /**
     * Retorna la suma total de los aportes del grupo
     * @return int
     */
    public function getSumaAportes(){
        $this->load->model('intranet/Grupofondoaportes');
        $grupoAportes = (new Grupofondoaportes())->getByGrupoFondo($this->id);

        $suma_aportes = 0;
        foreach ($grupoAportes as $aporte_grupo){
            $suma_aportes = $suma_aportes+$aporte_grupo->getAporte()->aportado_uf;
        }
        return $suma_aportes;
    }

    /**
     * Retorna la cantidad de aportes que corresponden al grupo
     * @return int
     */
    public function getCantidadAportantes(){
        $this->load->model('Grupofondoaportes');
        $grupoAportes = (new Grupofondoaportes())->getByGrupoFondo($this->id);
        return count($grupoAportes);
    }

    /**
     * Retorna el String que corresponde a la serie para informarla en una determinada Tabla o Lista
     * @return string
     */
    public function getSerie(){
        $fip = $this->getFip();
        $series = $fip->getSeries();
        $suma_uf = $this->getSumaAportes();

        foreach ($series as $k => $serie) {

            if ($suma_uf >= $serie->minimo && $suma_uf <= $serie->maximo) {
                return $serie->serie;
            }

            if ($k == 0) {
                if ($suma_uf < $serie->minimo) {
                    return $serie->serie;
                }
            }

            if ($k == (count($series) - 1)) {
                if (is_null($serie->maximo)) {
                    if ($suma_uf >= $serie->minimo) {
                        return $serie->serie;
                    }
                }
            }
        }
        return null;
    }

    /**
     * Retorna el String que corresponde a la serie para informarla en una determinada Tabla o Lista
     * @return string
     */
    public function getRoe(){
        $fip = $this->getFip();
        $series = $fip->getSeries();
        $suma_uf = $this->getSumaAportes();

        $this->load->model('intranet/Fipinfoextra');
        $avance_proyecto = (new Fipinfoextra())->getLastInfoExtraForFip($fip->id);

        foreach ($series as $k => $serie) {

            if ($suma_uf >= $series[0]->minimo && $suma_uf <= $series[0]->maximo) {
                $rentabilidad = (empty($avance_proyecto->roe_serie_a)) ? $series[0]->rentabilidad : $avance_proyecto->roe_serie_a;
                return $rentabilidad;
            } else if ($suma_uf >= $series[1]->minimo && $suma_uf <= $series[1]->maximo) {
                $rentabilidad = (empty($avance_proyecto->roe_serie_b)) ? $series[1]->rentabilidad : $avance_proyecto->roe_serie_b;
                return $rentabilidad;
            } else if ($suma_uf >= $series[2]->minimo && $suma_uf <= $series[2]->maximo) {
                $rentabilidad = (empty($avance_proyecto->roe_serie_c)) ? $series[2]->rentabilidad : $avance_proyecto->roe_serie_c;
                return $rentabilidad;
            } else {
                $rentabilidad = (empty($avance_proyecto->roe_serie_d)) ? $series[3]->rentabilidad : $avance_proyecto->roe_serie_d;
                return $rentabilidad ;
            }
        }
        return null;
    }

    /**
     * Retorna un tipo Usuario para tener la información de quién hizo el registro
     * @return array|User
     */
    public function getUser()
    {
        $this->load->model('User');
        return (new User())->getById($this->id_usuario_creacion);
    }

    /**
     * Retorna el grupo de aportes relacionado al grupo del fondo que tiene registrado el nautilus
     * @return array|null
     */
    public function getAportesgrupo(){
        $this->load->model('Grupofondoaportes');
        return (new Grupofondoaportes())->getByGrupoFondo($this->id);
    }
}