<?php
/**
 * Created by PhpStorm.
 * User: wafle
 * Date: 25-01-18
 * Time: 11:31
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller
{
    public function cartola($key_encriptada = NULL)
    {
        if(empty(trim($key_encriptada)))
        {
            show_error('Debe seleccionar un cliente para mostrar la información',500,'Error :: Cliente no seleccionado');
        }

        try{
            $this->load->model('api/Cartola');
            $this->load->model('intranet/Fip');
            $cartola        =   new Cartola();
            $cliente = $cartola->get_cliente_by_key_encriptada($key_encriptada);

            if(count($cliente) > 0)
            {
                $cliente = $cliente[0];
            }else{
                throw new Exception("No se ha encontrado el cliente");
            }

            $movimientos = $cartola->get_aportes($cliente['id'],$this->input->get('month'), $this->input->get('year'));
            $fondos = $cartola->get_fondos($cliente['id'],$this->input->get('month'), $this->input->get('year'));
            $resumenes = $cartola->get_resumen($cliente['id'],$this->input->get('month'), $this->input->get('year'));
            $resumenes_saldos = $cartola->get_resumen_saldos($cliente['id'],$this->input->get('month'), $this->input->get('year'));

            $result = array();
            $sumaPatrimonio = 0;

            $result['fecha_cartola'] = $cartola->get_cierre_mes($this->input->get('month'), $this->input->get('year'));
            $this->load->model('intranet/Aportesfip','', TRUE);

            foreach($fondos as $fondo)
            {
                $aporteTemp = (new Aportesfip())->getById($fondo['aporte_id']);
                $call = $aporteTemp->getCall();
                $temp_fip = $aporteTemp->getFip();
                /*
                if($temp_fip->is_multi_calls == true){
                    echo "<pre>";
                    print_r($temp_fip);
                    echo "</pre>";
                    die;
                }
                */
                $result[$fondo['id_fondo']] = $fondo;
                if($temp_fip->is_multi_calls){
                    if(isset($call->nombre)){
                        $result[$fondo['id_fondo']]['avance_proyecto'] = $cartola->get_fipinfoextra($result['fecha_cartola'], $fondo['id_fondo'], $call->nombre);
                    }else{
                        $result[$fondo['id_fondo']]['avance_proyecto'] = $cartola->get_fipinfoextra($result['fecha_cartola'], $fondo['id_fondo']);
                    }
                }else{
                    $result[$fondo['id_fondo']]['avance_proyecto'] = $cartola->get_fipinfoextra($result['fecha_cartola'], $fondo['id_fondo']);
                }                
                $comentario = $cartola->get_nota_cierre_fip($result['fecha_cartola'],$fondo['id_fondo']);


                if(count($comentario) > 0)
                {
                    $result[$fondo['id_fondo']]['comentario'] = $comentario[0]['comentario'];
                }

                foreach($movimientos as $movimiento)
                {
                    if($fondo['rel_aporte_fip_id'] == $movimiento['rel_aporte_fip_id'])
                    {
                        $result[$fondo['id_fondo']]['movimientos'][] = $movimiento;
                    }
                }


                foreach($resumenes as $resumen)
                {
                    if($fondo['rel_aporte_fip_id'] == $resumen['rel_aporte_fip_id'])
                    {
                        $sumaPatrimonio = $sumaPatrimonio+$resumen['saldo_contable'];
                        $result[$fondo['id_fondo']]['resumenes'][] = $resumen;
                    }
                }
            }

            $resumenOrdered = array();
            foreach($resumenes_saldos as $resumen_saldo){
                $fip = (new Fip())->getById($resumen_saldo["id"]);
                if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                    $resumen_saldo['moneda'] = $fip->getMoneda()->moneda;
                    $resumenOrdered[$fip->getMoneda()->moneda][] = $resumen_saldo;
                }else if(($fip->getMoneda()->moneda == 'UF')){
                    $resumen_saldo['moneda'] = $fip->getMoneda()->moneda;
                    $resumenOrdered[$fip->getMoneda()->moneda][] = $resumen_saldo;
                }else{
                    $resumen_saldo['moneda'] = $fip->getMoneda()->moneda;
                    $resumenOrdered['CLP'][] = $resumen_saldo;
                }
            }

            $result['patrimonio'] = $sumaPatrimonio;

            /** Agregar en el arreglo las fechas de las plantillas */
            $views_cartolas = array(
                '2020-10-31' => 'cartola_template_2020-10',
                '2021-01-31' => 'cartola_template_2021-01'
            );


            $selected_view = null;
            $cierre_mes = $cartola->get_cierre_mes(
                $this->input->get('month'), 
                $this->input->get('year'))['end_date'];  
            
                
            foreach($views_cartolas as $key => $vcartola){
                if(strtotime($cierre_mes) <= strtotime($key)){
                    $selected_view = $vcartola;
                }
            }
            //Prueba para ver nueva cartola

            if(is_null($selected_view)){
                $selected_view = 'cartola_template_2023';
            }
            $this->load->view('api/'.$selected_view,
                array(
                    'fondos' => $result,
                    'cliente' => $cliente,
                    'title' => 'Cartola',
                    'resumenes_saldos' => $resumenOrdered,
                    'fecha_primer_aporte' => $cartola->get_fecha_primer_aporte($cliente['id']),
                    'valores_cuota' => $cartola->get_valores_cuota($cartola->get_cierre_mes($this->input->get('month'), $this->input->get('year'))['end_date'])
                )
            );
        }catch (Exception $exception)
        {
            show_error($exception->getMessage(), $exception->getCode(), "Oops, tenemos un problema aquí.");
        }

    }

    public function cartola_cliente($key_encriptada = NULL)
    {
        if(empty(trim($key_encriptada)))
        {
            show_error('Debe seleccionar un cliente para mostrar la información',500,'Error :: Cliente no seleccionado');
        }

        try{
            $this->load->model('api/Cartola');
            $this->load->model('intranet/Fip');
            $cartola        =   new Cartola();
            $cliente = $cartola->get_cliente_by_key_encriptada($key_encriptada);

            if(count($cliente) > 0)
            {
                $cliente = $cliente[0];
            }else{
                throw new Exception("No se ha encontrado el cliente");
            }

            $movimientos = $cartola->get_aportes($cliente['id'],$this->input->get('month'), $this->input->get('year'));
            $fondos = $cartola->get_fondos($cliente['id'],$this->input->get('month'), $this->input->get('year'));
            $resumenes = $cartola->get_resumen($cliente['id'],$this->input->get('month'), $this->input->get('year'));
            $resumenes_saldos = $cartola->get_resumen_saldos($cliente['id'],$this->input->get('month'), $this->input->get('year'));

            $result = array();
            $sumaPatrimonio = 0;

            $result['fecha_cartola'] = $cartola->get_cierre_mes($this->input->get('month'), $this->input->get('year'));
            $this->load->model('intranet/Aportesfip','', TRUE);

            foreach($fondos as $fondo)
            {
                $aporteTemp = (new Aportesfip())->getById($fondo['aporte_id']);
                $call = $aporteTemp->getCall();
                $temp_fip = $aporteTemp->getFip();
                /*
                if($temp_fip->is_multi_calls == true){
                    echo "<pre>";
                    print_r($temp_fip);
                    echo "</pre>";
                    die;
                }
                */
                $result[$fondo['id_fondo']] = $fondo;
                if($temp_fip->is_multi_calls){
                    if(isset($call->nombre)){
                        $result[$fondo['id_fondo']]['avance_proyecto'] = $cartola->get_fipinfoextra($result['fecha_cartola'], $fondo['id_fondo'], $call->nombre);
                    }else{
                        $result[$fondo['id_fondo']]['avance_proyecto'] = $cartola->get_fipinfoextra($result['fecha_cartola'], $fondo['id_fondo']);
                    }
                }else{
                    $result[$fondo['id_fondo']]['avance_proyecto'] = $cartola->get_fipinfoextra($result['fecha_cartola'], $fondo['id_fondo']);
                }                
                $comentario = $cartola->get_nota_cierre_fip($result['fecha_cartola'],$fondo['id_fondo']);


                if(count($comentario) > 0)
                {
                    $result[$fondo['id_fondo']]['comentario'] = $comentario[0]['comentario'];
                }

                foreach($movimientos as $movimiento)
                {
                    if($fondo['rel_aporte_fip_id'] == $movimiento['rel_aporte_fip_id'])
                    {
                        $result[$fondo['id_fondo']]['movimientos'][] = $movimiento;
                    }
                }


                foreach($resumenes as $resumen)
                {
                    if($fondo['rel_aporte_fip_id'] == $resumen['rel_aporte_fip_id'])
                    {
                        $sumaPatrimonio = $sumaPatrimonio+$resumen['saldo_contable'];
                        $result[$fondo['id_fondo']]['resumenes'][] = $resumen;
                    }
                }
            }

            $resumenOrdered = array();
            foreach($resumenes_saldos as $resumen_saldo){
                $fip = (new Fip())->getById($resumen_saldo["id"]);
                if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                    $resumen_saldo['moneda'] = $fip->getMoneda()->moneda;
                    $resumenOrdered[$fip->getMoneda()->moneda][] = $resumen_saldo;
                }else{
                    $resumen_saldo['moneda'] = $fip->getMoneda()->moneda;
                    $resumenOrdered['CLP'][] = $resumen_saldo;
                }
            }

            $result['patrimonio'] = $sumaPatrimonio;

            /** Agregar en el arreglo las fechas de las plantillas */
            $views_cartolas = array(
                '2020-10-31' => 'cartola_2023',
                '2021-01-31' => 'cartola_2023'
            );


            $selected_view = null;
            $cierre_mes = $cartola->get_cierre_mes(
                $this->input->get('month'), 
                $this->input->get('year'))['end_date'];  
            
                
            foreach($views_cartolas as $key => $vcartola){
                if(strtotime($cierre_mes) <= strtotime($key)){
                    $selected_view = $vcartola;
                }
            }
            //Prueba para ver nueva cartola

            if(is_null($selected_view)){
                $selected_view = 'cartola_2023';
            }
            $this->load->view('api/'.$selected_view,
                array(
                    'fondos' => $result,
                    'cliente' => $cliente,
                    'title' => 'Cartola',
                    'resumenes_saldos' => $resumenOrdered,
                    'fecha_primer_aporte' => $cartola->get_fecha_primer_aporte($cliente['id']),
                    'valores_cuota' => $cartola->get_valores_cuota($cartola->get_cierre_mes($this->input->get('month'), $this->input->get('year'))['end_date'])
                )
            );
        }catch (Exception $exception)
        {
            show_error($exception->getMessage(), $exception->getCode(), "Oops, tenemos un problema aquí.");
        }

    }
}