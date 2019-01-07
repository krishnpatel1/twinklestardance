$(document).ready(function(){
$(".pop").on("click", function(e){
   e.preventDefault();					 
   $("#overlay").show();	
   var src = $(this).attr("href");
   $("#popup").load(src);
   $("#popup").fadeIn(500);
   return false;
});
$("#overlay").click(function(){
	$(this).hide();
	$("#popup").hide();
});
$(".close").click(function(){
						   alert("hh");
	$("#overlay").hide();
	$("#popup").hide();
});
});