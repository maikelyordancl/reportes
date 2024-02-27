<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {

	public function index()
	{
        if(!$this->session->userdata('usuario')){
            redirect('/login');
        }

	    $this->load->view('dashboard/header', array('title' => 'Clientes'));
        $this->load->view('dashboard/header_menu');
        $this->load->view('dashboard/sidebar_menu');
		$this->load->view('dashboard/content');
        $this->load->view('dashboard/footer');
	}

	public function lista_global()
    {
        if(!$this->session->userdata('usuario')){
            redirect('/login');
        }

        $this->load->library('table');

        $this->load->model('intranet/Estado_cliente', true);
        $this->load->model('intranet/Ejecutivo', false);
        $this->load->model('intranet/Cliente', false);
        $this->load->model('intranet/Fip', false);
        $estadosCliente = new Estado_cliente();
        $ejecutivo      = new Ejecutivo();
        $cliente        = new Cliente();
        $fip            = new Fip();

        $values = array(
            'estadosCliente'    => $estadosCliente->get(),
            'ejecutivos'        => $ejecutivo->get(),
            'fondosInversion'   => $fip->getForOption()
        );

        if($this->input->get('export'))
        {
            $this->export_csv($cliente->grid($this->input->get()), 'clientes');
            exit;
        }else{
            if($this->input->get())
            {
                $values['clientes'] = $cliente->grid($this->input->get());
            }
        }

        $this->load->view('dashboard/header', array('title' => 'Lista de Clientes'));
        $this->load->view('dashboard/header_menu');
        $this->load->view('dashboard/sidebar_menu');
        $this->load->view('clientes/listar_filtro', $values);
        $this->load->view('dashboard/footer');
    }

    public function lista_documentos()
    {

        if(!$this->session->userdata('usuario')){
            redirect('/login');
        }

        $this->load->library('table');

        $this->load->model('intranet/Estado_cliente', true);
        $this->load->model('intranet/Ejecutivo', false);
        $this->load->model('intranet/Cliente', false);
        $this->load->model('intranet/Fip', false);
        $estadosCliente = new Estado_cliente();
        $ejecutivo      = new Ejecutivo();
        $cliente        = new Cliente();
        $fip            = new Fip();

        $estadoPagos = array(
            array('id' => 1, 'nombre' => 'Aportado'),
            array('id' => 2, 'nombre' => 'Comprometido'),
            array('id' => 3, 'nombre' => 'Incrompletos'),
            array('id' => 4, 'nombre' => 'Liquidado'),
            array('id' => 5, 'nombre' => 'Caído'),
            array('id' => 6, 'nombre' => 'Duplicado')
        );
        $values = array(
            'estadosCliente'    => $estadosCliente->get(),
            'ejecutivos'        => $ejecutivo->get(),
            'fondosInversion'   => $fip->getForOption(),
            'estadoPagos'       => $estadoPagos,
            'clientes'          => $cliente->getDocumentos($this->input->get())
        );

        $this->load->view('dashboard/header', array('title' => 'Lista de Clientes'));
        $this->load->view('dashboard/header_menu');
        $this->load->view('dashboard/sidebar_menu');
        $this->load->view('clientes/listar_documentos_filtro', $values);
        $this->load->view('dashboard/footer');
    }

    private function export_csv($array, $file_name){
	    $file_name .= '_'.date("Y-m-d _H_i_s").'.csv';
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"$file_name.\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        $handle = fopen('php://output', 'w');
        fputcsv($handle, array_keys($array[0]), ';');
        foreach ($array as $data) {
            $data = array_map("utf8_decode", $data);
            fputcsv($handle, $data, ';');
        }
        fclose($handle);
        exit;
    }
}
