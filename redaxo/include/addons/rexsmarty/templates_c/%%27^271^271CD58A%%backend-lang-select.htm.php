<?php /* Smarty version 2.6.18, created on 2011-05-18 19:19:05
         compiled from backend-lang-select.htm */ ?>
<div id="rex-clang">
<ul>
	<li><?php echo $this->_tpl_vars['lang']['languages']; ?>
 : </li>
	<?php $_from = $this->_tpl_vars['langs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['langs'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['langs']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['langs']['iteration']++;
?>
		<li>
			<?php if ($this->_tpl_vars['clang'] == $this->_tpl_vars['key']): ?>
				<?php echo $this->_tpl_vars['item']; ?>

			<?php else: ?>
				<a href="?page=rexsale&subpage=<?php echo $_GET['subpage']; ?>
&parent=<?php echo $_REQUEST['parent']; ?>
&clang=<?php echo $this->_tpl_vars['key']; ?>
&mode=<?php echo $_GET['mode']; ?>
<?php if ($_REQUEST['editProd'] != ""): ?>&editProd=<?php echo $_REQUEST['editProd']; ?>
<?php endif; ?>"><?php echo $this->_tpl_vars['item']; ?>
</a>
			<?php endif; ?>
			
			<?php if (($this->_foreach['langs']['iteration'] == $this->_foreach['langs']['total']) == ""): ?>|<?php endif; ?>
		</li>
	<?php endforeach; endif; unset($_from); ?>
</ul>
</div>