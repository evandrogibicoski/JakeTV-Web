<script type="text/javascript">

function load_script_data(x,y){

	var div_id = "#new_div";
	if(x == undefined){
		var dd = document.getElementById('load_value_hidden').value++;
		var dc = dd;
	}else{
		var dd = document.getElementById('load_value_hidden').value++;
		var dc = dd;
	}
	
	var PageLimit = 24;
	var Offset = dc*PageLimit;
	var pagedata = (dc+1)*PageLimit;
	
	if(y>pagedata){
		$.ajax({
		url : 'service.php', 
		type : 'post',
		data: 'load_value_data='+dc,				
		success : function(data) 
		{
			if(data == 2){
				$('#load_more').hide();
			}else{
				$(div_id).append(data);
			}
		}	
		});
	}else{
		$.ajax({
		url : 'service.php', 
		type : 'post',
		data: 'load_value_data='+dc,				
		success : function(data) 
		{
			if(data == 2){
				$('#load_more').hide();
			}else{
				$(div_id).append(data);
				$('#load_more').hide();
			}
		}	
		});
	}
	
	
}

function load_like_page1(x,y){
	var div_id1 = "#likes_new_div";
	if(x == undefined){
		var dd = document.getElementById('load_value_hidden').value++;
		var dc = dd;
	}else{
		var dd = document.getElementById('load_value_hidden').value++;
		var dc = dd;
	}
	
	var PageLimit = 24;
	var Offset = dc*PageLimit;
	var pagedata = (dc+1)*PageLimit;
	
	if(y>pagedata){
		$.ajax({
		url : 'service.php', 
		type : 'post',
		data: 'likes_load_value_data='+dc,				
		success : function(data) 
		{
			if(data == 2){
				$('#load_more').hide();
			}else{
				$(div_id1).append(data);
			}
		}	
		});
	}else{
		$.ajax({
		url : 'service.php', 
		type : 'post',
		data: 'likes_load_value_data='+dc,				
		success : function(data) 
		{
			if(data == 2){
				$('#load_more').hide();
			}else{
				$(div_id1).append(data);
				$('#load_more').hide();
			}
		}	
		});
	}
	
	
}

function load_bookmark_page1(x,y){
	var div_id1 = "#bookmark_new_div";
	if(x == undefined){
		var dd = document.getElementById('load_value_hidden').value++;
		var dc = dd;
	}else{
		var dd = document.getElementById('load_value_hidden').value++;
		var dc = dd;
	}
	
	var PageLimit = 24;
	var Offset = dc*PageLimit;
	var pagedata = (dc+1)*PageLimit;
	
	if(y>pagedata){
		$.ajax({
		url : 'service.php', 
		type : 'post',
		data: 'bookmark_load_value_data='+dc,				
		success : function(data) 
		{
			if(data == 2){
				$('#load_more').hide();
			}else{
				$(div_id1).append(data);
			}
		}	
		});
	}else{
		$.ajax({
		url : 'service.php', 
		type : 'post',
		data: 'bookmark_load_value_data='+dc,				
		success : function(data) 
		{
			if(data == 2){
				$('#load_more').hide();
			}else{
				$(div_id1).append(data);
				$('#load_more').hide();
			}
		}	
		});
	}

	
}


/*function load_script(){
	var count = 1;
	var dd = document.getElementById('load_value_hidden').value++;
	var dc = dd+1;
	//document.getElementById('load_value_hidden').innerHTML = dd.value;
	$.ajax({
		url : 'index.php', 
		type : 'post',
		data: 'load_value='+dc,				
		success : function(data) 
		{
			window.location.reload();
		}	
	});
}*/


function load_like_page(){
	var count = 1;
	var dd = document.getElementById('load_value_hidden').value++;
	var dc = dd+1;
	$.ajax({
		url : 'likes.php', 
		type : 'post',
		data: 'load_value='+dc,				
		success : function(data) 
		{
			window.location.reload();
		}	
	});
}
function load_bookmark_page(){
	var count = 1;
	var dd = document.getElementById('load_value_hidden').value++;
	var dc = dd+1;
	$.ajax({
		url : 'bookmark.php', 
		type : 'post',
		data: 'load_value='+dc,				
		success : function(data) 
		{
			window.location.reload();
		}	
	});
}
function see_more(x){
	id = "#desc" + x;
	id1 = "#desc1" + x;
	$(id).hide();
	$('#seemore'+x).hide();
	$(id1).show();
	$('#back'+x).show();
}
function back(x){
	$(id1).hide();
	$('#back'+x).hide();
	$(id).show();
	$('#seemore'+x).show();
}

function register_join(){
	var f_name = document.getElementById('reg_f_name').value;
	var l_name = document.getElementById('reg_l_name').value;
	var email = document.getElementById('reg_email').value;
	var password = document.getElementById('reg_password').value;
	var c_password = document.getElementById('reg_c_password').value;
	
	if(f_name == ""){
		document.getElementById('reg_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Enter First Name.</div>";
	}
	else if(l_name == ""){
		document.getElementById('reg_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Enter Last Name.</div>";
	}
	else if(email == ""){
		document.getElementById('reg_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Enter Email.</div>";
	}
	else if(password == ""){
		document.getElementById('reg_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Enter Password.</div>";
	}
	else if(c_password != password){
		document.getElementById('reg_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Enter Valid Password.</div>";
	}
	else{
		$.ajax({
			url : 'service.php',
			type : 'post',
			data: 'register=1&f_name='+f_name+'&l_name='+l_name+'&email='+email+'&password='+password+'&c_password='+c_password,				
			success : function(data) 
			{
				if(data == '1'){
					document.getElementById('reg_validation').innerHTML = "<div class='alert alert-success' role='alert' style='font-size:16px;letter-spacing:1px;'>You Are Successfully Registered.</div>";
				}else if(data == '0'){
					document.getElementById('reg_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Try Again..</div>";
				}else{
					document.getElementById('reg_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Emai id Already Registered.</div>";
				}
			}
		});
	}
}
function login_user(){
		var email = document.getElementById('login_email').value;
		var password = document.getElementById('login_pass').value;
		
		if(email == ""){
			document.getElementById('login_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Enter Email.</div>";
		}else if(password == ""){
			document.getElementById('login_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Enter Password.</div>";
		}else{
			$.ajax({
			url : 'service.php',
			type : 'post',
			data: 'login=1&email='+email+'&password='+password,				
			success : function(data) 
			{
				if(data == '1'){
					window.location.href="index.php";
				}else if(data == '2'){
					document.getElementById('login_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Try Agin.</div>";
				}else{
					document.getElementById('login_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Enter Valid Email or Password.</div>";
				}
			}
		});
		}
}
function like_post(x){
	var postid = x;
	$.ajax({
		url : 'service.php',
			type : 'post',
			data: 'like_post=1&postid='+postid,				
			success : function(data) 
			{
				if(data == '1'){
					var p1 = ".like_post1" + x;
					var p = ".like_post" + x;
					$(p1).hide();
					$(p).show();
				}else if(data == '2'){
					alert('you have problem in login');
				}else{
					alert('please like again');
				}
			}
	});
	
}
function unlike_post(x){
	var postid = x;
	$.ajax({
		url : 'service.php',
			type : 'post',
			data: 'unlike_post=1&postid='+postid,				
			success : function(data) 
			{
				if(data == '1'){
					var p1 = ".like_post1" + x;
					var p = ".like_post" + x;
					$(p).hide();
					$(p1).show();
				}else if(data == '2'){
					alert('you have problem in login');
				}else{
					alert('please like again');
				}
			}
	});
	
}
function bookmark_post(x){
	var postid = x;
	$.ajax({
		url : 'service.php',
			type : 'post',
			data: 'bookmark_post=1&postid='+postid,				
			success : function(data) 
			{
				if(data == '1'){
					var b1 = ".bookmark_post1" + x;
					var b = ".bookmark_post" + x;
					$(b1).hide();
					$(b).show();
				}else if(data == '2'){
					alert('you have problem in login');
				}else{
					alert('please bookmark again');
				}
			}
	});
	
}
function unbookmark_post(x){
	var postid = x;
	$.ajax({
		url : 'service.php',
			type : 'post',
			data: 'unbookmark_post=1&postid='+postid,				
			success : function(data) 
			{
				if(data == '1'){
					var b1 = ".bookmark_post1" + x;
					var b = ".bookmark_post" + x;
					$(b).hide();
					$(b1).show();
				}else if(data == '2'){
					alert('you have problem in login');
				}else{
					alert('please bookmark again');
				}
			}
	});
	
}
/* ----------Likes----------- */
function unlike_post_likes(x){
	var postid = x;
	$.ajax({
		url : 'service.php',
			type : 'post',
			data: 'unlike_post=1&postid='+postid,				
			success : function(data) 
			{
				if(data == '1'){
					window.location.reload();
				}else if(data == '2'){
					alert('you have problem in login');
				}else{
					alert('please like again');
				}
			}
	});
	
}
/* ---------bookmark--------- */
function unbookmark_post_bookmark(x){
	var postid = x;
	$.ajax({
		url : 'service.php',
			type : 'post',
			data: 'unbookmark_post=1&postid='+postid,				
			success : function(data) 
			{
				if(data == '1'){
					window.location.reload();
				}else if(data == '2'){
					alert('you have problem in login');
				}else{
					alert('please bookmark again');
				}
			}
	});
	
}
</script>