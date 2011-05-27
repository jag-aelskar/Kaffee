<?php /* Smarty version 2.6.18, created on 2011-05-18 19:18:51
         compiled from backend-metainfo.htm */ ?>
<script type="text/javascript">
<?php echo '
function checkFieldsNow(x)
{	link=document.getElementById(\'LINK_\'+x);
	linkname=document.getElementById(\'LINK_\'+x+\'_NAME\');
	tex=document.getElementById(\'TEXEDITOR_\'+x);
	
	if (link.value!="")
	{	tex.value=tex.value+\'"\'+linkname.value+\'":redaxo://\'+link.value;
		link.value="";
	}
	
	media=document.getElementById(\'REX_MEDIA_\'+x);
	if (media.value!="")
	{	tex.value=tex.value+\'!files/\'+media.value+\'!\';
		media.value="";
	}
	setTimeout("checkFieldsNow(\'"+x+"\')",500);
}
'; ?>

</script>

<form name="REX_FORM" action="?page=rexsale&subpage=inventory" method="post">


<table cellspacing="1" cellpadding="4" border="0" class="rex-table rex-table-mrgn">
	<tr>
		<th style="width:26px;text-align:center;"><img src="media/document.gif" /></th>
		<th><?php echo $this->_tpl_vars['lang']['metainfo']; ?>
</th>
	</tr>
	
	
	<tr>
		<td>
		</td>
		<td colspan="4">
			<?php if ($_GET['metaUpdated'] != ""): ?>
			<p><strong><?php echo $this->_tpl_vars['lang']['metaDataSaved']; ?>
</strong></p>
			<?php endif; ?>
			
			<p><?php echo $this->_tpl_vars['lang']['metatitle']; ?>
<br />
			<input type="text" value="<?php echo $this->_tpl_vars['catinfo']['metatitle']; ?>
" style="width:300px;" name="metatitle" /></p>
	
			<p><?php echo $this->_tpl_vars['lang']['metakeywords']; ?>
<br />
			<input type="text" value="<?php echo $this->_tpl_vars['catinfo']['metakeywords']; ?>
" style="width:300px;" name="metakeywords" /></p>
	
		
			<?php echo $this->_tpl_vars['lang']['catdesc']; ?>
<br />
			
			<?php 
						
			textext('metatext',$this->_tpl_vars['catinfo']['metatext'],'width:350px;height:80px;');
			
			 ?>
			<br />
			<?php echo $this->_tpl_vars['lang']['image']; ?>
<br />
			
			
			
			<div class="rex-wdgt">
			  <div class="rex-wdgt-mda">
				<p>
				  <input type="text" size="30" name="REX_MEDIA_1" value="<?php echo $this->_tpl_vars['catinfo']['metabild']; ?>
" id="REX_MEDIA_1" readonly="readonly" />
				  <a href="#" onclick="openREXMedia(1,'');return false;" tabindex="24"><img src="media/file_open.gif" width="16" height="16" title="Open Mediapool" alt="Open Mediapool" /></a>
				  <a href="#" onclick="addREXMedia(1);return false;" tabindex="25"><img src="media/file_add.gif" width="16" height="16" title="Add New Media" alt="Add New Media" /></a>
				  <a href="#" onclick="deleteREXMedia(1);return false;" tabindex="26"><img src="media/file_del.gif" width="16" height="16" title="Remove Selection" alt="Remove Selection" /></a>
				</p>
			  </div>
			</div>
				
			<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['parent']; ?>
" />
			<input type="hidden" name="clang" value="<?php echo $this->_tpl_vars['clang']; ?>
" />
			
			<input type="submit" class="button" name="catmeta" value="<?php echo $this->_tpl_vars['lang']['save']; ?>
" />
		</td>
	</tr>
</table>
</form>