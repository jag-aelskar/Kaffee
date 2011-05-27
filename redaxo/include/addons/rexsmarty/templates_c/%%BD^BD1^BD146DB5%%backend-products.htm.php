<?php /* Smarty version 2.6.18, created on 2011-05-18 19:18:51
         compiled from backend-products.htm */ ?>
<div id="page-products">
	<form action="?page=rexsale&subpage=inventory" method="post">
	
	
	<?php if ($_REQUEST['editProd'] != ""): ?>
	<?php $_from = $this->_tpl_vars['products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
	<?php if ($this->_tpl_vars['item']['id'] == $_REQUEST['editProd']): ?>
	
		
	<table cellspacing="1" cellpadding="4" border="0" class="rex-table rex-table-mrgn">

			<tr><th colspan="2"><?php echo $this->_tpl_vars['lang']['editProduct']; ?>
</th></tr>

			<!-- Ugly nested tables to make things look nice -->
			<tr>
			
				<td valign="top" style="width:50%;">
					<table>
						<tr><th colspan="2"><?php echo $this->_tpl_vars['lang']['peStandard']; ?>
</th></tr>
						
						
						<tr>
							<th width="100"><?php echo $this->_tpl_vars['lang']['peName']; ?>
</th><td><input type="text" class="text" name="data[name]" value="<?php echo $this->_tpl_vars['item']['name']; ?>
" /></td>
						</tr>
								
						<tr>
							<th><?php echo $this->_tpl_vars['lang']['peTax']; ?>
</th>
							<td>
								<select name="data[tax]" id="tax" onchange="recalcPrice()">
									<?php $_from = $this->_tpl_vars['taxes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['taxkey'] => $this->_tpl_vars['taxitem']):
?>
										<option value="<?php echo $this->_tpl_vars['taxkey']; ?>
"<?php if ($this->_tpl_vars['item']['taxid'] == $this->_tpl_vars['taxkey']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['taxitem']['name']; ?>
</option>
									<?php endforeach; endif; unset($_from); ?>
								</select>
								
								<script type="text/javascript">
									taxes = new Array();
								<?php $_from = $this->_tpl_vars['taxes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['taxkey'] => $this->_tpl_vars['taxitem']):
?>
									taxes[<?php echo $this->_tpl_vars['taxkey']; ?>
]=<?php echo $this->_tpl_vars['taxitem']['amount']; ?>
;
								<?php endforeach; endif; unset($_from); ?>
								
									nettoString="<?php echo $this->_tpl_vars['lang']['pePriceNetto']; ?>
";
									
								
									<?php echo '
									function recalcPrice(brutto)
									{	netto=document.getElementById(\'nettoPrice\');
										nettoTag=document.getElementById(\'nettoPriceTag\');
										tax=document.getElementById(\'tax\');
										amt=(taxes[tax.value]+1)*100;
										
										if (!brutto)
										{	// Calculate from netto value
											
																			
											brutto=netto.value*(amt/100);
											brutto=Math.round(brutto*100)/100;
											document.getElementById(\'bruttoPrice\').value=brutto;
											
											if (netto.value==0)
											{	netto.value=0;
											}
											else
											{	recalcPrice(brutto);
											}
											
										}
										else
										{	// Calculate from brutto value
											brutto = brutto.replace(",", ".");
											nettotal=(brutto/amt)*100;
											netto.value=Math.round(nettotal*1000)/1000;
											nettoTag.innerHTML="("+nettoString+": "+Math.round(nettotal*100)/100+" EUR"+")";
										}
									}
									window.onload=function()
									{	recalcPrice();
									}
									'; ?>

								</script>
							</td>
						</tr>
						<tr>
							<th><?php echo $this->_tpl_vars['lang']['pePriceGross']; ?>
</th>
							<td><input id="bruttoPrice" onchange="recalcPrice(this.value)" type="text" class="text"  /></td>
						</tr>
						<tr>
							<th><?php echo $this->_tpl_vars['lang']['pePriceGrossNetto']; ?>
</th>
							<td><span id="nettoPriceTag" style="display:none;"></span><input id="nettoPrice" type="text" name="data[price]" value="<?php echo $this->_tpl_vars['item']['price']; ?>
" /></td>
						</tr>
						<tr>
							<th><?php echo $this->_tpl_vars['lang']['peManufacturer']; ?>
</th><td><input type="text" class="text" name="data[manufacturer]" value="<?php echo $this->_tpl_vars['item']['manufacturer']; ?>
" /></td>
						</tr>
						<tr>
							<th><?php echo $this->_tpl_vars['lang']['peMake']; ?>
</th><td><input type="text" class="text" name="data[make]" value="<?php echo $this->_tpl_vars['item']['make']; ?>
" /></td>
						</tr>
						<tr>
							<th><?php echo $this->_tpl_vars['lang']['peArticleNr']; ?>
</th><td><input type="text" class="text" name="data[artnr]" value="<?php echo $this->_tpl_vars['item']['artnr']; ?>
" /></td>
						</tr>

						<tr>
							<th><?php echo $this->_tpl_vars['lang']['peEAN']; ?>
</th><td><input type="text" class="text" name="data[ean]" value="<?php echo $this->_tpl_vars['item']['ean']; ?>
" /></td>
						</tr>
						<tr>
							<th><?php echo $this->_tpl_vars['lang']['peUPC']; ?>
</th><td><input type="text" class="text" name="data[upc]" value="<?php echo $this->_tpl_vars['item']['upc']; ?>
" /></td>
						</tr>
						<tr>
							<th><?php echo $this->_tpl_vars['lang']['peISBN']; ?>
</th><td><input type="text" class="text" name="data[isbn]" value="<?php echo $this->_tpl_vars['item']['isbn']; ?>
" /></td>
						</tr>
						
						<tr>
							<th><?php echo $this->_tpl_vars['lang']['specialoffer']; ?>
</th><td><input type="checkbox" class="checkbox" name="data[special]"<?php if ($this->_tpl_vars['item']['special'] == 1): ?> checked="checked"<?php endif; ?> /></td>
						</tr>
						
						<tr>
							<th><?php echo $this->_tpl_vars['lang']['peDownload']; ?>
</th><td><input type="text" class="text" name="data[download]" value="<?php echo $this->_tpl_vars['item']['download']; ?>
" /></td>
						</tr>

						
					</table>
					
					<table>
						<tr><th colspan="2"><?php echo $this->_tpl_vars['lang']['peImages']; ?>
</th></tr>
						<tr class="picchanger">
						
							<td>
								<table class=rexbutton><tr><td valign=top><select name=REX_MEDIALIST_SELECT_1 id=REX_MEDIALIST_SELECT_1 size=8 style="width:200px;" class=inpgrey100>
								
								<?php $_from = $this->_tpl_vars['item']['images']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['imgID'] => $this->_tpl_vars['img']):
?>
									<option value="<?php echo $this->_tpl_vars['img']; ?>
"><?php echo $this->_tpl_vars['img']; ?>
</option>
								<?php endforeach; endif; unset($_from); ?>
								
								</select></td>			
								<td class=inpicon><a href=javascript:moveREXMedialist(1,'top');><img src=media/file_top.gif width=16 height=16 vspace=2 title='^^' border=0></a><br><a href=javascript:moveREXMedialist(1,'up');><img src=media/file_up.gif width=16 height=16 vspace=2 title='^' border=0></a><br><a href=javascript:moveREXMedialist(1,'down');><img src=media/file_down.gif width=16 height=16 vspace=2 title='v' border=0></a><br><a href=javascript:moveREXMedialist(1,'bottom');><img src=media/file_bottom.gif width=16 height=16 vspace=2 title='vv' border=0></a></td><td class=inpicon><a href=javascript:openREXMedialist(1);><img src=media/file_add.gif width=16 height=16 vspace=2 title='+' border=0></a><br><a href=javascript:deleteREXMedialist(1);><img src=media/file_del.gif width=16 height=16 vspace=2 title='-' border=0></a></td></tr>
								<input type=hidden name=REX_MEDIALIST_1 value='<?php $_from = $this->_tpl_vars['item']['images']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['imgID'] => $this->_tpl_vars['img']):
?><?php echo $this->_tpl_vars['img']; ?>
,<?php endforeach; endif; unset($_from); ?>' id=REX_MEDIALIST_1 ></table>
							</td>
							<td style="width:100px;"><div style="overflow:hidden;"></div></td>					
						</tr>
					</table>
					
					
					
					<table>
						<tr><th><?php echo $this->_tpl_vars['lang']['peCategories']; ?>
</th></tr>
						<tr>
						<td>
							<select name="data[categories][]" size="15" multiple="multiple">
								<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "backend-categorymap.htm", 'smarty_include_vars' => array('product' => $this->_tpl_vars['item'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>						
							</select>
						</td>
						</tr>
						
						<!--
						<tr><th><?php echo $this->_tpl_vars['lang']['peRelated']; ?>
</th></tr>
						<tr>
						<td>
						<select name="data[related][]" size="15" multiple="multiple">
								<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "backend-productmap.htm", 'smarty_include_vars' => array('product' => $this->_tpl_vars['item'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>						
						</select>
						</td>
						</tr>-->
						
					</table>
				</td>
				
				
				<td valign="top">				
					<table>
						<tr><th colspan="2"><?php echo $this->_tpl_vars['lang']['peDescs']; ?>
</th></tr>
						
						<?php $_from = $this->_tpl_vars['products'][$this->_tpl_vars['key']]['desc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['descID'] => $this->_tpl_vars['desc']):
?>
						<tr>
							<th style="text-align:center;"><?php echo $this->_tpl_vars['metalabels'][$this->_tpl_vars['descID']]; ?>
</th>
							<td>
								<textarea name="data[desc][<?php echo $this->_tpl_vars['descID']; ?>
]"><?php echo $this->_tpl_vars['desc']; ?>
</textarea>
							</td>				
							
						</tr>
						<?php endforeach; endif; unset($_from); ?>
					</table>
					
					
					<table>
						<tr><th colspan="2"><?php echo $this->_tpl_vars['lang']['metadata']; ?>
</th></tr>
						<tr>
							<th style="text-align:center;"><?php echo $this->_tpl_vars['lang']['metatitle']; ?>
</th>
							<td>
								<textarea name="data[meta][title]"><?php echo $this->_tpl_vars['item']['meta']['title']; ?>
</textarea>
							</td>				
						</tr>

						<tr>
							<th style="text-align:center;"><?php echo $this->_tpl_vars['lang']['metakeywords']; ?>
</th>
							<td>
								<textarea name="data[meta][keywords]"><?php echo $this->_tpl_vars['item']['meta']['keywords']; ?>
</textarea>
							</td>				
						</tr>
						
						<tr>
							<th style="text-align:center;"><?php echo $this->_tpl_vars['lang']['metadescription']; ?>
</th>
							<td>
								<textarea name="data[meta][description]"><?php echo $this->_tpl_vars['item']['meta']['description']; ?>
</textarea>
							</td>				
						</tr>						

					</table>	
					
				</td>	
			
				
			
			</tr>
			<tr>
				<td colspan="2">
					
					<table>
						<tr><th><?php echo $this->_tpl_vars['lang']['peVariants']; ?>
</th></tr>
						<tr>
						<td>
						
						
									<iframe border="0" style="width:100%;height:400px;" frameborder="0" src="index.php?page=rexsale&iframe=variantframe&clang=<?php echo $_REQUEST['clang']; ?>
&product=<?php echo $_REQUEST['editProd']; ?>
"></iframe>
						
						
						</td>				
						</tr>
					</table>
					
				</td>
			</tr>
			
			<tr>
				<td colspan="2">
					<input type="hidden" name="parent" value="<?php echo $this->_tpl_vars['parent']; ?>
" />
					<input type="hidden" name="editProd" value="<?php echo $_REQUEST['editProd']; ?>
" />
					<input type="hidden" name="clang" value="<?php echo $this->_tpl_vars['clang']; ?>
" />
					
					<input type="submit" style="float:right;" value="<?php echo $this->_tpl_vars['lang']['peDel']; ?>
" name="delProduct" onclick="return confirm('<?php echo $this->_tpl_vars['lang']['reallyDelete']; ?>
');" />
					
					<input type="submit" value="<?php echo $this->_tpl_vars['lang']['save']; ?>
" name="editProduct" />
					<input type="submit" value="<?php echo $this->_tpl_vars['lang']['apply']; ?>
" name="applyProduct" />
					
					
				</td>
			</tr>
			
		</table>
		<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
	<?php else: ?>
	<table cellspacing="1" cellpadding="4" border="0" id="rexsale_table_prods" class="rex-table rex-table-mrgn">
		<thead>	
		<tr>
			<th style="width:26px;text-align:center;"><a href="?page=rexsale&subpage=inventory&clang=<?php echo $_REQUEST['clang']; ?>
&action=addProd&parent=<?php echo $this->_tpl_vars['parent']; ?>
"><img src="media/document_plus.gif" /></a></th>
			<th class="ajaxstatus">&nbsp;</th>
			<th style="width:250px;"><?php echo $this->_tpl_vars['lang']['product']; ?>
</th>
			<!--<th style="width:30px;"><?php echo $this->_tpl_vars['lang']['priority']; ?>
</th>-->
			<th><?php echo $this->_tpl_vars['lang']['editProduct']; ?>
</th>
			<th><?php echo $this->_tpl_vars['lang']['statusfunction']; ?>
</th>
		</tr>
		</thead>
		
			
			
			
		<tbody>	
			<?php $_from = $this->_tpl_vars['products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
			<tr>
				<td style="text-align:center;"><a href="?page=rexsale&subpage=inventory&parent=<?php echo $this->_tpl_vars['parent']; ?>
&clang=<?php echo $this->_tpl_vars['clang']; ?>
&editProd=<?php echo $this->_tpl_vars['item']['id']; ?>
"><img src="media/document.gif" alt="" /></a></td>
				<td class="rexsaleID" id="sort<?php echo $this->_tpl_vars['item']['id']; ?>
"><a href="#" class="sortlink"><img src="index.php?page=rexsale&load=move.gif"></a></td>
				<td><?php echo $this->_tpl_vars['item']['name']; ?>
</td>
				<!--<td><?php echo $this->_tpl_vars['item']['sortorder']; ?>
</td>-->
				<td><a href="?page=rexsale&subpage=inventory&parent=<?php echo $this->_tpl_vars['parent']; ?>
&clang=<?php echo $this->_tpl_vars['clang']; ?>
&editProd=<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['lang']['editdelProduct']; ?>
</a></td>
				<td>
				<a href="index.php?page=rexsale&subpage=inventory&parent=<?php echo $this->_tpl_vars['parent']; ?>
&clang=<?php echo $_REQUEST['clang']; ?>
&toggleProd=<?php echo $this->_tpl_vars['item']['id']; ?>
">
				<?php if ($this->_tpl_vars['item']['status'] == 1): ?>
				<span class="rex-online">online</span>
				<?php else: ?>
				<span class="rex-offline">offline</span>
				<?php endif; ?>
				</a>
				</td>
			</tr>
			<?php endforeach; endif; unset($_from); ?>
			
			
		</tbody>		
		
		<?php if ($_GET['action'] == 'addProd'): ?>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><input style="width:240px;" type="text" name="data[name]" value="" /></td>
				<!--<td>&nbsp;</td>-->
				<td>
					<input type="hidden" name="parent" value="<?php echo $_GET['parent']; ?>
" />
					<input type="submit" name="addProduct" value="<?php echo $this->_tpl_vars['lang']['peAdd']; ?>
" />
				</td>
				<td>&nbsp;</td>				
			</tr>
			<?php endif; ?>
	</table>
	<?php endif; ?>
	</form>
	
	
	
	<?php if ($_POST['editProduct'] != ""): ?>
		<script type="text/javascript">//alert('<?php echo $this->_tpl_vars['lang']['peProductSaved']; ?>
');</script>
	<?php endif; ?>
	
	
</div>