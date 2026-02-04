<?php 
// error_reporting(0);
class Cms extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->database();	
		$this->load->model('cms_model');	
		$this->load->model('admin_model');	
	}
	
	public function contents_list()
	{
		chk_access();
		
		$per_page = 20; 
        $page = @$_GET['per_page']? $_GET['per_page'] : 0;
						
        $result = $this->cms_model->get_contents_list($per_page, $page);		
		$data['records'] = @$result['results'];
	
		$total_rows = $result['count'];
		
		if(@$_GET['name'] != '')
			$base_url = BASE_URL.'cms/contents/list?'.$_SERVER['QUERY_STRING'];
		else
			$base_url = BASE_URL.'cms/contents/list?page=true';
		
        $data["links"] = create_links($per_page,$total_rows,$base_url);
		
		if($this->input->is_ajax_request())
		{
			$data['result'] = $this->load->view('elements/contents-list',$data,true);
			echo json_encode($data);die;
		}
		
		$data['pageTitle'] = 'Contents List';
		$data['content'] = 'admin/cms/contents-list';
		$this->load->view('admin/layout',$data);
	}
	
	public function manage_contents($content_id=0)
	{				
		if($this->input->post('title') != '') {
			
			$result = $this->cms_model->manage_contents();
			
			$response = array();
			if($result['status']) {
				$response['status'] = true;
				if(isset($result['insert_id'])) {
					$response['message'] = 'Saved Successfully.';
					$response['redirectTo'] = ADMIN_BASE_URL.'cms/contents/list';
				} else {
					$response['message'] = 'Updated Successfully.';
					$response['redirectTo'] = $this->session->userdata('referer');
				}	
			} else {
				$response['status'] = false;	
				$response['message'] = 'Unable to process your request right now. <br/> Please try again or some time later..[MNCMSS1]';
			}
			
			if($this->input->is_ajax_request()){
				echo json_encode($response);die;
			} else {
				redirect('/admin/cms/contents/list', 'refresh');
			}
		}
		else
		{									
			if(!empty($content_id)){
				$data['record'] = $this->admin_model->get_record('cms_contents', 'id', DeCrypt($content_id));
				if(isset($_SERVER['HTTP_REFERER'])) {			
					$referer = array('referer' => $_SERVER['HTTP_REFERER']);
					$this->session->set_userdata($referer);			
				}
			}	
				
			$data['pageTitle'] = 'Manage Contents';
			$data['content'] = 'admin/cms/manage-contents';
			$this->load->view('admin/layout',$data);
		}
	}
}
