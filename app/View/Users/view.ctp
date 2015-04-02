<!-- app/View/Users/index.ctp -->
<div class="users">
<h2>Users</h2>

<table>
<tr><th>Username:</th><td><?php echo $v_user['User']['username']; ?></td></tr>
<tr><th>Practice:</th><td><?php echo $v_user['Practice']['name']; ?></td></tr>
<tr><th>Created:</th><td><?php echo date('m/d/y \a\t g:i a', strtotime($v_user['User']['created'])); ?></td></tr>
<tr><th>Last Modified:</th><td><?php echo date('m/d/y \a\t g:i a', strtotime($v_user['User']['modified'])); ?></td></tr>
<tr><th>&nbsp;</th><td><?php echo $this->Html->link(
	'edit',
	array(
		'controller' => 'users',
		'action' => 'edit',
		$v_user['User']['id']
	)
);  ?></td></tr>
</table>

</div>
