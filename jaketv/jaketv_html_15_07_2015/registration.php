<?php 
	ob_start();
	include("config.php");
	if(isset($_POST['submit']))
	{
		$userid='0';
		$fname = $_POST['txtFname'];
		$lname = $_POST['txtLname'];
		$email = $_POST['txtEmail'];
		$password = $_POST['txtPassword'];
		$googleplusid = $_POST['txtGoogle'];
		echo $picture = $_FILES['picture']['name'];
		echo $uploadpic;
		if($_FILES["picture"]["name"]!="")
		{
			$picturename = $_FILES["picture"]["name"];
			$picture_image = date("dmyHis").$picturename;
			move_uploaded_file($_FILES["picture"]["tmp_name"],$uploadpic.'/'.$picture_image);
			$url = $siteurl.'/uploads/userprofile/'.$picture_image;
		}
		$json_array = array("method" => "Registration",
						"fname"=>$fname,
						"lname"	=> $lname,
						"password"=>$password,
						"googleplusid"=>$googleplusid,
						"picture"=>$url,
						"email"=>$email,
						"userid"=>'0'
						);
						header('Location:service.php?data='.json_encode($json_array));
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<form action="" method="post" enctype="multipart/form-data">
<table border="0">
<tr>
<td><input type="text" placeholder="First Name" name="txtFname" style="width:300px;height:30px"></td>
</tr>
<tr><td><input type="text" placeholder="Last Name" name="txtLname" style="width:300px;height:30px"></td></tr>
<tr><td><input type="text" placeholder="Email" name="txtEmail" style="width:300px;height:30px"></td></tr>
<tr><td><input type="text" placeholder="googleplusid" name="txtGoogle" style="width:300px;height:30px"></td></tr>
<tr><td><input type="text" placeholder="Password" name="txtPassword" style="width:300px;height:30px"></td></tr>
<tr><td><input type="file" placeholder="picture" name="picture"> </td></tr>
<tr><td><input type="submit" name="submit" value="submit" style="align:center"></td></tr>
</table>
</form>
</body>
