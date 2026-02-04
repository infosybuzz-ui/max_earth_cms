<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('chk_access'))
{
	function chk_access($action=NULL, $type=NULL, $role_check=false)
	{		
		$CI = & get_instance();		
		$CI->load->database();
		$CI->load->model('admin_model');	
		
		$admin_data = $CI->session->userdata('admin');
		$admin_id = $admin_data['admin_id'];
		
		$admin = $CI->admin_model->get_admin($admin_id, 'admin_id');
		
		if(!empty($admin)){
			return $admin_data;
			
		} else {
			if($CI->input->is_ajax_request()){
				echo 'login-error';die;
			}
			
			$CI->session->set_flashdata('error','Your session has been expired.<br/> Please login again to continue.');
			$current_url = current_url();
			$current_url = $_SERVER['QUERY_STRING'] ? $current_url.'?'.$_SERVER['QUERY_STRING'] : $current_url;
			redirect('login?return_url='.urlencode($current_url));	
		}
	}
}

