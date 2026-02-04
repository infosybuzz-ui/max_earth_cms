$(document).ready(function () {
	
	try{
		if(hideTopBckBtn != undefined){
			$('.hideTopBckBtn').hide();
		}
	} catch(Error){}
	
	$.validator.addMethod('alphaSpace', function (value, element) {		
		var matchText = REGEX_APLHA_SPACE;
		return this.optional(element) || matchText.test(value);
	}, "Please enter only alphabets with space");
	
	$.validator.addMethod('alphaNumeric', function (value, element) {		
		var matchText = REGEX_APLHA_NUM;
		return this.optional(element) || matchText.test(value);
	}, "Please enter only alphabets with space");
	
	$.validator.addMethod('alphaNumericSpace', function (value, element) {		
		var matchText = REGEX_APLHA_NUM_SPACE;
		return this.optional(element) || matchText.test(value);
	}, "Please enter only alphabets with space");
	
	$.validator.addMethod('validAddress', function (value, element) {		
		var matchText = REGEX_VALID_ADDR;
		return this.optional(element) || matchText.test(value);
	}, "Only [. , # /] Special Chars are allowed");
	
	$.validator.addMethod('validDesc', function (value, element) {		
		var matchText = REGEX_VALID_DESC;
		return this.optional(element) || matchText.test(value);
	}, "Only [. , -] Special Chars are allowed");
    
	$.validator.addMethod("exactlength", function(value, element, param){
    	return this.optional(element) || value.length == param;
    },("Please enter exactly {0} characters"));
	
	$.validator.addMethod("validAmount", function(value, element, param){
    	var matchText = REGEX_FLOAT;
		return this.optional(element) || matchText.test(value);
    },("Please enter valid amount"));
	
	$.validator.addMethod("validDate", function(value, element, param){
    	var matchText = REGEX_DATE;
		return this.optional(element) || matchText.test(value);
    },("Please enter valid date"));
	
	$.validator.addMethod("validbsnlid", function(value, element, param){
    	var matchText = REGEX_VALID_BSNLID;
		return this.optional(element) || matchText.test(value);
    },("Please enter valid id"));
	
	$.validator.addMethod("validIP", function(value, element, param){
    	var matchText = REGEX_VALID_IP;
		return this.optional(element) || matchText.test(value);
    },("Please enter valid IP"));
	
	$.validator.addMethod("validCName", function(value, element, param){
    	var matchText = REGEX_C_NAME;
		return this.optional(element) || matchText.test(value);
	},("Please enter valid name"));
	
	$(document).on('click','.search-btn',function(){
        reloadSearch();
	});
	
	$(document).on('click','.refresh-all',function(e){
		e.preventDefault();
		var url = $(this).attr('data-url');
		window.location.href = url;
	});
	
	$(document).on('input','.only-char',function(){ 		
		var $this = $(this);
		var regexp = REGEX_APLHA_R;
		var value = $this.val();
		
		if(value != '' && regexp.test(value)){			
			$this.val(value.replace(regexp,'')); 
		}
		return false;
	});
	
	$(document).on('input','.only-char-space',function(){ 		
		var $this = $(this);
		var regexp = REGEX_APLHA_SPACE_R;
		var value = $this.val();
		
		if(value != '' && regexp.test(value)){			
			$this.val(value.replace(regexp,'')); 
		}
		return false;
	});
	
	$(document).on('input','.only-number',function(){ 		
		var $this = $(this);
		var regexp = REGEX_NUM_R;
		var value = $this.val();
		
		if(value != '' && regexp.test(value)){			
			$this.val(value.replace(regexp,'')); 
		}
		return false;
	});
	
	$(document).on('input','.only-float',function(){ 		
		var $this = $(this);
		var regexp = REGEX_FLOAT_R;
		var value = $this.val();
		
		if(value != '' && regexp.test(value)){			
			$this.val(value.replace(regexp,'')); 
		}
		return false;
	});
	
	$(document).on('input','.only-alphaNum',function(){ 		
		var $this = $(this);
		var regexp = REGEX_APLHA_NUM_R;
		var value = $this.val();
		
		if(value != '' && regexp.test(value)){			
			$this.val(value.replace(regexp,'')); 
		}
		return false;
	});
	
	$(document).on('input','.only-alphaNum-space',function(){ 		
		var $this = $(this);
		var regexp = REGEX_APLHA_NUM_SPACE_R;
		var value = $this.val();
		
		if(value != '' && regexp.test(value)){			
			$this.val(value.replace(regexp,'')); 
		}
		return false;
	});
		
	$(document).on('input','.valid-address',function(){ 		
		var $this = $(this);
		var regexp = REGEX_VALID_ADDR_R;
		var value = $this.val();
		
		if(value != '' && regexp.test(value)){			
			$this.val(value.replace(regexp,'')); 
		}
		return false;
	});
	
	$(document).on('input','.valid-desc',function(){ 		
		var $this = $(this);
		var regexp = REGEX_VALID_DESC_R;
		var value = $this.val();
		
		if(value != '' && regexp.test(value)){			
			$this.val(value.replace(regexp,'')); 
		}
		return false;
	});
	
	$(document).on('input', '.valid-bsnlid', function(){
		var $this = $(this);
		var regexp = REGEX_VALID_BSNLID_R;
		var value = $this.val();
		
		if(value != '' && regexp.test(value)){			
			$this.val(value.replace(regexp, '')); 
		}
		return false;
	});
	
	$(document).on('input', '.valid-IP', function(){
		var $this = $(this);
		var regexp = REGEX_VALID_IP_R;
		var value = $this.val();
		
		if(value != '' && regexp.test(value)){			
			$this.val(value.replace(regexp, '')); 
		}
		return false;
	});
	
	$(document).on('input', '.valid-c-name', function(){
		var $this = $(this);
		var regexp = REGEX_C_NAME_R;
		var value = $this.val();
		
		if(value != '' && regexp.test(value)){			
			$this.val(value.replace(regexp, '')); 
		}
		return false;
	});
	
	$(document).on('click','.paginate_button a',function(e){
		e.preventDefault();
		var url = $(this).attr('href');
		
		history.pushState({isMine:true},pageTitle,url);
		
		showCustomLoader(true);
		$.ajax({
			type : 'POST',
			url : url,				
			dataType : 'json',
			error : function(){
				showCustomLoader(false);
			},
			success : function(response){
						 showCustomLoader(false);
						 $('.table-responsive').html(response.result);
					  }
		});
	});
	
	
	$(document).on('click','.print_page',function(e){
		//e.preventDefault();
		
		var thisRel = $(this).attr('rel');
		
		var current_url = window.location.href;
		var reg = /[\=\&]/;
		if(reg.test(current_url)){
			current_url = current_url + '&print=YES';
		} else {
			current_url = current_url + '?print=YES';
		}
		
		$(this).attr('href', current_url);
		//console.log(current_url);
	});
	
	$(document).on('click','.export_page',function(e){
		//e.preventDefault();
		
		var thisRel = $(this).attr('rel');
		
		var current_url = window.location.href;
		var reg = /[\=\&]/;
		if(reg.test(current_url)){
			current_url = current_url + '&export=YES';
		} else {
			current_url = current_url + '?export=YES';
		}
		
		$(this).attr('href', current_url);
		//console.log(current_url);
	});
	
	$(document).on('click','.inc_comm_detls_load_ajx',function(e){
		e.preventDefault();
		
		var href = $(this).attr('href');
		if(href != ''){
			$('#myIncCommDtlsModal').modal('toggle');
			var ldrHtml = '<div class="row" id="prod_loader_div" style="text-align:center;margin:28px 0px;">'+
								'<div class="col-lg-12">'+
									'<img alt="loading" src="'+ASSETS_URL+'img/ajax_loader11.gif"/>'+
								'</div>'+
							'</div>';
							
			$('#myIncCommDtlsModal').find('.modal-body').html(ldrHtml);
			//return false;
			$.ajax({
				type : 'POST',
				url : href,				
				dataType : 'json',
				error : function(){
					customAlertBox('Unable to proocess your request right now.<br/> Please try again or some time later', 'e');
					$('#myIncCommDtlsModal').find('.modal-body').html('');
				},
				success : function(response){
					 $('#myIncCommDtlsModal').find('.modal-title').html(response.pageTitleNew);
					 $('#myIncCommDtlsModal').find('.modal-body').html(response.result);
				}
			});
			return false;
		}
	});
	
	$("#manage_excl_upload_form").validate({
		onkeyup: false,
		rules: {
			csv_file: {
			    required: true,
			    //accept: "csv"
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
			
		},
		errorPlacement: function (error, element) {
			error.appendTo($(element).closest('div'));
		}
	});
	
	$(document).on('click','#download_sample',function(){
		var url = $(this).data('url');
		$(this).attr('href', url);
	});
	
	$(document).on('change','.upld_file_excl',function(){	

		var imagePath = $(this).val();
		var pathLength = imagePath.length;
		var lastDot = imagePath.lastIndexOf(".");
		var fileType = imagePath.substring(lastDot,pathLength);	
		var fileType = fileType.toLowerCase();
		var allowedTypes = ['.xls', '.xlsx'];							

		if($.inArray(fileType,allowedTypes) == '-1') {			
			$(this).val('');
			swal('The uploaded file type is not allowed.\nAllowed types : xlsx');
			return false;
		}
		var fileSize = this.files[0].size;
		var sizeKB = fileSize/1024;
        if(parseInt(sizeKB) > 1024) {
            var sizeMB = sizeKB/1024;
			var sizeStr = sizeMB.toFixed(2);
            if(sizeStr > 10) {
				$(this).val('');
				swal("Sorry! We can't accept files with size greater than 10MB.\nPlease upload file with size less than 10MB.");
				return false;
			}
        }
	});
	
	$(document).on('click','.manage_ticket-btn',function(){	
		if($('#manage_ticket-form').valid()){
			showCustomLoader(true);
			$.ajax({
				type : 'POST',
				url : BASE_URL+'tickets/add',				
				data : $('#manage_ticket-form').serialize(),				
				dataType : 'json',
				error : function(){
					showCustomLoader(false);
					customAlertBox('Unable to proocess your request right now.<br/> Please try again or some time later', 'e');
				},
				success : function(response){
					showCustomLoader(false);
					if(response.status){
						$('#MngTcktModl').modal('toggle');
						customAlertBox(response.message, '', 10000);
					} else {
						customAlertBox(response.message, 'e');
					}
				}
			});
		}
	});
	
	$(document).on('click', '.ticketForm', function(){
		var userId = $(this).attr('data-userId');
		var ticketId = $(this).attr('data-ticketId');
		
		$('#MngTcktModl').remove();
		showCustomLoader(true);
		$.ajax({
			url: BASE_URL+'ticket/get_TicketForm',
			type: 'POST',
			data: {userId: userId, ticketId: ticketId},
			dataType: 'JSON',
			error: function(){
				showCustomLoader(false);
				customAlertBox('Unable to proocess your request right now.<br/> Please try again or some time later', 'e');				
			},
			success: function(response){
				showCustomLoader(false);
				if(response.status){				
					$('body').append(response.result);
					activateTicketFormValidation();
					$('#MngTcktModl').modal('toggle');
				} else {
					customAlertBox(response.message, 'e');	
				}
			}
		});
	});
	
	$(document).on('click','.back-to-lnk',function(){
		history.go(-1);
	});
	
	$(document).on('change','.upld_files_lead',function(){	
		var files = $(this)[0].files;
		
		if(files.length > 0){
			$.each(files, function(i, file){
				
				var imagePath = file.name;
				var pathLength = imagePath.length;
				var lastDot = imagePath.lastIndexOf(".");
				var fileType = imagePath.substring(lastDot,pathLength);	
				var fileType = fileType.toLowerCase();
				var allowedTypes = ['.png','.jpg','.jpeg','.pdf'];							

				if($.inArray(fileType,allowedTypes) == '-1') {			
					$(this).val('');
					swal('The uploaded file(s) type is not allowed.\nAllowed types : png,jpg,jpeg,pdf');
					return false;
				}
				
				var fileSize = file.size;
				var sizeKB = fileSize/1024;
				if(parseInt(sizeKB) > 1024) {
					var sizeMB = sizeKB/1024;
					var sizeStr = sizeMB.toFixed(2);
					if(sizeStr > 2)
					{
						$(this).val('');
						swal("Sorry! We can't accept files with size greater than 2MB.\nPlease upload file with size less than 2MB.");
						return false;
					}
				}
			});
		}
	});
	
	$(document).on('blur','input[name="rate"]',function(){
		var rate = $(this).val();
		var rate_type = $('#rate_type').val();
		if(rate_type == 2 && rate > 100){
			$(this).val('100');
		}
	});
	
	$(document).on('change','#rate_type',function(){
		$('input[name="rate"]').trigger('blur');
	});
	
	$(document).on('change','#circle_id_n',function(){
		var circle_id = $(this).val();
		$('#ssa_id_n').html('<option value="">Select</option>');
		if($.trim(circle_id) != ''){
			
			$('#ssa_id_n').addClass('background-loader');
			$.ajax({
				url: BASE_URL+'user/getCirclesSSA',
				type: 'POST',
				data: {circle_id: circle_id},
				dataType: 'JSON',
				error: function(){
					$('#ssa_id_n').removeClass('background-loader');
					customAlertBox('Unable to proocess your request right now.<br/> Please try again or some time later[GCSSAJS]', 'e');
				},
				success: function(response){
					$('#ssa_id_n').removeClass('background-loader');		
					if(response.status){
						$('#ssa_id_n').html(response.html);
					} else{
						customAlertBox(response.message, 'e');
					}
				}
			});
		}
	});
	
	$(document).on('change','#ssa_id_n',function(){
		var ssa_id = $(this).val();
		$('#sdca_id_n').html('<option value="">Select</option>');
		if($.trim(ssa_id) != ''){
			
			$('#sdca_id_n').addClass('background-loader');
			$.ajax({
				url: BASE_URL+'user/getSSA_SDCA',
				type: 'POST',
				data: {ssa_id: ssa_id},
				dataType: 'JSON',
				error: function(){
					$('#sdca_id_n').removeClass('background-loader');
					customAlertBox('Unable to proocess your request right now.<br/> Please try again or some time later[GSSDCAJS]', 'e');
				},
				success: function(response){
					$('#sdca_id_n').removeClass('background-loader');	
					if(response.status){
						$('#sdca_id_n').html(response.html);
					} else{
						customAlertBox(response.message, 'e');
					}
				}
			});
		}
	});
});

function reloadSearch() 
{	
	var pageUrlTemp = pageUrl.split('?');
	if(pageUrlTemp[1] != undefined){
		var url = pageUrl+'&'+$('#search-form').serialize();
	} else {
		var url = pageUrl+'?'+$('#search-form').serialize();
	}
	
	
	history.pushState({isMine:true},pageTitle,url);
	
	showCustomLoader(true);
	$.ajax({
		type : 'POST',
		url : url,				
		dataType : 'json',
		error : function(){
			showCustomLoader(false);
		},
		success : function(response){
					showCustomLoader(false);
					try {
						if(response.subPageTitle != undefined){
							$('.subPageTitle').html(response.subPageTitle);
						} 
						$('.table-responsive').html(response.result);
					} catch(Error){ 
						$('.table-responsive').html(response.result);
					}
				  }
	});
} 

function activateTicketFormValidation(){
	$('#manage_ticket-form').validate({
		onkeyup: false,
		rules: {
			user: {
				required: true,
			},
			title: {
				required: true,
				alphaSpace: true,
			},
			description: {
				required: true,
				validDesc: true,
			},
			mobile_no: {
				required: true,
				number: true,
				exactlength: 10
			},
			priority: {
				required: true,
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
				
				/* $('html, body').animate({
					scrollTop: $(first_error).offset().top - 150
				}, 500); */
			}
		},
		errorPlacement: function (error, element) {
			error.appendTo($(element).closest('div'));
		}
	});
}