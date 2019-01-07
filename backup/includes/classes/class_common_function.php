<?php 
class common_function extends root_function 
{

	function common_function()
	{
		parent::root_function();
		parent::setMysqlKeyword("now()");
	}
	function short_description($descr,$noc="")
	{
		$sdescr=strip_tags($descr);
		if(empty($noc))$noc=200;
		if(trim($sdescr)<>'')
		{
			if(strlen($sdescr)>$noc)
				return substr($sdescr, 0, $noc).".....";
			else
				return $sdescr;
		}
		else
		return $sdescr;
	}
	///////////for redirect url////////
	function reDirect($url)
	{
		header("Location: ".$url);
		exit;
	}
	function goTo($url)
	{
		echo "<script>window.location.href='$url'</script>";
		exit;
	}
	///////////for redirect url////////
	function filterData($data,$strip=1)
	{
		$fdata=parent::data_prepare($data,0);
		if(!$strip)
			return $fdata;
		return stripslashes($fdata);
	}
	function filterData_array($datagiven)
	{
		foreach ($datagiven as $key=>$value)
		{
			if(is_array($value))
			{
				$data[$key]=$this->filterData_array($value);
			}
			else
			{
				$data[$key]=$this->filterData($value);
			}
		}
		return $data;
	}
	function pre($arr)
	{
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}
	function get_page_name($path='')
	{
		$page_path = ($path != "") ? $path : $_SERVER['HTTP_REFERER']; 
		$url_parts = parse_url($page_path);
		$tmp_path = explode("/",$url_parts['path']); //pre($tmp_path);
		$page_name = array_pop($tmp_path);
		$page_name = !empty($page_name) ? $page_name : "index.php";
		$page_name .= ($url_parts['query'] != "") ? "?".$url_parts['query'] : "";
		$page_name .= ($url_parts['fragment'] != "") ? "#".$url_parts['fragment'] : "";
		return $page_name;
	}
	
	
	function mailBody($bodypart){
		$data='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Welcome to Tshirt Design</title>
</head>
<body>
<table width="600" border="0" cellspacing="1" cellpadding="3" align="center" style="border:1px solid #d6d6d6; font:normal 12px/16px Arial, Helvetica, sans-serif; color:#818181;">
  <tr>
    <td align="left" valign="top" style="height:120px; border-bottom:3px solid #eeefef;"><img src="'.FURL.'images/logo.jpg" alt="" /></td>
  </tr>
  <tr>
    <td align="left" valign="top" style="padding:10px 20px 20px 20px; color:#4b4b4b;"><table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td align="left" valign="top">'.$bodypart.'</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="middle" style="height:50px; background-color:#eaf6e2; color:#4b4b4b">Copyright &copy; '.date("Y").' '.SITE_NAME.', All Rights Reserved.</td>
  </tr>
</table>
</body>
</html>';
		return $data;
	}
	
		/////////////////////////
	function sendMail($to="", $subject="", $body="",$from="",$fromname="",$type="",$replyto="",$bcc="",$cc="")
	{
		if(empty($type))
		{
			$type="html";
		}
		if($type=="plain")
		{
			$body = strip_tags($body);
		}
		if($type=="html")
		{
			$body = "<font face='Verdana, Arial, Helvetica, sans-serif'>".$body."</font>";
		}
		/* To send HTML mail*/ 
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers.= "Content-type: text/".$type."; charset=iso-8859-1\r\n";
		/* additional headers */ 
		//$headers .= "To: <".$to.">\r\n"; 
		if(!empty($from))
		{
			$headers .= "From: ".$fromname." <".$from.">\r\n";
		}
		if(!empty($replyto))
		{
			$headers .= "Reply-To: <".$replyto.">\r\n"; 
		}
		if(!empty($cc))
		{
			$headers .= "Cc: ".$cc."\r\n";
		}
		if(!empty($bcc))
		{
			$headers .= "Bcc: ".$bcc."\r\n";
		}
		if(@mail($to, $subject, $body, $headers))
		{
			return 1;
		}
		else
		{
			return $headers;
		}
	}
	
	function putContent($id)
	{
		$res=parent::selectData(TABLE_CONTENT,"","content_id='".$id."'",1);
		$content=$res['content_description'];
		return html_entity_decode($content);
	}
	function putMetaTags($page)
	{
		$res=parent::selectData(TABLE_SEO,"","seo_page='".$page."'",1);

		$meta_content='<title>'.$res['seo_meta_title'].'</title>';
		$meta_content.='<meta name="DESCRIPTION" content="'.$res['seo_meta_description'].'" />';
		$meta_content.='<meta name="SUMMARY" content="'.$res['seo_meta_summary'].'" />';
		$meta_content.='<meta name="KEYWORDS" content="'.$res['seo_meta_keywords'].'" />';
		$meta_content.='<meta name="AUTHOR" content="'.$res['seo_meta_author'].'" />';
		$meta_content.='<meta name="COVERAGE" content="'.$res['seo_meta_coverage'].'" />';
		$meta_content.='<meta name="IDENTIFIER" content="'.$res['seo_meta_identifier'].'" />';
		$meta_content.='<meta name="COUNTRY" content="'.$res['seo_meta_country'].'" />';
		$meta_content.='<meta name="COPYRIGHT" content="'.$res['seo_meta_copyright'].'" />';
		$meta_content.='<meta name="REVISIT" content="'.$res['seo_meta_revisit'].'" />';
		$meta_content.='<meta name="ROBOTS" content="'.$res['seo_meta_robots'].'" />';		
		$meta_content.='<meta http-equiv="content-type" content="text/html; charset=UTF-8" />';
		return $meta_content;
	}

	function select_page($selval)
	{
		$res=parent::selectData(TABLE_SEO,"","seo_status='Active'","","");
		while($row=mysql_fetch_array($res))
		{
			$str.="<option value='".$row['seo_id']."'";
			if($row['seo_id']==$selval)
			{
				$str.=' selected';
			}
			$str.=">".$row['seo_page']."</option>";
		}
		return $str;
	}
	
	function add_message($msgvar,$message)
	{
		$_SESSION[$msgvar] .= $message."<br>";
	}
	
	function get_message($msgvar)
	{
		return $_SESSION[$msgvar];
	}
	
	function remove_message($msgvar)
	{
		$_SESSION[$msgvar] = "";
	}
	function display_message($msgvar)
	{
		$message = '';
		if($this->get_message($msgvar))
		{
			if($_SESSION['messageClass']=='success')
			{
			$message = ' <div class="ui-widget"><div class="ui-state-highlight ui-corner-all" style="margin: 7px; padding: 0pt 0.7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: 0.3em;"></span>'.$this->get_message($msgvar).'</p></div></div>';
			}
			else
			{
			$message = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="margin: 7px; padding: 0pt 0.7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: 0.3em;"></span>'.$this->get_message($msgvar).'</p></div></div>';
			}
		}
		$this->remove_message($msgvar);
		return $message;
	}
	
	 function check_email_address($email) {
 
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    return false;
  }

  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) 
  {
    if(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",$local_array[$i]))
	{
      return false;
    }
  }

  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) 
	{
        return false; 
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) 
	{
      if(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$",$domain_array[$i])) 
	  {
        return false;
      }
    }
  }
  return true;
}
  function get_user($uid,$ufld="user_name")
  {
  		$sqlUser = parent::selectData(TABLE_USER,"","user_status='Active' and user_id='".$uid."'",1); 
		return $sqlUser[$ufld];
  }
  function get_confirm_contacts($uid)
  {
  		$sqlUser = parent::selectData(TABLE_INVITATION,"","inv_status='Active' and inv_user='".$uid."' and inv_action_status='Accept'",""); 
		return mysql_num_rows($sqlUser);
  }
  function get_pending_contacts($uid)
  {
  		$sqlUser = parent::selectData(TABLE_INVITATION,"","inv_status='Active' and inv_user='".$uid."' and inv_action_status='Request'",""); 
		return mysql_num_rows($sqlUser);
  }
  function encryptPass($strPass){
		$strPass=trim($strPass);
		$basePass=base64_encode($strPass);
		$revPass=strrev($basePass);
		//echo $oriPass=base64_decode(strrev($revPass));
		$first4=$this->randCode(4);
		$last4=$this->randCode(4);
		$enc_revPass=$first4.$revPass.$last4;
		return $enc_revPass;
	}
	function retrievePass($enc_revPass){
		$pass=substr($enc_revPass,4);
		$last4=substr($pass,-4,4);
		$pass1=str_replace($last4,"",$pass);
		$revPass=strrev($pass1);
		$oriPass=base64_decode($revPass);
		return $oriPass;
	//	echo "<br>".$oriPass;
	}
	function randCode($limit)
	{
		$rand=rand();
		$rand1=md5($rand);
		$pass = substr($rand1, 0, $limit);
		return $pass;
	}
	
	function invited_by($invId)
	{
		$inv_user_name = '';
		$invUser = parent::selectData(TABLE_INVITATION,"","inv_status='Active' and inv_id='".$invId."'",1); 
		if($invUser)
		{
			$userD = parent::selectData(TABLE_USER,"","user_status='Active' and user_id='".$invUser['inv_user_id']."'",1); 
			$inv_user_name = $userD['user_first_name'];
		}
		return $inv_user_name;
	}
	
	function mail_content($arr)
	{
		$mailC = parent::selectData(TABLE_EMAIL_TEMPLATE,"","et_id='1'",1); 
		$mail_template = nl2br($mailC['et_template']);
		
		$mail_template = str_replace('{USER_FNAME}',$arr['user_fname'],$mail_template);
		$mail_template = str_replace('{USER_LNAME}',$arr['user_lname'],$mail_template);
		$mail_template = str_replace('{USER_NAME}',$arr['user_name'],$mail_template);
		$mail_template = str_replace('{USER_EMAIL}',$arr['user_email'],$mail_template);
		$mail_template = str_replace('{INVITER_FNAME}',$arr['inviter_fname'],$mail_template);
		$mail_template = str_replace('{INVITER_LNAME}',$arr['inviter_lname'],$mail_template);
		$mail_template = str_replace('{INVITER_NAME}',$arr['inviter_name'],$mail_template);
		$mail_template = str_replace('{INVITER_EMAIL}',$arr['inviter_email'],$mail_template);
		$mail_template = str_replace('{SITE_NAME}',$arr['site_name'],$mail_template);
		$mail_template = str_replace('{SITE_URL}',$arr['site_url'],$mail_template);
		
		$link = FURL.'Signup.php?invId='.$this->encryptPass($arr['inv_req_id']);
		$aurl = '<a href="'.$link.'">Click Here</a>';
		$mail_template = str_replace('{CLICK_HERE}',$aurl,$mail_template);
		 
		return $this->mailBody($mail_template);
	}
	
	function mail_content_admin($arr)
	{
		$mailC = parent::selectData(TABLE_EMAIL_TEMPLATE,"","et_id='2'",1); 
		$mail_template = nl2br($mailC['et_template']);
		
		$mail_template = str_replace('{USER_FNAME}',$arr['user_fname'],$mail_template);
		$mail_template = str_replace('{USER_LNAME}',$arr['user_lname'],$mail_template);
		$mail_template = str_replace('{USER_NAME}',$arr['user_name'],$mail_template);
		$mail_template = str_replace('{USER_EMAIL}',$arr['user_email'],$mail_template);
		$mail_template = str_replace('{INVITER_FNAME}',$arr['inviter_fname'],$mail_template);
		$mail_template = str_replace('{INVITER_LNAME}',$arr['inviter_lname'],$mail_template);
		$mail_template = str_replace('{INVITER_NAME}',$arr['inviter_name'],$mail_template);
		$mail_template = str_replace('{INVITER_EMAIL}',$arr['inviter_email'],$mail_template);
		$mail_template = str_replace('{SITE_NAME}',$arr['site_name'],$mail_template);
		$mail_template = str_replace('{SITE_URL}',$arr['site_url'],$mail_template);
		
		$link = FURL.'Signup.php?invId='.$this->encryptPass($arr['inv_req_id']);
		$aurl = '<a href="'.$link.'">Click Here</a>';
		$mail_template = str_replace('{CLICK_HERE}',$aurl,$mail_template);
		 
		return $this->mailBody($mail_template);
	}
	
	function uploadFile($file_id, $folder="", $types="",$rename="") {

	$file_title = $_FILES[$file_id]['name'];
	$file_tmp = $_FILES[$file_id]['tmp_name'];
	
    if(!$file_title) return array('','No file specified');
    //Get file extension
    $ext_arr = split("\.",basename($file_title));
    $ext = strtolower($ext_arr[count($ext_arr)-1]); //Get the last extension
	
   if(!empty($types))
   { 
     $all_types = explode(",",strtolower($types));
		if($types) 
		{
			if(in_array($ext,$all_types));
			else {
				$result = "'".$file_title."' is not a valid file."; //Show error if any.
				return array('',$result);
			}
		}
	}

    //Not really uniqe - but for all practical reasons, it is
	if(!empty($rename))
	{
	 	$file_name=$rename.'.'.$ext; 
	}
	else
	{
		$uniqer = substr(md5(uniqid(rand(),1)),0,5);
		$file_name = $uniqer . '_' . date('YmdHis').'.'.$ext;//Get Unique Name
	}
    //Where the file must be uploaded to
    if($folder) $folder .= '/';//Add a '/' at the end of the folder
    $uploadfile = $folder . $file_name;

    $result = '';
    //Move the file from the stored location to the new location
    if (!move_uploaded_file($file_tmp, $uploadfile)) {
        $result = "Cannot upload the file '".$file_title."'"; //Show error if any.
        if(!file_exists($folder)) {
            $result .= " : Folder don't exist.";
        } elseif(!is_writable($folder)) {
            $result .= " : Folder not writable.";
        } 
        $file_name = '';
        
    } else {
        if(!$_FILES[$file_id]['size']) { //Check if the file is made
            @unlink($uploadfile);//Delete the Empty file
            $file_name = '';
            $result = "Empty file found - please use a valid file."; //Show the error message
        } else {
            chmod($uploadfile,0777);//Make it universally writable.
        }
    }

    return array($file_name,$result);
}

function getCategorySelect($sel_val){
		$categoryDetails = parent::selectData(TABLE_CATEGORY,"","category_status='Active'");
		$category = "";
		while($data = mysql_fetch_array($categoryDetails)){
			$class="";
			if($sel_val == $data['category_id']){
				$class = 'selected="selected"';
			}
			$category .= '<option value="'.$data['category_id'].'" '.$class.'>'.$data['category_name'].'</option>';
		}
		return $category;
}

function getUserSelect($sel_val){
		$userDetails = parent::selectData(TABLE_USER,"","user_status='Active'");
		$user = "";
		while($data = mysql_fetch_array($userDetails)){
			$class="";
			if($sel_val == $data['user_id']){
				$class = 'selected="selected"';
			}
			$user .= '<option value="'.$data['user_id'].'" '.$class.'>'.$data['user_first_name'].' '.$data['user_last_name'].'</option>';
		}
		return $user;
}

function getTitleforID($table,$field,$field_id,$value)
{
	$sql=parent::selectData($table,$field,"$field_id='".$value."'",1);
	return $sql[$field];
}

function getCategoryTitle($categoryId){
	return $this->getTitleforID(TABLE_CATEGORY,'category_name','category_id',$categoryId);
}
function getUsernameById($userId){
	$firstName = $this->getTitleforID(TABLE_USER,'user_first_name','user_id',$userId);
	$lastName = $this->getTitleforID(TABLE_USER,'user_last_name','user_id',$userId);
	$fullName = $firstName.' '.$lastName;
	return $fullName;
}

function getClassifiedCategorySelect($sel_val){
		$categoryDetails = parent::selectData(TABLE_CLASSIFIED_CATEGORY,"","classified_category_status='Active'");
		$category = "";
		while($data = mysql_fetch_array($categoryDetails)){
			$class="";
			if($sel_val == $data['classified_category_id']){
				$class = 'selected="selected"';
			}
			$category .= '<option value="'.$data['classified_category_id'].'" '.$class.'>'.$data['classified_category_name'].'</option>';
		}
		return $category;
}

function getClassifiedBoxsize($field_name , $sel_val ){
	$boxSizeDetails = parent::selectData(TABLE_CLASSIFIED_BOXSIZE,"","");
	$boxSize = "";
	while( $data = mysql_fetch_array($boxSizeDetails) ){
		$class = "";
		if($sel_val == $data['classified_boxsize_id']){
				$class = 'checked="checked"';
		}
		$boxSize .='<input type="radio" name="'.$field_name.'" value="'.$data['classified_boxsize_id'].'" '.$class.'>'.$data['classified_boxsize_name'];
	}
	return $boxSize;
}

function getDirectoryCategorySelect( $sel_val ){
	$categoryDetails = parent::selectData(TABLE_DIRECTORY_CATEGORY,"","directory_category_status='Active'");
		$category = "";
		while($data = mysql_fetch_array($categoryDetails)){
			$class="";
			if($sel_val == $data['directory_category_id']){
				$class = 'selected="selected"';
			}
			$category .= '<option value="'.$data['directory_category_id'].'" '.$class.'>'.$data['directory_category_name'].'</option>';
		}
		return $category;
}

function getAdvertisementCategorySelect( $sel_val ){
	$categoryDetails = parent::selectData(TABLE_ADVERTISEMENT_CATEGORY,"","advertisement_category_status='Active'");
		$category = "";
		while($data = mysql_fetch_array($categoryDetails)){
			$class="";
			if($sel_val == $data['advertisement_category_id']){
				$class = 'selected="selected"';
			}
			$category .= '<option value="'.$data['advertisement_category_id'].'" '.$class.'>'.$data['advertisement_category_name'].'</option>';
		}
		return $category;
}

function getImg($thumb=ENABLE_THUMB,$imgName="noimage.jpg",$path=GROUP_IMG,$alt="",$w="",$h="",$id="",$css="",$border=0,$exParam="",$displayIn="root")
	{
		if($displayIn=="root")
		$src='';
		if($displayIn=="admin")
		$src='../';
		$wt="";
		$ht="";
		if(empty($imgName))
		{
			$imgName="noimage.jpg";
		}
		if($thumb)
		{
			$src.='includes/thumb/phpThumb.php?&src=../'.$path.$imgName.$exParam;
			if($h)
			{
				$src.='&hp='.$h;
			}
			if($w)
			{
				$src.='&wl='.$w;
			}
		}
		else
		{
			$src.=$path.$imgName;
			$wt=" width='".$w."'";
			$ht=" height='".$h."'";
		}
		if($alt)
		{
			$alttxt=" alt='".$alt."' title='".$alt."'";
		}
		if($id)
		{
			$idTxt=" id='".$id."'";
		}
		if($css)
		{
			$cssTxt=" class='".$css."'";
		}
		$img='<img src="'.$src.'" border="'.$border.'" '.$wt.' '.$ht.' '.$alttxt.' '.$idTxt.' '.$cssTxt.'>';
		return $img;
	}
	
function getImageThumb($fol=IMAGES,$pic='',$title='',$class='',$width='50',$height='50',$path='')
	{
		if(is_file($path.$fol.$pic))
		{
			$img_string = '<img src="'.$path.'includes/thumb/phpThumb.php?src=../../'.$fol.$pic.'&amp;hp='.$height.'&amp;wl='.$width.'" alt="'.$title.'" class="'.$class.'" border="0">';
		}
		else
		{
			$fol=IMAGES;
			$pic=NOT_FOUND_IMG;
			$img_string = '<img src="'.$path.'includes/thumb/phpThumb.php?src=../../'.$fol.$pic.'&amp;hp='.$height.'&amp;wl='.$width.'" alt="'.$title.'" class="'.$class.'" border="0">';
		}
		return $img_string;
	}
	
	function get_menu_title($menuId)
	{
		if($menuId!=0)
		{
			$menuD = parent::selectData(TABLE_MENU,"","menu_id=" . $menuId."  and menu_status<>'Deleted'","1");
			return $menuD['menu_title'];
		}
		else
		{
			return "Root";
		}		
	}
	
	function build_menu_child($selval=0,$oldID=0,$depth=0)
	{
		$exclude=array();
		
		$child_query = parent::selectData(TABLE_MENU,"","menu_parent=" . $oldID."  and menu_status<>'Deleted'");

		while ( $child = mysql_fetch_array($child_query) )
		{
			if ( $child['menu_id'] != $child['menu_parent'] )
			{
				$space ="";
				for ( $c=0;$c<$depth;$c++ )
				{ 
					$space .= "--"; 
				}
				
				$selected="";
				if($selval==$child['menu_id']) $selected='selected';
				$tempTree .= "<option value='".$child['menu_id']."' ".$selected.">".$space.$child['menu_title'] . "</option>";
				
				$depth++; 
				if($this->get_menu_level($child['menu_id'])<=1)
				{
					//$tempTree .= $this->build_menu_child($selval,$child['menu_id'],$depth); 
				}	
				$depth--; 
				array_push($exclude, $child['menu_id']);
			}
		}
		return $tempTree;
	}
	
	function get_menu_level($menuId)
	{
		$level = 0;
		while($menuId)
		{
			$menuD = parent::selectData(TABLE_MENU,"","menu_id=" . $menuId."  and menu_status<>'Deleted'","1");
			$menuId = $menuD['menu_parent'];
			$level++;
		}	
		return $level;
	}
	
		function build_menu_tree($selval=0,$oldID=0,$depth=0,$sel=0)
	{
		$exclude=array();		
		$cl = 1;		
		$depthUsed = '';
		$child_query = parent::selectData(TABLE_MENU,"","menu_id>0 and menu_parent='".$oldID."' and menu_status='Active'");
		$totCount = mysql_num_rows($child_query);
		while ( $child = mysql_fetch_array($child_query) )
		{
			if ( $child['menu_id'] != $child['menu_parent'] )
			{
				if($cl==1)
				{
					if($oldID==0)
					{
						$tempTree .='<ul>';	
					}
					else
					{
						$tempTree .='<ul>';
					}
				}
				
				$selected="";
				if($selval==$child['menu_id']) $selected='selected';
				if($child['menu_title']!="")
				{
				
					$tempTree .= '<li><a href="'.FURL.'cms.php?menuId='.$child['menu_id'].'">'.$space.$child['menu_title'] . "</a>";		
			
				}
				if(!$this->has_menu_child($child['menu_id']))
				{
					$tempTree .='</li>';	
				}
				else
				{
					 $depth++; 
					$tempTree .= $this->build_menu_tree($selval,$child['menu_id'],$depth); 
					$tempTree .= "</li>";
				}
				if($totCount==$cl)
				{
					$tempTree .='</ul>';	
				}			
				
				$depth--; 
				array_push($exclude, $child['menu_id']);
				$cl++;
			}
		}
		return $tempTree;
	}
	
	
	function has_menu_child($parent)
	{
		$res=parent::selectData(TABLE_MENU,"","menu_id>0 and menu_parent=".$parent);
		$num = mysql_num_rows($res);
		if($num>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function countrySelect($selval){
		$res=parent::selectData(TABLE_COUNTRY,"","","","countries_name");
		$str='<option value="">Select a Country</option>';			
		while($row=mysql_fetch_array($res))
		{
			$str.="<option value='".$row['countries_id']."'";
			if($row['countries_id']==$selval)
			{
				$str.=' selected';
			}
			$str.=">".$row['countries_name']."</option>";
		}
		return $str;
	}

	function get_country($selval,$getval='countries_name'){
		$res=parent::selectData(TABLE_COUNTRY,"","countries_id='$selval'",1);
		if($res)
		{
			return $res[$getval];
		}
		else
		{
			return $selval;
		}	
	}
	
	function stateSelect($con,$selval){
		$res=parent::selectData(TABLE_STATE,"","country_id='".$con."'");
		$str='<option value="">Select a state</option>';			
		while($row=mysql_fetch_array($res))
		{
			$str.="<option value='".$row['state_id']."'";
			if($row['state_id']==$selval)
			{
				$str.=' selected';
			}
			$str.=">".$row['state_title']."</option>";
		}
		return $str;
	}
	
	
	function hasStates($con)
	{
		$res=parent::selectData(TABLE_STATE,"","state_status='Active' and country_id='".$con."'");
		$num = mysql_num_rows($res);
		if($num>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function get_state($selval,$getval='state_title'){
		$res=parent::selectData(TABLE_STATE,"","state_id='$selval'",1);
		if($res)
		{
			return $res[$getval];
		}
		else
		{
			return $selval;
		}	
	}
	
	
	
	function citySelect($st,$selval){
		$res=parent::selectData(TABLE_CITY,"","city_status='Active' and state_id='".$st."'","","city_title");
		$str='<option value="">Select a City</option>';			
		while($row=mysql_fetch_array($res))
		{
			$str.="<option value='".$row['city_id']."'";
			if($row['city_id']==$selval)
			{
				$str.=' selected';
			}
			$str.=">".$row['city_title']."</option>";
		}
		return $str;
	}
	function hasCities($st)
	{
		$res=parent::selectData(TABLE_CITY,"","city_status='Active' and state_id='".$st."'");
		$num = mysql_num_rows($res);
		if($num>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function orderStatusList($selval){
		$sql=parent::selectData(TABLE_ORDERSTATUS);
		$str="";
		while($row=mysql_fetch_array($sql))
			{
				$str.='<option value="'.$row[OrderStatus_ID].'" ';
				if($selval==$row[OrderStatus_ID]) $str.='selected';
				//if(empty($selval) && $row[OrderStatus_ID]==1) $str.='selected';
				$str.='>'.$row[OrderStatus_Name].'</option>';
			}
		return $str;
	}
	
	function selectContent($con,$selval){
		$res=parent::selectData(TABLE_CONTENT,"","");
		$str='<option value="">Select a Page</option>';			
		while($row=mysql_fetch_array($res))
		{
			$str.="<option value='".$row['content_id']."'";
			if($row['content_id']==$selval)
			{
				$str.=' selected';
			}
			$str.=">".$row['content_title']."</option>";
		}
		return $str;
	}
	
	function select_downloadType($selval)
	{
		$res=parent::selectData(TABLE_DOWNLOADTYPE,"","down_type_status='Active' ","","");
		while($row=mysql_fetch_array($res))
		{
			$str.="<option value='".$row['down_type_id']."'";
			if($row['down_type_id']==$selval)
			{
				$str.=' selected';
			}
			$str.=">".$row['down_type_name']."</option>";
		}
		return $str;
	}
	function get_downloadType($down_type_id)
	{
		$res=parent::selectData(TABLE_DOWNLOADTYPE,"","down_type_id='$down_type_id'",1);
		if($res)
		{
			return $res['down_type_name'];
		}
		
	}
	function get_product($prod_id)
	{
		$res=parent::selectData(TABLE_PRODUCT,"","prod_id='$prod_id'",1);
		if($res)
		{
			return $res['prod_title'];
		}
		
	}
	
	function select_type($selval)
	{
		$res=parent::selectData(TABLE_TYPE,"","type_status='Active' ","","");
		while($row=mysql_fetch_array($res))
		{
			$str.="<option value='".$row['type_id']."'";
			if($row['type_id']==$selval)
			{
				$str.=' selected';
			}
			$str.=">".$row['type']."</option>";
		}
		return $str;
	}
	function select_zip($pre_fix,$selval)
	{
	  $res=parent::selectData(TABLE_ZIP_CODE,"","state_prefix='".$pre_fix."'","","city asc");
	  while($row=mysql_fetch_array($res))
		{
			$str.="<option value='".$row['id']."'";
			if($row['id']==$selval)
			{
				$str.=' selected';
			}
			$str.=">".$row['city']." ( ".$row['zip_code']." ) "."</option>";
		}
		return $str;
	}
	function select_zip_city($pre_fix,$selval)
	{
	  $res=parent::selectData(TABLE_ZIP_CODE,"","state_prefix='".$pre_fix."' group by city","","city asc");
	  while($row=mysql_fetch_array($res))
		{
			$str.="<option value='".$row['id']."'";
			if($row['id']==$selval)
			{
				$str.=' selected';
			}
			$str.=">".$row['city']."</option>";
		}
		return $str;
	}
	
}
?>