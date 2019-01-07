<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" >
<link href="css/style.css" type="text/css" rel="stylesheet" />
<!--<link href="css/slide.css" type="text/css" rel="stylesheet" />
<script src="js/jquery-1.4.1.min.js" type="text/javascript"></script>
<script src="js/jquery-1.4.1.min.js" type="text/javascript"></script>
<script src="javascript/jquery.validate.js"></script>
<script src="js/jquery.easing.1.2.js" type="text/javascript"></script>
<script src="js/jquery.slideviewer.1.2.js" type="text/javascript"></script>

<script type="text/javascript">
	$(window).bind("load", function() {
	$("div#mygalone").slideView()
	});
</script>-->
<link rel="stylesheet" href="css/slideshow.css" type="text/css" />
<script type="text/javascript">var _siteRoot='index.html',_root='index.html';</script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script type="text/javascript">
function getCreditCardType(accountNumber){
  var result = "unknown";
  if (/^5[1-5]\d{2}-?\d{4}-?\d{4}-?\d{4}$/.test(accountNumber)) {
    result = "mastercard";
  }
  else if (/^4\d{3}-?\d{4}-?\d{4}-?\d{4}$/.test(accountNumber)){
    result = "visa";
  }
  else if (/^3[47]\d{13}$/.test(accountNumber)){
    result = "amex";
  }
  jQuery("#order_card_type").val(result);
}
</script>

<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-31951695-1']);
_gaq.push(['_trackPageview']);
(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>

<link rel="stylesheet" type="text/css" href="js/shadowbox/shadowbox.css"/>
<script type="text/javascript" src="js/shadowbox/shadowbox.js"></script>

<script type="text/javascript">
Shadowbox.init();

function popup(url) 
{
 var width  = 620;
 var height = 710;
 var left   = 0;
 var top    = 0;
 var params = 'width='+width+', height='+height;
 params += ', top='+top+', left='+left;
 params += ', directories=no';
 params += ', location=no';
 params += ', menubar=no';
 params += ', resizable=no';
 params += ', scrollbars=yes';
 params += ', status=no';
 params += ', toolbar=no';
 newwin=window.open(url,'windowname5', params);
 if (window.focus) {newwin.focus()}
 return false;
}
</script>

