<html>
<head>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

<!------ Include the above in your HEAD tag ---------->
</head>
<style>
body {
  margin: 0;
  padding: 0;
  background-color: #17a2b8;
  height: 100vh;
}
#login .container #login-row #login-column #login-box {
  margin-top: 120px;
  max-width: 600px;
  height: 42	0px;
  border: 1px solid #9C9C9C;
  background-color: #EAEAEA;
}
#login .container #login-row #login-column #login-box #login-form {
  padding: 20px;
}
#login .container #login-row #login-column #login-box #login-form #register-link {
  margin-top: -85px;
}
.error{color:red;}
.dnone{display:none;}
</style>
<body>
    <div id="login">
        <h3 class="text-center text-white pt-5">Send Template Form</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="" method="post">
                            <h3 class="text-center text-info">Login</h3>
                            <div class="form-group">
                                <label for="first_name" class="text-info">First Name:</label><br>
                                <input type="text" name="first_name" id="first_name" class="form-control">
								<span class="error dnone">Enter First Name</span>
                            </div>
                            <div class="form-group">
                                <label for="last_name" class="text-info">Last Name:</label><br>
                                <input type="text" name="last_name" id="last_name" class="form-control">
								<span class="error dnone">Enter Last Name</span>
                            </div>
							<div class="form-group">
                                <label for="Email_template" class="text-info">Email Template:</label><br>
                                <select type="text" name="template" id="template" class="form-control">
								<option value="">Please select template</option>
								</select>
								<span class="error dnone">Please select Template</span>
                            </div>
                            <div class="form-group">
                                <span id="submit1" class="btn btn-info btn-md">Sent Template</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<script>
	$(document).ready(function() {
		get_all_template();
		function get_all_template() {
			$.ajax({
				type: 'POST',
				url: "http://latestnewproject.loc/demo.php",
				data: {
					api: 2
				},
				dataType: "json",
				success: function(jsonData) {
					console.log(jsonData);
					var template = jsonData.data.items;
					$.each(template, function(key, value) {
						$("#template").append(new Option(value.name, value.name));
					});
				}
			});
		}
		$('body').on('click','#submit1', function() {
			$("#first_name, #last_name, #template").next().css('display','none');
			
			var first_name = $("#first_name").val();
			var last_name = $("#last_name").val();
			var template = $("#template").val();
			
			if(first_name == ''){
				$("#first_name").next().css('display','block');
				return false;
			}
			if(last_name == ''){
				$("#last_name").next().css('display','block');
				return false;
			}
			if(template == ''){
				$("#template").next().css('display','block');
				return false;
			}
			
			$.ajax({
				method: 'POST',
				url: "http://latestnewproject.loc/demo.php",
				data: {
					api: 1,
					first_name: first_name,
					last_name: last_name,
					template: template
				},
				dataType: "json",
				success: function(jsonData) {
					if(jsonData.status == 'success') {
						alert('Template sent successfully whose id is = '+jsonData.id);
						$("#first_name, #last_name, #template").val('');
					} else{
						alert('Failed to send Template!!!!');
					}
				}
			});
		});
	});
	</script>
</body>
</html>
