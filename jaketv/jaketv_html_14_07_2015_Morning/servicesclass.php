<?php 
	include("config.php");
	class servicecalss
	{
		function runquery($query)
		{
			$result = mysql_query($query);
			return $result;
		}
		function fetcharray($result)
		{
			$datas = array();
			while($row = mysql_fetch_assoc($result))
			{
				$datas[] = $row;	
			}
			return $datas;
		}
		function fetchrow($result)
		{
			$row = mysql_fetch_assoc($result);	
			return $row;
		}
		function TranslateNull($param)
		{
			$temp = json_encode($param);
			$temp = str_replace("null",'""',$temp);
			$temp = str_replace('\r\n','',$temp);
			return  $temp;
		}
		function numrows($result)
		{
			$nums = mysql_num_rows($result);
			return $nums;
		}
	}
?>