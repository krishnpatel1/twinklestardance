<?
class db_connect
{
	function db_connect() 
	{
		$this->host = DBHOST;
		$this->user = DBUSER;
		$this->pass = DBPASS;
		$this->db = DBNAME;
		$this->connect($host, $user, $pass, $db, false);
	}
	
	function connect($host='', $user='', $pass='', $db='', $persistant=false) 
	{
		if (!empty($host)) $this->host = $host; 
		if (!empty($user)) $this->user = $user; 
		if (!empty($pass)) $this->pass = $pass; 
		if ($persistant) 
			$this->link = @mysql_pconnect($this->host, $this->user, $this->pass) or $this->connectionError(mysql_error());
		else 
			$this->link = @mysql_connect($this->host, $this->user, $this->pass) or $this->connectionError(mysql_error());
		if (!$this->link) 
		{
			$this->connectionError(mysql_error());
			return false;
		} 
		// Select the database
		if (!$this->db_select($db)) return false;
		return true;  // success
	}
	
	function db_select($db='')
	{
		if (!empty($db)) $this->db = $db; 
		if (!mysql_select_db($this->db)) 
		{
			$this->connectionError(mysql_error());
			return false;
		}
		return true;
	}
	function connectionError($err)
	{
		if(!DEBUGMODE)
		{
			$errMsg="<b><font color='red' face='Verdana, Arial, Helvetica, sans-serif' size='2'><center>ERROR!!".$err."</center></font></b>";
		}
		else
		{
			$errMsg="<b><font color='red' face='Verdana, Arial, Helvetica, sans-serif' size='2'><center>ERROR!! Can not Connect with DB.Please Try Latter </center></font></b>";
		}
		echo "<br>".$errMsg;
		exit;
	}
}
?>