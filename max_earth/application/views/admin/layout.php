<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?php echo @$pageTitle?></title>

<link rel="shortcut icon" type="image/png" href="<?php echo ADMIN_ASSETS_URL?>img/favicon.png"/>
<link href="<?php echo ADMIN_ASSETS_URL?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo ADMIN_ASSETS_URL?>font-awesome/css/font-awesome.min.css" rel="stylesheet">   
<link href="<?php echo ADMIN_ASSETS_URL?>css/animate.css" rel="stylesheet">
<link href="<?php echo ADMIN_ASSETS_URL?>css/style.min.css" rel="stylesheet">
<link href="<?php echo ADMIN_ASSETS_URL?>css/developer.css?v=1.7" rel="stylesheet">	
<script src="<?php echo ADMIN_ASSETS_URL?>js/jquery-2.1.1.js"></script>
<link href="<?php echo ADMIN_ASSETS_URL?>css/sweet-alert.css" rel="stylesheet">
<script src="<?php echo ADMIN_ASSETS_URL?>js/sweet-alert.min.js"></script>

<style>
.navbar-brand{height:52px;}
.table > thead > tr > th{font-size:11px;text-align:center;vertical-align:middle;}
/*.float-e-margins{width:70%;margin:0 auto;}*/
</style>
<script>
var ADMIN_BASE_URL = '<?php echo ADMIN_BASE_URL?>';
var ADMIN_ASSETS_URL = '<?php echo ADMIN_ASSETS_URL?>';
var pageTitle = '<?php echo $pageTitle?>';

/***** Global Regex Here ******/
var REGEX_APLHA_SPACE = <?php echo REGEX_APLHA_SPACE?>;
var REGEX_APLHA_SPACE_R = <?php echo REGEX_APLHA_SPACE_R?>;
var REGEX_APLHA = <?php echo REGEX_APLHA?>;
var REGEX_APLHA_R = <?php echo REGEX_APLHA_R?>;
var REGEX_NUM = <?php echo REGEX_NUM?>;
var REGEX_NUM_R = <?php echo REGEX_NUM_R?>;
var REGEX_APLHA_NUM = <?php echo REGEX_APLHA_NUM?>;
var REGEX_APLHA_NUM_R = <?php echo REGEX_APLHA_NUM_R?>;
var REGEX_VALID_ADDR = <?php echo REGEX_VALID_ADDR?>;
var REGEX_VALID_ADDR_R = <?php echo REGEX_VALID_ADDR_R?>;
var REGEX_FLOAT = <?php echo REGEX_FLOAT?>;
var REGEX_FLOAT_R = <?php echo REGEX_FLOAT_R?>;
var REGEX_VALID_BSNLID = <?php echo REGEX_VALID_BSNLID?>;
var REGEX_VALID_BSNLID_R = <?php echo REGEX_VALID_BSNLID_R?>;
var REGEX_APLHA_NUM_SPACE = <?php echo REGEX_APLHA_NUM_SPACE?>;
var REGEX_APLHA_NUM_SPACE_R = <?php echo REGEX_APLHA_NUM_SPACE_R?>;
var REGEX_VALID_ADMIN_USERNAME = <?php echo REGEX_VALID_ADMIN_USERNAME?>;
var REGEX_VALID_ADMIN_USERNAME_R = <?php echo REGEX_VALID_ADMIN_USERNAME_R?>;
var REGEX_VALID_DESC = <?php echo REGEX_VALID_DESC?>;
var REGEX_VALID_DESC_R = <?php echo REGEX_VALID_DESC_R?>;
var REGEX_DATE = <?php echo REGEX_DATE?>;
var REGEX_DATE_R = <?php echo REGEX_DATE_R?>;
var REGEX_PLAN_NAME = <?php echo REGEX_PLAN_NAME?>;
var REGEX_PLAN_NAME_R = <?php echo REGEX_PLAN_NAME_R?>;
var REGEX_PLAN_CODE = <?php echo REGEX_PLAN_CODE?>;
var REGEX_PLAN_CODE_R = <?php echo REGEX_PLAN_CODE_R?>;
var REGEX_VALID_IP = <?php echo REGEX_VALID_IP?>;
var REGEX_VALID_IP_R = <?php echo REGEX_VALID_IP_R?>;
var REGEX_C_NAME = <?php echo REGEX_C_NAME?>;
var REGEX_C_NAME_R = <?php echo REGEX_C_NAME_R?>;
/**********/

$(document).ready(function(){
	
	$.ajaxSetup({
	  data: {'<?=$this->security->get_csrf_token_name(); ?>':'<?=$this->security->get_csrf_hash(); ?>'}
	});
	
	$(document).ajaxComplete(function(x,xhr,settings){
	   if($.trim(xhr.responseText) === 'login-error'){
			swal('Your current session has been expired.Please login again.\n Redirecting you to login page...');
			setTimeout(function(){
				window.location.href = BASE_URL+'login';
			},2000);
	   } else if($.trim(xhr.responseText) === 'access-error'){
			swal('Sorry! You don\'t have permission.');
			setTimeout(function(){
				window.location.href = BASE_URL+'dashboard';
			},2000);
	   }
	});
});
</script>
</head>

<body class="top-navigation">
    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
			<div class="row border-bottom white-bg">
				<nav class="navbar navbar-static-top" role="navigation">
					<div class="navbar-header">
						<button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
							<i class="fa fa-reorder"></i>
						</button>
						<a href="javascript:;" class="navbar-brand">Admin Panel</a>
					</div>
					<div class="navbar-collapse" id="">
						<ul class="nav navbar-top-links navbar-right">
							<li>
								<a href="<?php echo WEBSITE_BASE_URL?>" target="_blank"><i class="fa fa-user"></i> Website</a>
							</li>
							<li>
								<a href="<?php echo ADMIN_BASE_URL.'profile/view'?>"><i class="fa fa-user"></i> Profile</a>
							</li>
							<li>
								<a href="<?php echo ADMIN_BASE_URL.'logout'?>"><i class="fa fa-sign-out"></i> Log out</a>
							</li>
						</ul>
						<div style="float:right;margin-right:45px;font-size:15px;color:red;">
							Welcome: <?=$_SESSION['admin']['name']?><br/>
							Last Login: <?=$_SESSION['admin']['last_login']?>
						</div>
					</div>
				</nav>
				<nav class="navbar navbar-static-top" role="navigation" style="border: 1px solid #ccc;">
					<div class="navbar-collapse collapse" id="navbar">
						<ul class="nav navbar-nav">
							<li class="<?php echo $this->uri->segment(1) == 'cms' ? 'active' : ''?>">
								<a aria-expanded="false" role="button" href="<?php echo ADMIN_BASE_URL.'cms/contents/list'?>" class="dropdown-toggle">
									<i class="fa fa-gears"></i> 
									<span class="nav-label">CMS Contents</span>
								</a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
			<div class="row back_to_lst_dv">
				<?php 
					$current_url = current_url();
					if(strpos($current_url, '/list') === false && strpos($current_url, 'dashboard') === false) {
						$refrer = $this->agent->referrer();
						if(!empty($refrer)){
							$this->session->set_userdata('http_referer', $refrer);
						}
						
						echo '<button type="button" class="btn btn-sm btn-warning back-to-lnk hideTopBckBtn" data-url="'.$this->session->userdata('http_referer').'">Back to Previous Page</button>';
					}
				?>				
			</div>
			<?php $this->load->view($content) ?>
		
		</div>
    </div>

<div id="myIncCommDtlsModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"></h4>
				<!--<button class="btn btn-sm btn-primary m-t-n-xs incCommDtlsBckBtn" type="button"><strong>Back</strong></button>-->	
			</div>
			<div class="modal-body" style="padding: 2px;">						
					
			</div>
		</div>
	</div>
</div>

<?php 
	$flashMessage = '';$flashType = '';
	if($this->session->flashdata('success')){
		$flashType = 'success';
		$flashMessage = $this->session->flashdata('success');
	}
	else if($this->session->flashdata('error'))
	{
		$flashType = 'error';
		$flashMessage = $this->session->flashdata('error');
	}
?>	
	
<script src="<?php echo ADMIN_ASSETS_URL?>js/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>js/bootstrap.min.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>js/plugins/toastr/toastr.min.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>js/inspinia.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>js/sweet-alert.min.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>js/plugins/validate/jquery.validate.min.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>js/developer.js?v=2.2"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>js/jquery.datetimepicker.js"></script>

<link href="<?php echo ADMIN_ASSETS_URL?>css/jquery.datetimepicker.css" rel="stylesheet">
<link href="<?php echo ADMIN_ASSETS_URL?>css/plugins/toastr/toastr.min.css" rel="stylesheet">

<style>

</style>
	
<script>
$(document).ready(function(){
	$('body').append('<div id="loading_overlay" style="display: none;"><div class="loading_message round_bottom"><img alt="loading" src="'+ADMIN_ASSETS_URL+'img/ajax_loader1.gif"></div>');
	
	var flashMessage = "<?php echo $flashMessage?>";
	var flashType = "<?php echo $flashType?>";
	if($.trim(flashType) === 'success') {
		showToast('success',flashMessage);
	} else if($.trim(flashType) === 'error') {
		showToast('error',flashMessage);
	}
});
function showCustomLoader(show)
{
	if(show) {
		$('#loading_overlay').show();
		$('body').addClass('loding-cursor');
	} else {
		$('#loading_overlay').hide();
		$('body').removeClass('loding-cursor');	
	}
}

function customAlertBox(text, type, timer, title){
	
	if(type == undefined || type == ''){
		type = 'success';
	} else if(type == 'e'){
		type = 'error';
	} else if(type == 'w'){
		type = 'warning';
	}
	
	if(title == undefined){
		title = '';
	}
	
	if(timer == undefined){
		timer = 5000;
	}
	
	swal({
	  title: title,
	  text: text,
	  type : type,
	  html : true,	
	  timer: timer						  
	});
}

function showToast(type,message)
{
	toastr.options = {
		closeButton: true,
		progressBar: true,
		showMethod: 'fadeIn',
		timeOut: 4000
	};
	if($.trim(type) === 'success')
	{
		toastr.success(message);
	}
	else
	{
		toastr.error(message);
	}
}
	
</script>
</body>
</html>
