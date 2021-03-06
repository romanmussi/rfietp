<?php echo $html->css('/acl/css/acl'); ?>
<?php print $javascript->link('/acl/js/prototype') ?>
<script>
/* ACO  */
function acl_aco_editor_children(id) {
        indicator_show();
	new Ajax.Updater({success:'aco_editor_id'}, '<?php print $html->url('/acl/aclAcos/children/') ?>' + id,
        {
		method:'get',
		onSuccess: function() {
			indicator_hide();
		}
	});
}
function acl_aco_editor_reload() {
	
        new Ajax.Updater('aco_editor_id', '<?php print $html->url('/acl/aclAcos/children', true) ?>');
}
function acl_aco_permission_refresh() {
        indicator_show();
        aco_id = document.getElementById('aco_editor_id').value;
	new Ajax.Updater('aco_permissions', '<?php print $html->url('/acl/aclPermissions/acos/', true) ?>' + aco_id,
        {
		onSuccess: function() {
			indicator_hide();
		}
	});
}
/* ARO */
function acl_aro_editor_children(id) {
	indicator_show();
        new Ajax.Updater({success:'aro_editor_id'}, '<?php print $html->url('/acl/aclAros/children/') ?>' + id,
        {
		method:'get',
		onSuccess: function() {
			indicator_hide();
		}
	});
}
function acl_aro_editor_reload() {

	new Ajax.Updater('aro_editor_id', '<?php print $html->url('/acl/aclAros/children', true) ?>');
}
function acl_aro_permission_refresh() {
	indicator_show();
        aro_id = document.getElementById('aro_editor_id').value;
	new Ajax.Updater('aro_permissions', '<?php print $html->url('/acl/aclPermissions/aros/', true) ?>' + aro_id,
        {
		onSuccess: function() {
			indicator_hide();
		}
	});
}
/* PERMISSION */
function acl_permission_link() {
        indicator_show();
	aro_id = document.getElementById('aro_editor_id').value;
	aco_id = document.getElementById('aco_editor_id').value;
	h = new Hash({'data[AclAroAco][aro_id]':aro_id, 'data[AclAroAco][aco_id]':aco_id});
	new Ajax.Request('<?php print $html->url('/acl/aclPermissions/create') ?>', {parameters:h});
	acl_aro_permission_refresh();
	acl_aco_permission_refresh();
        indicator_hide();
}
function acl_permission_revoke(id) {
        indicator_show();
	new Ajax.Request('<?php print $html->url('/acl/aclPermissions/revoke/') ?>' + id, {onSuccess:
	function () {
		acl_aro_permission_refresh();
		acl_aco_permission_refresh();
                indicator_hide();
	}});
}

function setup() {
	acl_aro_editor_reload();
	acl_aco_editor_reload();
}

function indicator_show() {
	$('indicator').show();
}
function indicator_hide() {
	$('indicator').hide();
}

setup();
</script>
<?php print $this->renderElement('acl_menu') ?>
<div>
  <?php print $html->image('/acl/img/tango/32x32/emblems/emblem-readonly.png', array('align' => 'absmiddle')) ?>
  <b>Manage Permissions</b>
  <span id="indicator" style="display:none; padding-left:50px;"><?php print $html->image('indicator.gif', array('align'=>'absmiddle')) ?> Loading...</span>
</div>
<!--<div class="acl_message">
<h4>Navigating The Tree</h4>
<p>Try double-clicking on each aro/aco to find out if it has any children. If it does,
the children will load in the select box. You can move back one level by double-clicking
the two dots. If you single click an aro/aco, its already assigned permissions appear
in the chart below.</p>
<h4>Granting Permissions</h4>
<p>Navigate to an aro on the left side and an aco on the right side. When you are ready
to grant permission, click 'Grant', and you will see the newly assigned permission appear
below.</p>
<h4>Revoking Permissions</h4>
<p>You can easily revoke a permission by first browsing an aro/aco. When you click on one,
the granted permissions appear below. You can revoke a permission at any time by clicking
revoke.</p>
</div> -->
<table>
  <thead>
  <tr>
    <th>
      <?php print $html->image('/acl/img/tango/32x32/apps/system-users.png', array('align' => 'absmiddle')) ?>
      Usuarios
    </th>
    <th></th>
    <th>
      <?php print $html->image('/acl/img/tango/32x32/apps/preferences-system-windows.png', array('align' => 'absmiddle')) ?>
      Controles
    </th>
  </tr>
  </thead>
  <tr>
    <td>
      <select id="aro_editor_id" class="acl_select" style="height:100%" size="10" onChange="acl_aro_permission_refresh()" ondblclick="acl_aro_editor_children(this.value)">
		<option>Empty</option>
      </select><br />
    </td>
    <td width="80">
      <?php print $html->image('/acl/img/tango/32x32/actions/edit-redo.png', array('onClick' => 'acl_permission_link()', 'class' => 'acl_button')) ?>
    <td>
      <select id="aco_editor_id" class="acl_select" style="height:100%" size="10" onChange="acl_aco_permission_refresh()" ondblclick="acl_aco_editor_children(this.value)">
		<option>Empty</option>
      </select><br />
    </td>
  </tr>
  <tr>
    <td colspan="3">
    <div id="aro_permissions"></div>
    </td>
  </tr>
  <tr>
    <td colspan="3">
    <div id="aco_permissions"></div>
    </td>
  </tr>
</table>