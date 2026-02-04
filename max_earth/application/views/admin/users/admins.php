<style>
div.search-area{width: 98%;margin-left: 13px;}
</style>

<div class="wrapper wrapper-content animated fadeInRight">	
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Users </h5>
					<?php $pageUrl = BASE_URL.'admins/list'?>
					<div class="ibox-tools">
						<button type="button" class="btn btn-sm btn-primary refresh-all add-new-btn" data-url="<?php echo BASE_URL.'admins/add'?>">Add New</button>
						<!--<button type="button" class="btn btn-sm btn-primary refresh-all add-new-btn" data-url="<?php echo BASE_URL.'admins/add/bulk'?>">Bulk Upload</button>-->
					</div>
				</div>
				<div class="ibox-content">
					<div class="row">
						<form id="search-form" action="javascript:;">
						<div class="col-lg-12 search-area">
							<div class="col-md-3 form-group">
								<label class="control-label">Role</label>
								<select class="form-control" name="role">
									<option value="">Select</option>
									<?php 
										$role_id = @$_GET['role'];
										if(isset($roles)) {
											foreach($roles as $role) {
												$selected = '';
												if($role['role_id'] == $role_id) {
													$selected = 'selected';
												}
												echo '<option value="'.$role['role_id'].'" '.$selected.'>'.$role['role_name'].'</option>';
											}
										}
									?>
								</select>	
							</div>
							<div class="col-md-3 form-group">
								<label class="control-label">Name</label>
								<input type="text" placeholder="Search By Name" class="form-control only-alphaNum-space" name="name" value="<?php echo @$_GET['name']?>">
							</div>							
							<div class="col-md-3 form-group">
								<label class="control-label">Status</label>
								<select class="form-control" name="status">
									<option value="">Select</option>
									<option value="1" <?php echo @$_GET['status'] == 1 ? 'selected' : ''?>>Active</option>
									<option value="2" <?php echo @$_GET['status'] === 2 ? 'selected' : ''?>>Inactive</option></select>	
								</select>
							</div>
							<div class="col-md-12">
								<button type="button" class="btn btn-sm btn-primary search-btn">Search!</button>
								<button type="button" class="btn btn-sm btn-default refresh-all" data-url="<?php echo $pageUrl?>">Reset</button>
							</div>
						</div>
						</form>
					</div>
					<div class="table-responsive">
						<?php $this->load->view('elements/admin-list');?>
					</div>					
				</div>
			</div>
		</div>
	</div>
</div>

<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Change Password</h4>
			</div>
			<form action="<?php echo BASE_URL.'admin/change_admin_password'?>" id="change-password-form" method="post">		
				<div class="modal-body">						
					<input type="text" class="form-control" name="password" placeholder="Password"/>
					<br/>
					<input type="text" class="form-control" name="cpassword" placeholder="Confirm Password"/>
					<input type="hidden" class="form-control" name="admin_id"/>
				</div>
				<div class="modal-footer">
					<button class="btn btn-sm btn-primary m-t-n-xs" type="button" id="change-password-btn"><strong>Submit</strong></button>			
				</div>
			</form>
		</div>
	</div>
</div>

<script>
var pageUrl = '<?=$pageUrl?>';
var hideTopBckBtn = 'YES';
$(document).ready(function(){
	$(document).on('click','.change-password-link',function(){
		var user_id = $(this).attr('data-admin_id');
		$('input[name="admin_id"]').val(user_id);
		
		$('#myModal').modal('toggle');
	});		
	
	$(document).on('click','#change-password-btn',function(){        
		
		var url = BASE_URL+'admin/change_admin_password';
			
		showCustomLoader(true);
		$.ajax({
			type : 'POST',
			url : url,
			data : $('#change-password-form').serialize(),
			dataType: 'JSON',
			error : function(){
				showCustomLoader(false);
				customAlertBox('Unable to proocess your request right now.<br/> Please try again or some time later', 'e');
			},
			success : function(response){
				showCustomLoader(false);				
				if(response.status) {
					$('#change-password-form')[0].reset();
					$('#myModal').modal('toggle');
					customAlertBox(response.message);
					
				} else {
					customAlertBox(response.message, 'e');
				}
			}
		});
		return false;		
	});
	
	$(document).on('click','.change-status',function(){
        var status = $(this).attr('data-status');
		var admin_id = $(this).attr('data-admin_id');		
		var btn = $(this);
		
		var url = BASE_URL+'admin/change_admin_status';
		
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
				data: {admin_id:admin_id, status:status},
				dataType: 'JSON',
				error : function(){
					showCustomLoader(false);	
					customAlertBox('Unable to proocess your request right now.<br/> Please try again or some time later', 'e');
				},
				success : function(response){
					showCustomLoader(false);
					if(response.status) {
						customAlertBox(response.message);
						
						setTimeout(function(){
							window.location.reload();
						},200);
						
					} else {
						customAlertBox(response.message, 'e');
					}
				}
			});
			return false;
		});
	});
});

</script>
