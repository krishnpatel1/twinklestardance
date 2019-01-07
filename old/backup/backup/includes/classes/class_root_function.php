<?php 
class root_function extends db_connect 
{
	var $sqlQuery="";
	var $numRecord=0;
	var $mysqlKeyword=array();
	//error_reporting(0);
	function root_function()
	{
		parent::db_connect();
	}
	function setQuery($sql="")
	{
		if($sql=="")
		{
			$errMsg="<b><font color='red' face='Verdana, Arial, Helvetica, sans-serif' size='2'><center>ERROR!!<br>QUERY EMPTY<br></center></font></b>";
			echo "<br>".$errMsg;
		}
		$this->sqlQuery=$sql;
	}
	function getQuery($print=0)
	{
		if($this->sqlQuery=="")
		{
			$errMsg="<b><font color='red' face='Verdana, Arial, Helvetica, sans-serif' size='2'><center>ERROR!!<br>QUERY EMPTY<br></center></font></b>";
			echo "<br>".$errMsg;
		}
		if(!$print)
			return $this->sqlQuery;
		else
			echo $this->sqlQuery;
	}
	function data_prepare($string,$qto=1)
	{
		if(is_string($string))
		{
			$string=htmlspecialchars(addslashes(stripslashes(trim($string))));
			if(!$qto || $this->isMysqlKeyword($string))
			{
				return $string;
			}
			$string="'$string'";
			return $string;
		}
		else if(is_numeric($string))
		{
			return $string;
		}
		else
		{
			if(!$qto)
			{
				return $string;
			}
			$string="''";
			return $string;
		}
	}
	function getFields($table,$datagiven)
	{
		$fields = @mysql_list_fields(DBNAME, $table) or $this->mysqlError($sql);
		$column_num = @mysql_num_fields($fields) or $this->mysqlError($sql);
		for ($i = 0; $i < $column_num; $i++)
		 {
			$field_name=@mysql_field_name($fields, $i) or $this->mysqlError($sql);
			foreach ($datagiven as $key=>$value)
				{ 
					if($key==$field_name)
					$data[$key]=$value;
				}		
		}
		return $data;
	}
	function getFieldsOnly($table,$toreturn="",$alise="",$extra="")
	{
		$fields = @mysql_list_fields(DBNAME, $table) or $this->mysqlError($sql);
		$column_num = @mysql_num_fields($fields) or $this->mysqlError($sql);
		if(empty($toreturn))
		{
			$toreturn=array();
		}
		for ($i = 0; $i < $column_num; $i++)
		 {
			$field_name=@mysql_field_name($fields, $i) or $this->mysqlError($sql);
			if(!in_array($field_name,$toreturn))
			{
				$field_name_al=$alise.$field_name.$extra;
				$field_name_arr[]=$field_name_al;
			}
		}
		return $field_name_arr;
	}
	//INSERT FUNCTION
	function insertData($table,$datagiven)
	{
		$data=$this->getFields($table,$datagiven);
		$cols = '(';
		$values = '(';
		foreach ($data as $key=>$value) 
			{     
				$value=$this->data_prepare($value);
				$cols .= "$key,";  
				$values .= "$value,"; 
			}
		$cols = rtrim($cols, ',').')';
		$values = rtrim($values, ',').')';     
		$sql = "INSERT INTO ".$table." ".$cols." VALUES ".$values;
		$this->setQuery($sql);
		$result = @mysql_query($sql);
		if (!$result) $this->mysqlError($sql);
		$id = mysql_insert_id();
		if ($id == 0) return true;
		else return $id; 
	}
	
	//UPDATE FUNCTION
	
	function updateData($table, $datagiven, $condition) 
	{
		$data=$this->getFields($table,$datagiven);
		$sql = "UPDATE ".$table." SET";
		foreach ($data as $key=>$value) 
		{    
			$value=$this->data_prepare($value);
			$sql .= " $key=";  
			$sql .= "$value,"; 
		}
		$sql = rtrim($sql, ','); 
		if (!empty($condition)) $sql .= " WHERE ".$condition;
		$this->setQuery($sql);
		$result = @mysql_query($sql);
		if (!$result) $this->mysqlError($sql);		
		$rows = mysql_affected_rows();
		if ($rows == 0) return true; 
		else return $rows;
	}
		
	//DELETE FUNCTION
	function deleteData($table, $condition) 
	{
		$sql = "Delete from ".$table;
		if (!empty($condition)) $sql .= " WHERE ".$condition;
		$this->setQuery($sql);
		$result = @mysql_query($sql);
		if (!$result) $this->mysqlError($sql);		
		$rows = mysql_affected_rows();
		if ($rows == 0) return true; 
		else return $rows;
	}
	//SELECT FUNCTION
	function selectData($table,$parameter="",$condition="",$record="",$orderby="",$groupby="",$lmt="")
	{
		if(empty($parameter))
		{
			$parameter="*";
		}
		$sql="select ".$parameter." from ".$table;
		if(!empty($condition))
		 {
			$sql.=" where ".$condition;

		 }
		if(!empty($groupby))
		 {
			$sql.=" group by ".$groupby;
		 }
		if(!empty($orderby))
		 {
			$sql.=" order by ".$orderby; 
		 }
		if(!empty($lmt))
		 {
			$sql.=" limit ".$lmt;
		 }
		$this->setQuery($sql);
		if($record!=2)
		{
			$res = @mysql_query($sql) or $this->mysqlError($sql);
			$numres=@mysql_num_rows($res);
			$this->numRecord=$numres;
			if($record==1)
			{
				if($this->numRecord==0)
				{
					$res=0;
				}
				else
				{
					$res=@mysql_fetch_array($res);
				}
			}
		}
		else
		{
			$res=$sql;
		}
		return $res;
	}
	function qUpdate($table,$parameter,$condition="")
	{
		if(empty($condition))
		$condition=1;
		$sql="update ".$table." set ".$parameter." where ".$condition;
		$this->setQuery($sql);
		$res = @mysql_query($sql) or $this->mysqlError($sql);
		return mysql_affected_rows();
	}
	function qDelete($table,$condition)
	{
		if(!empty($condition))
		{
			$sql="delete from ".$table." where ".$condition;
			$this->setQuery($sql);
			$res = @mysql_query($sql) or $this->mysqlError($sql);
			return mysql_affected_rows();
		}
		else
			return 0;
	}
	//Counting Number of elements
	function countRows($sql)
	{
	  $result= @mysql_query($sql) or $this->mysqlError($sql);
	  $num_rows = @mysql_num_rows($result);
	  return $num_rows ;

	}
	function setMysqlKeyword($str="",$sep=",")
	{
		$this->mysqlKeyword=explode($sep,$str);
	}
	function isMysqlKeyword($string)
	{
		if(in_array($string,$this->mysqlKeyword))
		{
			return true;
		}
		return false;
	}
	//MYSQL Error
	function mysqlError($sql="")
	{
		if(!DEBUGMODE)
		{
			$qry="";
			if(!empty($sql)) $qry="<br>QUERY<br>".$sql;
			$errorNo=mysql_errno();
			$errMsg=mysql_error();
			$errMsg="<b><font color='red' face='Verdana, Arial, Helvetica, sans-serif' size='2'><center>ERROR!!".$errorNo."<br>".$errMsg.$qry."</center></font></b>";
		}
		else
		{
			$errMsg="<b><font color='red' face='Verdana, Arial, Helvetica, sans-serif' size='2'><center>ERROR!! Can not complete the operation.Please Try Latter.</center></font></b>";
		}
		echo "<br>".$errMsg;
	}
}
?>