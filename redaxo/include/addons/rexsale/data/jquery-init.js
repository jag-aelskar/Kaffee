var rexsale_ajax_cat_sortstr = "null";
var rexsale_ajax_prod_sortstr = "null";

function rexsale_cat_stopDrag()
{	$('#rexsale_table_cats tbody').sortable("destroy");
	
	
		var x = new Array();
	
		setTimeout( function()
			{
				$("#rexsale_table_cats td.rexsaleID").each(function (i)
				{	x[i]=$(this);
				});
				
			
				/* serialize, because the jquery serialize() doesn't do what we need in this case */
				var str = "";
				for (i=0;i<x.length;i++)
				{	str = str + x[i].attr('id')+'~~';
				}
							
				if (rexsale_ajax_cat_sortstr != str)
				{	$("#rexsale_table_cats .ajaxstatus").css('backgroundImage','url(index.php?page=rexsale&load=ajax.gif)');
					$("#rexsale_table_cats .ajaxstatus").css('background-repeat','no-repeat');
					$("#rexsale_table_cats .ajaxstatus").css('background-position','center center');
					
					$.post(window.location.href, { jqueryAjax: "resort", order: str, what: 'cats' },
					function(data)
					{	setTimeout(function()
							{	$("#rexsale_table_cats .ajaxstatus").css('backgroundImage','url()');
							},1000);
					});
				}
				rexsale_ajax_cat_sortstr = str;
  			},500);
}




function rexsale_prod_stopDrag()
{	$('#rexsale_table_prods tbody').sortable("destroy");
	
	
		var x = new Array();
	
		setTimeout( function()
			{
				$("#rexsale_table_prods td.rexsaleID").each(function (i)
				{	x[i]=$(this);
				});
			
				/* serialize, because the jquery serialize() doesn't do what we need in this case */
				var str = "";
				for (i=0;i<x.length;i++)
				{	str = str + x[i].attr('id')+'~~';
				}
											
				if (rexsale_ajax_prod_sortstr != str)
				{	$("#rexsale_table_prods .ajaxstatus").css('backgroundImage','url(index.php?page=rexsale&load=ajax.gif)');
					$("#rexsale_table_prods .ajaxstatus").css('background-repeat','no-repeat');
					$("#rexsale_table_prods .ajaxstatus").css('background-position','center center');
					
					$.post(window.location.href, { jqueryAjax: "resort", order: str, what: 'prods' },
					function(data)
					{	setTimeout(function()
							{	$("#rexsale_table_prods .ajaxstatus").css('backgroundImage','url()');
							},1000);
					});
				}
				rexsale_ajax_prod_sortstr = str;
  			},500);
}



$(document).ready(function()
{
	$("#rexsale_table_cats a.sortlink").mousedown(function ()
	{	$('#rexsale_table_cats tbody').sortable(
											{	stop: rexsale_cat_stopDrag }
										);
	});
	

	$("#rexsale_table_prods a.sortlink").mousedown(function ()
	{	$('#rexsale_table_prods tbody').sortable(
											{	stop: rexsale_prod_stopDrag }
										);
	});
	

});