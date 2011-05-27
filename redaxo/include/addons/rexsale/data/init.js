Behaviour.addLoadEvent 
(	function()
	{	// Product variants
		// If the product has no variants, display the first value box
		if (document.getElementById('optionsbox'))
		{	x=document.getElementById('optionsbox');
			if (document.getElementById('values'+x.value).style.display=="none")
			{	document.getElementById('values'+x.value).style.display="block";
			}
		}
	}
);


var Rules = {
	'.picchanger select' : function(el)
	{	el.onchange = function()
		{	
			preview=el.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.getElementsByTagName('TD')[4];
			preview=preview.getElementsByTagName('DIV')[0];
			
			preview.innerHTML='<img src="../index.php?rex_resize=100w__'+el.value+'" alt="" />';
		}
	},
	'#varoptions' : function(el)
	{	el.onclick = function()
		{	tables=document.getElementById('valuescol').getElementsByTagName('TABLE');
			
			
			for(i=0;i<tables.length;i++)
			{	tables[i].style.display="none";
				tables[i].getElementsByTagName('SELECT')[0].selectedIndex=-1;
				if (tables[i].getAttribute('id')=="values"+this.value)
				{	if (document.attachEvent)
					{	tables[i].style.display="block";
					}
					else
					{	tables[i].style.display="table";
					}
					tables[i].getElementsByTagName('SELECT')[0].selectedIndex=0;
				}
			}
			

		}
	},
	'#variantframe #optionsbox' : function(el)
	{	el.onchange = function()
		{	thevariants=document.getElementById('variants').getElementsByTagName('SELECT');
			
			for(i=0;i<thevariants.length;i++)
			{	thevariants[i].selectedIndex=-1;
				thevariants[i].style.display="none";
				if (thevariants[i].getAttribute('id')=="values"+this.value)
				{	thevariants[i].style.display="block";
					thevariants[i].selectedIndex=0;
				}
				
			}
			
		}
	}
	
};


function newOptionName(x)
{	
	if (document.getElementById('varoptions').value!="")
	{ 	
		opts=document.getElementById('varoptions').options;
		text="";
		for (i=0;i<opts.length;i++)
		{	if (opts[i].selected)
			{	text=opts[i].text;
			}
		}
	
		newName=prompt(x,text);
		if (newName!=null && newName!="")
		{	document.getElementById('mode').value="renOption";
			document.getElementById('modevalue').value=newName;
			document.getElementById('variantform').submit();
		}
		else
		{	document.getElementById('mode').value="";
			document.getElementById('modevalue').value="";
		}
	}
}


function newValueName(x,y)
{	
	if (document.getElementById('values'+y).value!="")
	{ 	
		opts=document.getElementById('svalues'+y).options;
		text="";
		for (i=0;i<opts.length;i++)
		{	if (opts[i].selected)
			{	text=opts[i].text;
			}
		}
	
		newName=prompt(x,text);
	
		if (newName!=null && newName!="")
		{	document.getElementById('mode').value="renValue";
			document.getElementById('modevalue').value=newName;
			document.getElementById('variantform').submit();
		}
		else
		{	document.getElementById('mode').value="";
			document.getElementById('modevalue').value="";
		}
	}
}

Behaviour.register(Rules);
