<?php 
	session_start();
	$serverrootpath = $_SERVER['DOCUMENT_ROOT'];
	$host = $_SERVER['HTTP_HOST'];
	if($serverrootpath=='/var/www')
	{
		$conn = mysql_connect("localhost","root","hjdimensions@@**123") or die("Server is not connected");
		$db = mysql_select_db("jaketv",$conn);
		
		$uploadpic = $serverrootpath."/jaketv/jaketv_html/uploads/userprofile";
		$siteurl = $host.'/jaketv/jaketv_html';
	}
	else
	{
		$conn = mysql_connect("localhost","root","") or die("Server is not connected");
		$db = mysql_select_db("jaketv",$conn);
		
		$uploadpic = $serverrootpath."/jaketv_html/uploads/userprofile";
		$siteurl = $host.'/jaketv_html';		
	}
?>