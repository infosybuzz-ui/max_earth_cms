<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins custom-wdth">
				<div class="ibox-title">
					<h5>Add/Edit Users</h5>
				</div>
				<div class="ibox-content">
					<?php 
						$attributes = array('class' => 'form-horizontal', 'id' => 'manage_register_form');
						echo form_open('javascript:;', $attributes);
					?>
					<!--<form class="form-horizontal" action="javascript:;" id="manage_register_form" method="post">-->	
						<div class="form-group">
							<label class="col-lg-4 control-label">Role</label>
							<div class="col-lg-7">
								<?php 
									$admin_roles = @$admin_roles[0];
									$admin_role_prim_id = @$admin_roles['id'];
									$admin_role_id = @$admin_roles['admin_role_id'];
									$role_circle_id = @$admin_roles['admin_role_circle_id'];
									$role_ssa_id = @$admin_roles['admin_role_ssa_id'];
									$role_sdca_id = @$admin_roles['admin_role_sdca_id'];
									
									$admin_role_locations = @$admin_role_locations[0];
									
									$role_circle_ids = explode(',', $admin_role_locations['circle_ids']);
									$role_ssa_ids = explode(',', $admin_role_locations['ssa_ids']);
									$role_sdca_ids = explode(',', $admin_role_locations['sdca_ids']);
									$role_node_ids = explode(',', $admin_role_locations['node_ids']);
									
									$cirlDsplSts = $ssaDsplSts = $sdcaDsplSts = $nodeDsplSts = 'display:none;';
									if(in_array($admin_role_id, array(2,9))){
										$cirlDsplSts = 'display:block;';
									} else if($admin_role_id == 3){
										$cirlDsplSts = $ssaDsplSts = $sdcaDsplSts = $nodeDsplSts = 'display:block;';
									}
									
								?>
								<input type="hidden" name="admin_role_prim_id" value="<?php echo EnCrypt($admin_role_prim_id)?>">
								<input type="hidden" name="admin_role_id" value="<?php echo $admin_role_id?>">
								<select name="role_id" id="role_id" class="form-control">
									<option value="">Select</option>									
									<?php 
										if(isset($roles)) {
											foreach($roles as $role) {
												$selected = '';
												if($role['role_id'] == $admin_role_id) {
													$selected = 'selected';
												}
												echo '<option value="'.$role['role_id'].'" '.$selected.'>'.$role['role_name'].'</option>';
											}
										}
									?>   									
							   </select>
							</div>
						</div>					
						<div class="form-group">
							<label class="col-lg-4 control-label">Username</label>
							<div class="col-lg-7">
								<input type="hidden" name="admin_id" value="<?php echo !empty($record['admin_id']) ? EnCrypt($record['admin_id']) : ''?>">
								<input type="text" class="form-control valid-admin-username" name="username" id="username"  placeholder="Username" value="<?php echo @$record['admin_username']?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label">Name</label>
							<div class="col-lg-7">
								<input type="text" class="form-control only-alphaNum-space" name="name" id="name"  placeholder="Name" value="<?php echo @$record['admin_name']?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label">Email</label>
							<div class="col-lg-7">
								<input type="text" class="form-control" name="email" id="email"  placeholder="Email" value="<?php echo @$record['admin_email']?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label">Mobile</label>
							<div class="col-lg-7">
								<input type="text" class="form-control only-number" name="mobile" id="mobile"  placeholder="Mobile" value="<?php echo @$record['admin_mobile']?>" maxlength="10">
							</div>
						</div>				
						<div class="form-group">
							<label class="col-lg-4 control-label">Designation</label>
							<div class="col-lg-7">
								<input type="text" class="form-control only-char-space" name="designation" id="designation"  placeholder="Designation" value="<?php echo @$record['admin_designation']?>">
							</div>
						</div>
						<div class="form-group" id="circle_row" style="<?=$cirlDsplSts?>">
							<label class="col-lg-4 control-label">Circle</label>
							<div class="col-lg-7">
								<select name="circle_id" id="circle_id" class="form-control" <?=$admin_role_id == 9 ? 'multiple' : ''?>>
									<option value="">Select</option>									
									<?php 
										if(isset($circles)) {
											foreach($circles as $rcd) {
												$selected = '';
												if(in_array($rcd['circle_id'], $role_circle_ids)) {
													$selected = 'selected';
												}
												echo '<option value="'.$rcd['circle_id'].'" '.$selected.'>'.$rcd['circle_name'].'</option>';
											}
										}
									?>   									
								</select>
								<span style="color:Red;font-size:10px;<?=$admin_role_id == 9 ? '' : 'display:none;'?>" id="sch_a">You can select Multiple Circles Here, Hold "Ctrl" Key for Multiple</span>
							</div>
						</div>	
						<div class="form-group" id="ssa_row" style="<?=$ssaDsplSts?>">
							<label class="col-lg-4 control-label">SSA</label>
							<div class="col-lg-7">
								<select name="ssa_id" id="ssa_id" class="form-control">
									<option value="">Select</option>									
									<?php 
										if(isset($ssa)) {
											foreach($ssa as $rcd) {
												$selected = '';
												if(in_array($rcd['ssa_id'], $role_ssa_ids)) {
													$selected = 'selected';
												}
												echo '<option value="'.$rcd['ssa_id'].'" '.$selected.'>'.$rcd['ssa_name'].'</option>';
											}
										}
									?>   									
								</select>
							</div>
						</div>	
						<div class="form-group" id="sdca_row" style="<?=$sdcaDsplSts?>">
							<label class="col-lg-4 control-label">SDCA</label>
							<div class="col-lg-7">
								<select name="sdca_id" id="sdca_id" class="form-control">
									<option value="">Select</option>									
									<?php 
										if(isset($sdca)) {
											foreach($sdca as $rcd) {
												$selected = '';
												if(in_array($rcd['sdca_id'], $role_ssa_ids)) {
													$selected = 'selected';
												}
												echo '<option value="'.$rcd['sdca_id'].'" '.$selected.'>'.$rcd['sdca_name'].'</option>';
											}
										}
									?>   									
								</select>
							</div>
						</div>
						<div class="form-group" id="node_row" style="<?=$nodeDsplSts?>">
							<label class="col-lg-4 control-label">Node</label>
							<div class="col-lg-7">
								<select name="node_id" id="node_id" class="form-control" multiple>
									<option value="">Select</option>									
									<?php 
										if(isset($nodes)) {
											foreach($nodes as $rcd) {
												$selected = '';
												if(in_array($rcd['node_id'], $role_node_ids)) {
													$selected = 'selected';
												}
												echo '<option value="'.$rcd['node_id'].'" '.$selected.'>'.$rcd['node_code'].'('.$rcd['node_oclan_ip'].')</option>';
											}
										}
									?>   									
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label">
								
							</label>
							<div class="col-lg-7">
								<button class="btn btn-sm btn-primary" type="button" id="manage-form">Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
	
	$(document).on('change','#circle_id',function(){
		var circle_id = $(this).val();
		var role_id = $('#role_id').val();
		
		$('#ssa_id').html('<option value="">Select</option>');
		if($.trim(circle_id) != '' && $.inArray(role_id, ['3']) > -1){
		
			$('#ssa_id').addClass('background-loader');
			$.ajax({
				url: BASE_URL+'user/getCirclesSSA',
				type: 'POST',
				data: {circle_id: circle_id},
				dataType: 'JSON',
				error: function(){
					$('#ssa_id').removeClass('background-loader');
					//customAlertBox('Unable to proocess your request right now.<br/> Please try again or some time later', 'e');
				},
				success: function(response){
					$('#ssa_id').removeClass('background-loader');	
					if(response.status){
						$('#ssa_id').html(response.html);
					} else{
						//customAlertBox(response.message, 'e');
					}
				}
			});
		}
	});
	
	$(document).on('change','#ssa_id',function(){
		var ssa_id = $(this).val();
		var role_id = $('#role_id').val();
		
		$('#sdca_id').html('<option value="">Select</option>');
		if($.trim(ssa_id) != '' && $.inArray(role_id, ['3']) > -1){
		
			$('#sdca_id').addClass('background-loader');
			$.ajax({
				url: BASE_URL+'user/getSSA_SDCA',
				type: 'POST',
				data: {ssa_id: ssa_id},
				dataType: 'JSON',
				error: function(){
					$('#sdca_id').removeClass('background-loader');
					//customAlertBox('Unable to proocess your request right now.<br/> Please try again or some time later', 'e');
				},
				success: function(response){
					$('#sdca_id').removeClass('background-loader');	
					if(response.status){
						$('#sdca_id').html(response.html);
					} else{
						//customAlertBox(response.message, 'e');
					}
				}
			});
		}
	});
	
	$(document).on('change','#sdca_id',function(){
		var sdca_id = $(this).val();
		var role_id = $('#role_id').val();
		
		$('#node_id').html('<option value="">Select</option>');
		if($.trim(sdca_id) != '' && $.inArray(role_id, ['3']) > -1){
		
			$('#node_id').addClass('background-loader');
			$.ajax({
				url: BASE_URL+'user/getSDCA_Nodes',
				type: 'POST',
				data: {sdca_id: sdca_id, calledFrom: 'admin'},
				dataType: 'JSON',
				error: function(){
					$('#node_id').removeClass('background-loader');
					//customAlertBox('Unable to proocess your request right now.<br/> Please try again or some time later', 'e');
				},
				success: function(response){
					$('#node_id').removeClass('background-loader');	
					if(response.status){
						$('#node_id').html(response.html);
					} else{
						//customAlertBox(response.message, 'e');
					}
				}
			});
		}
	});
	
	$(document).on('change','#role_id',function(){
		var role_id = $(this).val();
		
		$('#circle_row, #ssa_row, #sdca_row, #node_row').slideUp();
		$('#sch_a').hide();
		$('#circle_id').removeAttr('multiple');
		if($.trim(role_id) == '2' || $.trim(role_id) == '9'){
			$('#circle_row').slideDown();
		} else if($.trim(role_id) == '3') {
			$('#circle_row').slideDown();
			$('#circle_id').val('');
			$('#circle_id option[value=""]').prop('selected', true);
			$('#ssa_row').slideDown();
			$('#sdca_row').slideDown();
			$('#node_row').slideDown();
		}
		
		if($.trim(role_id) == '9'){
			$('#sch_a').show();
			$('#circle_id').attr('multiple', 'multiple');
		}
	});
	
	$(document).on('click','#manage-form',function(){
		if($("#manage_register_form").valid()){
		    
			var m_circles = '';
			$('#circle_id option:selected').each(function(){
				var val = $(this).attr('value');
				m_circles = m_circles != '' ? m_circles+','+val : val;
			});
			
			var m_nodes = '';
			$('#node_id option:selected').each(function(){
				var val = $(this).attr('value');
				m_nodes = m_nodes != '' ? m_nodes+','+val : val;
			});
			
			var formData = $('#manage_register_form').serialize();
			formData += '&m_circles='+m_circles;
			formData += '&m_nodes='+m_nodes;
			
			showCustomLoader(true);
			$.ajax({
				url: BASE_URL+'admins/add',
				type: 'POST',
				data: formData,
				dataType: 'JSON',
				error: function(){
					showCustomLoader(false);
					customAlertBox('Unable to proocess your request right now.<br/> Please try again or some time later', 'e');					
				},
				success: function(response){
					showCustomLoader(false);		
					if(response.status){
						customAlertBox(response.message);			

						setTimeout(function(){window.location.href=response.redirectTo;},2000);
						
					} else{
						customAlertBox(response.message, 'e');
					}
				}
			});
		}
	});	

	$(document).on('input','.valid-admin-username',function(){ 		
		var $this = $(this);
		var regexp = REGEX_VALID_ADMIN_USERNAME_R;
		var value = $this.val();
		
		if(value != '' && regexp.test(value)){			
			$this.val(value.replace(regexp,'')); 
		}
		return false;
	});	
	
	$.validator.addMethod("checkAdminCrcl", function(value, element, param){
    	var roleID = $('#role_id').val();
		if($.inArray(roleID, [2,3,9]) && $.trim(value) == ''){
			return false;
		}
		return true;
    },("This field is required")); 

	
	$.validator.addMethod("checkAdminSSA", function(value, element, param){
    	var roleID = $('#role_id').val();
		if($.inArray(roleID, [3]) && $.trim(value) == ''){
			return false;
		}
		return true;
    },("This field is required"));
	
	$.validator.addMethod("checkAdminSDCA", function(value, element, param){
    	var roleID = $('#role_id').val();
		if($.inArray(roleID, [3]) && $.trim(value) == ''){
			return false;
		}
		return true;
    },("This field is required"));
	
	$.validator.addMethod("checkAdminNodes", function(value, element, param){
    	var roleID = $('#role_id').val();
		if($.inArray(roleID, [3]) && $.trim(value) == ''){
			return false;
		}
		return true;
    },("This field is required"));
	
	$.validator.addMethod("validAdminUsername", function(value, element, param){
    	var matchText = REGEX_VALID_ADMIN_USERNAME;
		return this.optional(element) || matchText.test(value);
    },("Only Alphabets, Numbers & Underscore are allowed."));
	
	$("#manage_register_form").validate({
		onkeyup: false,
		rules: {			
			username: {
				required: true,	
				minlength: 5,			
				validAdminUsername: true,			
				remote : BASE_URL+'admin/check_admin_username?id='+$('input[name="admin_id"]').val(),
			},
			name: {
				required: true,
				alphaNumericSpace:true,
			},
			email: {
				required: true,
				email:true,
				remote: BASE_URL+'admin/check_admin_email?id='+$('input[name="admin_id"]').val(),
			},
			mobile: {
				required: true,
				number:true,
				maxlength:10,
				minlength:10,
				remote: BASE_URL+'admin/check_admin_mobile?id='+$('input[name="admin_id"]').val(),
			},						
			designation: {
				alphaSpace:true,
			},
			circle_id: {
				checkAdminCrcl:true,
			},	
			ssa_id: {
				checkAdminSSA:true,
			},
			sdca_id: {
				checkAdminSDCA:true,
			},
			node_id: {
				checkAdminNodes:true,
			},
		},
		messages: {
			username:{
				remote: 'Username Already Exist'
			},
			email:{
				remote: 'Email Already Exist'
			},
			mobile:{
				remote: 'Mobile Already Exist'
			}
		},
		submitHandler: function(form) {
			return false;
		},
		highlight: function (element) {						
			$(element).addClass('error');
		},
		unhighlight: function (element) {
			$(element).removeClass('error');
		},
		invalidHandler: function (form, validator) {
			var errors = validator.numberOfInvalids();
			if (errors) {
				var first_error = validator.errorList[0].element;				
				var lbl = '';
				if (errors == 1) {
					lbl = ' Please fill the complete form. {' + errors + '} field is incorrect.';
				} else {
					lbl = ' Please fill the complete form. {' + errors + '} fields are incorrect.';
				}
				
				$('html, body').animate({
					scrollTop: $(first_error).offset().top - 150
				}, 500);
			}
		},
		errorPlacement: function (error, element) {
			error.appendTo($(element).closest('div'));
		}
	});
});  
</script>
