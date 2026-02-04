<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
		<div class="col-lg-3">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Details</h5>
				</div>
				<div class="ibox-content no-padding">
					<ul class="list-group">
						<li class="list-group-item">
							<b>Name : </b> 
							<?php echo $user['admin_name']?>
						</li>
						<li class="list-group-item">
							<b>Email : </b> 
							<?php echo $user['admin_email'] != '' ? $user['admin_email'] : 'Not Available'?>
						</li>
						<li class="list-group-item">
							<b>Contact : </b> 
							<?php echo $user['admin_mobile'] != '' ? $user['admin_mobile'] : 'NA'?>
						</li>
						<li class="list-group-item tooltip-demo">
							<b>Status : </b>
							<?php 
								if($user['admin_status'] == 0)
								{
									echo 
									'<a href="javascript:;" class="" title="Pending" data-toggle="tooltip" data-placement="bottom">
										<i class="fa fa-star-o text-navy" style="color:#FF501E;"></i>
									</a> &nbsp;&nbsp;&nbsp;(Inactive)';
								}
								else if($user['admin_status'] == 1)
								{
									echo 
									'<a href="javascript:;" class="" title="Approved" data-toggle="tooltip" data-placement="bottom">
										<i class="fa fa-star text-navy"></i>
									</a> &nbsp;&nbsp;&nbsp;(Active)';
								}								
							?>
						</li>
						<li class="list-group-item">
							<b>Last Login : </b> 
							<?php echo date('M-d-Y h:i a',strtotime($user['admin_last_login']))?>
						</li>
					</ul>
				</div>
			</div>
        </div>
		<div class="col-lg-4">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Change Password</h5>
				</div>
				<div class="ibox-content">
					<?php 
						$attributes = array('class' => 'form-horizontal', 'id' => 'change-password-form');
						echo form_open('javascript:;', $attributes);
					?>
						<div class="form-group">
							<label class="col-lg-3 control-label">
								Old Password
							</label>
							<div class="col-lg-8">
								<input type="password" placeholder="Old Password" class="form-control" name="old-password"> 
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">
								New Password
							</label>
							<div class="col-lg-8">
								<input type="password" placeholder="Password" class="form-control" name="password"> 
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">
								Confirm Password
							</label>
							<div class="col-lg-8">
								<input type="password" placeholder="Confirm Password" class="form-control" name="cpassword">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">
								
							</label>
							<div class="col-lg-8">
								<button class="btn btn-sm btn-primary" type="button" id="change-password">Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
        </div>
		<div class="col-lg-5">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Profile</h5>
				</div>
				<div class="ibox-content">
					<form class="form-horizontal" action="javascript:;" id="update-profile-form">
						<div class="form-group">
							<label class="col-lg-3 control-label">
								Name
							</label>
							<div class="col-lg-8">
								<input type="text" placeholder="Name" class="form-control" name="name" id="name" value="<?php echo $user['admin_name']?>" disabled> 
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">
								Email
							</label>
							<div class="col-lg-8">
								<input type="text" placeholder="Email Address" class="form-control" name="email" id="email" value="<?php echo $user['admin_email']?>" disabled> 
							</div>
						</div>
					</form>
				</div>
			</div>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function() {
	$(document).on('click','#change-password',function(e){
		var btn = $(this);
		e.preventDefault();
		changePassword(btn);
	});   
	
	$(document).on('click','#update-profile',function(){
		if($("#update-profile-form").valid()){
		
			showCustomLoader(true);
			$.ajax({
				url: BASE_URL+'admin/update_loggedAdmin_profile',
				type: 'POST',
				data: $('#update-profile-form').serialize(),
				dataType: 'JSON',
				error: function(){
					showCustomLoader(false);		
					customAlertBox('Unable to proocess your request right now.<br/> Please try again or some time later', 'e');
				},
				success: function(response){
					showCustomLoader(false);		
					if(response.status){
						customAlertBox(response.message);			
					} else{
						customAlertBox(response.message, 'e');
					}
				}
			});
		}
	});	
	
	$("#update-profile-form").validate({
		onkeyup: false,
		rules: {
			name: {
				required: true,
				alphaSpace:true,
			},
			email: {
				required: true,
				email:true,
			},
			mobile: {
				required: true,
				number:true,
				maxlength:10,
				minlength:10
			},						
		},
		messages: {
			
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

function changePassword(btn)
{
	if($.trim($('input[name="old-password"]').val()) === '' && $.trim($('input[name="password"]').val()) === '' && $.trim($('input[name="cpassword"]').val()) === '')
	{
		showToast('error','Please enter all fields');
		return false;
	}
	else if($.trim($('input[name="old-password"]').val()) === '')
	{
		showToast('error','Please enter old password');
		return false;
	}
	else if($.trim($('input[name="password"]').val()) === '')
	{
		showToast('error','Please enter password');
		return false;
	}
	else if($.trim($('input[name="cpassword"]').val()) === '')
	{
		showToast('error','Please enter confirm password');
		return false;
	}
	else if($.trim($('input[name="password"]').val()) !== '' && $.trim($('input[name="cpassword"]').val()) !== '')
	{
		var password = $.trim($('input[name="password"]').val());
		var cpassword = $.trim($('input[name="cpassword"]').val());
		if(password !== cpassword)
		{
			showToast('error','Password & Confirm Password must be same');
			return false;
		}		
	}
	
	btn.attr('disabled',true);
	showCustomLoader(true);
	$.ajax({
		type : 'POST',
		url : BASE_URL+'admin/update_loggedAdmin_password',
		data : $('#change-password-form').serialize(),
		dataType: 'JSON',
		error : function(){
			btn.attr('disabled',false);
			showCustomLoader(false);
			customAlertBox('Unable to proocess your request right now.<br/> Please try again or some time later', 'e');
		},
		success : function(response){
				btn.attr('disabled',false);		
				showCustomLoader(false);
				if(response.status) {
					$('#change-password-form')[0].reset();
					customAlertBox(response.message);
				} else {
					$('#change-password-form')[0].reset();
					customAlertBox(response.message, 'e');
				}	
		}
	});			
}
</script>