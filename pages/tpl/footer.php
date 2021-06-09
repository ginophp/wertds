	
		<div id="MyModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Modal Header</h4>
					</div>
					<div class="modal-body">
						<p>Some text in the modal.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
				
			</div>
		</div>
	
	</div>
	
	<script>
		function ChangePassword(){
			
			$.ajax({
				type	:	"post",
				url		:	"pages/tpl/changepassword.php",
				data	:	{action : "ChangePasswordForm"},
				success	:	function(data){
				
					var ButtonList = '<button type="button" class="btn btn-info" onclick="SavePassword();">Save</button>'+
									'<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
					
					$("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-md");
					$("#MyModal .modal-title").html("Change Password");
					$("#MyModal .modal-body").html(data);
					$("#MyModal .modal-footer").html(ButtonList);
					$("#MyModal").modal('show');
				
				}
			});
			
		}
		
		function SavePassword(){
			
			$("#MyModal .modal-body").find(".alert").hide();
			
			if($("[name=ChangePasswordForm]").find("[name=OldPassword]").val().trim() == ""){
				$("[name=OldPassword]").focus();
				$("#MyModal .modal-body").find(".alert").addClass("alert-danger");
				$("#MyModal .modal-body").find(".alert").html("Please insert Old Password");
				$("#MyModal .modal-body").find(".alert").show();
				return false;
			}
			
			if($("[name=ChangePasswordForm]").find("[name=NewPassword]").val().trim() == ""){
				$("[name=NewPassword]").focus();
				$("#MyModal .modal-body").find(".alert").addClass("alert-danger");
				$("#MyModal .modal-body").find(".alert").html("Please insert New Password");
				$("#MyModal .modal-body").find(".alert").show();
				return false;
			}
			
			if($("[name=ChangePasswordForm]").find("[name=ConfirmPassword]").val().trim() == ""){
				$("[name=ConfirmPassword]").focus();
				$("#MyModal .modal-body").find(".alert").addClass("alert-danger");
				$("#MyModal .modal-body").find(".alert").html("Please insert Confirm Password");
				$("#MyModal .modal-body").find(".alert").show();
				return false;
			}
			
			if($("[name=ChangePasswordForm]").find("[name=ConfirmPassword]").val().trim() != $("[name=ChangePasswordForm]").find("[name=NewPassword]").val().trim()){
				$("[name=ConfirmPassword]").focus();
				$("#MyModal .modal-body").find(".alert").addClass("alert-danger");
				$("#MyModal .modal-body").find(".alert").html("New Password and Confirm Password doesn't match.");
				$("#MyModal .modal-body").find(".alert").show();
				return false;
			}
			
			$.ajax({
				type	:	"post",
				dataType:	"json",
				url		:	"pages/tpl/changepassword.php",
				data	:	$("[name=ChangePasswordForm]").serialize() + "&action=SavePassword",
				success	:	function(data){
					if(data.Success == 1){
						$("[name=OldPassword]").val("");
						$("[name=NewPassword]").val("");
						$("[name=ConfirmPassword]").val("");
						$("#MyModal .modal-body").find(".alert").removeClass("alert-danger").addClass("alert-success");
					}else{
						$("#MyModal .modal-body").find(".alert").removeClass("alert-success").addClass("alert-danger");
					}
					
					$("#MyModal .modal-body").find(".alert").show();
					$("#MyModal .modal-body").find(".alert").html(data.ErrorMessage);
				}
			});
		}
		
		function ViewCollectors(page){
			
			$.ajax({
				
				type	:	"post",
				url		:	"pages/supervisor/ajax/collector.php",
				data	:	{action : "ViewCollectors", page : page},
				success	:	function(data){
					var ButtonList = '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
									
					$("#MyModal .modal-dialog").removeClass("modal-sm").removeClass("modal-md").addClass("modal-lg");
					$("#MyModal .modal-title").html("View Collectors");
					$("#MyModal .modal-footer").html(ButtonList);
					$("#MyModal .modal-body").html(data);
					$("#MyModal").modal('show');
				
				}
				
			});
			
		}
        
		function ViewDriver(page){
			
			$.ajax({
				
				type	:	"post",
                dataType:	"json",
				url		:	"pages/operation/ajax/drivermodule.php",
				data	:	{action : "GetDriverList",Menu:'', page : page},
				success	:	function(data){
					var ButtonList = '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
									
					$("#MyModal .modal-dialog").removeClass("modal-sm").removeClass("modal-md").addClass("modal-lg");
					$("#MyModal .modal-title").html("View Driver");
					$("#MyModal .modal-footer").html(ButtonList);
                   
					$("#MyModal .modal-body").html(data.Details+data.Pagination);
                    
					$("#MyModal").modal('show');
				
				}
				
			});
			
		}
		
		function ViewProfile(){
			$.ajax({
				
				type	:	"post",
				url		:	"pages/tpl/profile.php",
				data	:	{action : "ViewProfile"},
				success	:	function(data){
					var ButtonList = '<button type="button" class="btn btn-info" onclick="return SaveProfile();">Save</button>'+
									'<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
					$("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-md");
					$("#MyModal .modal-title").html("View Profile");
					$("#MyModal .modal-body").html(data);
					$("#MyModal .modal-footer").html(ButtonList);
					$("#MyModal").modal('show');
				
				}
				
			});
		}
		
		function SaveProfile(){
			$.ajax({
				type	:	"post",
				dataType:	"json",
				url		:	"pages/tpl/profile.php",
				data	:	$("form[name=ProfileForm]").serialize() + "&action=SaveProfile",
				success	:	function(data){
					if(data.Success == 1){
						$("#MyModal .modal-body").find(".alert").addClass("alert-success").removeClass("alert-danger");
						$("#MyModal .modal-body").find(".alert").html(data.ErrorMessage);
						$("#MyModal .modal-body").find(".alert").show();
					}else{
						$("#MyModal .modal-body").find(".alert").addClass("alert-danger").removeClass("alert-success");
						$("#MyModal .modal-body").find(".alert").html(data.ErrorMessage);
						$("#MyModal .modal-body").find(".alert").show();
					}
				}
			});
		}
	</script>
	
</body>
</html>
