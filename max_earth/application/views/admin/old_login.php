<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo @$pageTitle?></title>
	<link rel="shortcut icon" type="image/png" href="<?php echo ASSETS_URL?>frontend/images/favicon.png"/>
    <link href="<?php echo ADMIN_ASSETS_URL?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo ADMIN_ASSETS_URL?>font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo ADMIN_ASSETS_URL?>css/animate.css" rel="stylesheet">
    <link href="<?php echo ADMIN_ASSETS_URL?>css/style.css" rel="stylesheet">
	<link href="<?php echo ADMIN_ASSETS_URL?>css/developer.css" rel="stylesheet">
	<script>
		var BASE_URL = '<?php echo ADMIN_BASE_URL?>';
		var ASSETS_URL = '<?php echo ADMIN_ASSETS_URL?>';
	</script>
</head>

<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            
            <h3>Welcome to Support System</h3>
            <p>Login in to enter the Panel.</p>
            <?php 
				$attributes = array('class' => 'm-t', 'id' => 'login-form', 'autocomplete' => 'off');
				echo form_open('javascript:;', $attributes);
			?>
			<!--<form class="m-t" role="form" action="javascript:;" id="login-form" autocomplete="off">-->
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Username" id="form-email" name="username">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" id="form-password" name="password">
                </div>
                <button type="button" id="thisSubmit" class="btn btn-primary block full-width m-b">Login</button>
			</form>
        </div>
    </div>

	<div class="footer">
		<footer style="float:left;width:100%;">
			ALL RIGHTS RESERVED. Copyright © 2017
		</footer>
	</div>
</div>        

<style>
.footer > footer {
    color: #f9f9f9;
    font-size: 15px;
    text-align: center;
}
.footer {
    background-color: #2f4050;
    float: none;
    position: fixed;
    width: 100%;
    z-index: 2002;
}
</style>

<script src="<?php echo ADMIN_ASSETS_URL?>js/jquery-2.1.1.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>js/bootstrap.min.js"></script>
<link href="<?php echo ADMIN_ASSETS_URL?>css/plugins/toastr/toastr.min.css" rel="stylesheet">
<script src="<?php echo ADMIN_ASSETS_URL?>js/plugins/toastr/toastr.min.js"></script>
<link href="<?php echo ADMIN_ASSETS_URL?>css/sweet-alert.css" rel="stylesheet">
<script src="<?php echo ADMIN_ASSETS_URL?>js/sweet-alert.min.js"></script>

<?php 
	$flashMessage = '';$flashType = '';
	if($this->session->flashdata('success')) {
		$flashType = 'success';
		$flashMessage = $this->session->flashdata('success');
	} else if($this->session->flashdata('error')) {
		$flashType = 'error';
		$flashMessage = $this->session->flashdata('error');
	}
?>	

<script>
jQuery(document).ready(function() {
    var flashMessage = "<?php echo $flashMessage?>";
	var flashType = "<?php echo $flashType?>";
	if($.trim(flashType) === 'success') {
		showToast('success',flashMessage);
	} else if($.trim(flashType) === 'error') {
		showToast('error',flashMessage);
	}	
	
	$(document).on('keyup','#form-email,#form-password',function(e){
		var charCode = (e.which) ? e.which : e.keyCode;
		if(charCode == 13) {
			var btn = $('#thisSubmit');
			loginSubmit(btn);
		}
	});
	
	$(document).on('click','#thisSubmit',function(e){
		var btn = $(this);
		e.preventDefault();
		loginSubmit(btn);
	});   
});

function loginSubmit(btn)
{
	if($.trim($('input[name="username"]').val()) === '' && $.trim($('input[name="password"]').val()) === '') {
		showToast('error','Please enter both fields');
		return false;
	} else if($.trim($('input[name="username"]').val()) === '') {
		showToast('error','Please enter username');
		return false;
	} else if($.trim($('input[name="password"]').val()) === '') {
		showToast('error','Please enter password');
		return false;
	} else  {
		btn.val('Authenticating...').attr('disabled',true);
		$.ajax({
			type : 'POST',
			url : BASE_URL+'login',
			data : $('#login-form').serialize(),
			dataType: 'JSON',
			error : function(){
				btn.val('Login').attr('disabled',false);
				showToast('error','An internal error has occured.');
			},
			success : function(response){
					if(response.status) {
						btn.val('Redirecting...');
						var href = window.location.href;
						if(href.indexOf('return_url') > -1) {
							href = href.split('=');
							window.location.href = decodeURIComponent(href[1]);
						} else {
							location.replace(response.redirectTo);
						}
					} else {
						btn.val('Login').attr('disabled',false);
						showToast('error','Please check your Username/Password.');					
					}	
			}
		});
	}
}

function showToast(type,message)
{
	toastr.options = {
		closeButton: true,
		progressBar: true,
		showMethod: 'slideDown',
		timeOut: 2000
	};
	if($.trim(type) === 'success') {
		toastr.success(message);
	} else {
		toastr.error(message);
	}
}

</script>		
	
</body>
</html>
