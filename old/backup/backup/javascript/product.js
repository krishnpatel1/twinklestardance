function show_custom_quote(pid,output)
{
	$(document).ready(function(){
	// ////////////////////////
	if($("#loading").length==0)
	{
		$("body").append($('<div id="loading">Loading...</div>'));
		$("#loading").hide();
	}
	var loadObj=$("#loading");
	if($("#dialogMessage").length==0)
	{
		$("body").append($('<div id="dialogMessage"></div>'));
	}	
	$('#dialogMessage').dialog({
			autoOpen: false,
			show: 'blind',
			hide: 'blind',
			//modal: true,
			buttons: {
				OK: function() {
					$(this).dialog('close');
					$('#pageGuard').hide();
				}
			}
		});
	///////////////////////////
	var outputContainer = $(output);	
	$.ajax({
			url: "ajax_product_quote.php",
			type: "POST",
			data: {"pid": pid,"task": 'getAttributes'},
			timeout: 120000,
			dataType: "html",
			beforeSend: function(){
				$(loadObj).show();
			},
			
			error: function(request,error) {
				
			$(loadObj).show();
			$('#dialogMessage')
				.dialog( "option", "title", "Internal Error: ")
				.html(error)
				.dialog('open');
				
			},
			
			success: function(response){
				//outputContainer.html(response);
				document.getElementById("show_product_details").innerHTML = response;
				$(loadObj).show();
				calculateCost(null);
			}
	});
	
	});
		
}


function calculateCost(sender)
{
	
	var loadObj=$("#loading");
	$(loadObj).show();
	
	$('#pageGuard').show();
	
	pid=$("input[name=product_id]").val();
	attriblist=$(".dd_attrib_val");
	
	var parms=[];
	var optparms=[];
	$.each(attriblist, function() {
		aid=$(this).attr("attrib");
		costdependable=$(this).attr("costdependable");
		optional=$(this).attr("optional");
		
		v=$(this).val();
		if(v==null)
			v="0";
		p=aid +":" + v;
			
		if(costdependable=="1")
		{			
			parms.push(p);
		}
		else if(optional=="1")
		{
			optparms.push(p);
		}
		
	});
	costattr=parms.join(",");
	optattr=optparms.join(",");
	paramters="task=getPrice&pid=" + pid + "&costattr=" + costattr + "&optattr=" + optattr;
	//alert(paramters);
	$.ajax({ 
		type: "POST",
		url: "ajax_product_quote.php", 
		data: paramters, 
		timeout: 120000,
		dataType: "json",
		error: function(request,error) {
			$(loadObj).hide();
			$('#dialogMessage')
				.dialog( "option", "title", "Internal Error: ")
				.html(error)
				.dialog('open');
				
		},
		success: function(response){
			//alert(response);
			$(loadObj).hide();
			if(typeof(response.isError) != 'undefined')
			{
				if(response.isError)
				{
					error="";
					$.each(response.errorMessage, function() {
						error =error + this + "<br>\n";
					});
					$('#dialogMessage')
								.dialog( "option", "title", "Warning Message:")
								.html(error)
								.dialog('open');
				}
				else
				{
					$('#pageGuard').hide();
					var result=response.output;
					
					var amount=parseFloat(result.amount);
					var vat =parseFloat(result.vat);
					var tax =parseFloat(result.tax);
					var totalWithVat=parseFloat(amount + vat);
					
					var shipping=parseFloat(result.shipping);
					var shipping_vat=parseFloat(result.shipping_vat);
					var shippingWithVat=parseFloat(shipping_vat + shipping);
					
					payableAmount=parseFloat(totalWithVat + shippingWithVat);
					
					var workingday=parseFloat(result.workingday);
					//alert("Demo")
					$("#totalcost").html('').fadeOut("fast",function(){
						var totalDtl=$('<div class="divL">\
						  <h2>totale</h2>\
						</div>\
						<div class="divR"><span>'+amount.toFixed(2)+' &euro; +IVA </span></div>\
						<div class="divL">\
						  <h4>totale IVA ('+tax.toFixed(1)+'%) inclusa</h4>\
						</div>\
						<div class="divR">'+totalWithVat.toFixed(2)+' &euro;</div>\
						<div class="sidetext">\
						<b>Spedizione </b><input name="shipping" type="radio" value="1" checked onclick="click_shipping_option(this,'+payableAmount.toFixed(2)+');">S&igrave;\
						 <input name="shipping" type="radio" value="0"  onclick="click_shipping_option(this,'+totalWithVat.toFixed(2)+');">Non richiesta\
						</div>\
						<div class="divL shipping_opt">\
						  <h4>Spedizione ('+shipping.toFixed(2) +' &euro; +IVA)</h4>\
						</div>\
						<div class="divR shipping_opt">+'+shippingWithVat.toFixed(2)+' &euro;</div>\
						<div class="divL"><h2>Totale fattura</h2></div>\
						<div class="divR"><span id="payableamount">'+payableAmount.toFixed(2)+' &euro;</span><input name="hdPayableAmount" id="hdPayableAmount" type="hidden" value="'+payableAmount.toFixed(2)+'"/></div>\
						<div><h4>note:</h4></div>\
						<div class="div1">\
							<textarea name="notes" id="notes" rows="4" cols="30"></textarea>\
						  </div>\
						<div class="div1 flR">\
						<input name="btnupdate" type="submit" value="Acquista" class="button"  />\
						  </div>\
					 ').appendTo("#totalcost");
					 
					 $("input[name=btndndpdf]").click(function(){
						location.href='pdfquote.php';
						return false;
					});
					
					 $("#totalcost").fadeIn("fast");
					});
					
					
				}
			}
		}
	
	});	
	
	//set description of the attribute value 
	if(sender!=null)
	{
		aid=$(sender).attr("attrib");
		tag="#" +$(sender).attr("id") +" option:selected";
		
		var description="";
		var baseprice="";
		$(tag).each(function () {
                description=$(this).attr("info");
				baseprice=$(this).attr("price");
         });
		 $("#sv" +aid).fadeOut("slow",function(){
		 	$(this)
				.html(description)
				.fadeIn("slow");
		 });
		 
		 $("#svp" +aid).fadeOut("slow",function(){
		 	$(this)
				.html(baseprice)
				.fadeIn("slow");
		 });
		 
		
	}
	
}
function  click_shipping_option(rdo,amount)
{
	//alert(rdo.value);
	if(rdo.value=="1")
	{
		$("#payableamount").html(amount.toFixed(2) + ' &euro;');
		$("#hdPayableAmount").val(amount.toFixed(2));
		$(".shipping_opt").fadeIn();
	}
	else
	{
		
		$("#payableamount").html(amount.toFixed(2) + ' &euro;');
		$("#hdPayableAmount").val(amount.toFixed(2));
		$(".shipping_opt").fadeOut();
	}
	
	
}