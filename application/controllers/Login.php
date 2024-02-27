<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        if($this->session->userdata('usuario')){
            redirect('dashboard');
        }else {
            $this->load->view('home_header');
            $this->load->view('login');
            $this->load->view('home_footer');
        }
	}

	public function logon()
    {
        try{
            $this->load->model('intranet/Auth_user', true);
            $auth_user = new Auth_user();
            $values = $auth_user->get($this->input->post('user_id'));
            if($values != null && count($values) > 0)
            {
                $usuario = $values[0];
                $this->session->set_userdata('usuario', $usuario);
                echo json_encode(array(
                    'status'    =>'ok',
                    'code'      => 200 ,
                    'message'   => 'Bienvenid@, '.$usuario['first_name'].' '.$usuario['last_name'],
                    'action'    => '/dashboard/')
                );
            }
        }catch (Exception $ex)
        {
            echo json_encode(array('status'=>'error', 'code' => $ex->getCode() ,'message' => $ex->getMessage()));
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('usuario');
        redirect('/login');
    }
}
