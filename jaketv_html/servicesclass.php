<?php 
	session_start();
	$serverrootpath = $_SERVER['DOCUMENT_ROOT'];
	echo $siteuri = $_SERVER['HTTP_HOST'];
	if($serverrootpath=='/var/www')
	{
		$conn = mysql_connect("localhost","root","hjdimensions@@**123") or die("Server is not connected");
		$db = mysql_select_db("jaketv",$conn);
		
		$uploadpic = $serverrootpath."/uploads/userprofile";
	}
?>