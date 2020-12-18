<?php
ob_start();
session_start();

$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
if($_SERVER['DOCUMENT_ROOT']=="/var/www/html")
{
	mysql_connect("localhost","root","root") or die ("Oops! Connection fail.");
	mysql_select_db("jaketv") or die ("Oops! No database found.");
	
	$document	= $_SERVER['DOCUMENT_ROOT'].'/jaketv/jaketv_admin/'; // Admin Panel
	$siteadmin	= $protocol."://".$_SERVER['HTTP_HOST']."/jaketv/jaketv_admin/";
	$_SESSION["DOCUMENTPATH"]	= $document;
	$_SESSION["ADMINPATH"]		= $siteadmin;
	
	$upload_postimage	= $_SESSION["DOCUMENTPATH"].'uploads/postimage/'; // Banner upload path
	$download_postimage	= $_SESSION["ADMINPATH"].'uploads/postimage/'; // Banner download path
	
	
	$document_service	= $_SERVER['DOCUMENT_ROOT'].'/jaketv/jaketv_webservice/'; // Web Service
	$sitefront	= $protocol."://".$_SERVER['HTTP_HOST']."/jaketv/jaketv_webservice/";
	$_SESSION["DOCUMENTPATHSERVICES"]	= $document_service;
	$_SESSION["FRONTPATH"]		= $sitefront;
	
	$upload_userprofile		= $_SESSION["DOCUMENTPATHSERVICES"].'uploads/userprofile/'; // Profile upload path
	$download_userprofile	= $_SESSION["FRONTPATH"].'uploads/userprofile/'; // Profile download path
}
else
{
	@mysql_connect("localhost","root","") or die ("Oops! Connection fail.");
	@mysql_select_db("jaketv") or die ("Oops! No database found.");
	
	$document	= $_SERVER['DOCUMENT_ROOT'].'jaketv/jaketv_admin/';
	$siteadmin	= $protocol."://".$_SERVER['HTTP_HOST']."/jaketv/jaketv_admin/";
	$_SESSION["DOCUMENTPATH"]	= $document;
	$_SESSION["ADMINPATH"]		= $siteadmin;
	
	$upload_postimage	= $_SESSION["DOCUMENTPATH"].'uploads/postimage/'; // Banner upload path
	$download_postimage	= $_SESSION["ADMINPATH"].'uploads/postimage/'; // Banner download path
	
	
	
	$document_service	= $_SERVER['DOCUMENT_ROOT'].'jaketv/jaketv_webservice/'; // Web Service
	$sitefront	= $protocol."://".$_SERVER['HTTP_HOST']."jaketv/jaketv_webservice/";
	$_SESSION["DOCUMENTPATHSERVICES"]	= $document_service;
	$_SESSION["FRONTPATH"]		= $sitefront;
	
	$upload_userprofile		= $_SESSION["DOCUMENTPATHSERVICES"].'uploads/userprofile/'; // Profile upload path
	$download_userprofile	= $_SESSION["FRONTPATH"].'uploads/userprofile/'; // Profile download path
	
}
	error_reporting(E_ERROR | E_PARSE);
	
	/* COMMON FUNCTIONS START*/
	
	ini_set('display_errors', 'On');
	error_reporting(E_ALL);
	
	//stop email from spam
function spamcheck($field) 
{
  $field=filter_var($field, FILTER_SANITIZE_EMAIL);
  if(filter_var($field, FILTER_VALIDATE_EMAIL))
  {
	return TRUE;
  } 
  else 
  {
	return FALSE;
  }
}

function qry_runQuery($qry) 
{
	$result = @mysql_query($qry) or die(mysql_error().' at Line:'.__LINE__." ".$qry);
	if ($result)
	{ 
		return true;
	}
	else
	{
		return false;
	}
}

// numbers query to be processed
function qry_numRows($qry) 
{
	$result = mysql_query($qry) or die(mysql_error().' at Line:'.__LINE__." ".$qry);
	$row = mysql_num_rows($result);
	return $row;
}

// fetch row query to be processed
function qry_fetchRow($qry) 
{
	$result = mysql_query($qry) or die(mysql_error().' at Line:'.__LINE__." ".$qry);
	$row = @mysql_fetch_assoc($result);
	return $row;	
}

// fetch multiple rows query to be processed
function qry_fetchRows($qry)
{
   $result = @mysql_query($qry) or die(mysql_error().' at Line:'.__LINE__." ".$qry);
	
	if ($num = @mysql_num_rows($result)) // if the result set contains atleast single row
	{
		while($row = @mysql_fetch_assoc($result)) // traversing the result set
		{
			//strip slashes from info - the ones we added while sanitizing input
			foreach ($row as $key => $value)
			{			
				$row[$key] = stripslashes($value);
			}        	
			$search_result[] = $row; // storing each row in an array
		}
		return $search_result;	// finally returning the result set as an array
	}	
	else
	{
		return 0;
	}
}

// Get last inserted id with one time insert data
function qry_insertedId($qry) 
{
	$result = mysql_query($qry) or die(mysql_error().' at Line:'.__LINE__." ".$qry);
	if ($result)
	{
		return $id = mysql_insert_id();
	}
	else
	{
		return 0;
	}
}

function distance($lat1, $lon1, $lat2, $lon2, $unit) 
{
	  $theta = $lon1 - $lon2;
	  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	  $dist = acos($dist);
	  $dist = rad2deg($dist);
	  $miles = $dist * 60 * 1.1515;
	  $unit = strtoupper($unit);
	 
	  if ($unit == "K") 
	  {
	    return ($miles * 1.609344);
	  } 
	  else if ($unit == "N") 
	  {
	     return ($miles * 0.8684);
	  } 
	  else 
	  {
	     return $miles;
	  }
}
//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "M") . " Miles<br>";
//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "K") . " Kilometers<br>";
//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "N") . " Nautical Miles<br>";

function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2) {
    $theta = $longitude1 - $longitude2;
    $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $miles = $miles * 60 * 1.1515;
    return $miles;
}

function get_driving_information($start, $finish, $raw = false)
{
	if(strcmp($start, $finish) == 0)
	{
		$time = 0;
		if($raw)
		{
			$time .= ' seconds';
		}
 
		return array('distance' => 0, 'time' => $time);
	}
 
	$start  = urlencode($start);
	$finish = urlencode($finish);
 
	$distance   = 'unknown';
	$time		= 'unknown';
 
	$url = 'http://maps.googleapis.com/maps/api/directions/xml?origin='.$start.'&destination='.$finish.'&sensor=false';
	if($data = file_get_contents($url))
	{
		$xml = new SimpleXMLElement($data);
 
		if(isset($xml->route->leg->duration->value) AND (int)$xml->route->leg->duration->value > 0)
		{
			if($raw)
			{
				$distance = (string)$xml->route->leg->distance->text;
				$time	  = (string)$xml->route->leg->duration->text;
			}
			else
			{
				$distance = (int)$xml->route->leg->distance->value / 1000 / 1.609344; 
				$time	  = (int)$xml->route->leg->duration->value;
			}
		}
		else
		{
			throw new Exception('Could not find that route');
		}
 
		return array('distance' => $distance, 'time' => $time);
	}
	else
	{
		throw new Exception('Could not resolve URL');
	}
}
function get_random_string()
{
    $valid_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $length = 8 ;
    // start with an empty random string
    $random_string = "";

    // count the number of chars in the valid chars string so we know how many choices we have
    $num_valid_chars = strlen($valid_chars);

    // repeat the steps until we've created a string of the right length
    for ($i = 0; $i < $length; $i++)
    {
        // pick a random number from 1 up to the number of valid chars
        $random_pick = mt_rand(1, $num_valid_chars);

        // take the random character out of the string of valid chars
        // subtract 1 from $random_pick because strings are indexed starting at 0, and we started picking at 1
        $random_char = $valid_chars[$random_pick-1];

        // add the randomly-chosen char onto the end of our string so far
        $random_string .= $random_char;
    }

    // return our finished random string
    return $random_string;
}

function moneyFormatIndia($num){
    $explrestunits = "" ;
    if(strlen($num)>3){
        $lastthree = substr($num, strlen($num)-3, strlen($num));
        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for($i=0; $i<sizeof($expunit); $i++){
            // creates each of the 2's group and adds a comma to the end
            if($i==0)
            {
                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
            }else{
                $explrestunits .= $expunit[$i].",";
            }
        }
        $thecash = $explrestunits.$lastthree;
    } else {
        $thecash = $num;
    }
    return $thecash; // writes the final format where $currency is the currency symbol.
}

function generateRandomString($length = 45) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ(_-)*@!$';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>
