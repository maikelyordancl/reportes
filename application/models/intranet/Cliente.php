<?php
/**
 * Created by PhpStorm.
 * User: wafle
 * Date: 28-11-17
 * Time: 05:08
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Model
{
    private $intranet;

    public function __construct()
    {
        parent::__construct();
        $this->intranet = $this->load->database('intranet_aicapitals', true);
    }

    public function getDocumentos($filter = NULL, $withoutResult = FALSE)
    {
        $query = "select CONCAT('<a href=\"https://intranet.aicapitals.cl/cliente/',tc.key_encriptada,'\" target=\"_blank\" class=\"btn btn-primary\"> Ver Ficha</a>')
                       ,CONCAT(tc.rut,'-',tc.dv) as rut
                       ,CONCAT(tc.nombre,' ', tc.seg_nombre, ' ', tc.apellido, ' ', tc.seg_apellido) as nombre
                       ,CASE WHEN mail1 IS NOT NULL
                          THEN
                            mail1
                        ELSE
                          CASE WHEN mail2 IS NOT NULL
                            THEN
                              mail2
                          ELSE
                            CASE WHEN mail3 IS NOT NULL
                              THEN
                                mail3
                            END
                          END
                        END as correo
                       ,CASE WHEN tc.cedula IS NOT NULL AND tc.cedula <> ''
                          THEN 'Tiene'
                        ELSE
                          'No Tiene'
                        END as cedula
                       ,CASE WHEN tc.pep IS NOT NULL AND tc.pep <> ''
                          THEN 'Tiene'
                       ELSE
                          'No Tiene'
                       END as ficha_cliente
                       ,tc.fecha_ingreso
                       ,CONCAT(au.first_name,' ', au.last_name) as nombre_ejecutivo
                       ,au.username                       
                  from trabajo__cliente tc
            INNER JOIN trabajo__aportes_fip taf
                    ON tc.id = taf.rel_cliente_id
            INNER JOIN trabajo__fip tf
                    ON taf.rel_aporte_fip_id = tf.id
            INNER JOIN auth_user au
                    ON tc.rel_ejecutivo_id = au.id                    
                 WHERE taf.estado_pago IS NOT NULL ";

                if(!is_null($filter))
                {
                    if(isset($filter['estado_pago'])) {
                        if($filter['estado_pago'] != 'ALL') {
                            $query .= " AND taf.estado_pago = '" . $filter['estado_pago'] . "' ";
                        }
                    }else{
                        $query .=  " AND taf.estado_pago = '1' ";
                    }

                    if(isset($filter['ejecutivo']))
                    {
                        if($filter['ejecutivo'] != null && !empty($filter['ejecutivo']))
                        {
                            $query .= " AND au.id = ".$filter['ejecutivo'];
                        }
                    }

                    if(isset($filter['fondo_inversion']))
                    {
                        if($filter['fondo_inversion'] != null && !empty($filter['fondo_inversion']))
                        {
                            $query .= " AND tf.id = ".$filter['fondo_inversion']." ";
                        }
                    }
                }
                $query .= " GROUP BY tc.id, au.first_name, au.seg_nombre, au.last_name, au.seg_apellido, au.username ";

        if($withoutResult)
        {
            return $this->intranet->query($query);
        }else{
            return $this->intranet->query($query)->result_array();
        }
    }

    public function grid($filter = NULL, $withoutResult = FALSE)
    {
        $query = "SELECT trabajo__cliente.rut || '-' || trabajo__cliente.dv      rut,
                        INITCAP(trabajo__cliente.nombre)       nombre,
                        INITCAP(trabajo__cliente.seg_nombre)   seg_nombre,
                        INITCAP(trabajo__cliente.apellido)     apellido,
                        INITCAP(trabajo__cliente.seg_apellido) seg_apellido,
                        INITCAP(trabajo__cliente.direccion)    direccion,
                        INITCAP(trabajo__cliente.comuna)       comuna,
                        INITCAP(trabajo__cliente.ciudad)       ciudad,
                        trabajo__cliente.fecha_ingreso,
                        trabajo__cliente.celular,
                        oficina,
                        nacimiento,
                        CASE 
                          WHEN trabajo__cliente.categoria = '2' THEN
                          rep.mail
                        ELSE
                            CASE WHEN mail1 IS NOT NULL
                              THEN
                                mail1
                            ELSE
                              CASE WHEN mail2 IS NOT NULL
                                THEN
                                  mail2
                              ELSE
                                CASE WHEN mail3 IS NOT NULL
                                  THEN
                                    mail3
                                ELSE
                                    rep.mail
                                END
                              END
                            END 
                        END   correo,
                        trabajo__estado_cliente.estado_cliente,
                        INITCAP(vw_ejecutivos.first_name) || ' ' || INITCAP(vw_ejecutivos.last_name) ejecutivo,
                        vw_ejecutivos.email,       rep.rut as representante_rut,
                       rep.nombre as representante_nombre,
                       rep.mail as representante_mail
                      FROM trabajo__cliente
                        LEFT JOIN trabajo__estado_cliente
                          ON trabajo__cliente.rel_estado_id = trabajo__estado_cliente.id
                        LEFT JOIN  vw_ejecutivos
                          ON trabajo__cliente.rel_ejecutivo_id = vw_ejecutivos.id 
                        LEFT JOIN Obtener_representantes(trabajo__cliente.key_encriptada)  rep
                          ON trabajo__cliente.categoria = '2'
              ";
        if(isset($filter['fondo_inversion'])) {
            if(isset($filter['fondo_inversion'])) {
                if($filter['fondo_inversion'] != null && !empty($filter['fondo_inversion']))
                {
                    $query .= "     INNER JOIN trabajo__aportes_fip
                          ON trabajo__cliente.id = trabajo__aportes_fip.rel_cliente_id 
                         AND trabajo__aportes_fip.aportado_uf > 0 
                        INNER JOIN trabajo__fip
                          ON trabajo__fip.id = trabajo__aportes_fip.rel_aporte_fip_id ";
                }
            }
        }
        $query .= " WHERE trabajo__cliente.rut IS NOT NULL";
        if(!is_null($filter)) {
            if(isset($filter['fondo_inversion']))
            {
                if($filter['fondo_inversion'] != null && !empty($filter['fondo_inversion']))
                {
                    $query .= " AND trabajo__fip.id = ".$filter['fondo_inversion']." ";
                    if(isset($filter['liquidados']))
                        if($filter['liquidados'])
                                $query .= " AND trabajo__aportes_fip.fecha_liquidar IS NULL ";
                }
            }

            if(isset($filter['estado_cliente']))
            {
                if($filter['estado_cliente'] != null && !empty($filter['estado_cliente']))
                {
                    $query .= " AND trabajo__estado_cliente.id = ".$filter['estado_cliente'];
                }
            }

            if(isset($filter['ejecutivo']))
            {
                if($filter['ejecutivo'] != null && !empty($filter['ejecutivo']))
                {
                    $query .= " AND vw_ejecutivos.id = ".$filter['ejecutivo'];
                }
            }

            //trabajo__cliente.mailing
            if(isset($filter['mailing'])){
                if($filter['mailing']){
                    $query .= " AND trabajo__cliente.mailing = TRUE";
                }else{
                    $query .= " AND trabajo__cliente.mailing = FALSE";
                }
            }
        }
        $query .= " ORDER BY trabajo__cliente.nombre";

        /*
        echo $query;
        die;
        */

        if($withoutResult)
        {
            return $this->intranet->query($query);
        }else{
            return $this->intranet->query($query)->result_array();
        }
    }
}