<?php

class Admin_model extends CI_Model
{
	var $leadStatsIdToCons = 4;
	
	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_user($user_id=NULL, $select=NULL)
	{		
		$user = array();
		if($select){
			$this->db->select($select);
		}
		$user = $this->db->get_where('bs_users', array('user_id' => $user_id))->row_array();		
		return $user;		
	}
	
	public function get_admin($admin_id=NULL, $select=NULL)
	{		
		$admin = array();
		if($select){
			$this->db->select($select);
		}
		$admin = $this->db->get_where('bs_admins', array('admin_id' => $admin_id))->row_array();		
		return $admin;		
	}
	
	public function get_admin_with_roles($admin_id=NULL)
	{		
		$admin = array();
		$this->db->select('bs_admins.admin_id, bs_admins.admin_name, bs_admins.admin_username, bs_admins.admin_mobile, bs_admin_roles.admin_role_id, bs_admin_roles.admin_role_ssa_id, bs_admin_roles.admin_role_circle_id');
		$this->db->where('bs_admins.admin_id', $admin_id);
		$this->db->order_by('bs_admins.admin_id','asc');
		$this->db->join('bs_admin_roles', 'bs_admin_roles.admin_id=bs_admins.admin_id', 'INNER'); 
		$admin = $this->db->get("bs_admins")->row_array();	
		return $admin;		
	}
	
	public function get_user_by_userId($userId=NULL, $select=NULL)
	{		
		$user = array();
		if($select){
			$this->db->select($select);
		}
		$user = $this->db->get_where(TBL_USERS, array('UserId' => $userId))->row_array();
		
		return $user;		
	}
   
    public function get_email_templates($limit, $start) 
	{        
		$data = array();
					
		$this->db->from('ts_email_config');
		$data['count'] = $this->db->count_all_results();
		
		$this->db->order_by('id','desc'); 
		$this->db->limit($limit, $start);
		$data['result'] = $this->db->get("ts_email_config")->result_array();
		return $data;
    }
	
	public function get_record($table, $prim_key=NULL, $id, $select=NULL)
	{	
		if($select){
			$this->db->select($select);
		}
		$query = $this->db->get_where($table, array($prim_key => $id));
		return $query->row_array();
	}
	
	public function get_record_md5($table, $prim_key=NULL, $id, $select=NULL)
	{	
		if($select){
			$this->db->select($select);
		}
		$query = $this->db->get_where($table, array("MD5($prim_key)" => $id));
		return $query->row_array();
	}
	
	public function get_all_records($table, $order=NULL, $select=NULL)
	{
		if($select){
			$this->db->select($select);
		}
		
		if($order) {
			$this->db->order_by($order,'asc');
		}		
		$query = $this->db->get($table);
		return $query->result_array();
	}		
	
	public function get_all_actions($admin_id=NULL)
	{		
		$this->db->order_by('ts_access_actions.id','asc');						
		$this->db->where('ts_access_actions.parent_id',0); 
		$this->db->where('ts_access_actions.status',1); 
		$actions = $this->db->get("ts_access_actions")->result_array();
		
		foreach($actions as $j=>$row)
		{
			$ParentId = $row['id'];
			$this->db->order_by('ts_access_actions.id','asc');						
			$this->db->where('ts_access_actions.parent_id',$ParentId);
			$this->db->where('ts_access_actions.status',1); 
			$rslts = $this->db->get("ts_access_actions")->result_array();
			
			if(trim($admin_id) != '')
			{
				if(!empty($rslts))
				{
					foreach($rslts as $k=>$rslt)
					{									
						$where = array('admin_id' => $admin_id,'action' => strtolower($row['name']),'type' => $rslt['type']);
						$this->db->select('access');
						$this->db->where($where); 				
						$temp = $this->db->get("ts_subadmin_access")->row_array();
						
						$rslts[$k]['access'] = @$temp['access'];
					}
				}
			}
			
			$actions[$j]['childs'] = $rslts;
		}
		
		return $actions;
	}
	
	public function get_all_admins($limit, $start, $role_id=NULL, $all=false) 
	{        
		$data = array(); $where = array('bs_admins.admin_id >' => 1); $like = array(); 
		
		if(!empty($_GET['status'])) {	
			$_GET['status'] = $_GET['status'] == 2 ? 0 : $_GET['status'];
			$where = array_merge($where, array('bs_admins.admin_status' => $_GET['status']));			
		}
		
		if(!empty($_GET['name'])) {
			$like = array_merge($like, array('bs_admins.admin_name' => $_GET['name']));
		}	

		if(!empty($_GET['role'])) {
			$where = array_merge($where, array('bs_admin_roles.admin_role_id' => $_GET['role']));
		}		

		if(!empty($role_id)){
			$where = array_merge($where, array('bs_admin_roles.admin_role_id' => $role_id));
		}		
		
		if(!$all){		
			$this->db->where($where);
			$this->db->like($like); 
			$this->db->join('bs_admin_roles', 'bs_admin_roles.admin_id=bs_admins.admin_id', 'INNER');
			$this->db->join('bs_roles', 'bs_roles.role_id=bs_admin_roles.admin_role_id', 'INNER');
			$this->db->from('bs_admins');
			$data['count'] = $this->db->count_all_results();
		}
		
		$this->db->select('bs_admins.*, group_concat(bs_roles.role_name) as roles ,bs_admin_roles.admin_role_id ,bs_admin_roles.id as role_prim_id');
		$this->db->where($where);
		$this->db->like($like); 
		if(!$all){		
			$this->db->limit($limit, $start);
		}
		$this->db->order_by('bs_admins.admin_id','desc'); 
		$this->db->join('bs_admin_roles', 'bs_admin_roles.admin_id=bs_admins.admin_id', 'INNER');
		$this->db->join('bs_roles', 'bs_roles.role_id=bs_admin_roles.admin_role_id', 'INNER');
		$this->db->group_by('bs_admin_roles.admin_id');
		$admins = $this->db->get("bs_admins")->result_array();
		
		foreach($admins as $k=>$rcd){
			$rslt = $this->admin_role_locations($rcd['admin_role_id'], $rcd['role_prim_id']);
			if(!empty($rslt)){
				$rcd = array_merge($rcd, $rslt[0]);
			}
			
			$admins[$k] = $rcd;
		}
		
		$data['result'] = $admins;
		return $data;
    }
	
	public function manage_admin()
	{
		validateManageAdmin(); //Validate Request Data
		
		$logged_admin = $this->session->userdata('admin');
		$logged_admin_id = $logged_admin['admin_id'];
		
		$admin_id = $this->input->post('admin_id');
		$admin_id = DeCrypt($admin_id);
							
		$role_id = $this->input->post('role_id');										
		$admin_role_type = $this->input->post('admin_role_id');										
		$admin_role_prim_id = $this->input->post('admin_role_prim_id');										
		$admin_role_id = DeCrypt($admin_role_prim_id);										
		$circle_id = $this->input->post('circle_id');										
		$ssa_id = $this->input->post('ssa_id');	
		$sdca_id = $this->input->post('sdca_id');	
		$m_circles = $this->input->post('m_circles');	
		$m_nodes = $this->input->post('m_nodes');	
		
		if($role_id == 8){
			$adminExists = $this->getAdminsByRoleId($role_id, $admin_id);
			if(!empty($adminExists)){
				$response['status'] = false;	
				$response['message'] = 'There should be only one NOC Incharge.';
				echo json_encode($response);die;	
			}
		}
		
		$admin = array();	
		$admin['admin_name'] = $this->input->post('name');										
		$admin['admin_username'] = $this->input->post('username');										
		$admin['admin_email'] = $this->input->post('email');										
		$admin['admin_mobile'] = $this->input->post('mobile');	
		$admin['admin_designation'] = $this->input->post('designation');	
		$admin['admin_status'] = 1;	
		
		$sts = $this->check_admin_username($admin['admin_username'], $admin_id);
		if($sts == 'false'){
			$response['status'] = false;	
			$response['message'] = 'Username Already Exist.<br/>Please enter a valid username';
			echo json_encode($response);die;	
		}
		
		$sts = $this->check_admin_email($admin['admin_email'], $admin_id);
		if($sts == 'false'){
			$response['status'] = false;	
			$response['message'] = 'Email Already Exist.<br/>Please enter a valid email';
			echo json_encode($response);die;	
		}
		
		$sts = $this->check_admin_mobile($admin['admin_mobile'], $admin_id);
		if($sts == 'false'){
			$response['status'] = false;	
			$response['message'] = 'Mobile Already Exist.<br/>Please enter a valid email';
			echo json_encode($response);die;	
		}
		
		$result = array('status' => false);
		try{
			$this->db->trans_begin();  // Transaction Start
			
			if(empty($admin_id)){			
				$admin['admin_added_on'] = date('Y-m-d H:i:s');		
				
				$code = $admin['admin_mobile'];
				if(empty($code)){
					$code = mt_rand(100000,999999);	
				}					
				$password = md5($code);
				
				$admin['admin_password'] = $password;		
				$admin['admin_emailed_pass'] = $code;										
				if($this->db->insert('bs_admins', $admin)){
					$result['status'] = true;
					$result['insert_id'] = $this->db->insert_id();
					$admin_id = $result['insert_id'];
				} else {
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later [MA1]');
				}
				
				$call_description = 'New Admin Added Successfully';
				$call_type = 1;
				
			} else {
				$admin['admin_updated_on'] = date('Y-m-d H:i:s');	
			
				$this->db->where('admin_id', $admin_id);
				if(!$this->db->update('bs_admins', $admin)){
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later [MA2]');
				}
				
				$call_description = 'Admin Details Updated Successfully';
				$call_type = 2;
			}
			
			$RoleData = array();
			$RoleData['admin_id'] = $admin_id;
			$RoleData['admin_role_id'] = $role_id;
			$RoleData['admin_role_status'] = 1;
			$RoleData['admin_role_ssa_id'] = $ssa_id;
			$RoleData['admin_role_circle_id'] = $circle_id;
			
			$sts = $this->check_admin_role_existense($RoleData);
			if($sts[0]){
				$response['status'] = false;	
				$response['message'] = $sts[1].' Admin Already Exist for specified location.';
				
				$this->db->trans_rollback(); // Transaction Rollback
				echo json_encode($response);die;	
			}
			
			if(empty($admin_role_id)){
				$RoleData['admin_role_added_on'] = date('Y-m-d H:i:s');		
				if(!$this->db->insert('bs_admin_roles', $RoleData)){
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later [MA3]');	
				}
				
				$admin_role_id = $this->db->insert_id();
				
			} else {
				$this->db->where('id', $admin_role_id);
				if(!$this->db->update('bs_admin_roles', $RoleData)){
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later [MA4]');
				}
				
				if($admin_role_type != $role_id) {
					$role = $this->get_record('bs_roles', 'role_id', $role_id, 'role_name');
					$call_description .= ' Role has been changed to '.$role['role_name'];
				}
			}
			
			if(in_array($role_id, array(2,3,9))){
				
				if(!empty($admin_id)){
					$RoleLocationsUpdate = array();
					$RoleLocationsUpdate['admin_location_status'] = 0;
					
					$this->db->where('admin_role_id', $admin_role_id);
					if(!$this->db->update('bs_admin_role_locations', $RoleLocationsUpdate)){
						throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later [MA5]');
					}
				}
				
				$RoleLocations = $tmp = array();
				$tmp['admin_role_id'] = $admin_role_id;
				$tmp['admin_location_status'] = 1;
				
				if($role_id == 2){
					
					$tmp['admin_location_type'] = 1;
					$tmp['admin_location_circle_id'] = $circle_id;
					
					$RoleLocations[] = $tmp;
					
				} else if($role_id == 3){
					
					$tmp['admin_location_type'] = 2;
					$tmp['admin_location_circle_id'] = $circle_id;
					$tmp['admin_location_ssa_id'] = $ssa_id;
					$tmp['admin_location_sdca_id'] = $sdca_id;
					
					$m_nodes = explode(',', $m_nodes);
					foreach($m_nodes as $node_id){
						$tmp['admin_location_node_id'] = $node_id;
						
						$RoleLocations[] = $tmp;
					}
				} else if($role_id == 9){
					
					$tmp['admin_location_type'] = 1;
					
					$m_circles = explode(',', $m_circles);
					foreach($m_circles as $circle_id){
						$tmp['admin_location_circle_id'] = $circle_id;
						
						$RoleLocations[] = $tmp;
					}
				}
				
				if(!empty($RoleLocations)){
					if(!$this->db->insert_batch('bs_admin_role_locations', $RoleLocations)){
						throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later [MA6]');	
					}
				}
			}
			
			$CallInsertData = array();
			$CallInsertData['call_user_id'] = $admin_id;
			$CallInsertData['call_logged_admin_id'] = $logged_admin_id;
			$CallInsertData['call_desc'] = $call_description;
			$CallInsertData['call_type'] = $call_type;
			$CallInsertData['call_time'] = date('Y-m-d H:i:s');
			
			if($this->db->insert('bs_admin_call_logs', $CallInsertData)) {
				if($this->db->trans_status() === FALSE) {
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later [MA7]');								
				} else {
					$this->db->trans_commit(); // Transaction Commit
					$result['status'] = true;
				}
			}
		
		}  catch(Exception $e){
			$this->db->trans_rollback(); // Transaction Rollback
			$result['message'] = $e->getMessage();	
			$result['status'] = false;	
		}
		
		return $result;
	}
	
	public function getAdminsByRoleId($role_id, $admin_id=NULL){
		if(!empty($admin_id)){
			$this->db->where(array('bs_admins.admin_id !=' => $admin_id));
		}
		$this->db->select('bs_admin_roles.admin_role_id');
		$this->db->where(array('bs_admin_roles.admin_role_id' => $role_id));
		$this->db->order_by('bs_admins.admin_id','desc'); 
		$this->db->join('bs_admin_roles', 'bs_admin_roles.admin_id=bs_admins.admin_id', 'INNER');
		$query = $this->db->get("bs_admins");	
		$records = $query->result_array();

		return $records;
	}
	
	public function check_admin_role_existense($RoleData=array()){
		$role_name = '';
		if(in_array($RoleData['admin_role_id'], array(2))){
			$cond = array('admin_role_id' => $RoleData['admin_role_id'], 'admin_id != ' => $RoleData['admin_id']);
			
			if($RoleData['admin_role_id'] == 2){
				$role_name = 'CBH';
				$cond = array_merge($cond, array('admin_role_circle_id' => $RoleData['admin_role_circle_id']));
			} else if(0 && $RoleData['admin_role_id'] == 3){
				$role_name = 'FE';
				$cond = array_merge($cond, array('admin_role_ssa_id' => $RoleData['admin_role_ssa_id']));
			}
			
			$exist_arr = $this->db->get_where('bs_admin_roles', $cond)->row_array();
			if(!empty($exist_arr)){
				return array(true, $role_name);
			}
		}
		return array(false, $role_name);
	}
	
	public function get_afe_users($limit, $start) {        
		
		$data = array(); $where = array(); $like = array(); 
		
		if(isset($_GET['status'])) {	
			$_GET['status'] = $_GET['status'] == 2 ? 0 : $_GET['status'];
			$where = array_merge($where,array('bs_afe_users.afe_status' => $_GET['status']));			
		}
		
		if(isset($_GET['name']) && !empty($_GET['name'])){
			$like = array_merge($like,array('bs_afe_users.afe_name' => $_GET['name']));
		}		
					
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->from('bs_afe_users');
		$this->db->join('bs_afe_cats', 'bs_afe_cats.category_id=bs_afe_users.afe_category_id', 'LEFT');  
		$this->db->join('bs_circles', 'bs_circles.circle_id=bs_afe_users.afe_circle_id', 'INNER');  
		$this->db->join('bs_ssa', 'bs_ssa.ssa_id=bs_afe_users.afe_ssa_id', 'INNER');
		$data['count'] = $this->db->count_all_results();
		
		$this->db->select('bs_afe_users.*, bs_circles.circle_name, bs_ssa.ssa_name, bs_afe_cats.category_name');
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->limit($limit, $start);
		$this->db->order_by('bs_afe_users.afe_id','desc');
		$this->db->join('bs_afe_cats', 'bs_afe_cats.category_id=bs_afe_users.afe_category_id', 'LEFT'); 
		$this->db->join('bs_circles', 'bs_circles.circle_id=bs_afe_users.afe_circle_id', 'INNER');  
		$this->db->join('bs_ssa', 'bs_ssa.ssa_id=bs_afe_users.afe_ssa_id', 'INNER');
		$query = $this->db->get("bs_afe_users");		
		$data['result'] = $query->result_array();
		
		return $data;
    }
	
	public function manage_afe() {
		
		validateManageAFE(); //Validate Request Data
		
		$logged_admin = $this->session->userdata('admin');
		$logged_admin_id = $logged_admin['admin_id'];
		
		$afe_id = $this->input->post('afe_id');
		$afe_id = DeCrypt($afe_id);
		
		$data = array();
		$data['afe_category_id'] = $this->input->post('category_id');							
		$data['afe_name'] = $this->input->post('name');							
		$data['afe_email'] = $this->input->post('email');										
		$data['afe_mobile'] = $this->input->post('mobile');										
		$data['afe_pan_card'] = $this->input->post('pan_card');										
		$data['afe_address'] = $this->input->post('address');											
		$data['afe_circle_id'] = $this->input->post('circle_id');											
		$data['afe_ssa_id'] = $this->input->post('ssa_id');											
		$data['afe_bank_name'] = $this->input->post('bank_name');									
		$data['afe_bank_account_no'] = $this->input->post('bank_account_no');									
		$data['afe_bank_ifsc_code'] = $this->input->post('bank_ifsc_code');										
		$data['afe_bank_branch_address'] = $this->input->post('bank_branch_address');

		$sts = $this->check_afe_user_email($data['afe_email'], $afe_id);
		if($sts == 'false'){
			$response['status'] = false;	
			$response['message'] = 'Email Already Exist.<br/>Please enter a valid email';
			echo json_encode($response);die;	
		}
		
		$sts = $this->check_afe_user_mobile($data['afe_mobile'], $afe_id);
		if($sts == 'false'){
			$response['status'] = false;	
			$response['message'] = 'Mobile Already Exist.<br/>Please enter another no';
			echo json_encode($response);die;	
		}
										
		$result = array('status' => false);
		if(empty($afe_id)){			
			
			$data['afe_added_on'] = date('Y-m-d H:i:s');		
			$data['afe_unique_referral_code'] = $this->generateReferralCode($data['afe_name']);		
						
			if($this->db->insert('bs_afe_users', $data)){
				$result['status'] = true;
				$result['insert_id'] = $this->db->insert_id();
			} 
			
		} else {
			
			$data['afe_updated_on'] = date('Y-m-d H:i:s');	
		
			$this->db->where('afe_id', $afe_id);
			if($this->db->update('bs_afe_users', $data)){
				$result['status'] = true;
			}
		}
		
		return $result;
	}
	
	function generateReferralCode($name){
		
		$fname = substr($name, 1);
		
		$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$res = "";
		for ($i = 0; $i < 9; $i++) {
			$res .= $chars[mt_rand(0, strlen($chars)-1)];
		}
		
		$referral_code = $fname.$res;
		return strtoupper($referral_code);
	}
	
	public function get_admin_roles($admin_id, $md5=false){
		if($md5){
			$this->db->where('MD5(admin_id)', $admin_id);
		} else {
			$this->db->where('admin_id', $admin_id);
		}
		$this->db->where(array('admin_role_status' => 1));
		$this->db->select('bs_admin_roles.*, bs_roles.role_name, bs_circles.circle_name, bs_ssa.ssa_name, bs_admin_roles.id as role_prim_id');
		$this->db->join('bs_roles', 'bs_roles.role_id=bs_admin_roles.admin_role_id', 'INNER');
		$this->db->join('bs_circles', 'bs_circles.circle_id=bs_admin_roles.admin_role_circle_id', 'LEFT');  
		$this->db->join('bs_ssa', 'bs_ssa.ssa_id=bs_admin_roles.admin_role_ssa_id', 'LEFT');
		$this->db->order_by('bs_admin_roles.id','desc'); 
		$query = $this->db->get("bs_admin_roles");		
		$roles = $query->result_array();
		
		return $roles;
	}
	
	public function get_all_roles(){
		$this->db->where(array('role_status' => 1));
		$query = $this->db->get("bs_roles");		
		$roles = $query->result_array();
		
		return $roles;
	}
	
	public function manage_leads() {
		
		validateManageLeads(); //Validate Request Data
		
		$logged_admin = $this->session->userdata('admin');
		$logged_admin_id = $logged_admin['admin_id'];
		
		$user_id = $this->input->post('lead_id');
		$user_id = DeCrypt($user_id);
		
		$user = $this->get_LeadDetails($user_id);
		if(!empty($user_id) && empty($user)){
			$response['status'] = false;	
			$response['message'] = 'Unable to process your request right now. <br/> Please try again or some time later [LC1]';
			echo json_encode($response);die;	
		}
		
		$FileData = array(); 
		if(isset($_FILES['app_forms_img']['name'][0]) && !empty($_FILES['app_forms_img']['name'][0])){
			
			$this->load->library('upload'); 
			
			$files = $_FILES;
			$cpt = count($_FILES['app_forms_img']['name']);
			
			$files_name = array(); $one_file_uploaded = false;
			for($i = 0; $i < $cpt; $i++){
				
				$_FILES['userfile']['name']= $files['app_forms_img']['name'][$i];
				$_FILES['userfile']['type']= $files['app_forms_img']['type'][$i];
				$_FILES['userfile']['tmp_name']= $files['app_forms_img']['tmp_name'][$i];
				$_FILES['userfile']['error']= $files['app_forms_img']['error'][$i];
				$_FILES['userfile']['size']= $files['app_forms_img']['size'][$i]; 
				
				$file_name = str_replace(' ','',$_FILES['userfile']['name']);
				$temp = explode('.',$file_name);					
				$file_name = "File-$lead_id-".(time()*microtime());
				$file_name = $file_name.'.'.end($temp);
				$_FILES['userfile']['name'] = $file_name;
				
				$this->upload->initialize($this->set_upload_options());
				
				if($this->upload->do_upload('userfile')){					
					$files_name[] = $file_name;
					$one_file_uploaded = true;
				} else {
					//prx($this->upload->display_errors());
				}
			}
			
			if(!$one_file_uploaded) {
				$response['status'] = false;	
				$response['message'] = 'We are facing some issues while uploading file. <br/>Please try later. [LC0]';
				echo json_encode($response);die;	
			}
			
			$FileData = array('file_name' => implode('*-*', $files_name), 'file_type' => 1, 'file_added_on' => date('Y-m-d H:i:s'));	
		}
		
		$data = array();
		$user_id = $user['user_id'];
		$data['user_full_name'] = $this->input->post('name');							
		$data['user_email'] = $this->input->post('email');										
		$data['user_mobile'] = $this->input->post('mobile');										
		$data['user_address'] = $this->input->post('address');										
		$data['user_circle_id'] = $this->input->post('circle_id');											
		$data['user_ssa_id'] = $this->input->post('ssa_id');
		$data['user_sdca_id'] = $this->input->post('sdca_id');
		$data['user_lead_payment_done'] = $this->input->post('payment_status');
		$data['user_afe_referer_id'] = $this->input->post('afe_id');
		$data['user_lead_source'] = $this->input->post('lead_source');
		$data['user_lead_sdca'] = $this->input->post('lead_sdca');
		
		$sts = $this->check_user_email($data['user_email'], $user_id);
		if($sts == 'false'){
			$response['status'] = false;	
			$response['message'] = 'Email Already Exist.<br/>Please enter a valid email';
			echo json_encode($response);die;	
		}
		
		$sts = $this->check_user_mobile($data['user_mobile'], $user_id);
		if($sts == 'false'){
			$response['status'] = false;	
			$response['message'] = 'Mobile No is Already Exist.<br/>Please enter another.';
			echo json_encode($response);die;	
		}
		
		$user_plan_id = $this->input->post('user_plan_id');										
		$plan_id = $this->input->post('plan_id');										
		$payment_status = $this->input->post('payment_status');										
		
		$result = array('status' => false);
		try{
			$this->db->trans_begin();  // Transaction Start
			
			if(empty($user)){			
				
				$user_lead_status_id = 1;
				$data['user_added_on'] = date('Y-m-d H:i:s');		
				$data['user_lead_status_id'] = $user_lead_status_id;		
				$data['user_active'] = 1;		
							
				if($this->db->insert('bs_users', $data)){
					$result['status'] = true;
					$user_id = $this->db->insert_id();
					$result['insert_id'] = $user_id;
				} 
				
				$call_description = 'New Lead Created Successfully';
				$call_type = 1;
				
			} else {
				
				$user_lead_status_id = $user['user_lead_status_id'];
				$data['user_updated_on'] = date('Y-m-d H:i:s');	
			
				$this->db->where('user_id', $user_id);
				if($this->db->update('bs_users', $data)){
					$result['status'] = true;
				}
				
				$call_description = 'Lead Updated Successfully';
			}
			
			if($one_file_uploaded){
				$FileData['lead_id'] = $user_id;
				if(!$this->db->insert('bs_lead_files', $FileData)){
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later [LC2]');	
				}
			}
			
			$PlanData = array();
			$PlanData['user_id'] = $user_id;
			$PlanData['user_plan_id'] = $plan_id;
			$PlanData['user_plan_status'] = 1;
			
			if(empty($user)){
				$PlanData['user_plan_started_on'] = date('Y-m-d H:i:s');		
				if(!$this->db->insert('bs_user_plans', $PlanData)){
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later [LC3]');	
				}
			} else {
				
				$PlanData['user_plan_ended_on'] = date('Y-m-d H:i:s');
				
				$this->db->where('user_id', $user_id);
				if(!$this->db->update('bs_user_plans', $PlanData)){
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later [LC4]');
				}
				
				if($user['user_plan_id'] != $plan_id) {
					$pln = $this->get_record('bs_plans', 'plan_id', $plan_id, 'plan_name');
					$call_description .= ' Plan has been changed to '.$pln['plan_name'];
				}
			}
			
			$CallInsertData = array();
			$CallInsertData['call_user_id'] = $user_id;
			$CallInsertData['call_logged_admin_id'] = $logged_admin_id;
			$CallInsertData['call_desc'] = $call_description;
			$CallInsertData['call_status_id'] = $user_lead_status_id;
			$CallInsertData['call_time'] = date('Y-m-d H:i:s');
			
			if($this->db->insert('bs_user_call_logs', $CallInsertData)) {
				if($this->db->trans_status() === FALSE) {
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later [LC5]');								
				} else {
					$this->db->trans_commit(); // Transaction Commit
					$result['status'] = true;
				}
			}
		} catch(Exception $e){
			$this->db->trans_rollback(); // Transaction Rollback
			$result['message'] = $e->getMessage();	
			$result['status'] = false;	
		}
		
		return $result;
	}
	
	public function get_all_leads($limit, $start, $allUsers=false) {        
		
		$data = array(); $like = array(); $where_str = '1=1';
		
		$where = array('bs_users.user_lead_status_id <' => 4);
		if($allUsers){
			$where = array('bs_users.user_lead_status_id >' => 3);
		}
		
		if(!empty($_GET['status'])) {	
			$_GET['status'] = $_GET['status'] == 2 ? 0 : $_GET['status'];
			$where = array_merge($where,array('bs_users.user_lead_status_id' => $_GET['status']));			
		}
		
		if(!empty($_GET['circle'])) {	
			$circle = $_GET['circle'];
			$where_str .= " AND bs_users.user_circle_id IN ($circle)";			
		}
		
		if(!empty($_GET['ssa'])){
			$ssa = $_GET['ssa'];
			$where_str .= " AND bs_users.user_ssa_id IN ($ssa)";
		}
		
		if(!empty($_GET['sdca'])){
			$sdca = $_GET['sdca'];
			$where_str .= " AND bs_users.user_sdca_id IN ($sdca)";
		}
		
		if(!empty($_GET['bsnl_id'])){
			$where = array_merge($where,array('bs_users.user_bsnl_id' => $_GET['bsnl_id']));
		}
		
		if(!empty($_GET['cust_id'])){
			$where = array_merge($where,array('bs_users.user_customer_id' => $_GET['cust_id']));
		}
		
		if(!empty($_GET['mobile'])){
			$where = array_merge($where,array('bs_users.user_mobile' => $_GET['mobile']));
		}
		
		if(!empty($_GET['name'])){
			$like = array_merge($like,array('bs_users.user_full_name' => $_GET['name']));
		}		
		
		$this->db->where($where);			
		$this->db->where($where_str);
		$this->db->like($like); 
		$this->db->from('bs_users');
		$this->db->join('bs_circles', 'bs_circles.circle_id=bs_users.user_circle_id', 'INNER'); 
		$this->db->join('bs_ssa', 'bs_ssa.ssa_id=bs_users.user_ssa_id', 'INNER');  
		$this->db->join('bs_sdca', 'bs_sdca.sdca_id=bs_users.user_sdca_id', 'LEFT');  
		$this->db->join('bs_lead_status', 'bs_lead_status.status_id=bs_users.user_lead_status_id', 'INNER'); 
		$this->db->join('bs_user_plans', 'bs_user_plans.user_id=bs_users.user_id', 'INNER'); 
		$this->db->join('bs_plans', 'bs_plans.plan_id=bs_user_plans.user_plan_id', 'INNER'); 
		$data['count'] = $this->db->count_all_results();
		
		$this->db->select('bs_users.*, bs_lead_status.status_name as current_status, bs_plans.plan_name, bs_circles.circle_name, bs_ssa.ssa_name, bs_sdca.sdca_name');
		$this->db->where($where);
		$this->db->where($where_str);
		$this->db->like($like); 
		$this->db->limit($limit, $start);
		$this->db->order_by('bs_users.user_id','desc'); 
		$this->db->join('bs_circles', 'bs_circles.circle_id=bs_users.user_circle_id', 'INNER');  
		$this->db->join('bs_ssa', 'bs_ssa.ssa_id=bs_users.user_ssa_id', 'INNER');
		$this->db->join('bs_sdca', 'bs_sdca.sdca_id=bs_users.user_sdca_id', 'LEFT');
		$this->db->join('bs_lead_status', 'bs_lead_status.status_id=bs_users.user_lead_status_id', 'INNER'); 
		$this->db->join('bs_user_plans', 'bs_user_plans.user_id=bs_users.user_id', 'INNER'); 
		$this->db->join('bs_plans', 'bs_plans.plan_id=bs_user_plans.user_plan_id', 'INNER'); 
		$query = $this->db->get("bs_users");		
		$data['results'] = $query->result_array();
		
		return $data;
    }
	
	public function check_user_email($email, $user_id=NULL) {  
		if(empty($user_id)){
			$user_id = 99999999;
		}
		$already = $this->db->get_where('bs_users',array('LOWER(user_email)' => strtolower($email), 'user_id != ' => $user_id))->row_array();
		if(!empty($already)) {
			$sts = 'false';
		} else {
			$sts = 'true';
		}
		
		return $sts;
	}
	
	public function check_user_mobile($mobile, $user_id=NULL) {  
		if(empty($user_id)){
			$user_id = 99999999;
		}
		$already = $this->db->get_where('bs_users',array('user_mobile' => $mobile, 'user_id != ' => $user_id))->row_array();
		if(!empty($already)) {
			$sts = 'false';
		} else {
			$sts = 'true';
		}
		
		return $sts;
	}
	
	public function check_admin_email($email, $admin_id=NULL){		
		if(trim($admin_id) == ''){
			$admin_id = 99999999;
		}
		
		$already = $this->db->get_where('bs_admins',array('LOWER(admin_email)' =>  strtolower($email), 'admin_id != ' => $admin_id))->row_array();
		if(!empty($already)) {
			$sts = 'false';
		} else {
			$sts = 'true';
		}
		
		return $sts;
	}
	
	public function check_admin_mobile($mobile, $admin_id=NULL){		
		if(trim($admin_id) == ''){
			$admin_id = 99999999;
		}
		
		$already = $this->db->get_where('bs_admins',array('admin_mobile' => $mobile, 'admin_id != ' => $admin_id))->row_array();
		if(!empty($already)) {
			$sts = 'false';
		} else {
			$sts = 'true';
		}
		
		return $sts;
	}
	
	public function check_admin_username($username, $admin_id=NULL){	
		if(trim($admin_id) == ''){
			$admin_id = 99999999;
		}
		
		$already = $this->db->get_where('bs_admins',array('LOWER(admin_username)' => strtolower($username), 'admin_id != ' => $admin_id))->row_array();
		if(!empty($already)) {
			$sts = 'false';
		} else {
			$sts = 'true';
		}
		
		return $sts;
	}
	
	public function check_afe_user_email($email, $user_id=NULL){		
		if(trim($user_id) == ''){
			$user_id = 99999999;
		}
		
		$already = $this->db->get_where('bs_afe_users',array('LOWER(afe_email)' => strtolower($email), 'afe_id != ' => $user_id))->row_array();
		if(!empty($already)) {
			$sts = 'false';
		} else {
			$sts = 'true';
		}
		
		return $sts;
	}
	
	public function check_afe_user_mobile($mobile, $user_id=NULL){	
		if(trim($user_id) == ''){
			$user_id = 99999999;
		}
		
		$already = $this->db->get_where('bs_afe_users',array('afe_mobile' => $mobile, 'afe_id != ' => $user_id))->row_array();
		if(!empty($already)) {
			$sts = 'false';
		} else {
			$sts = 'true';
		}
		
		return $sts;
	}
	
	public function get_all_leadsStatus(){
		$statss_arr = $this->db->get_where('bs_lead_status',array('status_active' => 1, 'status_type' => 'L'))->result_array();
		
		return $statss_arr;
	}
	
	public function get_Circles($circle_id=NULL, $region_id=NULL){
		if(is_array($circle_id) && !empty($circle_id)){
			$this->db->where_in('circle_id', $circle_id);
		} else if(!empty($circle_id)) {
			$this->db->where('circle_id', $circle_id);
		}
		
		if(is_array($region_id) && !empty($region_id)){
			$this->db->where_in('circle_region_id', $region_id);
		} else if(!empty($region_id)) {
			$this->db->where('circle_region_id', $region_id);
		}
		
		$circles = $this->db->get_where('bs_circles', array('circle_status' => 1))->result_array();
		return $circles;
	}
	
	public function get_SSA($circle_id=NULL, $ssa_id=NULL){
		if(is_array($circle_id) && !empty($circle_id)){
			$this->db->where_in('circle_id', $circle_id);
		} else if(!empty($circle_id)) {
			$this->db->where('circle_id', $circle_id);
		}
		
		if(is_array($ssa_id) && !empty($ssa_id)){
			$this->db->where_in('ssa_id', $ssa_id);
		} else if(!empty($ssa_id)) {
			$this->db->where('ssa_id', $ssa_id);
		}
		$ssa = $this->db->get_where('bs_ssa', array('ssa_status' => 1))->result_array();
		return $ssa;
	}
	
	public function get_Plans($plan_id=NULL, $circle_id=NULL){
		if(!empty($plan_id)) {
			$this->db->where('plan_id', $plan_id);
		}
		
		if(is_array($circle_id) && !empty($circle_id)){
			$this->db->where_in('circle_id', $circle_id);
		} else if(!empty($circle_id)) {
			$this->db->where('circle_id', $circle_id);
		}
		
		$plans = $this->db->get_where('bs_plans', array('plan_status' => 1))->result_array();
		return $plans;
	}
	
	public function get_allAFEs($only_Active=NULL, $circle_id=NULL){
		
		if(!empty($only_Active)) {
			$this->db->where('afe_status', 1);
		}
		
		if(!empty($circle_id)){
			$this->db->where('afe_circle_id', $circle_id);
		}
		
		$this->db->select('afe_id, afe_name, afe_name, afe_mobile');
		$results = $this->db->get("bs_afe_users")->result_array();
		
		return $results;
	}
	
	public function get_LeadDetails($lead_id){
		$this->db->select('bs_users.*, bs_user_plans.user_plan_id, bs_plans.plan_name, bs_circles.circle_name, bs_ssa.ssa_name, bs_afe_users.afe_name, bs_afe_users.afe_mobile, bs_lead_status.status_name as current_status');
		$this->db->where('bs_users.user_id', $lead_id);
		$this->db->order_by('bs_users.user_id','desc'); 
		$this->db->join('bs_user_plans', 'bs_user_plans.user_id=bs_users.user_id', 'INNER'); 
		$this->db->join('bs_circles', 'bs_circles.circle_id=bs_users.user_circle_id', 'INNER'); 
		$this->db->join('bs_ssa', 'bs_ssa.ssa_id=bs_users.user_ssa_id', 'INNER'); 
		$this->db->join('bs_plans', 'bs_plans.plan_id=bs_user_plans.user_plan_id', 'INNER'); 
		$this->db->join('bs_afe_users', 'bs_afe_users.afe_id=bs_users.user_afe_referer_id', 'LEFT'); 
		$this->db->join('bs_lead_status', 'bs_lead_status.status_id=bs_users.user_lead_status_id', 'INNER');
		$query = $this->db->get("bs_users");	

		return $query->row_array();	
	}
	
	public function get_LeadLogs($lead_id){
		$this->db->select('bs_user_call_logs.*, bs_admins.admin_name, bs_admins.admin_username, bs_lead_status.status_name');
		$this->db->where('bs_user_call_logs.call_user_id', $lead_id);
		$this->db->join('bs_lead_status', 'bs_lead_status.status_id=bs_user_call_logs.call_status_id', 'LEFT'); 
		$this->db->join('bs_admins', 'bs_admins.admin_id=bs_user_call_logs.call_logged_admin_id', 'LEFT'); 
		$this->db->order_by('bs_user_call_logs.call_id', 'DESC');
		$results = $this->db->get("bs_user_call_logs")->result_array();
		
		return $results;
	}
	
	public function get_LeadsStatus($lead){
		$this->db->where('bs_lead_status.previous_status_id', $lead['user_lead_status_id']);
		$this->db->where('bs_lead_status.status_type', 'L');
		$this->db->order_by('bs_lead_status.status_id', 'DESC');
		$this->db->where('bs_lead_status.status_active', 1);
		$results = $this->db->get("bs_lead_status")->result_array();
		
		return $results;
	}
	
	public function get_LeadFiles($lead){
		$this->db->where('bs_lead_files.lead_id', $lead['user_id']);
		$this->db->order_by('bs_lead_files.file_id', 'DESC');
		$results = $this->db->get("bs_lead_files")->result_array();
		
		return $results;
	}
	
	public function get_afe_commissions($limit, $start, $month, $year, $and_whre=array(), $sts_in_whr=array()){
		$data = array(); $where = array('commission_status_id > ' => 0); 
		
		if(!empty($month)){
			$where = array_merge($where, array('commission_month' => $month, 'commission_year ' => $year));		
		}
		
		$where_str = '1=1';
		if(is_array($and_whre) && !empty($and_whre)){
			$where = array_merge($where, $and_whre);		
		} else if(!empty($and_whre)){
			$where_str = $and_whre;
		}
		
		if(!empty($_GET['afe'])) {	
			$where = array_merge($where, array('bs_afe_users.afe_id' => DeCrypt($_GET['afe'])));	
		}
		
		
		if(!empty($sts_in_whr)){
			$this->db->where_in('commission_status_id', $sts_in_whr);
		}
		$this->db->where($where);
		$this->db->where($where_str);
		$this->db->from('bs_afe_commissions');
		$this->db->join('bs_afe_commission_status', 'bs_afe_commission_status.status_id=bs_afe_commissions.commission_status_id', 'INNER'); 
		$this->db->join('bs_commission_master', 'bs_commission_master.id=bs_afe_commissions.applied_commission_id', 'INNER'); 
		$this->db->join('bs_afe_users', 'bs_afe_users.afe_id=bs_afe_commissions.commission_afe_id', 'INNER'); 
		$this->db->order_by('bs_afe_commissions.afe_name','asc'); 
		$data['count'] = $this->db->count_all_results();
		
		$this->db->select('bs_afe_commissions.*, bs_afe_users.afe_id, bs_afe_users.afe_name, bs_afe_users.afe_mobile, bs_afe_commission_status.status_name_long as current_status, bs_commission_master.rate as commission_rate, bs_commission_master.rate_type as commission_rate_type');
		$this->db->where($where);
		$this->db->where($where_str);
		if(!empty($sts_in_whr)){
			$this->db->where_in('commission_status_id', $sts_in_whr);
		}
		$this->db->limit($limit, $start);
		$this->db->join('bs_afe_commission_status', 'bs_afe_commission_status.status_id=bs_afe_commissions.commission_status_id', 'INNER'); 
		$this->db->join('bs_commission_master', 'bs_commission_master.id=bs_afe_commissions.applied_commission_id', 'INNER'); 
		$this->db->join('bs_afe_users', 'bs_afe_users.afe_id=bs_afe_commissions.commission_afe_id', 'INNER'); 
		$this->db->order_by('bs_afe_users.afe_id','asc'); 
		$commissions = $this->db->get("bs_afe_commissions")->result_array();		
		
		$data['results'] = $commissions;
		return $data;
	}
	
	public function get_afe_commissions_monthly($limit, $start, $month, $year, $and_whre=array(), $all=false, $active_check=true){
		$data = array(); $where = array(); $like = array();
		
		if($active_check){
			$where = array_merge($where, array('bs_afe_users.afe_status' => 1));	
		}
		
		$where_str = '1=1';
		if(is_array($and_whre) && !empty($and_whre)){
			$where = array_merge($where, $and_whre);		
		} else if(!empty($and_whre)){
			$where_str = $and_whre;
		}
		
		if(!empty($_GET['afe'])) {	
			$where = array_merge($where, array('bs_afe_users.afe_id' => DeCrypt($_GET['afe'])));	
		}
		
		if(!$all) {
			$this->db->where($where);
			$this->db->like($like); 
			$this->db->from('bs_afe_users');
			$data['count'] = $this->db->count_all_results();
		}
		
		$this->db->select('afe_id, afe_name, afe_mobile, afe_circle_id');
		$this->db->where($where);
		$this->db->where($where_str);
		$this->db->like($like); 
		if(!$all) {
			$this->db->limit($limit, $start);
		}
		$this->db->order_by('bs_afe_users.afe_name','asc'); 
		$afe_users = $this->db->get("bs_afe_users")->result_array();		
		
		foreach($afe_users as $k=>$usr){
			$afe_id = $usr['afe_id'];
			
			$this->db->select('bs_plans.plan_name, bs_plans.plan_rental');
			$this->db->where('user_afe_referer_id', $afe_id);
			$this->db->where('user_lead_status_id', $this->leadStatsIdToCons);
			$this->db->where('MONTH(installation_date)', $month);
			$this->db->where('YEAR(installation_date)', $year);
			$this->db->order_by('bs_users.user_id','desc'); 
			$this->db->join('bs_user_plans', 'bs_user_plans.user_id=bs_users.user_id', 'INNER'); 
			$this->db->join('bs_plans', 'bs_plans.plan_id=bs_user_plans.user_plan_id', 'INNER'); 
			$leads = $this->db->get("bs_users")->result_array();	
			
			$total_leads = count($leads); $total_plans_amt = 0;
			foreach($leads as $lead){
				$total_plans_amt = $total_plans_amt + $lead['plan_rental'];
			}
			
			$cr_rt = $this->get_current_commission_rate(1, $month, $year, $usr['afe_circle_id'], $total_leads);
			$commission_rate = $cr_rt['rate'];
			$commission_type = $cr_rt['rate_type'];
			
			$commission_amount = 0;
			if($commission_type == 2){
				$commission_amount = $total_plans_amt*($commission_rate/100);
			} else if($total_plans_amt > 0){
				$commission_amount = $commission_rate;
			}
			//$commission_amount = number_format($commission_amount, 2);
			
			$afe_users[$k]['total_leads'] = $total_leads;
			$afe_users[$k]['total_plans_amt'] = $total_plans_amt;
			$afe_users[$k]['applied_commission_id'] = $cr_rt['id'];
			$afe_users[$k]['commission_rate'] = $commission_rate;
			$afe_users[$k]['commission_rate_type'] = $commission_type;
			$afe_users[$k]['commission_amount'] = $commission_amount;
			$afe_users[$k]['commission_total_leads'] = $total_leads;
		}
		
		$data['results'] = $afe_users;
		return $data;
	}
	
	public function get_afe_leads_count($afe_id, $month, $year){
		$this->db->where('user_afe_referer_id', $afe_id);
		$this->db->where('MONTH(installation_date)', $month);
		$this->db->where('YEAR(installation_date)', $year);
		//$this->db->where('user_lead_status_id >=', 4);
		$this->db->from('bs_users');
		$total_leads = $this->db->count_all_results();
		
		return $total_leads;
	}
	
	public function get_afe_leads($afe_id, $month, $year){
		$data = array();
		
		$this->db->select('bs_users.*, bs_plans.plan_name, bs_plans.plan_rental, bs_lead_status.status_name as current_status');
		if(is_array($afe_id)){
			$this->db->where_in('user_afe_referer_id', $afe_id);
		} else {
			$this->db->where('user_afe_referer_id', $afe_id);
		}
		//$this->db->where('user_lead_status_id >=', 4);
		$this->db->where('MONTH(installation_date)', $month);
		$this->db->where('YEAR(installation_date)', $year);
		$this->db->order_by('bs_users.user_id','desc'); 
		$this->db->join('bs_lead_status', 'bs_lead_status.status_id=bs_users.user_lead_status_id', 'INNER');
		$this->db->join('bs_user_plans', 'bs_user_plans.user_id=bs_users.user_id', 'INNER'); 
		$this->db->join('bs_plans', 'bs_plans.plan_id=bs_user_plans.user_plan_id', 'INNER'); 
		$leads = $this->db->get("bs_users")->result_array();
		
		$data['count'] = 0;
		$data['results'] = $leads;
		
		return $data;
	}
	
	public function get_current_commission_rate($type, $month, $year, $circle_id, $total_leads){
		$this->db->select('id, rate, rate_type');
		$this->db->where('type', 1);
		$this->db->where('MONTH(start_date)', $month);
		$this->db->where('YEAR(start_date)', $year);
		$this->db->where('default_flg', 'N');
		//$this->db->where('MONTH(end_date)', $month);
		$this->db->where('active', 1);
		$this->db->order_by('circle_id', 'desc'); 
		$this->db->where("((circle_id = '$circle_id' AND ($total_leads BETWEEN min_lead_cnt AND max_lead_cnt)) OR (($total_leads BETWEEN min_lead_cnt AND max_lead_cnt) AND (circle_id = 0 OR circle_id IS NULL)))");
		$record = $this->db->get("bs_commission_master")->row_array();
		
		if(empty($record)){
			$this->db->where('type', 1);
			$this->db->where('default_flg', 'Y');
			$this->db->order_by('id', 'desc'); 
			$record = $this->db->get("bs_commission_master")->row_array();
		}
		
		return $record;
	}
	
	public function get_current_incentive_rate($type, $month, $year, $circle_id, $total_leads){
		$this->db->select('id, rate, rate_type');
		$this->db->where('type', $type);
		$this->db->where('MONTH(start_date)', $month);
		$this->db->where('YEAR(start_date)', $year);
		//$this->db->where('MONTH(end_date)', $month);
		$this->db->where('active', 1);
		$this->db->where('default_flg', 'N');
		$this->db->where("($total_leads BETWEEN min_lead_cnt AND max_lead_cnt)");
		$record = $this->db->get("bs_incentive_master")->row_array();
		
		//$this->db->order_by('circle_id', 'desc'); 
		//$this->db->where("((circle_id = '$circle_id' AND ($total_leads BETWEEN min_lead_cnt AND max_lead_cnt)) OR (($total_leads BETWEEN min_lead_cnt AND max_lead_cnt) AND (circle_id = 0 OR circle_id IS NULL)))");
		
		if(empty($record)){
			$this->db->where('type', $type);
			$this->db->where('default_flg', 'Y');
			$this->db->order_by('id', 'desc'); 
			$record = $this->db->get("bs_incentive_master")->row_array();
		}
		
		return $record;
	}
	
	public function get_commissions_allowed_sts($current_sts_id){
		$logged_in_role_id = $_SESSION['admin']['current_role_id'];
		
		$this->db->where("FIND_IN_SET('$current_sts_id', previous_status_id)");
		$this->db->where("FIND_IN_SET('$logged_in_role_id', allowed_role_id)");
		$this->db->where('bs_afe_commission_status.status_active', 1);
		$this->db->where('bs_afe_commission_status.status_id !=', $current_sts_id);
		$this->db->order_by('bs_afe_commission_status.status_id', 'ASC');
		$results = $this->db->get("bs_afe_commission_status")->result_array();
		
		return $results;
	}
	
	public function get_all_afes($cond=array()){
		$this->db->order_by('bs_afe_users.afe_name','asc'); 
		if(!empty($cond)){
			$this->db->where($cond);
			$this->db->order_by('bs_afe_users.afe_id','asc'); 
		}
		$this->db->select('afe_id, afe_name, afe_mobile');
		$this->db->where('afe_status', 1);
		$afe_users = $this->db->get("bs_afe_users")->result_array();
		
		return $afe_users;
	}
	
	public function get_afe_details($afe_id){
		$this->db->select('bs_afe_users.*, bs_circles.circle_name, bs_ssa.ssa_name');
		$this->db->where('bs_afe_users.afe_id', $afe_id);
		$this->db->join('bs_circles', 'bs_circles.circle_id=bs_afe_users.afe_circle_id', 'INNER'); 
		$this->db->join('bs_ssa', 'bs_ssa.ssa_id=bs_afe_users.afe_ssa_id', 'INNER'); 
		$record = $this->db->get("bs_afe_users")->row_array();		
		
		return $record;
	}
	
	public function get_fe_incentives_list_monthly($limit, $start, $month, $year, $role_id=3, $all=false, $and_whre=array()){
		$data = array(); $where = array('bs_admins.admin_status' => 1, 'bs_admin_roles.admin_role_id' => $role_id); $like = array();

		$where_str = '1=1';
		if(is_array($and_whre) && !empty($and_whre)){
			$where = array_merge($where, $and_whre);		
		} else if(!empty($and_whre)){
			$where_str = $and_whre;
		}
		
		if(!empty($_GET['user'])) {	
			$where = array_merge($where, array('bs_admins.admin_id' => DeCrypt($_GET['user'])));	
		}
		
		if(!$all) {
			$this->db->where($where);
			$this->db->like($like); 
			$this->db->from('bs_admins');
			$this->db->join('bs_admin_roles', 'bs_admin_roles.admin_id=bs_admins.admin_id', 'INNER'); 
			$data['count'] = $this->db->count_all_results();
		}
		
		$this->db->select('bs_admins.admin_id, bs_admins.admin_name, bs_admins.admin_mobile, bs_admin_roles.admin_role_ssa_id, bs_admin_roles.admin_role_circle_id');
		$this->db->where($where);
		$this->db->where($where_str);
		$this->db->like($like); 
		if(!$all) {
			$this->db->limit($limit, $start);
		}
		$this->db->order_by('bs_admins.admin_id','asc');
		$this->db->join('bs_admin_roles', 'bs_admin_roles.admin_id=bs_admins.admin_id', 'INNER'); 
		$fe_admins = $this->db->get("bs_admins")->result_array();		
		
		foreach($fe_admins as $j=>$rcd){
			
			$this->db->select('afe_id, afe_name, afe_mobile');
			$this->db->where('afe_ssa_id', $rcd['admin_role_ssa_id']);
			$this->db->order_by('bs_afe_users.afe_name','asc'); 
			$afe_users = $this->db->get("bs_afe_users")->result_array();	
			
			$total_plans_amt = 0; $incentive_total_leads = 0;
			foreach($afe_users as $k=>$usr){
				$afe_id = $usr['afe_id'];
				
				$this->db->select('bs_plans.plan_name, bs_plans.plan_rental');
				$this->db->where('user_afe_referer_id', $afe_id);
				$this->db->where('user_lead_status_id', $this->leadStatsIdToCons);
				$this->db->where('MONTH(installation_date)', $month);
				$this->db->where('YEAR(installation_date)', $year);
				$this->db->order_by('bs_users.user_id','desc'); 
				$this->db->join('bs_user_plans', 'bs_user_plans.user_id=bs_users.user_id', 'INNER'); 
				$this->db->join('bs_plans', 'bs_plans.plan_id=bs_user_plans.user_plan_id', 'INNER'); 
				$leads = $this->db->get("bs_users")->result_array();	
				
				$leads_count = count($leads);
				
				if($leads_count > AFE_TARGET) {
					foreach($leads as $lead){
						$total_plans_amt = $total_plans_amt + $lead['plan_rental'];
					}
					
					$incentive_total_leads = $incentive_total_leads + $leads_count;
				}
			}
			
			$cr_rt = $this->get_current_incentive_rate($role_id, $month, $year, '', $incentive_total_leads);
			$incentive_rate = $cr_rt['rate'];
			$incentive_type = $cr_rt['rate_type'];
			
			$incentive_amount = 0;
			if($incentive_type == 2){
				$incentive_amount = $total_plans_amt*($incentive_rate/100);
			} else if($total_plans_amt > 0) {
				$incentive_amount = $incentive_rate;
			}
			
			$fe_admins[$j]['total_plans_amt'] = $total_plans_amt;
			$fe_admins[$j]['incentive_rate'] = $incentive_rate;
			$fe_admins[$j]['incentive_rate_type'] = $incentive_type;
			$fe_admins[$j]['applied_incentive_id'] = $cr_rt['id'];
			$fe_admins[$j]['incentive_amount'] = $incentive_amount;
			$fe_admins[$j]['incentive_total_leads'] = $incentive_total_leads;
		}
		
		$data['results'] = $fe_admins;
		return $data;
	}
	
	public function get_cbh_incentives_list_monthly($limit, $start, $month, $year, $role_id=2, $all=false, $and_whre=array()){
		$data = array(); $where = array('bs_admins.admin_status' => 1, 'bs_admin_roles.admin_role_id' => $role_id); $like = array();

		$where_str = '1=1';
		if(is_array($and_whre) && !empty($and_whre)){
			$where = array_merge($where, $and_whre);		
		} else if(!empty($and_whre)){
			$where_str = $and_whre;
		}		
		
		if(!empty($_GET['user'])) {	
			$where = array_merge($where, array('bs_admins.admin_id' => DeCrypt($_GET['user'])));	
		}
		
		if(!$all) {
			$this->db->where($where);
			$this->db->like($like); 
			$this->db->from('bs_admins');
			$this->db->join('bs_admin_roles', 'bs_admin_roles.admin_id=bs_admins.admin_id', 'INNER'); 
			$data['count'] = $this->db->count_all_results();
		}
		
		//find CBH
		$this->db->select('bs_admins.admin_id, bs_admins.admin_name, bs_admins.admin_mobile, bs_admin_roles.admin_role_ssa_id, bs_admin_roles.admin_role_circle_id');
		$this->db->where($where);
		$this->db->where($where_str);
		$this->db->like($like); 
		if(!$all) {
			$this->db->limit($limit, $start);
		}
		$this->db->order_by('bs_admins.admin_id','asc');
		$this->db->join('bs_admin_roles', 'bs_admin_roles.admin_id=bs_admins.admin_id', 'INNER'); 
		$cbh_admins = $this->db->get("bs_admins")->result_array();		
		
		foreach($cbh_admins as $i=>$rcd){
			//find FE for CBH
			$circle_id = $rcd['admin_role_circle_id'];
			
			$this->db->select('bs_admins.admin_id, bs_admins.admin_name, bs_admins.admin_mobile, bs_admin_roles.admin_role_ssa_id, bs_admin_roles.admin_role_circle_id');
			$this->db->where(array('admin_role_circle_id' => $circle_id, 'admin_role_id' => 3));
			$this->db->order_by('bs_admins.admin_id','asc');
			$this->db->join('bs_admin_roles', 'bs_admin_roles.admin_id=bs_admins.admin_id', 'INNER'); 
			$fe_admins = $this->db->get("bs_admins")->result_array();	
			
			$incentive_total_leads = 0; $incentive_total_amt = 0;
			foreach($fe_admins as $j=>$rcd){
				
				$total_fe_leads_count = 0; $total_plans_amt = 0;
				
				$this->db->select('afe_id, afe_name, afe_mobile');
				$this->db->where('afe_ssa_id', $rcd['admin_role_ssa_id']);
				$this->db->order_by('bs_afe_users.afe_name','asc'); 
				$afe_users = $this->db->get("bs_afe_users")->result_array();	
				
				foreach($afe_users as $k=>$usr){
					$afe_id = $usr['afe_id'];
					
					$this->db->select('bs_plans.plan_name, bs_plans.plan_rental');
					$this->db->where('user_afe_referer_id', $afe_id);
					$this->db->where('user_lead_status_id', $this->leadStatsIdToCons);
					$this->db->where('MONTH(installation_date)', $month);
					$this->db->where('YEAR(installation_date)', $year);
					$this->db->order_by('bs_users.user_id','desc'); 
					$this->db->join('bs_user_plans', 'bs_user_plans.user_id=bs_users.user_id', 'INNER'); 
					$this->db->join('bs_plans', 'bs_plans.plan_id=bs_user_plans.user_plan_id', 'INNER'); 
					$leads = $this->db->get("bs_users")->result_array();	
					
					$total_fe_leads_count = $total_fe_leads_count + count($leads);
					
					foreach($leads as $lead){
						$total_plans_amt = $total_plans_amt + $lead['plan_rental'];
					}
				}
				
				if($total_fe_leads_count > FE_TARGET) {
					$incentive_total_leads = $incentive_total_leads + $total_fe_leads_count;
					$incentive_total_amt = $incentive_total_amt + $total_plans_amt;
				}
			}
			
			$cr_rt = $this->get_current_incentive_rate($role_id, $month, $year, '', $incentive_total_leads);
			$incentive_rate = $cr_rt['rate'];
			$incentive_type = $cr_rt['rate_type'];
			
			$incentive_amount = 0;
			if($incentive_type == 2){
				$incentive_amount = $incentive_total_amt*($incentive_rate/100);
			} else if($incentive_total_amt > 0){
				$incentive_amount = $incentive_rate;
			}
			
			$cbh_admins[$i]['total_plans_amt'] = $incentive_total_amt;
			$cbh_admins[$i]['incentive_rate'] = $incentive_rate;
			$cbh_admins[$i]['incentive_rate_type'] = $incentive_type;
			$cbh_admins[$i]['applied_incentive_id'] = $cr_rt['id'];
			$cbh_admins[$i]['incentive_amount'] = $incentive_amount;
			$cbh_admins[$i]['incentive_total_leads'] = $incentive_total_leads;			
		}
		
		$data['results'] = $cbh_admins;
		return $data;
	}
	
	public function get_incentives_list($limit, $start, $month, $year, $role_id, $and_whre=array()){
		$data = array(); $where = array('incentive_role_id' => $role_id, 'incentive_month' => $month, 'incentive_year ' => $year, ' 	incentive_status_id > ' => 0); 
		
		if(!empty($and_whre)){
			$where = array_merge($where, $and_whre);		
		}
		
		if(!empty($_GET['user'])) {	
			$where = array_merge($where, array('bs_admins.admin_id' => DeCrypt($_GET['admin'])));	
		}
		
		$this->db->where($where);
		$this->db->from('bs_incentives');
		$this->db->join('bs_incentive_status', 'bs_incentive_status.status_id=bs_incentives.incentive_status_id', 'INNER');
		$this->db->join('bs_incentive_master', 'bs_incentive_master.id=bs_incentives.applied_incentive_id', 'INNER'); 
		$this->db->join('bs_admins', 'bs_admins.admin_id=bs_incentives.incentive_admin_id', 'INNER');
		$this->db->join('bs_admin_roles', 'bs_admin_roles.admin_id=bs_admins.admin_id', 'INNER'); 
		$data['count'] = $this->db->count_all_results();
		
		$this->db->select('bs_incentives.*, bs_admins.admin_id, bs_admins.admin_name, bs_admins.admin_mobile, bs_incentive_status.status_name_long as current_status, bs_incentive_master.rate as incentive_rate, bs_incentive_master.rate_type as incentive_rate_type');
		$this->db->where($where);
		$this->db->limit($limit, $start);
		$this->db->join('bs_incentive_status', 'bs_incentive_status.status_id=bs_incentives.incentive_status_id', 'INNER'); 
		$this->db->join('bs_incentive_master', 'bs_incentive_master.id=bs_incentives.applied_incentive_id', 'INNER'); 
		$this->db->join('bs_admins', 'bs_admins.admin_id=bs_incentives.incentive_admin_id', 'INNER');
		$this->db->join('bs_admin_roles', 'bs_admin_roles.admin_id=bs_admins.admin_id', 'INNER'); 
		$this->db->order_by('bs_admins.admin_name','asc'); 
		$incentives = $this->db->get("bs_incentives")->result_array();		
		
		$data['results'] = $incentives;
		return $data;
	}
	
	public function get_all_admins_byRole($role_id, $and_whre=NULL){
		if(!empty($and_whre)){
			$this->db->where($and_whre);
		}
		$this->db->select('bs_admins.admin_id, bs_admins.admin_name, bs_admins.admin_mobile');
		$this->db->where(array('bs_admins.admin_status' => 1, 'bs_admin_roles.admin_role_id' => $role_id));
		$this->db->order_by('bs_admins.admin_id','asc');
		$this->db->join('bs_admin_roles', 'bs_admin_roles.admin_id=bs_admins.admin_id', 'INNER'); 
		$admins = $this->db->get("bs_admins")->result_array();	
		
		return $admins;
	}
	
	public function get_admin_leads_count($admin_id, $role_id, $month, $year){
		$admin = $this->get_admin_with_roles($admin_id);
		
		$afe_cond = array();
		if($admin['admin_role_id'] == 2){
			$afe_cond = array('afe_circle_id' => $admin['admin_role_circle_id']);
		} else {
			$afe_cond = array('afe_ssa_id' => $admin['admin_role_ssa_id']);
		}
		
		$afe_users = $this->get_all_afes($afe_cond);
		$afe_ids = array_map(function($e){return $e['afe_id'];}, $afe_users);
		
		$this->db->where_in('user_afe_referer_id', $afe_ids);
		$this->db->where('MONTH(installation_date)', $month);
		$this->db->where('YEAR(installation_date)', $year);
		//$this->db->where('user_lead_status_id >=', 4);
		$this->db->from('bs_users');
		$total_leads = $this->db->count_all_results();
		
		return $total_leads;
	}
	
	public function get_incentives_leads($limit, $start, $admin_id, $month, $year){
		$admin = $this->get_admin_with_roles($admin_id);
		
		$afe_cond = array();
		if($admin['admin_role_id'] == 2){
			$afe_cond = array('afe_circle_id' => $admin['admin_role_circle_id']);
		} else {
			$afe_cond = array('afe_ssa_id' => $admin['admin_role_ssa_id']);
		}
		
		$results = $this->get_afe_commissions_monthly($limit, $start, $month, $year, $afe_cond, true, false);
		$results['admin'] = $admin;
		
		return $results;
	}
	
	public function get_cbh_incentive_leads($limit, $start, $admin_id, $month, $year){
		$admin = $this->get_admin_with_roles($admin_id);
		
		$fe_cond = array('bs_admin_roles.admin_role_circle_id' => $admin['admin_role_circle_id']);
		
		$results = $this->get_fe_incentives_list_monthly($limit, $start, $month, $year, 3, false, $fe_cond);
		$results['admin'] = $admin;
		
		return $results;
	}
	
	public function get_leads($limit, $start, $and_whre=NULL){
		$data = $where = array(); $where_str = '1=1';
		
		if(!empty($_GET['afe'])){
			$where = array_merge($where, array('bs_afe_users.afe_id' =>  DeCrypt($_GET['afe'])));
		}
		
		if(!empty($_GET['from_date'])){
			$where = array_merge($where, array('DATE(user_added_on) >=' => date('Y-m-d', strtotime($_GET['from_date']))));
		}
		
		if(!empty($_GET['to_date'])){
			$where = array_merge($where, array('DATE(user_added_on) <=' => date('Y-m-d', strtotime($_GET['to_date']))));
		}
		
		if(!empty($_GET['month']) && !empty($_GET['year'])){
			$where = array_merge($where, array('YEAR(user_added_on)' => $_GET['year'], 'YEAR(user_added_on)' => $_GET['year']));
		}
		
		if(!empty($_GET['circle'])){
			$circle = $_GET['circle'];
			$where_str .= " AND bs_users.user_circle_id IN ($circle)";
		}
		
		if(!empty($_GET['ssa'])){
			$ssa = $_GET['ssa'];
			$where_str .= " AND bs_users.user_circle_id IN ($ssa)";
		}
		
		$this->db->select('bs_users.user_full_name, bs_users.user_mobile, bs_users.user_lead_source, bs_plans.plan_name, bs_plans.plan_rental, bs_lead_status.status_name as current_status, bs_afe_users.afe_name, bs_afe_users.afe_mobile, bs_circles.circle_name, bs_ssa.ssa_name');
		$this->db->join('bs_lead_status', 'bs_lead_status.status_id=bs_users.user_lead_status_id', 'INNER');
		$this->db->join('bs_user_plans', 'bs_user_plans.user_id=bs_users.user_id', 'INNER'); 
		$this->db->join('bs_plans', 'bs_plans.plan_id=bs_user_plans.user_plan_id', 'INNER'); 
		$this->db->join('bs_circles', 'bs_circles.circle_id=bs_users.user_circle_id', 'INNER'); 
		$this->db->join('bs_ssa', 'bs_ssa.ssa_id=bs_users.user_ssa_id', 'INNER'); 
		$this->db->join('bs_afe_users', 'bs_afe_users.afe_id=bs_users.user_afe_referer_id', 'LEFT'); 
		$this->db->order_by('bs_users.user_id','desc'); 
		$this->db->where($where); 
		$this->db->where($where_str); 
		
		$leads = $this->db->get("bs_users")->result_array();
		
		$data['count'] = 0;
		$data['results'] = $leads;
		
		return $data;
	}
	
	public function get_leads_cnt($limit, $start, $and_whre=NULL){
		$data = $where = array(); $where_str = '1=1';
		
		if(!empty($_GET['from_date'])){
			$where = array_merge($where, array('user_added_on >=' => date('Y-m-d', strtotime($_GET['from_date']))));
		}
		
		if(!empty($_GET['to_date'])){
			$where = array_merge($where, array('user_added_on <=' => date('Y-m-d', strtotime($_GET['to_date']))));
		}
		
		if(!empty($_GET['month']) && !empty($_GET['year'])){
			$where = array_merge($where, array('YEAR(user_added_on)' => $_GET['year'], 'YEAR(user_added_on)' => $_GET['year']));
		}
		
		if(!empty($_GET['circle'])){
			$circle = $_GET['circle'];
			$where_str .= "bs_afe_users.afe_circle_id IN ($circle)";
		}
		
		if(!empty($_GET['ssa'])){
			$ssa = $_GET['ssa'];
			$where_str .= "bs_afe_users.afe_ssa_id IN ($ssa)";
		}
		
		$this->db->select('bs_afe_users.afe_id, bs_afe_users.afe_name, bs_afe_users.afe_mobile, COUNT(bs_users.user_afe_referer_id) as total_leads, bs_circles.circle_name, bs_ssa.ssa_name');
		$this->db->join('bs_circles', 'bs_circles.circle_id=bs_afe_users.afe_circle_id', 'INNER'); 
		$this->db->join('bs_ssa', 'bs_ssa.ssa_id=bs_afe_users.afe_ssa_id', 'INNER'); 
		$this->db->join('bs_users', 'bs_users.user_afe_referer_id=bs_afe_users.afe_id', 'LEFT'); 
		$this->db->group_by('bs_afe_users.afe_id'); 
		$this->db->order_by('bs_afe_users.afe_name','desc');
		$this->db->where($where); 		
		$this->db->where($where_str); 		
		$leads = $this->db->get("bs_afe_users")->result_array();
		
		$data['count'] = 0;
		$data['results'] = $leads;
		
		return $data;
	}
	
	private function set_upload_options() {   
		
		$config = array();
		$config['upload_path'] = './assets/uploads/leads/';
		$config['allowed_types'] = 'pdf|jpg|png|jpeg';
		$config['max_size'] = '2048';			

		return $config;
	}
	
	public function get_bsnl_commissions($type, $limit, $start, $month, $year, $and_whre=array(), $sts_in_whr=array(), $all_records=true){
		$data = array(); $where = array('comm_status_id > ' => 0, 'comm_type ' => $type); 
		
		if(!empty($month)){
			$where = array_merge($where, array('comm_month' => $month, 'comm_year ' => $year));		
		}
		
		if(!empty($and_whre)){
			$where = array_merge($where, $and_whre);		
		}
		
		if(!empty($_GET['circle'])){
			$circle_id = DeCrypt($_GET['circle']);
			$where = array_merge($where, array('comm_circle_id' => $circle_id));	
		}
		
		if($all_records) {
			if(!empty($sts_in_whr)){
				$this->db->where_in('comm_status_id', $sts_in_whr);
			}
			$this->db->where($where);
			$this->db->from('bs_bsnl_commissions');
			$this->db->join('bs_commission_master', 'bs_commission_master.id=bs_bsnl_commissions.comm_applied_commision_id', 'INNER'); 
			$this->db->join('bs_regions', 'bs_regions.region_id=bs_bsnl_commissions.comm_circle_id', 'INNER'); 
			$this->db->join('bs_ssa', 'bs_ssa.ssa_id=bs_bsnl_commissions.comm_ssa_id', 'INNER');  
			$data['count'] = $this->db->count_all_results();
		}
		
		$this->db->select('comm_circle_id,comm_ssa_id,comm_total_amount,comm_amount, bs_regions.region_name as circle_name, bs_ssa.ssa_name, bs_commission_master.rate as commission_rate');
		$this->db->where($where);
		if(!empty($sts_in_whr)){
			$this->db->where_in('comm_status_id', $sts_in_whr);
		}
		$this->db->limit($limit, $start);
		$this->db->join('bs_commission_master', 'bs_commission_master.id=bs_bsnl_commissions.comm_applied_commision_id', 'INNER'); 
		$this->db->join('bs_regions', 'bs_regions.region_id=bs_bsnl_commissions.comm_circle_id', 'INNER'); 
		$this->db->join('bs_ssa', 'bs_ssa.ssa_id=bs_bsnl_commissions.comm_ssa_id', 'INNER');   
		$this->db->order_by('bs_regions.region_name','asc'); 
		$commissions = $this->db->get("bs_bsnl_commissions")->result_array();		
		
		$data['results'] = $commissions;
		return $data;
	}
	
	public function get_current_bsnl_commission_rate($month, $year, $circle_id){
		$this->db->select('id, rate');
		$this->db->where('circle_id', $circle_id);
		$this->db->where('type', 2);
		$this->db->where('MONTH(start_date)', $month);
		$this->db->where('YEAR(start_date)', $year);
		//$this->db->where('MONTH(end_date)', $month);
		$this->db->where('active', 1);
		$this->db->where('default_flg', 'N');
		$this->db->order_by('id', 'desc'); 
		$record = $this->db->get("bs_commission_master")->row_array();
		
		if(empty($record)){
			$this->db->where('type', 2);
			$this->db->where('default_flg', 'Y');
			$this->db->order_by('id', 'desc'); 
			$record = $this->db->get("bs_commission_master")->row_array();
		}
		
		return $record;
	}
	
	public function get_all_commision_leads($month, $year, $circle_id=NULL, $ssa_id=NULL){
		$where = array('user_active' => 1, 'user_lead_status_id >= ' => 3);
		
		if(is_array($circle_id) && !empty($circle_id)){
			$this->db->where_in('user_circle_id', $circle_id);
		} else if(!empty($circle_id)){
			$where = array_merge($where, array('user_circle_id' => $circle_id));	
		}
		if(!empty($ssa_id)){
			$where = array_merge($where, array('user_ssa_id' => $ssa_id));	
		}
				
		$this->db->select('user_full_name,user_bsnl_id,user_email,user_mobile, bs_plans.plan_name, bs_plans.plan_rental');
		$this->db->where($where);
		$this->db->where("installation_date IS NOT NULL AND installation_date != '0000-00-00'");
		$this->db->where('MONTH(installation_date)', $month);
		$this->db->where('YEAR(installation_date)', $year);
		$this->db->order_by('bs_users.user_id','desc'); 
		$this->db->join('bs_user_plans', 'bs_user_plans.user_id=bs_users.user_id', 'INNER'); 
		$this->db->join('bs_plans', 'bs_plans.plan_id=bs_user_plans.user_plan_id', 'INNER'); 
		$results = $this->db->get("bs_users")->result_array();	
		
		return $results;
	}
	
	public function checkValidDataByName($name, $type, $circle_id=NULL){
		$result = array();
		$name = strtolower($name);
		
		if($type == 'circle'){
			$result = $this->db->get_where('bs_circles', array('LOWER(circle_code)' => strtolower($name), 'circle_status' => 1))->row_array();
		} else if($type == 'ssa'){
			$result = $this->db->get_where('bs_ssa', array('LOWER(ssa_code)' => strtolower($name), 'ssa_status' => 1, 'circle_id' => $circle_id))->row_array();
		} else if($type == 'role'){
			$result = $this->db->get_where('bs_roles', array('LOWER(role_code)' => strtolower($name), 'role_status' => 1))->row_array();
		} else if($type == 'plan'){
			$result = $this->db->get_where('bs_plans', array('LOWER(plan_code)' => strtolower($name), 'plan_status' => 1, 'circle_id' => $circle_id))->row_array();
		} else if($type == 'lead_status'){
			$result = $this->db->get_where('bs_lead_status', array('LOWER(status_code)' => strtolower($name), 'status_active' => 1, 'status_type' => 'L'))->row_array();
		} else if($type == 'sdca'){
			$result = $this->db->get_where('bs_sdca', array('LOWER(sdca_code)' => strtolower($name), 'sdca_status' => 1, 'ssa_id' => $circle_id))->row_array();
		}
		
		return $result;
	}
	
	public function checkBSNLID($bsnl_id, $user_id=NULL){
		if(empty($user_id)){
			$user_id = 99999999;
		}
		$already = $this->db->get_where('bs_users',array('user_bsnl_id' => $bsnl_id, 'user_id != ' => $user_id))->row_array();
		if(!empty($already)) {
			$sts = 'false';
		} else {
			$sts = 'true';
		}
		
		return $sts;
	}
	
	public function checkCustID($CustID, $user_id=NULL){
		if(empty($user_id)){
			$user_id = 99999999;
		}
		$already = $this->db->get_where('bs_users',array('user_customer_id' => $CustID, 'user_id != ' => $user_id))->row_array();
		if(!empty($already)) {
			$sts = 'false';
		} else {
			$sts = 'true';
		}
		
		return $sts;
	}
	
	public function checkAccntNo($AccntNo, $user_id=NULL){
		if(empty($user_id)){
			$user_id = 99999999;
		}
		$already = $this->db->get_where('bs_users',array('user_account_no' => $AccntNo, 'user_id != ' => $user_id))->row_array();
		if(!empty($already)) {
			$sts = 'false';
		} else {
			$sts = 'true';
		}
		
		return $sts;
	}
	
	public function saveBulkUploadLog($logData=array()){
		$logData['log_end_time'] = date('Y-m-d H:i:s');
		$this->db->insert('bs_bulk_upload_log', $logData);
	}
	
	public function get_all_tickets($limit, $start, $user_id=NULL, $current_RoleId=NULL, $and_where=array(), $all=false, $loggedIn_data=array(), $mobile=NULL) {        
		$logged_admin_id = $loggedIn_data['admin_id'];
		
		$data = $like = $where = array(); 
		
		$where_other = 'bs_tickets.ticket_id IS NOT NULL';
		if(!empty($user_id) || !empty($mobile)){
			$where_other = "1=1 AND (bs_tickets.ticket_user_id = $user_id OR bs_tickets.ticket_mobile_no = '$mobile')"; 
		}
		
		if(!empty($and_where)){
			$where = array_merge($where, $and_where);
		}
		
		if($current_RoleId == 4){
			$where = array_merge($where,array('bs_tickets.ticket_assigned_to_support' => 'Y', 'bs_tickets.ticket_status_id != ' => 7));
		} else if($current_RoleId == 5){
			$where = array_merge($where,array('bs_tickets.ticket_assigned_to_noc_team' => 'Y', 'bs_tickets.ticket_status_id != ' => 7));
		} else if($current_RoleId == 3){
			$where = array_merge($where,array('bs_tickets.ticket_assigned_to_tech' => 'Y', 'bs_tickets.ticket_status_id != ' => 7, 'ticket_assigned_fe_user_id' => $logged_admin_id));
		}
		
		if(!empty($_GET['status'])) {	
			$where = array_merge($where,array('bs_tickets.ticket_status_id' => $_GET['status']));			
		}
		
		if(!empty($_GET['ticket'])){
			$where = array_merge($where,array('bs_tickets.ticket_no' => $_GET['ticket']));
		}
		
		if(!empty($_GET['mobile'])){
			$where = array_merge($where,array('bs_users.user_mobile' => $_GET['mobile']));
		}
		
		if(!empty($_GET['email'])){
			$like = array_merge($like,array('bs_users.user_email' => $_GET['email']));
		}
		
		if(!empty($_GET['accnt_no'])){
			$where = array_merge($where,array('bs_users.user_account_no' => $_GET['accnt_no']));
		}
		
		if(!empty($_GET['priority'])){
			$where = array_merge($where,array('bs_tickets.ticket_priority_id' => $_GET['priority']));
		}
		
		if(empty($user_id) && !$all){		
			$this->db->where($where);
			$this->db->where($where_other);
			$this->db->like($like); 
			$this->db->from('bs_tickets');
			$this->db->join('bs_users', 'bs_users.user_id=bs_tickets.ticket_user_id', 'LEFT'); 
			$this->db->join('bs_ticket_status', 'bs_ticket_status.status_id=bs_tickets.ticket_status_id', 'INNER'); 
			$this->db->join('bs_admins', 'bs_admins.admin_id=bs_tickets.ticket_assigned_user_id', 'LEFT'); 
			$data['count'] = $this->db->count_all_results();
		}
		
		$this->db->select('bs_tickets.*, bs_ticket_status.status_name as current_status, bs_users.user_full_name, bs_users.user_mobile, bs_admins.admin_name as assigned_to');
		$this->db->where($where);
		$this->db->where($where_other);
		$this->db->like($like); 
		if(empty($user_id) && !$all){		
			$this->db->limit($limit, $start);
		}
		$this->db->order_by('bs_tickets.ticket_id','desc'); 
		$this->db->join('bs_ticket_status', 'bs_ticket_status.status_id=bs_tickets.ticket_status_id', 'INNER'); 
		$this->db->join('bs_users', 'bs_users.user_id=bs_tickets.ticket_user_id', 'LEFT');
		$this->db->join('bs_admins', 'bs_admins.admin_id=bs_tickets.ticket_assigned_user_id', 'LEFT'); 		
		$query = $this->db->get("bs_tickets");		
		$data['results'] = $query->result_array();
		
		return $data;
    }
	
	public function manage_ticket($priorities=array())
	{
		validateManageTicket(); //Validate Request Data
		
		$logged_admin = $this->session->userdata('admin');
		$logged_admin_id = $logged_admin['admin_id'];
		
		$ticket_id = $this->input->post('ticket_id');
		$ticket_id = DeCrypt($ticket_id);
		if(!empty($ticket_id)){
			$ticketDetails = $this->get_record('bs_tickets', 'ticket_id', $ticket_id);
			if(empty($ticketDetails)){
				$result['message'] = 'Unable to proocess your request right now.<br/> Please try again or some time later [TC1]';
				$result['status'] = false;	
				return $result;
			}
		}
		
		$result = array('status' => false);
		
		$user_id = $this->input->post('user');
		
		$userDetails = $ticket = array();
		if($user_id != 'new_user' || 1){
			$user_id = DeCrypt($user_id);		
			$userDetails = $this->get_record('bs_users', 'user_id', $user_id);
			if(empty($userDetails)){
				$result['message'] = 'Unable to proocess your request right now.<br/> Please try again or some time later [TC2]';
				$result['status'] = false;	
				return $result;
			}
			$ticket['ticket_user_id'] = $user_id;	
		}										
																					
		//$ticket['ticket_mobile_no'] = $this->input->post('mobile_no');										
		$ticket['ticket_mobile_no'] = $userDetails['user_mobile'];										
		$ticket['ticket_title'] = $this->input->post('title');										
		$ticket['ticket_desc'] = $this->input->post('description');	
		$ticket['ticket_priority_id'] = $this->input->post('priority');	
		$ticket['ticket_assigned_to_support'] = 'Y';	
		
		try{
			$this->db->trans_begin();  // Transaction Start
			
			if(empty($ticket_id)){			
				$status_id = 1;
				$ticket['ticket_created_by'] = $logged_admin_id;		
				$ticket['ticket_created_at'] = date('Y-m-d H:i:s');	
				$ticket['ticket_no'] = $this->generateTicketNo();
				$ticket['ticket_status_id'] = $status_id;
				
				$result['ticket_no'] = $ticket['ticket_no'];
				
				if($this->db->insert('bs_tickets', $ticket)){
					$result['status'] = true;
					$result['insert_id'] = $this->db->insert_id();
					$ticket_id = $result['insert_id'];
				} else {
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later [TC3]');
				}
				
				$call_description = 'New Ticket Created';
				$call_type = 1;
				
			} else {
				$ticket = array();
				$ticket['ticket_priority_id'] = $this->input->post('priority');	
				
				$status_id = $ticketDetails['ticket_status_id'];
				$ticket['ticket_updated_at'] = date('Y-m-d H:i:s');	
			
				$this->db->where('ticket_id', $ticket_id);
				if(!$this->db->update('bs_tickets', $ticket)){
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later [TC4]');
				}
				
				$call_description = 'Ticket Details Updated';
				$call_type = 2;
				
				if($ticketDetails['ticket_priority_id'] != $ticket['ticket_priority_id']){
					$call_description .= "<br/>Priority has been changed from <b>{$priorities[$ticketDetails['ticket_priority_id']]}</b> to <b>{$priorities[$ticket['ticket_priority_id']]}</b>";
				}
			}
			
			$CallInsertData = array();
			$CallInsertData['log_ticket_id'] = $ticket_id;
			$CallInsertData['log_admin_id'] = $logged_admin_id;
			$CallInsertData['log_ticket_status_id'] = $status_id;
			$CallInsertData['log_description'] = $call_description;
			$CallInsertData['log_time'] = date('Y-m-d H:i:s');
			
			if($this->db->insert('bs_ticket_logs', $CallInsertData)) {
				if($this->db->trans_status() === FALSE) {
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later [TC5]');								
				} else {
					if(empty($ticket_id)){
						sendTicketSMS($ticket['ticket_mobile_no'], $userDetails, $ticket['ticket_no'], 2);
						if(!empty($userDetails['user_email'])){
							sendTicketEmail($userDetails['user_email'], $userDetails, $ticket['ticket_no'], 1);
						}
					}
					
					$this->db->trans_commit(); // Transaction Commit
					$result['status'] = true;
				}
			}
		
		}  catch(Exception $e){
			$this->db->trans_rollback(); // Transaction Rollback
			$result['message'] = $e->getMessage();	
			$result['status'] = false;	
		}
		
		return $result;
	}
	
	
	public function generateTicketNo(){
		
		$today = date('Y-m-d');		
		$where = "DATE(ticket_created_at) = DATE('$today')";		
		//$where = "DATE(ticket_created_at) = DATE(NOW())";		
		//$where = "ticket_created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW()";		
		
		$this->db->select('COUNT(ticket_id) as ticket_count');
		$this->db->where($where); 				
		$record = $this->db->get("bs_tickets")->row_array();				
		$temp_id = $record['ticket_count'];
		
		$ticket_no = date('Ymd'). str_pad(($temp_id + 1), 4, '0', STR_PAD_LEFT);
		
		return $ticket_no;
	}
	
	public function get_TicketDetails($ticket_id){
		$this->db->select('bs_tickets.*, bs_ticket_status.status_name as current_status, bs_users.user_full_name, bs_users.user_mobile, bs_users.user_bsnl_id');
		$this->db->where('bs_tickets.ticket_id', $ticket_id);
		$this->db->join('bs_ticket_status', 'bs_ticket_status.status_id=bs_tickets.ticket_status_id', 'INNER'); 
		$this->db->join('bs_users', 'bs_users.user_id=bs_tickets.ticket_user_id', 'LEFT');
		$result = $this->db->get('bs_tickets')->row_array();
		
		return $result;
	}
	
	public function get_TicketLogs($ticket_id){
		$this->db->select('bs_ticket_logs.*, bs_admins.admin_name, bs_admins.admin_username, bs_ticket_status.status_name');
		$this->db->where('bs_ticket_logs.log_ticket_id', $ticket_id);
		$this->db->join('bs_ticket_status', 'bs_ticket_status.status_id=bs_ticket_logs.log_ticket_status_id', 'LEFT'); 
		$this->db->join('bs_admins', 'bs_admins.admin_id=bs_ticket_logs.log_admin_id', 'LEFT'); 
		$this->db->order_by('bs_ticket_logs.log_id', 'DESC');
		$results = $this->db->get("bs_ticket_logs")->result_array();
		
		return $results;
	}
	
	public function get_all_TicketStatus(){
		//$this->db->select('DISTINCT(status_name), status_id');
		$statss_arr = $this->db->get_where('bs_ticket_status',array('status_active' => 1))->result_array();
		
		return $statss_arr;
	}
	
	public function change_TicketAssignedUser($ticketData, $assigned_user_id, $loggedIn_data){
		
		$logged_Admin_id = $loggedIn_data['admin_id'];
		$current_RoleId = $loggedIn_data['current_role_id'];
		$ticket_id = $ticketData['ticket_id'];
		
		$update_data = array();
		$update_data['ticket_assigned_user_id'] = $assigned_user_id;
		if($ticketData['ticket_assigned_to_noc_team'] == 'Y'){
			$update_data['ticket_assigned_noc_user_id'] = $assigned_user_id;
		} else {
			$update_data['ticket_assigned_support_user_id'] = $assigned_user_id;
		}
		
		$result['status'] = false;	
		try{
			$this->db->trans_begin();  // Transaction Start
			
			$this->db->where('ticket_id', $ticket_id);
			if($this->db->update('bs_tickets', $update_data)){
				$CallInsertData = array();
				$CallInsertData['log_ticket_id'] = $ticket_id;
				$CallInsertData['log_admin_id'] = $logged_Admin_id;
				$CallInsertData['log_ticket_status_id'] = $ticketData['ticket_status_id'];
				$CallInsertData['log_description'] = 'Ticket has been assigned to: '.$loggedIn_data['name'];
				$CallInsertData['log_time'] = date('Y-m-d H:i:s');
				
				if($this->db->insert('bs_ticket_logs', $CallInsertData)) {
					
					sendTicketAssignedMail($loggedIn_data, $ticketData['ticket_no'], 3);
					sendTicketAssignedSMS($loggedIn_data, $ticketData['ticket_no'], 4);
					
					if($this->db->trans_status() === FALSE) {
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later [UTC1]');								
					} else {
						$this->db->trans_commit(); // Transaction Commit
						$result['status'] = true;
					}
				}
			}
		}  catch(Exception $e){
			$this->db->trans_rollback(); // Transaction Rollback
			$result['message'] = $e->getMessage();	
		}
		
		return $result;
	}
	
	public function get_AllowedTicketStatus($ticket, $current_RoleId){
		
		$this->db->where("FIND_IN_SET('{$ticket['ticket_status_id']}', bs_ticket_status.previous_status_id) >", 0);
		$this->db->where("(FIND_IN_SET('{$current_RoleId}', bs_ticket_status.status_allowed_role_id) > 0 OR bs_ticket_status.status_allowed_role_id IS NULL)");
		$this->db->order_by('bs_ticket_status.status_id', 'ASC');
		$this->db->where('bs_ticket_status.status_active', 1);
		$results = $this->db->get("bs_ticket_status")->result_array();
		
		return $results;
	}
	
	public function admin_role_locations($role_type, $admin_role_id){
		
		if(in_array($role_type, array(2, 9))){
			$this->db->join('bs_circles', 'bs_circles.circle_id=bs_admin_role_locations.admin_location_circle_id', 'INNER');
			$this->db->select("GROUP_CONCAT(admin_location_circle_id) as circle_ids, GROUP_CONCAT(bs_circles.circle_name) as circle_names");
		} else if($role_type == 3){
			$this->db->join('bs_circles', 'bs_circles.circle_id=bs_admin_role_locations.admin_location_circle_id', 'INNER');
			$this->db->join('bs_ssa', 'bs_ssa.ssa_id=bs_admin_role_locations.admin_location_ssa_id', 'INNER');
			$this->db->join('bs_sdca', 'bs_sdca.sdca_id=bs_admin_role_locations.admin_location_sdca_id', 'INNER');
			$this->db->join('bs_nodes', 'bs_nodes.node_id=bs_admin_role_locations.admin_location_node_id', 'INNER');
			$this->db->select("GROUP_CONCAT(admin_location_ssa_id) as ssa_ids, GROUP_CONCAT(bs_ssa.ssa_name) as ssa_names, GROUP_CONCAT(admin_location_circle_id) as circle_ids, GROUP_CONCAT(bs_circles.circle_name) as circle_names, GROUP_CONCAT(admin_location_sdca_id) as sdca_ids, GROUP_CONCAT(bs_sdca.sdca_name) as sdca_names, GROUP_CONCAT(admin_location_node_id) as node_ids, GROUP_CONCAT(bs_nodes.node_code) as node_names");
		}
		
		$this->db->order_by('bs_admin_role_locations.id', 'ASC');
		$this->db->where('bs_admin_role_locations.admin_location_status', 1);
		$this->db->where('bs_admin_role_locations.admin_role_id', $admin_role_id);
		$this->db->group_by('bs_admin_role_locations.admin_role_id');
		$results = $this->db->get("bs_admin_role_locations")->result_array();
		
		foreach($results as $k=>$rcd){
			$circle_ids = $rcd['circle_ids'];
			$circle_ids = array_unique(explode(',', $circle_ids));
			
			$circle_names = $rcd['circle_names'];
			$circle_names = array_unique(explode(',', $circle_names));
			
			$results[$k]['circle_ids'] = implode(',', $circle_ids);
			$results[$k]['circle_names'] = implode(',', $circle_names);
			
			$ssa_ids = $rcd['ssa_ids'];
			if(!empty($ssa_ids)){
				$ssa_ids = $rcd['ssa_ids'];
				$ssa_ids = array_unique(explode(',', $ssa_ids));
				
				$ssa_names = $rcd['ssa_names'];
				$ssa_names = array_unique(explode(',', $ssa_names));
				
				$results[$k]['ssa_ids'] = implode(',', $ssa_ids);
				$results[$k]['ssa_names'] = implode(',', $ssa_names);
			}
			
			$sdcs_ids = $rcd['sdcs_ids'];
			if(!empty($sdcs_ids)){
				$sdcs_ids = $rcd['sdcs_ids'];
				$sdcs_ids = array_unique(explode(',', $sdcs_ids));
				
				$sdca_names = $rcd['sdca_names'];
				$sdca_names = array_unique(explode(',', $sdca_names));
				
				$results[$k]['sdcs_ids'] = implode(',', $sdcs_ids);
				$results[$k]['sdca_names'] = implode(',', $sdca_names);
			}
			
			$node_ids = $rcd['node_ids'];
			if(!empty($node_ids)){
				$node_ids = $rcd['node_ids'];
				$node_ids = array_unique(explode(',', $node_ids));
				
				$node_names = $rcd['node_names'];
				$node_names = array_unique(explode(',', $node_names));
				
				$results[$k]['node_ids'] = implode(',', $node_ids);
				$results[$k]['node_names'] = implode(',', $node_names);
			}
		}
		return $results;
	}
	
	public function get_AFECategories(){
		$categories = $this->db->get_where('bs_afe_cats',array('category_status' => 1))->result_array();
		return $categories;
	}
	
	public function manage_leads_other_Details(){
		
		$lead_id = $this->input->post('lead_id');
		$lead_id = DeCrypt($lead_id);
		
		$LeadData = $this->get_record('bs_users', 'user_id', $lead_id);
		if(empty($LeadData)){
			$response['status'] = false;
			$response['message'] = 'Unable to proocess your request right now.<br/> Please try again or some time later [CLOD1]';
			echo json_encode($response);die;
		}
		
		validateChangeLeadOtherDetais($LeadData);
		
		$status_id = $LeadData['user_lead_status_id'];
		$cpe_payment_amnt = $this->input->post('cpe_payment_amnt');
		$cpe_payment_mode = $this->input->post('cpe_payment_mode');
		$bsnl_user_id = $this->input->post('bsnl_user_id');
		$caf_no = $this->input->post('caf_no');
		$cr_no = $this->input->post('cr_no');
		$accnt_no = $this->input->post('accnt_no');
		$cust_id = $this->input->post('cust_id');
		
		$logged_admin = $this->session->userdata('admin');
		$logged_admin_id = $logged_admin['admin_id']; 
		
		$response = array('status' => false);
		try{
			$this->db->trans_begin();  // Transaction Start
			
			$log_desc = 'Details has been changed. <br/>';
			$and_log_desc = '';
			
			$LeadUpdateData = array();
			if(!empty($bsnl_user_id) && $LeadData['user_bsnl_id'] != $bsnl_user_id){
				/* $valid = $this->checkBSNLID($bsnl_user_id, $lead_id);
				if($valid != 'true'){
					$response['message'] = 'BSNL Id Already Exist..';
					echo json_encode($response);die;
				} */
				$LeadUpdateData['user_bsnl_id'] = $bsnl_user_id;
				$and_log_desc .= "BSNL ID from <b>{$LeadData['user_bsnl_id']}</b> to <b>$bsnl_user_id</b> <br/>";
			}
			
			if(!empty($caf_no) && $LeadData['user_lead_caf_no'] != $caf_no){
				$LeadUpdateData['user_lead_caf_no'] = $caf_no;
				$and_log_desc .= "CAF NO from <b>{$LeadData['user_lead_caf_no']}</b> to <b>$caf_no</b> <br/>";
			}
			
			if(!empty($accnt_no) && $LeadData['user_account_no'] != $accnt_no){
				$valid = $this->admin_model->checkAccntNo($accnt_no, $lead_id);
				if($valid != 'true'){
					$response['message'] = 'Account No Already Exist.';
					echo json_encode($response);die;
				}
				$LeadUpdateData['user_account_no'] = $accnt_no;
				$and_log_desc .= "Account NO from <b>{$LeadData['user_account_no']}</b> to <b>$accnt_no</b> <br/>";
			}
			
			if(!empty($cust_id) && $LeadData['user_customer_id'] != $cust_id){
				$valid = $this->admin_model->checkCustID($cust_id, $lead_id);
				if($valid != 'true'){
					$response['message'] = 'Customer ID Already Exist.';
					echo json_encode($response);die;
				}
				$LeadUpdateData['user_customer_id'] = $cust_id;
				$and_log_desc .= "Customer ID from <b>{$LeadData['user_customer_id']}</b> <b>to $cust_id</b> <br/>";
			}
			
			if(!empty($cr_no) && $LeadData['user_lead_cr_no'] != $cr_no){
				$LeadUpdateData['user_lead_cr_no'] = $cr_no;
				$and_log_desc .= "CR No from <b>{$LeadData['user_lead_cr_no']}</b> to <b>$cr_no</b> <br/>";
			}
			
			if(!empty($cpe_payment_mode) && $LeadData['user_cpe_payment_mode'] != $cpe_payment_mode){
				$LeadUpdateData['user_cpe_payment_mode'] = $cpe_payment_mode;
				$and_log_desc .= "CPE Payment Mode from <b>{$LeadData['user_cpe_payment_mode']}</b> to <b>$cpe_payment_mode</b> <br/>";
			}
			
			if(!empty($cpe_payment_amnt) && $LeadData['user_cpe_payment_amnt'] != $cpe_payment_amnt){
				$LeadUpdateData['user_cpe_payment_amnt'] = $cpe_payment_amnt;
				$and_log_desc .= "CPE Payment Amt from <b>{$LeadData['user_cpe_payment_amnt']}</b> to <b>$cpe_payment_amnt</b> <br/>";
			}
			
			if(!empty($LeadUpdateData)){
				$this->db->where('user_id', $lead_id);
				if($this->db->update('bs_users', $LeadUpdateData)) {
					$CallInsertData = array();
					$CallInsertData['call_user_id'] = $lead_id;
					$CallInsertData['call_logged_admin_id'] = $logged_admin_id;
					$CallInsertData['call_desc'] = $log_desc.$and_log_desc;
					$CallInsertData['call_status_id'] = $status_id;
					$CallInsertData['call_time'] = date('Y-m-d H:i:s');
					
					$sts = $this->db->insert('bs_user_call_logs', $CallInsertData);
					if($sts) {
						if($this->db->trans_status() === FALSE) {
							throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later [CLOD2]');								
						} else {
							$this->db->trans_commit(); // Transaction Commit
							$response['status'] = true;
							$response['message'] = 'Status has been changed successfully.';
						}
					} else {
						throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later [CLOD3]');	
					}
				} else {
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later [CLOD4]');	
				}
			} else {
				throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later [CLOD5]');	
			}
			
		} catch(Exception $e) {
			$this->db->trans_rollback(); // Transaction Rollback
			$response['message'] = $e->getMessage();
		}
		
		return $response;
	}
	
	public function get_SDCA($ssa_id=NULL, $sdca_id=NULL){
		if(is_array($ssa_id) && !empty($ssa_id)){
			$this->db->where_in('ssa_id', $ssa_id);
		} else if(!empty($ssa_id)) {
			$this->db->where('ssa_id', $ssa_id);
		}
		
		if(is_array($sdca_id) && !empty($sdca_id)){
			$this->db->where_in('sdca_id', $sdca_id);
		} else if(!empty($sdca_id)) {
			$this->db->where('sdca_id', $sdca_id);
		}
		$records = $this->db->get_where('bs_sdca', array('sdca_status' => 1))->result_array();
		return $records;
	}
	
	public function get_Nodes($sdca_id=NULL, $node_id=NULL, $calledFrom=NULL){
		$assigned_node_ids = array(0);
		if(!empty($calledFrom) && $calledFrom == 'admin'){
			
			$assigned_nodes = $this->get_assigned_nodes();
			if(!empty($assigned_nodes)){
				$assigned_node_ids = array_map(function($e){return $e['admin_location_node_id'];}, $assigned_nodes);
			}
		}
		
		if(is_array($sdca_id) && !empty($sdca_id)){
			$this->db->where_in('sdca_id', $sdca_id);
		} else if(!empty($sdca_id)) {
			$this->db->where('sdca_id', $sdca_id);
		}
		
		if(is_array($node_id) && !empty($node_id)){
			$this->db->where_in('node_id', $node_id);
		} else if(!empty($node_id)) {
			$this->db->where('node_id', $node_id);
		}
		
		$this->db->where_not_in('node_id', $assigned_node_ids);
		$records = $this->db->get_where('bs_nodes', array('node_status' => 1))->result_array();
		return $records;
	}
	
	public function get_assigned_nodes($admin_id=NULL, $node_ids=array()){
		if(!empty($admin_id) && empty($node_ids)) {
			$this->db->where('bs_admins.admin_id', $admin_id);
		} else {
			$this->db->where('bs_admins.admin_status', 1);
		}
		
		if(!empty($node_ids)){
			$this->db->where_in('bs_admin_role_locations.admin_location_node_id', $node_ids);
			if(!empty($admin_id)) {
				$this->db->where('bs_admins.admin_id !=', $admin_id);
			}
		}
		
		$this->db->select('bs_admin_role_locations.admin_location_node_id');
		$this->db->join('bs_admin_roles', 'bs_admin_roles.id=bs_admin_role_locations.admin_role_id', 'INNER');
		$this->db->join('bs_admins', 'bs_admins.admin_id=bs_admin_roles.admin_id', 'INNER');
		$assigned_nodes = $this->db->get_where('bs_admin_role_locations', array('bs_admin_roles.admin_role_id' => 3, 'bs_admin_roles.admin_role_status' => 1, 'bs_admin_role_locations.admin_location_status' => 1, 'bs_admin_role_locations.admin_location_node_id >' => 0))->result_array();
		
		return $assigned_nodes;
	}
}	
