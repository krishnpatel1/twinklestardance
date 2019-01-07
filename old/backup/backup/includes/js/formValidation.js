/*

 var frmvalidator = new formValidator("myform");
 frmvalidator.addValidation("FirstName","req","Please enter your First Name");
 frmvalidator.addValidation("FirstName","maxlen=20","Max length for FirstName is 20");
 frmvalidator.addValidation("FirstName","alpha");
 
 frmvalidator.addValidation("LastName","req");
 frmvalidator.addValidation("LastName","maxlen=20");
 
 frmvalidator.addValidation("Email","maxlen=50");
 frmvalidator.addValidation("Email","req");
 frmvalidator.addValidation("Email","email");

 frmvalidator.addValidation("Zip","maxlen=10");
 frmvalidator.addValidation("Zip","req");
 frmvalidator.addValidation("Zip","zip");

 frmvalidator.addValidation("Phone","maxlen=50");
 frmvalidator.addValidation("Phone","numeric");
 
 frmvalidator.addValidation("Address","maxlen=50");
 frmvalidator.addValidation("Country","dontselect=0");
 
 myformValidator.addValidation("LicProgram","selone","You must select at least one program!"); (radio)

 
*/


// whitespace characters
var whitespace = " \t\n\r";



/****************************************************************/

// Right trims the string...  Useful for SQL datatypes of CHAR

var defaultEmptyOK = false

function isDigit (c)
{   return ((c >= "0") && (c <= "9"))
}

function isInteger (s)

{   var i;

    if (isEmpty(s)) 
       if (isInteger.arguments.length == 1) return defaultEmptyOK;
       else return (isInteger.arguments[1] == true);

    // Search through string's characters one by one
    // until we find a non-numeric character.
    // When we do, return false; if we don't, return true.

    for (i = 0; i < s.length; i++)
    {   
        // Check that current character is number.
        var c = s.charAt(i);

        if (!isDigit(c)) return false;
    }

    // All characters are numbers.
    return true;
}

function RTrim(strTrim)
{
	var str = new String(strTrim);
	var i = 0;
	var c = "";
	var endpos = 0

	for (i = str.length; i >= 0 && endpos == 0; i = i - 1) {
		c = str.charAt(i);
		if (whitespace.indexOf(c) == -1)
			endpos = i;
	}

	return str.substring(0,endpos+1);
}


/****************************************************************/

// Check whether string s is empty.

function isEmpty(s)
{   return ((s == null) || (s.length == 0))
}

/****************************************************************/

// Returns true if string s is empty or 
// whitespace characters only.

function isWhitespace (s)

{   var i;

    // Is s empty?
    if (isEmpty(s)) return true;

    // Search through string's characters one by one
    // until we find a non-whitespace character.
    // When we do, return false; if we don't, return true.

    for (i = 0; i < s.length; i++)
    {   
	// Check that current character isn't whitespace.
	var c = s.charAt(i);

	if (whitespace.indexOf(c) == -1) return false;
    }

    // All characters are whitespace.
    return true;
}


function formValidator(frmname) {
    this.formobj=document.forms[frmname];
	if(!this.formobj)
	{
	  alert("BUG: couldnot get Form object "+frmname);
		return;
	}
	if(this.formobj.onsubmit)
	{
	 this.formobj.old_onsubmit = this.formobj.onsubmit;
	 this.formobj.onsubmit=null;
	}
	else
	{
	 this.formobj.old_onsubmit = null;
	}
	this.formobj.onsubmit=form_submit_handler;
	this.addValidation = add_validation;
	this.setAddnlValidationFunction=set_addnl_vfunction;
	this.clearAllValidations = clear_all_validations;
}

function set_addnl_vfunction(functionname)
{
  this.formobj.addnlvalidation = functionname;
}

function clear_all_validations()
{
	for(var itr=0;itr < this.formobj.elements.length;itr++)
	{
		this.formobj.elements[itr].validationset = null;
	}
}

function form_submit_handler() {
	for(var itr=0;itr < this.elements.length;itr++) {
		if(this.elements[itr].validationset && !this.elements[itr].validationset.validate()) {
		  return false;
		}
	}
	
	if(this.addnlvalidation) {
	  str =" var ret = "+this.addnlvalidation+"()";
	  //alert(str);
	  eval(str);
      if(!ret) return ret;
	}
	return true;
}

function add_validation(itemname,descriptor,errstr)
{
	if(!this.formobj) {
		alert("BUG: the form object is not set properly");
		return;
	}//if
	
	var itemobj = this.formobj[itemname];

	//for radio button; don't do for 'select' item
    if(itemobj.length && isNaN(itemobj.selectedIndex)) {
		itemobj = itemobj[0];
	}	
	
	if(!itemobj){
		alert("BUG: Couldnot get the input object named: "+itemname);
		return;
	}
	
	if(!itemobj.validationset) {
		itemobj.validationset = new ValidationSet(itemobj);
	}
	
	itemobj.validationset.add(descriptor,errstr);
}

function ValidationDesc(inputitem,desc,error) {
    this.desc=desc;
	this.error=error;
	this.itemobj = inputitem;
	this.validate=vdesc_validate;
}

function vdesc_validate() {
 if(!validateInput(this.desc,this.itemobj,this.error)) {
    this.itemobj.focus();
		return false;
 }
 return true;
}

function ValidationSet(inputitem) {
    this.vSet=new Array();
	this.add = add_validationdesc;
	this.validate= vset_validate;
	this.itemobj = inputitem;
}

function add_validationdesc(desc,error) {
  this.vSet[this.vSet.length]= new ValidationDesc(this.itemobj,desc,error);
}

function vset_validate() {
   for(var itr=0;itr<this.vSet.length;itr++) {
	   if(!this.vSet[itr].validate()) {
		   return false;
		 }
	 }
	 return true;
}

/*  checks the validity of an email address entered 
*   returns true or false 
*/ 

function validateEmail(email) {
    var splitted = email.match("^(.+)@(.+)$");
    if(splitted == null) return false;
    if(splitted[1] != null )
    {
      var regexp_user=/^\"?[\w-_\.]*\"?$/;
      if(splitted[1].match(regexp_user) == null) return false;
    }
    if(splitted[2] != null)
    {
      var regexp_domain=/^[\w-\.]*\.[A-Za-z]{2,4}$/;
      if(splitted[2].match(regexp_domain) == null) 
      {
	    var regexp_ip =/^\[\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\]$/;
	    if(splitted[2].match(regexp_ip) == null) return false;
      }// if
      return true;
    }
return false;
}

// This function determines if the string passed in is a valid
// US zip code.  It accepts either ##### or #####-####.  If the
// string is valid, it returns true, else false.

function isZipcode(strZip)
{
	var s = new String(strZip);

	if (s.length != 5 && s.length != 10)
		// inappropriate length
		return false;


	for (var i=0; i < s.length; i++)
		if ((s.charAt(i) < '0' || s.charAt(s) > '9') && s.charAt(i) != '-')
			return false;

	return true;
}


function TestComparison(objValue,strCompareElement,strvalidator,strError) {
   var bRet=true;
   var objCompare=null;
   if(!objValue.form)
   {
      alert("BUG: No Form object!");
	  return false
   }
   objCompare = objValue.form.elements[strCompareElement];
   if(!objCompare)
   {
     alert("BUG: Element with name"+strCompareElement+" not found !");
     return false;
   }
   if(strvalidator != "eqelmnt")
   {
      if(isNaN(objValue.value)) 
      { 
        alert(objValue.name+": Should be a number "); 
        return false; 
      }//if 
      if(isNaN(objCompare.value)) 
      { 
        alert(objCompare.name+": Should be a number "); 
        return false; 
      }//if 	  
   }//if
   var cmpstr="";
   switch(strvalidator)
   {
       case "eqelmnt": 
			{
			   if(objValue.value != objCompare.value)
			   {
 	 		      cmpstr = " should be equal to ";
			      bRet = false;
			   }//if
			   break;
			}//case
		case "ltelmnt":
			{
			if(eval(objValue.value) >= eval(objCompare.value)) 
				{
			       cmpstr =  " should be less than "; 
			       bRet = false;					
				}
			  break;
			}//case
		case "leelmnt":
			{
				if(eval(objValue.value) >  eval(objCompare.value)) 
				{
			       cmpstr =  " should be less than or equal to"; 
			       bRet = false;					
				}
			  break;
			}//case		
		case "gtelmnt":
			{
				if(eval(objValue.value) <=  eval(objCompare.value)) 
				{
			       cmpstr =  " should be greater than"; 
			       bRet = false;					
				}
			  break;
			}//case
		case "geelmnt":
			{
				if(eval(objValue.value) < eval(objCompare.value)) 
				{
			       cmpstr =  " should be greater than or equal to"; 
			       bRet = false;					
				}
			  break;
			}//case
   }//switch
   if(bRet==false) {
      if(!strError || strError.length==0) {
	    strError = objValue.name + cmpstr + objCompare.value; 
	  }//if
	  alert(strError);
   }//if
   return bRet;
}

function TestSelMin(objValue,strMinSel,strError) {
    var bret = true;
	var objcheck = objValue.form.elements[objValue.name];
	var chkcount =0;
	if(objcheck.length)
	{
		for(var c=0;c < objcheck.length;c++)
		{
		   if(objcheck[c].checked == "1")
		   {
		     chkcount++;
		   }//if
		}//for
	}
	else
	{
	  chkcount = (objcheck.checked == "1")?1:0;
	}
	var minsel = eval(strMinSel);
	if(chkcount < minsel)
	{
		if(!strError || strError.length ==0) 
		{ 
			strError = "Please Select atleast"+minsel+" check boxes for"+objValue.name;  
		}//if                                                               
		alert(strError); 
		bret = false;
	}
	return bret;
}

function TestDontSelectChk(objValue,chkValue,strError)
{
    var pass=true;
	var objcheck = objValue.form.elements[objValue.name];
    if(objcheck.length)
	{
		var idxchk=-1;
		for(var c=0;c < objcheck.length;c++)
		{
		   if(objcheck[c].value == chkValue)
		   {
		     idxchk=c;
			 break;
		   }//if
		}//for
		if(idxchk>= 0)
		{
		  if(objcheck[idxchk].checked=="1")
		  {
		    pass=false;
		  }
		}//if
	}
	else
	{
		if(objValue.checked == "1")
		{
			pass=false;
		}//if
	}//else
	if(pass==false)
	{
     if(!strError || strError.length ==0) 
        { 
        	strError = "Can't Proceed as you selected "+objValue.name;  
        }//if			  
	  alert(strError);
	  
	}
    return pass;
}

function TestRequiredInput(objValue,strError)
{
 var ret = true;
    if(eval(objValue.value.length) == 0 || isWhitespace(objValue.value)) { 
       if(!strError || strError.length ==0) { 
         strError = objValue.name + " : Required Field"; 
       }//if 
       alert(strError); 
       ret=false; 
    }//if 
return ret;
}

function TestMaxLen(objValue,strMaxLen,strError)
{
 var ret = true;
    if(eval(objValue.value.length) > eval(strMaxLen)) 
    { 
      if(!strError || strError.length ==0) 
      { 
        strError = objValue.name + " : "+ strMaxLen +" characters maximum "; 
      }//if 
      alert(strError + "\n[Current length = " + objValue.value.length + " ]"); 
      ret = false; 
    }//if 
return ret;
}

function TestMinLen(objValue,strMinLen,strError)
{
 var ret = true;
    if(eval(objValue.value.length) <  eval(strMinLen)) 
    { 
      if(!strError || strError.length ==0) 
      { 
        strError = objValue.name + " : " + strMinLen + " characters minimum  "; 
      }//if               
      alert(strError + "\n[Current length = " + objValue.value.length + " ]"); 
      ret = false;   
    }//if 
return ret;
}

function TestInputType(objValue,strRegExp,strError,strDefaultError)
{
   var ret = true;

    var charpos = objValue.value.search(strRegExp); 
    if(objValue.value.length > 0 &&  charpos >= 0) 
    { 
     if(!strError || strError.length ==0) 
      { 
        strError = strDefaultError;
      }//if 
      alert(strError + "\n [Error character position " + eval(charpos+1)+"]"); 
      ret = false; 
    }//if 
 return ret;
}

function TestEmail(objValue,strError)
{
var ret = true;
     if(!validateEmail(objValue.value)) 
     { 
       if(!strError || strError.length ==0) 
       { 
          strError = objValue.name+": Enter a valid Email address "; 
       }//if                                               
       alert(strError); 
       ret = false; 
     }//if 
return ret;
}

function TestZip(objValue,strError)
{
var ret = true;
     if(!isZipcode(objValue.value)) 
     { 
       if(!strError || strError.length ==0) 
       { 
          strError = objValue.name+": Enter a valid Zip code "; 
       }//if                                               
       alert(strError); 
       ret = false; 
     }//if 
return ret;
}

function TestLessThan(objValue,strLessThan,strError)
{
var ret = true;
	  if(isNaN(objValue.value)) 
	  { 
	    alert(objValue.name+": Should be a number "); 
	    ret = false; 
	  }//if 
	  else
	  if(eval(objValue.value) >=  eval(strLessThan)) 
	  { 
	    if(!strError || strError.length ==0) 
	    { 
	      strError = objValue.name + " : value should be less than "+ strLessThan; 
	    }//if               
	    alert(strError); 
	    ret = false;                 
	   }//if   
return ret;          
}

function TestGreaterThan(objValue,strGreaterThan,strError)
{
var ret = true;
     if(isNaN(objValue.value)) 
     { 
       alert(objValue.name+": Should be a number "); 
       ret = false; 
     }//if 
	 else
     if(eval(objValue.value) <=  eval(strGreaterThan)) 
      { 
        if(!strError || strError.length ==0) 
        { 
          strError = objValue.name + " : value should be greater than "+ strGreaterThan; 
        }//if               
        alert(strError); 
        ret = false;
      }//if  
return ret;           
}

function TestRegExp(objValue,strRegExp,strError)
{
var ret = true;
    if(!objValue.value.match(strRegExp)) 
    { 
      if(!strError || strError.length ==0) 
      { 
        strError = objValue.name+": Invalid characters found "; 
      }//if                                                               
      alert(strError); 
      ret = false;                   
    }//if 
return ret;
}
function TestDontSelect(objValue,index,strError)
{
var ret = true;
     if(objValue.selectedIndex == null) 
     { 
       alert("BUG: dontselect command for non-select Item"); 
       ret = false; 
     } 
	 else
     if(objValue.selectedIndex == eval(index)) 
     { 
      if(!strError || strError.length ==0) 
       { 
       strError = objValue.name+": Please Select one option "; 
       }//if                                                               
       alert(strError); 
       ret =  false;                                   
      } 
return ret;
}

function TestSelectOneRadio(objValue,strError)
{
	var objradio = objValue.form.elements[objValue.name];
	var one_selected=false;
	for(var r=0;r < objradio.length;r++)
	{
	  if(objradio[r].checked == "1")
	  {
	  	one_selected=true;
		break;
	  }
	}
	if(false == one_selected)
	{
      if(!strError || strError.length ==0) 
       {
	    strError = "Please select one option from "+objValue.name;
	   }	
	  alert(strError);
	}
return one_selected;
}

//*  Checks each field in a form 
function validateInput(strValidateStr,objValue,strError) 
{ 
    var ret = true;
    var epos = strValidateStr.search("="); 
    var  command  = ""; 
    var  cmdvalue = ""; 
    if(epos >= 0) 
    { 
     command  = strValidateStr.substring(0,epos); 
     cmdvalue = strValidateStr.substr(epos+1); 
    } 
    else 
    { 
     command = strValidateStr; 
    } 

    switch(command) 
    { 
        case "req": 
        case "required": 
         { 
		   ret = TestRequiredInput(objValue,strError)
           break;             
         }
        case "maxlength": 
        case "maxlen": 
          { 
			 ret = TestMaxLen(objValue,cmdvalue,strError)
             break; 
          }
        case "minlength": 
        case "minlen": 
           { 
			 ret = TestMinLen(objValue,cmdvalue,strError)
             break; 
           }
        case "alnum": 
        case "alphanumeric": 
           { 
				ret = TestInputType(objValue,"[^A-Za-z0-9]",strError, 
						objValue.name+": Only alpha-numeric characters allowed ");
				break; 
           }
        case "alnum_s": 
        case "alphanumeric_space": 
           { 
				ret = TestInputType(objValue,"[^A-Za-z0-9\\s]",strError, 
						objValue.name+": Only alpha-numeric characters and space allowed ");
				break; 
           }		   
        case "num": 
        case "numeric": 
           { 
                ret = TestInputType(objValue,"[^0-9]",strError, 
						objValue.name+": Only digits allowed ");
                break;               
           }
        case "alphabetic": 
        case "alpha": 
           { 
                ret = TestInputType(objValue,"[^A-Za-z]",strError, 
						objValue.name+": Only alphabetic characters allowed ");
                break; 
           }
        case "alphabetic_space": 
        case "alpha_s": 
           { 
                ret = TestInputType(objValue,"[^A-Za-z\\s]",strError, 
						objValue.name+": Only alphabetic characters and space allowed ");
                break; 
           }
        case "email": 
          { 
			   ret = TestEmail(objValue,strError);
               break; 
          }
        case "zip": { 
			   ret = TestZip(objValue,strError);
               break; 
        }
        case "lt": 
        case "lessthan": 
         { 
    	      ret = TestLessThan(objValue,cmdvalue,strError);
              break; 
         }
        case "gt": 
        case "greaterthan": 
         { 
			ret = TestGreaterThan(objValue,cmdvalue,strError);
            break; 
         }
        case "regexp": 
         { 
			ret = TestRegExp(objValue,cmdvalue,strError);
           break; 
         }
        case "dontselect": 
         { 
			 ret = TestDontSelect(objValue,cmdvalue,strError)
             break; 
         }
		case "dontselectchk":
		{
			ret = TestDontSelectChk(objValue,cmdvalue,strError)
			break;
		}
		case "selmin":
		{
			ret = TestSelMin(objValue,cmdvalue,strError);
			break;
		}
		case "selone":
		{
			ret = TestSelectOneRadio(objValue,strError);
		    break;
		}		 
		//Comparisons
		case "eqelmnt": 
		case "ltelmnt":
		case "leelmnt":
		case "gtelmnt":
		case "geelmnt":
		{
		    return TestComparison(objValue,cmdvalue,command,strError);
    		break;
		}
    }//switch 
    return ret; 
}

function validateSpChar(data)
{
	var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?~_"; 
	   for (var i = 0; i < data.length; i++) {
		if (iChars.indexOf(data.charAt(i)) != -1) {
		return false;
		}
	  }
	return true;  
}
function isValidCreditCard(type, ccnum) {
   if (type == "VisaCard") {
      // Visa: length 16, prefix 4, dashes optional.
      var re = /^4\d{3}-?\d{4}-?\d{4}-?\d{4}$/;
   } else if (type == "MasterCard") {
      // Mastercard: length 16, prefix 51-55, dashes optional.
      var re = /^5[1-5]\d{2}-?\d{4}-?\d{4}-?\d{4}$/;
   } else if (type == "DiscoverCard") {
      // Discover: length 16, prefix 6011, dashes optional.
      var re = /^6011-?\d{4}-?\d{4}-?\d{4}$/;
   } else if (type == "AmExCard") {
      // American Express: length 15, prefix 34 or 37.
      var re = /^3[4,7]\d{13}$/;
   } else if (type == "DinersClubCard") {
      // Diners: length 14, prefix 30, 36, or 38.
      var re = /^3[0,6,8]\d{12}$/;
   }
   if (!re.test(ccnum)) return false;
   // Remove all dashes for the checksum checks to eliminate negative numbers
   ccnum = ccnum.split("-").join("");
   // Checksum ("Mod 10")
   // Add even digits in even length strings or odd digits in odd length strings.
   var checksum = 0;
   for (var i=(2-(ccnum.length % 2)); i<=ccnum.length; i+=2) {
      checksum += parseInt(ccnum.charAt(i-1));
   }
   // Analyze odd digits in even length strings or even digits in odd length strings.
   for (var i=(ccnum.length % 2) + 1; i<ccnum.length; i+=2) {
      var digit = parseInt(ccnum.charAt(i-1)) * 2;
      if (digit < 10) { checksum += digit; } else { checksum += (digit-9); }
   }
   if ((checksum % 10) == 0) return true; else return false;
}
function validateCreditCard(ccnum) {
	// Remove all dashes for the checksum checks to eliminate negative numbers
   ccnum = ccnum.split("-").join("");
   // Checksum ("Mod 10")
   // Add even digits in even length strings or odd digits in odd length strings.
   var checksum = 0;
   for (var i=(2-(ccnum.length % 2)); i<=ccnum.length; i+=2) {
      checksum += parseInt(ccnum.charAt(i-1));
   }
   // Analyze odd digits in even length strings or even digits in odd length strings.
   for (var i=(ccnum.length % 2) + 1; i<ccnum.length; i+=2) {
      var digit = parseInt(ccnum.charAt(i-1)) * 2;
      if (digit < 10) { checksum += digit; } else { checksum += (digit-9); }
   }
   if ((checksum % 10) == 0)
   {
	   	var Visa = /^4\d{3}-?\d{4}-?\d{4}-?\d{4}$/;
		var Master = /^5[1-5]\d{2}-?\d{4}-?\d{4}-?\d{4}$/;
		var Discover = /^6011-?\d{4}-?\d{4}-?\d{4}$/;
		var AmEx = /^3[4,7]\d{13}$/;
		var DinersClub = /^3[0,6,8]\d{12}$/;     
		if (Visa.test(ccnum)){
			return 'Visa';
		}
		else if(Master.test(ccnum)){
			return 'MasterCard';
		}
		else if(Discover.test(ccnum)){
			return 'Discover';
		}
		else if(AmEx.test(ccnum)){
			return 'Amex';
		}
		else if(DinersClub.test(ccnum)){
			return 'DinersClub';
		}
		else{
			return false;	
		}
   }
   else{
	return false;
   }
}
function IsUSPhoneNumber(objdata,message)
{
	/*IsUSPhoneNumber(objdata,separator,firstL,secondL,thirdL,message)
	var value		= objdata.value;
	var valArr		= value.split(separator);
	var digit		= "99999";
	var errMessage	= "[Ex: " + digit.substr(0,firstL) + "-" + digit.substr(0,secondL) + "-" + digit.substr(0,thirdL) + "]";
	if (valArr.length == 3)
	{
		//
		var IsNo = 1;
		if ( valArr[0].length == firstL && valArr[1].length == secondL && valArr[2].length == thirdL)
		{
			if ( isNaN(valArr[0]) ) IsNo = 0;
			if ( isNaN(valArr[1]) ) IsNo = 0;
			if ( isNaN(valArr[2]) ) IsNo = 0;
			
			if ( IsNo == 0 )
			{
				alert("Please enter a valid data " + message + "\n" + errMessage);
				return false;
			}
		}
		else
		{
			alert("Please enter valid " + message + "\n" + errMessage);
			return false;
		}
	}
	else
	{
		alert("Please enter valid " + message + "\n" + errMessage);
		return false;
	}
	
return true;*/


    if(!(/^\d{3}-\d{3}-\d{4}$/).test(objdata.value))
    {
        alert("Please enter valid " + message + "\n" + "[Ex: 999-999-9999]");
        return false;
    }
    else
        return true;

}

function isAlphanumeric(alphane)
{
	var numaric = alphane;
	for(var j=0; j<numaric.length; j++)
		{
			  var alphaa = numaric.charAt(j);
			  var hh = alphaa.charCodeAt(0);
			  if((hh > 47 && hh<58) || (hh > 64 && hh<91) || (hh > 96 && hh<123))
			  {
				  return false;
			  }
			  else	
			  {
			     return true;
			  }
 		}
		
return false;
}

