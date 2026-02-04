<style>
.actions-a{
	float: left;
    margin-right: 15px;
}
</style>

<div class="wrapper wrapper-content animated fadeInRight">	
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Contents List </h5>	
					<?php 
						$pageUrl = ADMIN_BASE_URL.'cms/contents/list';
					?>
					<div class="ibox-tools">
	
					</div>
				</div>
				<div class="ibox-content">
					<div class="table-responsive">
						<?php $this->load->view('admin/elements/contents-list');?>
					</div>					
				</div>
			</div>
		</div>
	</div>
</div>

<script>
var pageUrl = '<?php echo $pageUrl?>';
var hideTopBckBtn = 'YES';
$(document).ready(function(){	
	
});

</script>