<?php
ob_start();
include("config.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>
<?php
if(isset($_POST['frgtpaswrd']))
{
$email = $_POST['email'];
$json_array = array("method"=>"ForgotPassword",
					"email"=>$email
					);
					header('Location:service.php?data='.json_encode($json_array));
}
?>
<body>
<form action="" method="post">
<table border="0">
<tr><td><input type="text" name="email" placeholder="EMAIL" style="height:30px;width:300px"></td></tr><br><br>
<tr><td><input type="submit" name="frgtpaswrd" value="FORGOT PASSWORD" style="height:30px;width:300px"></td></tr>
</table>
</form>
</body>
</html>