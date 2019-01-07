<?php //echo CHtml::cssFile(Yii::app()->theme->baseUrl.'/css/slAjaxTabs.css');
$cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery');
$cs->registerCssFile(Yii::app()->baseUrl.'/css/slAjaxTabs.css');
?>
<div id="tabsJ">
<ul>
<?php foreach($tabs as $i=>$tab){
	echo '<li><a id="tabJ'.($i+1).'" href="#"><span>'.$tab['title'].'</span></a></li>';
} ?>
</ul>
</div>
<div id="preloader">
<?php echo CHtml::image(Yii::app()->baseUrl.'/images/loading.gif') ?>Loading</div>
<div id="tabcontent"></div>
<script type="text/javascript">
var pageUrl = new Array();	
<?php foreach($tabs as $i=>$tab){		
echo 'pageUrl['.($i+1).'] ="'.CHtml::normalizeUrl(array($tab['url'])).'";' ;		
} ?>
function loadTab(id){
	if (pageUrl[id].length > 0){ 
		$("#preloader").show();
		$.ajax({
			url: pageUrl[id], 
			cache: false,
			success: function(message){			            	
				$("#tabcontent").empty().append(message);
				$("#preloader").hide();             
			}
		});			        
	}
}
$(document).ready(function(){
	$("#preloader").hide(); 
<?php foreach($tabs as $i=>$tab){	
	echo '$("#tabJ'.($i+1).'").click(function(){';
	echo '$(".selected").removeClass("selected");';
	echo '$("#tabJ'.($i+1).'").toggleClass("selected");';
	echo 'loadTab('.($i+1).');';
	echo '});';	
} 
	if(count($tabs)>0){
		echo '$("#tabJ1").click();';
	}
?>
});
</script>
