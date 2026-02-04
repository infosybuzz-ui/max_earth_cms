<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('validateManageLeads')) {
	
	function validateManageLeads() {	
		$CI = & get_instance();		
		
		$CI->form_validation->set_rules('name', 'Name', 'required|regex_match['.REGEX_C_NAME.']');
		$CI->form_validation->set_rules('email', 'Email', 'valid_email');
		$CI->form_validation->set_rules('mobile', 'Mobile', 'required|numeric|exact_length[10]');
		$CI->form_validation->set_rules('address', 'Address', 'required|regex_match['.REGEX_VALID_ADDR.']');
		$CI->form_validation->set_rules('circle_id', 'Circle', 'required');
		$CI->form_validation->set_rules('ssa_id', 'SSA', 'required');
		$CI->form_validation->set_rules('sdca_id', 'SDCA', 'required');
		$CI->form_validation->set_rules('plan_id', 'Plan', 'required');
		$CI->form_validation->set_rules('payment_status', 'Advance Rental Status', 'required');
		$CI->form_validation->set_rules('lead_source', 'Lead Source', 'required|numeric');
		
		$lead_id = $CI->input->post('lead_id');
		if(!empty($lead_id)){
			//$CI->form_validation->set_rules('user_plan_id', 'User Selected Plan', 'required');
		}
		
		$lead_source = $CI->input->post('lead_source');
		if($lead_source == 2){
			$CI->form_validation->set_rules('afe_id', 'Sales Partner', 'required');
		}
		
		if($CI->form_validation->run() == FALSE){
			$response['status'] = false;
			$response['message'] = reset($CI->form_validation->error_array());
			echo json_encode($response); die;
		}
	}
		
}

if(!function_exists('validateManageAdmin')) {
	
	function validateManageAdmin() {	
		$CI = & get_instance();		
		
		$CI->form_validation->set_rules('role_id', 'Role', 'required');
		$CI->form_validation->set_rules('username', 'Username', 'required|min_length[5]|regex_match['.REGEX_VALID_ADMIN_USERNAME.']');
		$CI->form_validation->set_rules('name', 'Name', 'required|regex_match['.REGEX_APLHA_NUM_SPACE.']');
		$CI->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$CI->form_validation->set_rules('mobile', 'Mobile', 'required|numeric|exact_length[10]');
		$CI->form_validation->set_rules('designation', 'Designation', 'regex_match['.REGEX_APLHA_SPACE.']');
		
		$admin_id = $CI->input->post('admin_id');
		if(!empty($admin_id)){
			$CI->form_validation->set_rules('admin_role_prim_id', 'Admin Selected Role', 'required');
			$CI->form_validation->set_rules('admin_role_id', 'Admin Selected Role', 'required');
		}
		
		$role_id = $CI->input->post('role_id');
		if($role_id == 2){
			$CI->form_validation->set_rules('circle_id', 'Circle', 'required');
			
		} else if($role_id == 3){
			$CI->form_validation->set_rules('circle_id', 'Circle', 'required');
			$CI->form_validation->set_rules('ssa_id', 'SSA', 'required');
			$CI->form_validation->set_rules('sdca_id', 'SDCA', 'required');
			$CI->form_validation->set_rules('m_nodes', 'Node', 'required');
			
		} else if($role_id == 9){
			$CI->form_validation->set_rules('m_circles', 'Circle', 'required');
		}
		
		if($CI->form_validation->run() == FALSE){
			$response['status'] = false;
			$response['message'] = reset($CI->form_validation->error_array());
			echo json_encode($response); die;
		}
	}
		
}

if(!function_exists('validateManageAFE')) {
	
	function validateManageAFE() {	
		$CI = & get_instance();		
		
		$CI->form_validation->set_rules('category_id', 'Category', 'required');
		$CI->form_validation->set_rules('name', 'Name', 'required|regex_match['.REGEX_APLHA_SPACE.']');
		$CI->form_validation->set_rules('email', 'Email', 'valid_email');
		$CI->form_validation->set_rules('mobile', 'Mobile', 'required|numeric|exact_length[10]');
		$CI->form_validation->set_rules('pan_card', 'Pan Card', 'exact_length[10]|regex_match['.REGEX_APLHA_NUM.']');
		$CI->form_validation->set_rules('address', 'Address', 'regex_match['.REGEX_VALID_ADDR.']');
		$CI->form_validation->set_rules('circle_id', 'Circle', 'required');
		$CI->form_validation->set_rules('ssa_id', 'SSA', 'required');
		
		if($CI->form_validation->run() == FALSE){
			$response['status'] = false;
			$response['message'] = reset($CI->form_validation->error_array());
			echo json_encode($response); die;
		}
	}
		
}

if(!function_exists('validateChangeLeadStatus')) {
	
	function validateChangeLeadStatus() {	
		$CI = & get_instance();		
		
		$CI->form_validation->set_rules('lead_id', 'Lead ID', 'required');
		$CI->form_validation->set_rules('status_id', 'Status', 'required|numeric');
		$CI->form_validation->set_rules('description', 'Description', 'required|min_length[10]|regex_match['.REGEX_VALID_DESC.']');
		
		$status_id = $CI->input->post('status_id');
		if($status_id == 2){
			$CI->form_validation->set_rules('bsnl_user_id', 'BSNL ID', 'required|regex_match['.REGEX_VALID_BSNLID.']');
			$CI->form_validation->set_rules('caf_no', 'CAF No', 'required|regex_match['.REGEX_APLHA_NUM.']');
			$CI->form_validation->set_rules('installation_date', 'Installation Date', 'required|exact_length[10]|regex_match['.REGEX_DATE.']');
			$CI->form_validation->set_rules('accnt_no', 'Account No', 'required|max_length[20]|regex_match['.REGEX_NUM.']');
			$CI->form_validation->set_rules('cust_id', 'Customer ID', 'required|max_length[20]|regex_match['.REGEX_APLHA_NUM.']');
			
		} else if($status_id == 3){
			$CI->form_validation->set_rules('cpe_payment_mode', 'Payment Mode', 'required|regex_match['.REGEX_APLHA_SPACE.']');
			$CI->form_validation->set_rules('cr_no', 'CR No', 'required|regex_match['.REGEX_APLHA_NUM.']');
			$CI->form_validation->set_rules('cpe_payment_amnt', 'Payment Amount', 'required|regex_match['.REGEX_FLOAT.']|max_length[5]');
			
		}
		
		if($CI->form_validation->run() == FALSE){
			$response['status'] = false;
			$response['message'] = reset($CI->form_validation->error_array());
			echo json_encode($response); die;
		}
	}
		
}

if(!function_exists('validateManagePlans')) {
	
	function validateManagePlans() {	
		$CI = & get_instance();		
		
		$CI->form_validation->set_rules('circle_id', 'Circle', 'required');
		$CI->form_validation->set_rules('plan_name', 'Plan Name', 'required|regex_match['.REGEX_PLAN_NAME.']');
		$CI->form_validation->set_rules('plan_code', 'Plan Code', 'required|regex_match['.REGEX_PLAN_CODE.']');
		$CI->form_validation->set_rules('plan_rental', 'Rental', 'required|regex_match['.REGEX_NUM.']');
		
		if($CI->form_validation->run() == FALSE){
			$response['status'] = false;
			$response['message'] = reset($CI->form_validation->error_array());
			echo json_encode($response); die;
		}
	}	
}

if(!function_exists('validateManageCommissions')) {
	
	function validateManageCommissions($com_type=NULL) {	
		$CI = & get_instance();		
		
		$CI->form_validation->set_rules('title', 'Commission Title', 'required|regex_match['.REGEX_APLHA_NUM_SPACE.']');
		$CI->form_validation->set_rules('rate', 'Commission Rate', 'required|max_length[4]|regex_match['.REGEX_FLOAT.']');
		$CI->form_validation->set_rules('type', 'Commission For', 'required');
		$CI->form_validation->set_rules('month', 'Month', 'required');
		$CI->form_validation->set_rules('year', 'Year', 'required');
		$CI->form_validation->set_rules('rate_type', 'Commission Type', 'required');
		$CI->form_validation->set_rules('location_applicable', 'Select Location', 'required');
		
		if(empty($com_type)){
			$CI->form_validation->set_rules('min_lead_cnt', 'Min Count', 'required|numeric|max_length[4]');
			
			$min_lead_cnt = $CI->input->post('min_lead_cnt');
			if($min_lead_cnt > 0){
				$CI->form_validation->set_rules('max_lead_cnt', 'Max Count', "required|numeric|max_length[4]|greater_than[$min_lead_cnt]");
			} else {
				$CI->form_validation->set_rules('max_lead_cnt', 'Max Count', "required|numeric|max_length[4]|greater_than_equal_to[$min_lead_cnt]");
			}
		}
		
		$location_applicable = $CI->input->post('location_applicable');
		if($location_applicable == 'Y'){
			$CI->form_validation->set_rules('circle_id', 'Circle', 'required');
		}
		
		$rate_type = $CI->input->post('rate_type');
		if($rate_type == 2){
			$CI->form_validation->set_rules('rate', 'Commission Rate', 'required|regex_match['.REGEX_FLOAT.']|less_than_equal_to[100]');
		} else {
			$CI->form_validation->set_rules('rate', 'Commission Rate', 'required|max_length[4]|regex_match['.REGEX_FLOAT.']');
		}
		
		if($CI->form_validation->run() == FALSE){
			$response['status'] = false;
			$response['message'] = reset($CI->form_validation->error_array());
			echo json_encode($response); die;
		}
	}	
}

if(!function_exists('validateManageIncentives')) {
	
	function validateManageIncentives() {	
		$CI = & get_instance();		
		
		$CI->form_validation->set_rules('title', 'Incentive Title', 'required|regex_match['.REGEX_APLHA_NUM_SPACE.']');
		$CI->form_validation->set_rules('rate', 'Incentive Rate', 'required|regex_match['.REGEX_FLOAT.']');
		$CI->form_validation->set_rules('type', 'Incentive For', 'required');
		$CI->form_validation->set_rules('month', 'Month', 'required');
		$CI->form_validation->set_rules('year', 'Year', 'required');
		$CI->form_validation->set_rules('rate_type', 'Incentive Type', 'required');
		$CI->form_validation->set_rules('min_lead_cnt', 'Min Count', 'required|numeric|max_length[4]');
		//$CI->form_validation->set_rules('location_applicable', 'Select Location', 'required');
		
		$min_lead_cnt = $CI->input->post('min_lead_cnt');
		if($min_lead_cnt > 0){
			$CI->form_validation->set_rules('max_lead_cnt', 'Max Count', "required|numeric|max_length[4]|greater_than[$min_lead_cnt]");
		} else {
			$CI->form_validation->set_rules('max_lead_cnt', 'Max Count', "required|numeric|max_length[4]|greater_than_equal_to[$min_lead_cnt]");
		}
		
		$location_applicable = $CI->input->post('location_applicable');
		if($location_applicable == 'Y'){
			$CI->form_validation->set_rules('circle_id', 'Circle', 'required');
		}
		
		$rate_type = $CI->input->post('rate_type');
		if($rate_type == 2){
			$CI->form_validation->set_rules('rate', 'Incentive Rate', 'required|regex_match['.REGEX_FLOAT.']|less_than_equal_to[100]');
		} else {
			$CI->form_validation->set_rules('rate', 'Incentive Rate', 'required|max_length[4]|regex_match['.REGEX_FLOAT.']');
		}
		
		if($CI->form_validation->run() == FALSE){
			$response['status'] = false;
			$response['message'] = reset($CI->form_validation->error_array());
			echo json_encode($response); die;
		}
	}	
}

if(!function_exists('validateManageTicket')) {
	
	function validateManageTicket() {	
		$CI = & get_instance();		
		
		$CI->form_validation->set_rules('priority', 'Ticket Priority', 'required');
		$CI->form_validation->set_rules('user', 'Customer', 'required');
		
		$ticket_id = $CI->input->post('ticket_id');
		if(empty($ticket_id)){
			$CI->form_validation->set_rules('title', 'Ticket Title', 'required|regex_match['.REGEX_APLHA_SPACE.']');
			$CI->form_validation->set_rules('description', 'Ticket Desc', 'required|regex_match['.REGEX_VALID_DESC.']');
		}
		
		if($CI->form_validation->run() == FALSE){
			$response['status'] = false;
			$response['message'] = reset($CI->form_validation->error_array());
			echo json_encode($response); die;
		}
	}
		
}

if(!function_exists('validateTicketStatusChange')) {
	
	function validateTicketStatusChange() {	
		$CI = & get_instance();		
		
		$CI->form_validation->set_rules('t', 'Ticket', 'required');
		$CI->form_validation->set_rules('s', 'Status', 'required');
		$CI->form_validation->set_rules('d', 'Description', 'required|regex_match['.REGEX_VALID_DESC.']');
		
		if($CI->form_validation->run() == FALSE){
			$response['status'] = false;
			$response['message'] = reset($CI->form_validation->error_array());
			echo json_encode($response); die;
		}
	}
		
}

if(!function_exists('validateChangeLeadOtherDetais')) {
	
	function validateChangeLeadOtherDetais($LeadData) {	
		$CI = & get_instance();		
		
		$CI->form_validation->set_rules('lead_id', 'Lead ID', 'required');
		
		$status_id = $LeadData['user_lead_status_id'];
		if($status_id >= 2){
			$CI->form_validation->set_rules('bsnl_user_id', 'BSNL ID', 'required|regex_match['.REGEX_VALID_BSNLID.']');
			$CI->form_validation->set_rules('caf_no', 'CAF No', 'required|regex_match['.REGEX_APLHA_NUM.']');
			$CI->form_validation->set_rules('accnt_no', 'Account No', 'required|max_length[20]|regex_match['.REGEX_APLHA_NUM.']');
			$CI->form_validation->set_rules('cust_id', 'Customer ID', 'required|max_length[20]|regex_match['.REGEX_APLHA_NUM.']');
			
		} else if($status_id >= 3){
			$CI->form_validation->set_rules('cpe_payment_mode', 'Payment Mode', 'required|regex_match['.REGEX_APLHA_SPACE.']');
			$CI->form_validation->set_rules('cr_no', 'CR No', 'required|regex_match['.REGEX_APLHA_NUM.']');
			$CI->form_validation->set_rules('cpe_payment_amnt', 'Payment Amount', 'required|regex_match['.REGEX_FLOAT.']|max_length[5]');
			
		}
		
		if($CI->form_validation->run() == FALSE){
			$response['status'] = false;
			$response['message'] = reset($CI->form_validation->error_array());
			echo json_encode($response); die;
		}
	}
		
}
