<?php 
	ob_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>
<?php 
	if(isset($_POST['submit']))
	{
		$email = $_POST['email']	;
		$password = $_POST['password'];
		$json_array = array("method"=>"login",
							"email"=>$email,
							"password"=>$password
		);
		header("location:service.php?data=".json_encode($json_array));
	}
?>
<body>
	<form method="post" action="" name="loginfrm">
    	<input type="text" name="email" id="email" value="" placeholder="Email" style="width:300px;height:30px;">
        <input type="password" name="password" value="" placeholder="Password" style="width:300px;height:30px;">
        <input type="submit" name="submit" style="width:300px;height:40px;">
    </form> 
</body>
</html>