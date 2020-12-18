<script type="text/javascript">

function register_join(){
	var f_name = document.getElementById('reg_f_name').value;
	var l_name = document.getElementById('reg_l_name').value;
	var email = document.getElementById('reg_email').value;
	var password = document.getElementById('reg_password').value;
	var c_password = document.getElementById('reg_c_password').value;
	
	if(f_name == ""){
		document.getElementById('reg_validation').innerHTML = "<center>Select first name</center>";
	}
	else if(l_name == ""){
		document.getElementById('reg_validation').innerHTML = "<center>Select last name</center>";
	}
	else if(email == ""){
		document.getElementById('reg_validation').innerHTML = "<center>Select email id</center>";
	}
	else if(password == ""){
		document.getElementById('reg_validation').innerHTML = "<center>Select password</center>";
	}
	else if(c_password != password){
		document.getElementById('reg_validation').innerHTML = "<center>Mismatch Password</center>";
	}
	else{
		$.ajax({
			url : 'service.php',
			type : 'post',
			data: 'register=1&f_name='+f_name+'&l_name='+l_name+'&email='+email+'&password='+password+'&c_password='+c_password,				
			success : function(data) 
			{
				if(data == '1'){
					document.getElementById('reg_validation').innerHTML = "<center>You are successfuly registered. Go to login page.</center>";
				}else if(data == '0'){
					document.getElementById('reg_validation').innerHTML = "<center>You are not registered. Try again</center>";
				}else{
					document.getElementById('reg_validation').innerHTML = "<center>Your email id already registered. select another one.</center>";
				}
			}
		});
	}
}


function login_user(){
		var email = document.getElementById('login_email').value;
		var password = document.getElementById('login_pass').value;
		
		if(email == ""){
			document.getElementById('login_validation').innerHTML = "<center>Select email id</center>";
		}else if(password == ""){
			document.getElementById('login_validation').innerHTML = "<center>Select password</center>";
		}else{
			$.ajax({
			url : 'service.php',
			type : 'post',
			data: 'login=1&email='+email+'&password='+password,				
			success : function(data) 
			{alert(data);
				/*if(data == '1'){
					document.getElementById('reg_validation').innerHTML = "<center>You are successfuly registered. Go to login page.</center>";
				}else if(data == '0'){
					document.getElementById('reg_validation').innerHTML = "<center>You are not registered. Try again</center>";
				}else{
					document.getElementById('reg_validation').innerHTML = "<center>Your email id already registered. select another one.</center>";
				}*/
			}
		});
		}
}
</script>