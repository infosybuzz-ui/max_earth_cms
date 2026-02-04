<?php 
error_reporting(0);
class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->database();
		$this->load->model('admin_model');			
	}
	
	public function index() {
		
		chk_access();
			
		$data['pageTitle'] = 'Dashboard';
		$data['content'] = 'admin/index';
		$this->load->view('admin/layout',$data);
	}
			
	public function login()
	{
		$redirect_url = ADMIN_BASE_URL.'dashboard';
		if(!empty($_POST)) {	
			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));
			
			$where = "(admin_username = '$username' OR admin_email = '$username') AND admin_password = '$password'";
			$this->db->where($where);						
			$is_valid = $this->db->get('bs_admins')->row_array();
			
			if(!empty($is_valid)) {
				if($is_valid['admin_status'] == 0) {
					$response['status'] = false;
					$response['message'] = 'Your account is deactivated. <br/> Please contact administration';
					
					echo json_encode($response); die;
				}
				
				if($is_valid['admin_status'] == 2) {
					$response['status'] = false;
					$response['message'] = 'Your account has been blocked.<br/> Please contact administration';
					
					echo json_encode($response); die;
				}
				
				$updateData = array('admin_last_login' => date('Y-m-d H:i:s'));
				$this->db->where('admin_id', $is_valid['admin_id']);
				$this->db->update('bs_admins', $updateData);
				
				$session_data = array(
					'admin_id' => $is_valid['admin_id'],					
					'email' => $is_valid['admin_email'],
					'mobile' => $is_valid['admin_mobile'],
					'name' => $is_valid['admin_name'],
					'last_login' => $updateData['admin_last_login'],
				);
				$this->session->set_userdata('admin', $session_data);
				
				$response['status'] = true;
				$response['message'] = 'Loggen In Successfully.';
				$response['redirectTo'] = $redirect_url;
				
			} else {
				$response['status'] = false;
				$response['message'] = 'Incorrect Username or Password.';
			}
			
			echo json_encode($response); die;
		} else {						
			
			$logged_session = $this->session->userdata('admin');
			if(!empty($logged_session)){
				redirect($redirect_url);
			}
			
			$data['pageTitle'] = 'Login';
			$this->load->view('admin/login',$data);
		}
	}
	
	public function logout() {
		$this->session->unset_userdata('admin_id');
		$this->session->sess_destroy();
		redirect('admin/login');
	}	
	
	public function admin_profile()
	{
		chk_access();
		
		$AdminId = $this->session->userdata('admin_id');
		$data['user'] = $this->admin_model->get_admin($AdminId);
		$data['pageTitle'] = 'Profile';
		$data['content'] = 'admin/users/admin-details';
		$this->load->view('admin/layout',$data);
	}
	
	public function change_password()
	{
		chk_access();
		
		$OldPassword = $this->input->post('old-password');
		$OldPassword = md5($OldPassword);
		$Password = $this->input->post('password');
		$Password = md5($Password);
		
		$AdminId = $this->session->userdata('admin_id');
		$admin = $this->admin_model->get_admin($AdminId);
		
		if(trim($OldPassword) != trim($admin['password']))
		{
			echo 'old';die;
		}
		
		$UpdateData = array('password' => $Password);
		$this->db->where('id',$admin['id']);
		if($this->db->update('ts_users',$UpdateData))
		{
			echo 'success';die;
		}
		echo 'error';die;
	}
	
	public function admin_list()
	{		
		chk_access('admins', 1, true);
		
		$per_page = 10; 
		$page = @$_GET['per_page']? $_GET['per_page'] : 0;
		
		$result = $this->admin_model->get_all_admins($per_page, $page);
		//prx($result);		
		if(!empty($_GET['status']) != '' || !empty($_GET['name'])){
			$base_url = BASE_URL.'admins/users/list?'.$_SERVER['QUERY_STRING'];
		} else {
			$base_url = BASE_URL.'admins/users/list?page=true';
		}
			
		$total_rows = $result['count'];	
		
		$data['links'] = create_links($per_page,$total_rows,$base_url);
		
		$data['admins'] = $result['result'];
		
		if($this->input->is_ajax_request()) {
			$data['result'] = $this->load->view('elements/admin-list',$data,true);
			echo json_encode($data);die;
		}
		
		$data['roles'] = $this->admin_model->get_all_roles();
		
		$data['pageTitle'] = 'Admins';
		$data['content'] = 'admin/users/admins';
		$this->load->view('admin/layout',$data);
	}
			
	public function manage_admin($admin_id=NULL)
	{				
		if(!empty($_POST)) {					
			
			$result = $this->admin_model->manage_admin();			
			
			$response = array();
			if($result['status']) {
				$response['status'] = true;
				if(isset($result['insert_id'])) {
					$response['message'] = 'Added Successfully.';
					$response['redirectTo'] = BASE_URL.'admins/list';
					
				} else {
					$response['message'] = 'Updated Successfully.';
					$response['redirectTo'] = $this->session->userdata('referer');
				}	
			} else {
				$response['status'] = false;	
				if(empty($response['message'])){				
					$response['message'] = 'Unable to process your request right now. <br/> Please try again or some time later.[MAN1]';
				}
			}
			
			echo json_encode($response);die;	
								
		} else {												
			
			if(!empty($admin_id)) {
				chk_access('admins' ,3, true);
				
				$admin_id = DeCrypt($admin_id);
				
				$data['record'] = $this->admin_model->get_record('bs_admins', 'admin_id', $admin_id);
				$data['admin_roles'] = $this->admin_model->get_admin_roles($admin_id);
				
				$data['admin_role_locations'] = $this->admin_model->admin_role_locations($data['admin_roles'][0]['admin_role_id'], $data['admin_roles'][0]['id']);
				
				if(!empty($data['admin_role_locations'][0]['circle_names'])){
					$circle_ids = $data['admin_role_locations'][0]['circle_ids'];
					$circle_ids = explode(',', $circle_ids);
					$data['ssa'] = $this->admin_model->get_SSA($circle_ids);
				}
				
				if(!empty($data['admin_role_locations'][0]['ssa_names'])){
					$ssa_ids = $data['admin_role_locations'][0]['ssa_ids'];
					$ssa_ids = explode(',', $ssa_ids);
					$data['sdca'] = $this->admin_model->get_SDCA($ssa_ids);
				}
				
				if(!empty($data['admin_role_locations'][0]['sdca_names'])){
					$sdca_ids = $data['admin_role_locations'][0]['sdca_ids'];
					$sdca_ids = explode(',', $sdca_ids);
					$data['nodes'] = $this->admin_model->get_Nodes($sdca_ids);
				}
				
				if(isset($_SERVER['HTTP_REFERER'])){			
					$referer = array('referer' => $_SERVER['HTTP_REFERER']);
					$this->session->set_userdata($referer);			
				}
				
			} else {
				chk_access('admins', 2, true);
			}	

			$data['circles'] = $this->admin_model->get_Circles();
			$data['roles'] = $this->admin_model->get_all_roles();
			
			$data['pageTitle'] = 'Manage Admin';
			$data['content'] = 'admin/users/manage-admin';
			$this->load->view('admin/layout',$data);
		}
	}		
	
	public function admin_view($admin_id=NULL)
	{
		chk_access('admins',1, true);
		
		$admin_id = DeCrypt($admin_id);
		
		$data['user'] = $this->admin_model->get_record('bs_admins', 'admin_id', $admin_id);
		
		$data['role_details'] = $this->admin_model->get_admin_roles($admin_id);
		foreach($data['role_details'] as $k=>$role){
			$rslt = $this->admin_model->admin_role_locations($role['admin_role_id'], $role['role_prim_id']);
			if(!empty($rslt)){
				$data['role_details'][$k] = array_merge($role, $rslt[0]);
			}
		}
		
		$data['pageTitle'] = 'Admin Details';
		$data['content'] = 'admin/users/admin-details';
		$this->load->view('admin/layout',$data);
	}		
	
	public function delete_admin($admin_id=NULL)
	{
		if($this->session->userdata('admin_id') == 1) {
		
			if(trim($admin_id) != '')
			{
				$UpdateData = array('deleted' => 1);
				
				$this->db->where('id',$admin_id);			
				if($this->db->update('admins', $UpdateData)) {			
					$this->session->set_flashdata('success','Deleted successfully');
				} else{
					$this->session->set_flashdata('error','Unable to delete');
				}
			}
			else
			{
				$this->session->set_flashdata('error','Unable to delete');
			}
		}
		
		$redirect_to = str_replace(base_url(),'',$_SERVER['HTTP_REFERER']);
		redirect(str_replace('index.php/','',$redirect_to));
	}
	
	public function change_admin_password()
	{
		$logged_admin = chk_access('admins', 3, true);
		
		$logged_admin_id = $logged_admin['admin_id'];
		$admin_id = @$_POST['admin_id'];
		$admin_id = DeCrypt($admin_id);
		$password = @$_POST['password'];
		$cpassword = @$_POST['cpassword'];
				
		$response = array();
		if(!empty($admin_id) && !empty($password) && !empty($cpassword)) {
			if(trim($password) == trim($cpassword)) {
				$password = md5($password);
				
				try{
					$this->db->trans_begin();  // Transaction Start
				
					$UpdateData = array('admin_password' => $password);
					$this->db->where('admin_id', $admin_id);
					if($this->db->update('bs_admins', $UpdateData)) {
						if($this->db->trans_status() === FALSE) {
							throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later.[CAP1]');								
						} else {
							$this->db->trans_commit(); // Transaction Commit
							$response['status'] = true;
							$response['message'] = 'Password Changed Successfully';
						}
					} else {
						throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later.[CAP3]');
					}
					
				}  catch(Exception $e){
					$this->db->trans_rollback(); // Transaction Rollback
					$response['status'] = false;	
					$response['message'] = $e->getMessage();
				}	
			} else {
				$response['status'] = false;
				$response['message'] = 'Unable to process your request. <br/> Please try again or some later.[CAP4]';
			}
		} else {
			$response['status'] = false;
			$response['message'] = 'Unable to process your request. <br/> Please try again or some later.[CAP5]';
		}
		
		echo json_encode($response);die;
	}
	
	public function change_admin_status()
	{
		chk_access('admins', 4, true);
		
		$logged_admin = $this->session->userdata('admin');
		$logged_admin_id = $logged_admin['admin_id'];
				
		$status = $this->input->post('status');
		$admin_id = $this->input->post('admin_id');
		$admin_id = DeCrypt($admin_id);
		
		$response = array();
		if(!empty($status) && !empty($admin_id)) {			
			
			if($status == 1){
				//$admin_detail = $this->admin_model->get_record('bs_admins', 'admin_id', $admin_id);
				$admin_roles = $this->admin_model->get_admin_roles($admin_id);
				if($admin_roles[0]['admin_role_id'] == 3){
					$assigned_nodes = $this->admin_model->get_assigned_nodes($admin_id);
					if(!empty($assigned_nodes)){
						$assigned_node_ids = array_map(function($e){return $e['admin_location_node_id'];}, $assigned_nodes);
						
						if(!empty($assigned_node_ids)){
							$assigned_nodes_a = $this->admin_model->get_assigned_nodes($admin_id, $assigned_node_ids);
							if(!empty($assigned_nodes_a)){
								$response['status'] = false;	
								$response['message'] = 'Node\'s assigned to this FE are re-assigned to some other FE, as this FE was Inactive.';
								echo json_encode($response); die;
							}
						}
					}
				}
			}
			
			try{
				$this->db->trans_begin();  // Transaction Start
			
				$UpdateData = array('admin_status' => $status);
				$this->db->where('admin_id' ,$admin_id);
				if($this->db->update('bs_admins', $UpdateData)) {
					
					$sts_array = array(0 => 'Inactive', 1 => 'Active', 2 => 'Disabled');
					$sts_txt = $sts_array[$status];
					
					$CallInsertData = array();
					$CallInsertData['call_user_id'] = $admin_id;
					$CallInsertData['call_logged_admin_id'] = $logged_admin_id;
					$CallInsertData['call_desc'] = 'Status has been changed to "'.$sts_txt.'"';
					$CallInsertData['call_type'] = 3;
					$CallInsertData['call_time'] = date('Y-m-d H:i:s');
					
					if($this->db->insert('bs_admin_call_logs', $CallInsertData)) {
						if($this->db->trans_status() === FALSE) {
							throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later.[CAS1]');								
						} else {
							$this->db->trans_commit(); // Transaction Commit
							$response['status'] = true;
							$response['message'] = 'Status Changed Successfully';
						}
					} else {
						throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later.[CAS2]');
					}				
				} else {
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later.[CAS3]');
				}
				
			}  catch(Exception $e){
				$this->db->trans_rollback(); // Transaction Rollback
				$response['status'] = false;	
				$response['message'] = $e->getMessage();
			}	
		} else {
			$response['status'] = false;
			$response['message'] = 'Unable to process your request. <br/> Please try again or some later.[CAS4]';
		}
		
		echo json_encode($response);die;
	}
	
	public function update_loggedAdmin_password()
	{
		$logged_admin = chk_access('admins', 3, true);
		
		$logged_admin_id = $logged_admin['admin_id'];
		
		$OldPassword = $this->input->post('old-password');
		$password = $this->input->post('password');
		$cpassword = $this->input->post('cpassword');
		
		$admin = $this->admin_model->get_admin($logged_admin_id, 'admin_password');
		
		$response = array();
		if(trim(md5($OldPassword)) == trim($admin['admin_password'])) {
				
			if(!empty($logged_admin_id) && !empty($password) && !empty($cpassword)) {
				if(trim($password) == trim($cpassword)) {
					$password = md5($password);
					
					try{
						$this->db->trans_begin();  // Transaction Start
					
						$UpdateData = array('admin_password' => $password);
						$this->db->where('admin_id', $logged_admin_id);
						if($this->db->update('bs_admins', $UpdateData)) {
							
							if($this->db->trans_status() === FALSE) {
								throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later.[LADP1]');								
							} else {
								$this->db->trans_commit(); // Transaction Commit
								$response['status'] = true;
								$response['message'] = 'Password Changed Successfully';
							}			
						} else {
							throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later.[LADP3]');
						}
						
					}  catch(Exception $e){
						$this->db->trans_rollback(); // Transaction Rollback
						$response['status'] = false;	
						$response['message'] = $e->getMessage();
					}	
				} else {
					$response['status'] = false;
					$response['message'] = 'Unable to process your request. <br/> Please try again or some later.[LADP4]';
				}
			} else {
				$response['status'] = false;
				$response['message'] = 'Unable to process your request. <br/> Please try again or some later.[LADP5]';
			}
		} else {
			$response['status'] = false;
			$response['message'] = 'Please enter correct Old Password';
		}
		echo json_encode($response);die;
	}
	
	public function update_loggedAdmin_profile(){
		
		$loggedInData = chk_access('admins', 4, true);
		
		if(!empty($_POST['name'])){
			$admin_id = $loggedInData['admin_id'];
			
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$mobile = $this->input->post('mobile');
			
			$sts = $this->admin_model->check_admin_email($email, $admin_id);
			if($sts == 'false'){
				$response['status'] = false;	
				$response['message'] = 'Email Already Exist.<br/>Please enter a valid email';
				echo json_encode($response);die;	
			}
			
			try{
				$this->db->trans_begin();  // Transaction Start
			
				$UpdateArray = array('admin_name' => $name,'admin_email' => $email,'admin_mobile' => $mobile);
				$this->db->where('admin_id' ,$admin_id);
				if($this->db->update('bs_admins', $UpdateArray)) {
					
					if($this->db->trans_status() === FALSE) {
						throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later.[LADPR1]');								
					} else {
						$this->db->trans_commit(); // Transaction Commit
						$response['status'] = true;
						$response['message'] = "Profile updated successfully.";
					}				
				} else {
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later.[LADPR3]');
				}
				
			}  catch(Exception $e){
				$this->db->trans_rollback(); // Transaction Rollback
				$response['status'] = false;	
				$response['message'] = $e->getMessage();
			}
			
		} else {
			$response['status'] = false;
			$response['message'] = "Unable to process your request.<br/> Please try later.[LADPR4]";
		}
		
		echo json_encode($response); die;
	}
	
	public function loggedAdmin_profile()
	{
		$loggedInData = chk_access('admins');
		
		$AdminId = $loggedInData['admin_id'];
		$data['user'] = $this->admin_model->get_admin($AdminId);
		$data['pageTitle'] = 'Profile';
		$data['content'] = 'admin/users/logged-admin-details';
		$this->load->view('admin/layout',$data);
	}
	
	public function check_admin_username($return=false){		
		$username = $this->input->get('username');
		$admin_id = $this->input->get('id');
		$admin_id = DeCrypt($admin_id);
		
		$sts = $this->admin_model->check_admin_username($username, $admin_id);
		echo $sts;
	}
	
	public function check_admin_email($return=false){		
		$email = $this->input->get('email');
		$admin_id = $this->input->get('id');
		$admin_id = DeCrypt($admin_id);
		
		$sts = $this->admin_model->check_admin_email($email, $admin_id);
		echo $sts;
	}
}
