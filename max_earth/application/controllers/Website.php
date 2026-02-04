<?php 
error_reporting(0);
class Website extends CI_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->database();	
		$this->load->model('cms_model');
	}
	
	public function index() {
		$data['pageName'] = 'home';
		$data['view'] = 'website/home';
		$this->load->view('website/layout',$data);
	}
	
	public function about() {
		$data = $this->cms_model->get_content_details(1);
		
		$sieLInks = [
			'url' => 'ABout us'
		];
		
		$data['pageName'] = 'about';
		$data['view'] = 'website/about';
		$data['data'] = $data;
		$data['sieLInks'] = $sieLInks;
		$this->load->view('website/layout',$data);
	}
	
	public function verticals() {
		$data['pageName'] = 'verticals';
		$data['view'] = 'website/verticals';
		$this->load->view('website/layout',$data);
	}
	
	public function projects() {
		$data['pageName'] = 'projects';
		$data['view'] = 'website/projects';
		$this->load->view('website/layout',$data);
	}
	
	public function investors() {
		$data['pageName'] = 'investors';
		$data['view'] = 'website/investors';
		$this->load->view('website/layout',$data);
	}
	
	public function latest_news() {
		$data['pageName'] = 'latest_news';
		$data['view'] = 'website/latest_news';
		$this->load->view('website/layout',$data);
	}
	
	public function contact_us() {
		$data['pageName'] = 'contact_us';
		$data['view'] = 'website/contact_us';
		$this->load->view('website/layout',$data);
	}
}
?>
