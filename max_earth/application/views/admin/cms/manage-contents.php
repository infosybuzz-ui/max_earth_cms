<style>
.form-group .control-label{
	text-align: left;
}
</style>
<div class="wrapper wrapper-content animated fadeInRight custom-wdth">
    <div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Manage Contents</h5>
				</div>
				<div class="ibox-content">
					<?php 
						$attributes = array('class' => 'form-horizontal', 'id' => 'manage-cms-form', 'method' => "post");
						echo form_open(ADMIN_BASE_URL.'cms/contents/save', $attributes);
					?>
						<div class="form-group">
							<label class="col-lg-12 control-label">
								Type
							</label>
							<div class="col-lg-12">
								<input type="text" placeholder="SSA Name" class="form-control only-alphaNum-space" name="content_type" value="<?php echo @$record['content_type']?>" disabled> 
								<input type="hidden" name="referer" value="<?php echo $this->session->userdata('referer')?>" />
								<input type="hidden" name="content_id" value="<?php echo !empty($record['id']) ? EnCrypt($record['id']) : ''?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-12 control-label">
								Title
							</label>
							<div class="col-lg-12">
								<input type="text" placeholder="Content Title" class="form-control" name="title" value="<?php echo @$record['content_title']?>"> 
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-12 control-label">
								Description
							</label>
							<div class="col-lg-12">
								<textarea id="tiny" name="description"><?php echo @$record['content_description']?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label">
								
							</label>
							<div class="col-lg-8">
								<button class="btn btn-sm btn-primary" type="button" id="manage-form">Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
        </div>
    </div>
</div>


<script src="https://cdn.tiny.cloud/1/3vqquzsddv3sd5l0k4c18ircjv33hlwqhfyz69r9hw9hkmuv/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<script>
jQuery(document).ready(function() {
	tinymce.init({
		selector: 'textarea#tiny',
		plugins: [
		  // Core editing features
		  'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
		  // Your account includes a free trial of TinyMCE premium features
		  // Try the most popular premium features until Jun 17, 2025:
		  'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
		],
		toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
		tinycomments_mode: 'embedded',
		tinycomments_author: 'Author name',
		mergetags_list: [
		  { value: 'First.Name', title: 'First Name' },
		  { value: 'Email', title: 'Email' },
		],
		ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
	  });
	  
	$(document).on('click','#manage-form',function(){
		if($("#manage-cms-form").valid()){		
			showCustomLoader(true);
			$("#manage-cms-form")[0].submit()
		}
	});	
	
	$("#manage-cms-form").validate({
		onkeyup: false,
		rules: {
			title: {
				required: true,
				alphaNumericSpace:true,
			},
			description: {
				required: true,
			}			
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

</script>