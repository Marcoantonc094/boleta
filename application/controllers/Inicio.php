<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class inicio extends CI_Controller {
	public $rol;
	function __construct(){
		parent::__construct();
		$this->load->library(array('session','form_validation'));
		$this->load->model('admin_model');
		$this->load->model('usuario_model');
		$this->load->model('boletas_model');
		$this->load->model('vigencias_model');
		$this->load->helper('form');
		$this->load->database('default');
		$this->load->library('encrypt');
	}
	public function index()
	{
		if (!$this->session->userdata('is_logued_in')) {
			redirect('inicio/login','refresh');
		}
		else{
			// comesar aqui sw
			$data = array(
				'boletas' => $this->boletas_model->getBoletas(),
				'tipo'=>0,
				'rol' => $this->session->userdata('rol'),
				'graIni' => $this->gBi(),
				'graFin' => $this->gBf()				
			);
			$rol = $this->session->userdata('rol');
			if($rol==1){
				$var="admin";
			}else{
				$var="operario";
			}
			$this->load->view('common/header');
			$this->load->view('common/sidebar');
			$this->load->view($var.'/inicio',$data);
			$this->load->view('common/footer');
		}
	}
	public function login()
	{
		$this->load->view('admin/login');
	}
	public function ingreso(){
		$user = $this->input->post('user');
		$pass = $this->input->post('pass');
		$pass = sha1($pass);
		$check = $this->admin_model->ingresar($user,$pass);
		if(!$check){
			$this->login();
		}
		else{
			$data = array(
                 'is_logued_in' => TRUE,
                 'id_usuario' => $check->id,
                 'username' => $check->usuario,
                 'user' => $check->nombre,
                 'rol' => $check->cargo_id,
             ); 
			$this->session->set_userdata($data);	
			redirect(base_url('index.php/inicio'),'refresh');
		}
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('index.php/inicio/login'),'refresh');
	}
	public function usuario(){
		if (!$this->session->userdata('is_logued_in'))
			redirect('index.php/inicio/login','refresh');
		if ($this->uri->segment(3)) {
			$data = array(
				'user' => $this->usuario_model->getU($this->uri->segment(3)),
				'users' => $this->usuario_model->getUser(),
			);
			$data['tipo'] ='updU';
		}
		else{
			$data['tipo'] ='regU';
			$data['users'] =$this->usuario_model->getUser();
		}
		$this->load->view('common/header');
		$this->load->view('common/sidebar');
		$this->load->view('admin/form_boletas', $data);
		$this->load->view('common/footer', $data);
	}
//-----usuario
	public function add_u(){
		$valores = array(
			'user'=>$this->input->post('afi'),
			'nom'=>$this->input->post('nom'),
			'pass' => sha1($this->input->post('emp')),
			'rol'=>$this->input->post('rol'),
		);
		$ejecutar = $this->usuario_model->addUser($valores);
		redirect(base_url('index.php/inicio/usuario/').$ejecutar,'refresh');
	}
	public function getU(){
		echo json_encode($this->usuario_model->getUser());
	}
	public function editar_usuario(){
		$data = array(
			'id' => $this->session->userdata('id_usuario'),
			'user' => $this->session->userdata('username'),
			'rol' => $this->session->userdata('rol'),
			'usuario' => $this->usuario_model->getU($this->uri->segment(3)),
			'opcion' => 'Editar Usuario'
		);
		if($data['rol'] != ''){
			$this->load->view('common/header1');
			$this->load->view('common/header_pt');
			$this->load->view('common/header2');
			$this->load->view('common/menu',$data);
			$this->load->view('common/sidebar');
			$this->load->view('admin/r_usuario',$data);
			$this->load->view('common/footer1');
			$this->load->view('common/footer_pt');
			$this->load->view('common/footer_s');
			$this->load->view('common/footer2t',$data);
		}
		else{
			redirect(base_url('index.php/inicio'));
		}
	}

	public function updU(){
		$valores = array(
			'user'=>$this->input->post('afi'),
			'nom'=>$this->input->post('nom'),
			'id'=>$this->input->post('id_u'),
			'rol'=>$this->input->post('rol'),
		);
		if($this->input->post('emp2')!=''){
			$valores['pass'] = sha1($this->input->post('emp2'));
		}
		else{
			$valores['pass'] = '1';
		}
		
		$ejecutar = $this->usuario_model->updUser($valores);
		redirect(base_url('index.php/inicio/usuario/').$ejecutar,'refresh');
	}

	public function dU(){
		$valores = array(
			'id' => $this->uri->segment(3)
		);
		$ejecutar = $this->usuario_model->eliminar($valores);
		redirect(base_url('index.php/inicio/usuario'),'refresh');
	}
	public function gBi(){
		$val = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
		foreach ($this->boletas_model->grafBoletasI() as $key => $value) {
			$val[$value->mes - 1] = (int)$value->total;
		}
		return $val;
	}
	public function gBf(){
		$val = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
		foreach ($this->boletas_model->grafBoletasF() as $key => $value) {
			$val[$value->mes - 1] = (int)$value->total;
		}
		return $val;
	}	
}
