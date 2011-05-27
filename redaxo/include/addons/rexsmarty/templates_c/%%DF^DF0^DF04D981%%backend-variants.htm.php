<?php /* Smarty version 2.6.18, created on 2011-05-18 19:19:05
         compiled from backend-variants.htm */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "backend-lang-select.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>





<div id="product-variants">
<form action="?page=rexsale&subpage=variants" method="POST" id="variantform">
<input type="hidden" id="mode" name="mode" value="" />
<input type="hidden" id="modevalue" name="modevalue" value="" />
<br />
<table cellspacing="1" cellpadding="4" border="0" class="rex-table rex-table-mrgn">
	<tr>
		<th style="width:50%;"><?php echo $this->_tpl_vars['lang']['vaOptions']; ?>
</th>
		<th><?php echo $this->_tpl_vars['lang']['vaValues']; ?>
</th>
	</tr>
	<tr>
		<td>
			<table style="width:250px">
				<tr>
					<td>
						<select id="varoptions" name="options" size="10" style="width:250px;">
							
							<?php $_from = $this->_tpl_vars['options']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
							<option value="<?php echo $this->_tpl_vars['k']; ?>
"<?php if ($_POST['addValue'][$this->_tpl_vars['k']] != "" || $_POST['options'] == $this->_tpl_vars['k']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['v']; ?>
</option>
							<?php endforeach; endif; unset($_from); ?>
							
						</select>					
					</td>
					<td class=inpicon>
						<input type="hidden" name="clang" value="<?php echo $_REQUEST['clang']; ?>
" />
						<input type="image" name="addOption" src="media/file_add.gif" />
						<input type="image" name="delOption" src="media/file_del.gif" />
						<a href="javascript:newOptionName('<?php echo $this->_tpl_vars['lang']['vaNewOptionName']; ?>
');"><img src="media/file_open.gif" /></a>
					</td>
				</tr>
			</table>
		</td>
		<td id="valuescol">
			<?php $_from = $this->_tpl_vars['options']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ok'] => $this->_tpl_vars['ov']):
?>
				<table id="values<?php echo $this->_tpl_vars['ok']; ?>
" style="width:250px;height:100%;<?php if ($_POST['addValue'][$this->_tpl_vars['ok']] == '' && $_POST['options'] != $this->_tpl_vars['ok']): ?>display:none;<?php endif; ?>">
				<tr>
					<td>
						<select style="width:250px" name="values[<?php echo $this->_tpl_vars['ok']; ?>
]" size="10" id="svalues<?php echo $this->_tpl_vars['ok']; ?>
">
								<?php $_from = $this->_tpl_vars['values'][$this->_tpl_vars['ok']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['kk'] => $this->_tpl_vars['vv']):
?>
								<option value="<?php echo $this->_tpl_vars['kk']; ?>
"><?php echo $this->_tpl_vars['vv']; ?>
</option>
								<?php endforeach; endif; unset($_from); ?>
						</select>
					</td>
					<td class=inpicon>
						<input type="image" name="addValue[<?php echo $this->_tpl_vars['ok']; ?>
]" src="media/file_add.gif" />
						<input type="image" name="delValue[<?php echo $this->_tpl_vars['ok']; ?>
]" src="media/file_del.gif" />
						<a href="javascript:;"><img src="media/file_open.gif" onclick="newValueName('<?php echo $this->_tpl_vars['lang']['vaNewValueName']; ?>
','<?php echo $this->_tpl_vars['ok']; ?>
');" /></a>						
					</td>
				</tr>
				</table>
			<?php endforeach; endif; unset($_from); ?>
		</td>
	</tr>
</table>



</form>
</div>