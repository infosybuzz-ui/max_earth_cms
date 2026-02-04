<?php

class Cms_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_contents_list($limit, $start) {        
		
		$data = array(); $where = array(); $like = array(); 
		
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->from('cms_contents');
		$data['count'] = $this->db->count_all_results();
		
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->limit($limit, $start);
		$this->db->order_by('id','desc'); 
		$query = $this->db->get("cms_contents");		
		$data['results'] = $query->result_array();
		
		return $data;
    }
	
	public function manage_contents() {
		$logged_admin = $this->session->userdata('admin');
		$logged_admin_id = $logged_admin['admin_id'];
		
		$content_id = $this->input->post('content_id');
		$content_id = DeCrypt($content_id);
		
		$data = array();
		$data['content_title'] = $this->input->post('title');
		$data['content_description'] = $this->input->post('description');							
		
		$result = array('status' => false);
		if(empty($content_id)){			
			
			$data['created_by'] = $logged_admin_id;				
	
			if($this->db->insert('cms_contents', $data)){
				$result['status'] = true;
				$result['insert_id'] = $this->db->insert_id();
			} 
		
		} else {
			
			$data['updated_by'] = $logged_admin_id;	
		
			$this->db->where('id', $content_id);
			if($this->db->update('cms_contents', $data)){
				$result['status'] = true;
			}
		}
		
		return $result;
	}
	
	public function get_content_details($id=0) {        
		
		$this->db->where(['id', $id]);
		$query = $this->db->get("cms_contents");		
		$data = $query->row_array();
		
		return $data;
    }
}	
