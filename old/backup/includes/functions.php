<?
function loadTemplate()
{
	$no_of_args=func_num_args();
	$template_path=TEMPLATE_PATH;
	if($no_of_args==2)
	{
		$template_path=func_get_arg(1);
	}
	$template_name=func_get_arg(0);
	$file_path=$template_path."/".$template_name;
	//$path_parts = pathinfo($file_path);
	//echo $path_parts["extension"];
	if(file_exists($file_path)&&!is_dir($file_path))
	{
		$content=file_get_contents($file_path);	
	}
	else
	{
		$content="File does not exist";
	}
	return $content;
}

function pre($data)
{
	print"<pre>";
	print_r($data);
	print"</pre>";
}
function showDropdown($arr,$selectedVal="",$type=0)// type=0 for no key, type=1 for use key
{
	if($type==1)
	{
		$optArr=$arr;
	}
	else
	{
		foreach($arr as $key_a=>$val_a)
		{
			$optArr[$val_a]=$val_a;
		}
	}
	$output='';
	if(is_array($optArr))
	{
		foreach($optArr as $key=>$val)
		{
			if($key==$selectedVal)
			{
				$selected=" selected=\"selected\"";
			}
			else
			{
				$selected="";
			}
			$output.='<option value="'.$key.'"'.$selected.'>'.$val.'</option>';
		}
	}
	return $output;
}

function showStatus($selVal='')
{
	$status=array("Active","Inactive");
	$opt=showDropdown($status,$selVal);
	return $opt;
}

function currentPage()
{
	if(basename($_SERVER['PHP_SELF'])=="")
	{
		$page = "index.php";
	}
	else
	{
		$page = basename($_SERVER['PHP_SELF']);
	}
	return $page;
}

function getContent()
{
	global $obj; 
	$pageName = currentPage();
	$content=$obj->selectData(TABLE_CONTENT,"","content_page='".$pageName."'",1);
	return html_entity_decode($content['content_description']);
}
function getTitle()
{
	global $obj; 
	$pageName = currentPage();
	$content=$obj->selectData(TABLE_CONTENT,"","content_page='".$pageName."'",1);
	return html_entity_decode($content['content_title']);
}

function userSecure()
{
	global $obj;
	$_SESSION['user_request_path']=basename($_SERVER['REQUEST_URI']);
	if(!isLogged())
	{
		$obj->add_message("login_msg","Please login to view the page!");
		$obj->reDirect("login.php");

	}
}

function userLogin($username,$password)
{
	global $obj;
	$error=false;

	$user=$obj->selectData(TABLE_USER,"","user_email='".$username."' and user_status='Active'",1);	
	
	if($user)
	{
		if($password==$user['password'])
		{
			$_SESSION['user_request_path']=$_SESSION['user_request_path']?$_SESSION['user_request_path']:"index.php";
			$_SESSION['user']=$user;
			$obj->updateData(TABLE_USER,array("user_last_login"=>"now()"),"user_id='".$user['user_id']."'");
			$obj->reDirect($_SESSION['user_request_path']);
		}
		else
		{
			$error=INVALID_LOGIN;
		}
	}
	else
	{
		$error=INVALID_LOGIN;
	}
	return $error;
}

function isLogged()
{
	if($_SESSION['user']['user_id']!="")
	{
		return true;
	}
	else
	{
		return false;
	}
}
function userLogout()
{
	global $obj;
	unset($_SESSION['user']);
	unset($_SESSION['user_request_path']);
	unset($_SESSION['scart']);
	unset($_SESSION['RETURN_PATH_CART']);
	$obj->add_message("login_msg",LOGOUT_SUCCESS);
}
function animate()
{
	//$content='<META http-equiv="Page-Enter" CONTENT="RevealTrans(Duration=1,Transition=12)">';
	return $content;
}
function str_replace_array($key,$rep,$str)
{
	preg_match_all("/".$key."/",$str,$matches);
	for($i=0;$i<count($matches[0]);$i++)
	{
		$old_str=substr($str,0,strpos($str,$key)+strlen($key));
		$new_str=str_replace($key,$rep[$i],$old_str);
		$str=str_replace($old_str,$new_str,$str);
	}
	return $str;
}

function adminSecure()
{
	global $obj;
	$_SESSION['admin_request_page']=$_SERVER['REQUEST_URI'];
	if(!isset($_SESSION['admin']))
	{
		$obj->reDirect("index.php");
	}
}

function managerSecure()
{
	global $obj;
	$_SESSION['manager_request_page']=$_SERVER['REQUEST_URI'];
	if(!isset($_SESSION['manager']))
	{
		$obj->reDirect("index.php");
	}
}

function proSecure()
{
	global $obj;
	$_SESSION['pro_request_page']=$_SERVER['REQUEST_URI'];
	if(!isset($_SESSION['provider']))
	{
		$obj->reDirect("index.php");
	}
}

function runIt($code="")
{
	$code="?>".$code."<?";
	eval($code);
}

function supportExtension($filename,$s_array=array())
{
	if(count($s_array)<=0||(!is_array($s_array)))
	{
		$s_array=array("jpg","jpeg","gif","bmp");
	}
	$file_ext=strtolower(end(explode(".",$filename)));
	if(in_array($file_ext,$s_array))
	{
		return true;
	}
	return false;
}

function imageURL($image_path)
{
	$url=$image_path;
	if(!file_exists($image_path))
	{
		//$url=pathinfo($image_path,PATHINFO_DIRNAME)."/".NOT_FOUND_IMG;
		$url=IMAGES.NOT_FOUND_IMG;
	}
	else if(is_dir($image_path))
	{
		//$url=$image_path."/".NOT_FOUND_IMG;
		$url=IMAGES.NOT_FOUND_IMG;
	}
	return $url;
}

function random_float ($min,$max) {
   return ($min+lcg_value()*(abs($max-$min)));
}

class paging
{
	var $res;
	var $rcd_num;
	var $limit;
	var $pageno;
	function paging($table_name,$field,$condition,$limit)
	{
		global $obj;
		$pageno=$_REQUEST['pageno'];
		$rowsUser=$obj->selectData($table_name,'count(*) as c',$condition);
		$countUser=mysql_fetch_assoc($rowsUser);
		$rcd_num=$countUser['c'];
		if($rcd_num > 0)
		{
			 if(empty($pageno))
			 $pageno=1;		
			 
			 $offset=$limit*($pageno-1);
			  /* page no recalculate */
			 if($pageno>1)
			 {
			 	if(!$obj->selectData($table_name,$field,$condition,1,"","",$offset.",1"))
				{
					if($rcd_num%$limit)
					{
						$last_page=$rcd_num/$limit+1;
					}
					else
					{
						$last_page=$rcd_num/$limit;
					}
					$pageno=(int)$last_page;
					$offset=$limit*($pageno-1);	
				}	
			 }
			 /* eof page no recalculate */
			$rowsUser = $obj->selectData($table_name,$field,$condition,"","","",$offset.",".$limit);
		}
		$this->res=$rowsUser;
		$this->rcd_num=$rcd_num;
		$this->limit=$limit;
		$this->pageno=$pageno;
	}
	function page_list($lnkParam="",$lnkScr="",$yahoopaging=1,$nopageshow="")
	{
		global $obj;
		$obj->pagewise($this->rcd_num,$this->limit,$this->pageno,$lnkParam,$lnkScr,$yahoopaging,$nopageshow);
	}
}

function gotoPage($url)
{
	?>
	<script>
	window.location='<?=$url?>';
	</script>
	<?
}

function keyToSearchArray($arr)
{
	foreach($arr as $key=>$val)
	{
		$opt[]="%%".strtoupper($key)."%%";
	}
	return $opt;
}
function isEmail($string)
{
	$email=trim($string);
	if(!preg_match ("/^[\w\.-]{1,}\@([\da-zA-Z-]{1,}\.){1,}[\da-zA-Z-]+$/", $email))
	{
   		return false;
	}
	return true;	
}

function emailUsed($email)
{
	global $obj;
	$user=$obj->selectData(TABLE_USER,"","user_email='".$email."' and user_status!='Deleted'",1);
	return $user;
}
function invUsed($email)
{
	global $obj;
	$user=$obj->selectData(TABLE_INVITATION,"","inv_email='".$email."' and inv_status!='Deleted'",1);
	return $user;
}
function userNameExists($uname)
{
	global $obj;
	$user=$obj->selectData(TABLE_USER_LOGIN,"","user_name='".$uname."' and user_status!='Deleted'",1);
	return $user;
}

function providerPaypalUserExist($uname)
{
	global $obj;
	$user=$obj->selectData(TABLE_PROVIDER,"","pro_paypal_user='".$uname."' and pro_status!='Deleted'",1);
	return $user;
}

function affPaypalUserExist($uname)
{
	global $obj;
	$user=$obj->selectData(TABLE_AFFILIATE,"","aff_paypal_user='".$uname."' and aff_status!='Deleted'",1);
	return $user;
}


function deldir($dir) // Delete the directory
{
  $current_dir = opendir($dir);
  while($entryname = readdir($current_dir)){
     if(is_dir("$dir/$entryname") and ($entryname != "." and $entryname!="..")){
        deldir("${dir}/${entryname}");
     }elseif($entryname != "." and $entryname!=".."){
        unlink("${dir}/${entryname}");
     }
  }
  closedir($current_dir);
  rmdir(${dir});
}

function numberArray($from,$to)
{
	if($from>$to)
	{
		for($i=$from;$i>=$to;$i--)
		{
			$a[$i]=$i;
		}
	}
	else
	{
		for($i=$from;$i<=$to;$i++)
		{
			$a[$i]=$i;
		}
	}
	return $a;
}

function showThumb($imagePath,$width=100,$height=100,$extra="",$thumbBase="")
{
	$imageExt=strtolower(end(explode(".",$imagePath)));
	if($thumbBase=="../")
	{
		$pathBack="";
	}
	else
	{
		$pathBack="../";
	}
	$path=$thumbBase."includes/thumb/phpThumb.php?src=../".$pathBack.imageURL($imagePath)."&w=".$width."&h=".$height;
	if($imageExt=="gif")
	{
		$path.="&f=gif";
	}
	$imgset="<img src=\"".$path."\" ".$extra.">";
	echo $imgset;
}

function uploadFile($fieldName,$path="",$name="")
{
	$out['error']=0;
	$out['error_name']="";
	if($name)
	{
		$newname=$name;
	}
	else
	{
		$newname=time().rand(1000,100000000);
	}
	if(!$_FILES[$fieldName]['name'])
	{
		$out['error']=1;
		$out['error_name']="file not uploaded";
	}
	else
	{
		$fileExt=strtolower(end(explode(".",$_FILES[$fieldName]['name'])));
		$newFileName=$newname.".".$fileExt;
		$target=$path.$newFileName;
		if(move_uploaded_file($_FILES[$fieldName]['tmp_name'],$target))
		{
			$out['file_name']=$newFileName;
		}
		else
		{
			$out['error']=1;
			$out['error_name']="error occured whilee uploading";
		}
	}
	return $out;
}

function get_age($dateobirth)
{
	$difference = abs(strtotime($dateobirth) - strtotime(date("Y-m-d")));
	return $age = round(((($difference/60)/60)/24/365), 0);
}

function ftp_is_dir($conn, $dir ) 
{
    $ftpcon=$conn;
    // get current directory
    $original_directory = ftp_pwd( $ftpcon );
    // test if you can change directory to $dir
    // suppress errors in case $dir is not a file or not a directory
    if ( @ftp_chdir( $ftpcon, $dir ) ) 
	{
        // If it is a directory, then change the directory back to the original directory
        ftp_chdir( $ftpcon, $original_directory );
        return true;
    } 
    else 
	{
        return false;
    }        
} 

function get_order_status($status)
{
	global $obj;
	$q_status=$obj->selectData(TABLE_ORDERSTATUS,"","OrderStatus_ID='".$status."'");
	$status_name=mysql_fetch_array($q_status);
	return $status_name['OrderStatus_Name'];
}
function changedateAdv($date)
{
	$dat=explode(" ",$date);
	$dt=explode("-",$dat[0]);
	$year=$dt[0];
	$month=$dt[1];
	$day=$dt[2];
	$timestamp=mktime(0, 0, 0, $month, $day, $year);
	$mn=date("F",$timestamp);
	$yr=$dt[0];
	$da=$dt[2];
	$adv_date=$mn."  ".$da." ,".$yr;
	return($adv_date);
}
  function time_diff($start, $end="NOW")
{
        $sdate = strtotime($start);
        $edate = strtotime($end);

        $time = $edate - $sdate;
        if($time>=0 && $time<=59) {
                // Seconds
                $timeshift = $time.' seconds ';

        } elseif($time>=60 && $time<=3599) {
                // Minutes + Seconds
                $pmin = ($edate - $sdate) / 60;
                $premin = explode('.', $pmin);
               
                $presec = $pmin-$premin[0];
                $sec = $presec*60;
               
                $timeshift = $premin[0].' min '.round($sec,0).' sec ';

        } elseif($time>=3600 && $time<=86399) {
                // Hours + Minutes
                $phour = ($edate - $sdate) / 3600;
                $prehour = explode('.',$phour);
               
                $premin = $phour-$prehour[0];
                $min = explode('.',$premin*60);
               
                $presec = '0.'.$min[1];
                $sec = $presec*60;

                $timeshift = $prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';

        } elseif($time>=86400) {
                // Days + Hours + Minutes
                $pday = ($edate - $sdate) / 86400;
                $preday = explode('.',$pday);

                $phour = $pday-$preday[0];
                $prehour = explode('.',$phour*24);

                $premin = ($phour*24)-$prehour[0];
                $min = explode('.',$premin*60);
               
                $presec = '0.'.$min[1];
                $sec = $presec*60;
               
                $timeshift = $preday[0].' days '.$prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';

        }
        return $timeshift;
}

function generatePassword ($length = 8){
    $password = "";
    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
    $maxlength = strlen($possible);
    if ($length > $maxlength) {
      $length = $maxlength;
    }
    $i = 0; 
    while ($i < $length) { 
      $char = substr($possible, mt_rand(0, $maxlength-1), 1);
      if (!strstr($password, $char)) { 
        $password .= $char;
        $i++;
      }
    }
    return $password;
  }
?>