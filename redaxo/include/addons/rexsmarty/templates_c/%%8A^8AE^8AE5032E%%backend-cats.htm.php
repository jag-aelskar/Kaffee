<?php /* Smarty version 2.6.18, created on 2011-05-18 19:18:51
         compiled from backend-cats.htm */ ?>
<form action="?page=rexsale&subpage=inventory" method="post">
<table id="rexsale_table_cats" cellspacing="1" cellpadding="4" border="0" class="rex-table rex-table-mrgn">

	<tr>
		<th style="width:26px;text-align:center;"><a href="?page=rexsale&subpage=inventory&clang=<?php echo $_REQUEST['clang']; ?>
&action=addCat&parent=<?php echo $this->_tpl_vars['parent']; ?>
"><img src="media/folder_plus.gif" /></a></th>
		<th class="ajaxstatus">&nbsp;</th>
		<th style="width:250px;"><?php echo $this->_tpl_vars['lang']['category']; ?>
</th>
		<!--<th style="width:30px;"><?php echo $this->_tpl_vars['lang']['priority']; ?>
</th>-->
		<th><?php echo $this->_tpl_vars['lang']['editieren']; ?>
</th>
		<th style="width:100px;"><?php echo $this->_tpl_vars['lang']['statusfunction']; ?>
</th>
	</tr>
	
<?php if ($this->_tpl_vars['errors'] != ""): ?>
	<tr class="warning">
		<td style="text-align:center;"><img src="media/warning.gif" alt="" /></td>
		<td colspan="4">
		<?php $_from = $this->_tpl_vars['errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
			<?php echo $this->_tpl_vars['v']; ?>
<br />
		<?php endforeach; endif; unset($_from); ?>
		</td>
	</tr>
<?php endif; ?>


<?php if ($this->_tpl_vars['parent'] > 0): ?>
	<tr>
			<td style="text-align:center;">
			</td>
			<td>&nbsp;</td>
			<td><a href="index.php?page=rexsale&subpage=inventory&parent=<?php echo $this->_tpl_vars['array']['id']; ?>
&clang=<?php echo $_REQUEST['clang']; ?>
">..</a></td>
			<!--<td>&nbsp;</td>-->
			<td>&nbsp;</td>
			<td>&nbsp;</td>
	</tr>
<?php endif; ?>

<tbody>	
<?php $_from = $this->_tpl_vars['cattree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cat'] => $this->_tpl_vars['array']):
?>	
	<tr>
		<td style="text-align:center;">
		<a href="index.php?page=rexsale&subpage=inventory&parent=<?php echo $this->_tpl_vars['array']['id']; ?>
&clang=<?php echo $_REQUEST['clang']; ?>
"><img src="media/folder.gif" alt=""></a>
		</td>
		<td class="rexsaleID" id="sort<?php echo $this->_tpl_vars['array']['id']; ?>
"><a href="#" class="sortlink"><img src="index.php?page=rexsale&load=move.gif"></a></td>		
		<?php if ($_GET['editCat'] == $this->_tpl_vars['array']['id']): ?>
			<td><input style="width:240px;" type="text" name="catname" value="<?php echo $this->_tpl_vars['array']['name']; ?>
" /></td>
			
			<!--<td><input type="text" style="width:20px;" name="catsort" value="<?php echo $this->_tpl_vars['array']['sortorder']; ?>
" /></td>-->
			<td>
				<input type="hidden" name="id" value="<?php echo $_REQUEST['editCat']; ?>
" />
				<input type="hidden" name="parent" value="<?php echo $_REQUEST['parent']; ?>
" />
				<input type="hidden" name="clang" value="<?php echo $this->_tpl_vars['clang']; ?>
" />
				<input type="submit" name="editcat" value="<?php echo $this->_tpl_vars['lang']['edit']; ?>
" /><input type="submit" name="delcat" value="<?php echo $this->_tpl_vars['lang']['del']; ?>
" />
			</td>
			<td>&nbsp;</td>
		<?php else: ?>
			<td><a href="index.php?page=rexsale&subpage=inventory&parent=<?php echo $this->_tpl_vars['array']['id']; ?>
&clang=<?php echo $_REQUEST['clang']; ?>
"><?php echo $this->_tpl_vars['array']['name']; ?>
</a></td>
			<!--<td><?php echo $this->_tpl_vars['array']['sortorder']; ?>
</td>-->
			<td><a href="index.php?page=rexsale&subpage=inventory&parent=<?php echo $_REQUEST['parent']; ?>
&clang=<?php echo $_REQUEST['clang']; ?>
&editCat=<?php echo $this->_tpl_vars['array']['id']; ?>
"><?php echo $this->_tpl_vars['lang']['editdel']; ?>
</a></td>
			<td>
			<a href="index.php?page=rexsale&subpage=inventory&parent=<?php echo $this->_tpl_vars['parent']; ?>
&clang=<?php echo $_REQUEST['clang']; ?>
&toggleCat=<?php echo $this->_tpl_vars['array']['id']; ?>
">
			<?php if ($this->_tpl_vars['array']['status'] == 1): ?>
			<span class="rex-online">online</span>
			<?php else: ?>
			<span class="rex-offline">offline</span>
			<?php endif; ?>
			</a>
			</td>
		<?php endif; ?>
		
	</tr>
<?php endforeach; endif; unset($_from); ?>
</tbody>




<?php if ($_GET['action'] == 'addCat'): ?>
	<tr>
			<td style="text-align:center;">
			<a href="index.php?page=rexsale&subpage=inventory&parent=<?php echo $this->_tpl_vars['array']['id']; ?>
&clang=<?php echo $_REQUEST['clang']; ?>
"><img src="media/folder.gif" alt=""></a>
			</td>
			<td>&nbsp;</td>
			<td><input type="text" name="catname" style="width:240px;" value="" /></td>
			
			<!--<td><?php echo $this->_tpl_vars['array']['sortorder']; ?>
</td>-->
			<td>
				<input type="hidden" name="parent" value="<?php echo $_GET['parent']; ?>
" />
				<input type="submit" name="addcat" value="<?php echo $this->_tpl_vars['lang']['add']; ?>
" />
			</td>
			<td>&nbsp;</td>
	</tr>
<?php endif; ?>


</table>
</form>