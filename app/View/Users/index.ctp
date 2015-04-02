<!-- app/View/Users/index.ctp -->
<div class="users">
<h2>Users</h2>
<table>
	<tr>
        <th>ID</th>
        <th>Username</th>
        <th>Practice</th>
        <th>Created</th>
        <th>&nbsp;</th>
    </tr>
	<?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo $user['User']['id']; ?></td>
        <td>
            <?php echo $this->Html->link(
            	$user['User']['username'],
				array(
					'controller' => 'users',
					'action' => 'view',
					$user['User']['id']
				)
			); ?>
        </td>
        <td><?php echo $user['Practice']['name']; ?></td>
        <td><?php echo $user['User']['created']; ?></td>
        <td><?php echo $this->Html->link(
    		'edit',
			array(
				'controller' => 'users',
				'action' => 'edit',
				$user['User']['id']
			)
		);  ?><?php if ( true ): ?>
				<?php /*echo $this->Html->link(
		    		'delete',
					array(
						'controller' => 'users',
						'action' => 'delete',
						$user['User']['id']
					)
				); */ ?>
			<?php endif; ?>
		</td>
    </tr>
    <?php endforeach; ?>
</table>
</div>
