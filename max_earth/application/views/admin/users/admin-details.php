<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
		<div class="col-lg-4">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Personal Details</h5>
				</div>
				<div class="ibox-content no-padding">
					<ul class="list-group">
						<li class="list-group-item">
							<b>Name : </b> 
							<?php echo $user['admin_name']?>
						</li>
						<li class="list-group-item ">
							<b>Username : </b> 
							<?php echo $user['admin_username']?>
						</li>
						<li class="list-group-item">
							<b>Email : </b> 
							<?php echo $user['admin_email'] != '' ? $user['admin_email'] : 'Not Available'?>
						</li>
						<li class="list-group-item">
							<b>Contact : </b> 
							<?php echo $user['admin_mobile'] != '' ? $user['admin_mobile'] : 'Not Available'?>
						</li>						
						<li class="list-group-item tooltip-demo">
							<b>Status : </b>
							<?php 
								if($user['admin_status'] == 0)
								{
									echo 
									'<a href="javascript:;" class="change-status" title="Pending" data-toggle="tooltip" data-placement="bottom">
										<i class="fa fa-star-o text-navy" style="color:#FF501E;"></i>
									</a> &nbsp;&nbsp;&nbsp;(Inactive)';
								}
								else if($user['admin_status'] == 1)
								{
									echo 
									'<a href="javascript:;" class="change-status" title="Approved" data-toggle="tooltip" data-placement="bottom">
										<i class="fa fa-star text-navy"></i>
									</a> &nbsp;&nbsp;&nbsp;(Active)';
								}								
							?>
						</li>
						<li class="list-group-item">
							<b>Last Login : </b> 
							<?php 
								if(trim($user['admin_last_login']) == '0000-00-00 00:00:00')
									echo 'No Login Yet';									
								else
									echo date('M-d-Y h:i a',strtotime($user['admin_last_login']));
							?>
						</li>			
					</ul>
				</div>
			</div>
        </div>
		
		<div class="col-lg-5">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Role Details</h5>
				</div>
				<div class="ibox-content no-padding">
					<ul class="list-group">
						<?php 
							foreach($role_details as $role){
						?>
							<li class="list-group-item">
								<b>Role: </b> 
								<?php 
									echo $role['role_name'].'<br/>';
									if(in_array($role['admin_role_id'], array(2,9)) && !empty($role['circle_names'])){
										echo ' <br/>[Circle: '.$role['circle_names'].']';
									} else if($role['admin_role_id'] == 3){
										echo ' [Circle: '.$role['circle_names'].']<br/>';
										echo ' [SSA: '.$role['ssa_names'].']<br/>';
										echo ' [SDCA: '.$role['sdca_names'].']<br/>';
										echo ' [Nodes: '.$role['node_names'].']<br/>';
									}
								?>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
        </div>
		
		<?php 
			if($user['role_id'] == 2 && 0)
			{
		?>
		<div class="col-lg-10">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Access Details</h5>
				</div>
				<div class="ibox-content">
					<form class="form-horizontal" action="<?php echo 'javascript:;'?>" id="manage-form" method="post">
						<?php 
							if(!empty($actions))
							{
								foreach($actions as $action)
								{
						?>						
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo str_replace('_',' ',$action['name'])?></label>
								<div class="col-sm-10">
									<?php 
										if(!empty($action['childs']))
										{
											foreach($action['childs'] as $child)
											{
												$checked = '';
												if(@$child['access'] == 1)
												{
													$checked = 'checked';
												}
									?>
											<label class="checkbox-inline my-checkbox-inline"> 
												<input type="checkbox" class="access_check" value="<?php echo strtolower($action['name'])?>" data-type="<?php echo $child['type']?>" <?php echo $checked?>> 
												<?php echo $child['name']?> 
											</label> 	   									
									<?php 
											}
										}
									?>
								</div>
							</div>
						<?php 
								}
							}
						?>	
						<div class="form-group">
							<label class="col-lg-2 control-label">
								
							</label>
							<div class="col-lg-10">
								<a href="<?php echo BASE_URL.'admin/access/admin/'.$user['id']?>">
									<button class="btn btn-sm btn-primary" type="button" id="manage-form">Update
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
        </div>	
		<?php } ?>
    </div>
</div>

<script>
$(document).ready(function(){
	
	setTimeout(function(){
		$('input:checkbox').attr('disabled',true);
	},100);
	
	/* $(document).on('click','.change-status',function(){
        var status = $(this).attr('data-status');
		var UserId = $(this).attr('data-userid');
		var field = $(this).attr('data-field');
		var btn = $(this);
		
		var url = BASE_URL+'admin/home/change_status?user_id='+UserId+'&status='+status+'&field='+field;
		
		swal({			
		  title:'',
		  text: "Are you sure you want change Status?",
		  showCancelButton: true,
		  confirmButtonColor: "#68AC35",
		  confirmButtonText: "Yes change",
		  closeOnConfirm: true
		},
		function(){		
		    showCustomLoader(true);
			$.ajax({
				type : 'POST',
				url : url,
				dataType: 'JSON',
				error : function(){
					showCustomLoader(false);					
				},
				success : function(response){
					showCustomLoader(false);
					console.log(response.status);
					if(response.status)
					{
						showToast('success',response.message);
						
						setTimeout(function(){
							window.location.reload();
						},100);
					}	
					else
					{
						showToast('error',response.message);
					}
				}
			});
			return false;
		});
	}); */
});
</script>
