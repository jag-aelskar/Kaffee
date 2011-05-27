<?php /* Smarty version 2.6.18, created on 2011-05-18 19:18:51
         compiled from backend-cat-tree.htm */ ?>
<p>
<strong><?php echo $this->_tpl_vars['lang']['directory']; ?>
</strong>: <a href="?page=rexsale&subpage=inventory&clang=<?php echo $_REQUEST['clang']; ?>
"><?php echo $this->_tpl_vars['lang']['home']; ?>
</a>
<?php $_from = $this->_tpl_vars['crumbs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
| <a href="index.php?page=rexsale&subpage=inventory&parent=<?php echo $this->_tpl_vars['item'][0]; ?>
&clang=<?php echo $_REQUEST['clang']; ?>
"><?php echo $this->_tpl_vars['item'][1]; ?>
</a>
<?php endforeach; endif; unset($_from); ?>
</p>
<br />