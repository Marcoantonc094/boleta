<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dpdf extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library(array('session','form_validation'));
		$this->load->model('boletas_model');
		$this->load->model('vigencias_model');
		$this->load->helper('form');
		$this->load->database('default');
		$this->load->library('encrypt');
	}
	public function index() {	
		if (!$this->session->userdata('is_logued_in'))
			redirect('inicio/login','refresh');
		$data = array(
			'boletas' => $this->boletas_model->getBoletas(),
		);
		$this->load->view('pdf/pdf',$data);
		// Get output html
		/**/
		$html = $this->output->get_output();
		$this->load->library('dompdf_gen');
		$this->dompdf->load_html($html);
		$this->dompdf->set_paper('letter','landscape');
		$this->dompdf->render();
		$now = new DateTime('now'); 
		$this->dompdf->stream($now->format('d_m_Y'),array("Attachment"=>0));
		
	}
	public function detailList(){
		$data1 = array();
		$data2 = array();
		$data3 = array();
		$data4 = array();
		$data5 = array();
		$data6 = array();
		$bt = $this->boletas_model->getBoletas();
		foreach($bt as $key => $row){
		  if($row->fin!='')
		    $dif = $row->dif2;
		  else
		    $dif = $row->dif1;
		  if($row->estado!=2){
		    if($dif<=15){
		      if( $dif>10)
		        array_push($data1, $row);
		      else{
		        if ($dif>5) 
		          array_push($data2, $row);
		        else{
		          if($dif>=0)
		            array_push($data3, $row);
		          else
		          	array_push($data6, $row);
		        }
		      }
		    }
		    else{
		      array_push($data4, $row);
		    }
		  }
		  else
		  	array_push($data5, $row);
		}
		$type = (int)$this->uri->segment(3);
		$dt = array();
		$tit = "";
		switch ($type) {
			case 1:
				$dt = $data1;
				$tit = 'Boletas a expirar en 15 dias';
				break;
			case 2:
				$dt = $data2;
				$tit = 'Boletas a expirar en 10 dias';
				break;
			case 3:
				$dt = $data3;
				$tit = 'Boletas a expirar en 5 dias';
				break;
			case 4:
				$dt = $data4;
				$tit = 'Boletas Normales';
				break;
			case 5:
				$dt = $data5;
				$tit = 'Boletas Liberadas';
				break;
			case 6:
				$dt = $data6;
				$tit = 'Boletas No Liberadas';
				break;
			
			default:
				# code...
				break;
		}
		$data = array(
			'boletas' => $dt,
			'titulo' => $tit
		);
		$this->load->view('pdf/pdf',$data);
		// Get output html
		/**/
		$html = $this->output->get_output();
		$this->load->library('dompdf_gen');
		$this->dompdf->load_html($html);
		$this->dompdf->set_paper('letter','landscape');
		$this->dompdf->render();
		$now = new DateTime('now'); 
		$this->dompdf->stream($now->format('d_m_Y'),array("Attachment"=>0));
	}
	public function pdf() {	
		if (!$this->session->userdata('is_logued_in'))
			redirect('inicio/login','refresh');
		$data = array(
			'boletas' => $this->boletas_model->getBoletas(),
		);
		$this->load->view('pdf/pdf',$data);
	}
	public function detalle() {	
		if (!$this->session->userdata('is_logued_in'))
			redirect('inicio/login','refresh');
		$data = array(
			'boleta' => $this->boletas_model->getBoleta($this->uri->segment(3)),
			'vigencia' => $this->vigencias_model->getVigencia($this->uri->segment(3)),
		);
		$this->load->view('pdf/lista_detalle',$data);
		$html = $this->output->get_output();
		// Load library
		$this->load->library('dompdf_gen');
		$this->dompdf->load_html($html);
		$this->dompdf->set_paper('letter','portrait');
		$this->dompdf->render();
		$now = new DateTime('now'); 
		$this->dompdf->stream($now->format('d_m_Y'),array("Attachment"=>0));
	}
}
