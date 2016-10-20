<html>
<head>
	<title>Ajax Upload</title>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/ajaxupload.js"></script>
	<style>
	.upload{background:#CCCCCC; border: 2px solid #F0B21E; color: #1F93EC; font-size: 28px; padding: 10px 15px; width: 167px;}
	</style>
</head>
<body>
<div class="main">
	
	<div id="imageupload" class="upload">Upload Image</div>
	<div class="status"></div>
	
	<div class="result" >
		Result: <br/><br/>
		<span id="images"></span>
	</div>

	<script type="text/javascript">
		// file upload
		$(function(){
			var file_type = '';
			var btnUpload=$('#imageupload');
			var status=$('.status');
			new AjaxUpload(btnUpload, {
				action: "upload.php",
				//Name of the file input box
				name: 'uploadfile',
				onSubmit: function(file, ext){
					file_type = ext;
					status.html('uploading....');
				},
				onComplete: function(file, response){
					
					//On completion clear the status
					status.html('');
					//Add uploaded file to list
					if(response==="upload_error"){
						alert("Error in upload");
					} else{
						
						var imgHtml = '<br/><br/><div><img src="uploads/'+response+'" /></div>';
						
						$("#images").append(imgHtml);
					}
				}
			});
			
		});
	</script>
</div>
</body>
</html>