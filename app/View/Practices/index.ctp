<!-- app/View/Practices/index.ctp -->
<div class="practices">
<h2>Practice Settings</h2>
<table>
	<tr>
        <th>Name</th>
        <th>Website</th>
        <th>Phone #</th>
        <th>Modified</th>
        <th>&nbsp;</th>
    </tr>
	<?php foreach ($practices as $p): ?>
    <tr>
        <td><?php echo $p['Practice']['name']; ?></td>
        <td><?php echo $p['Practice']['website']; ?></td>
        <td><?php echo $p['Practice']['phone']; ?></td>
        <td><?php echo $p['Practice']['modified']; ?></td>
        <td><?php echo $this->Html->link(
    		'edit',
			array(
				'controller' => 'practices',
				'action' => 'edit',
				$p['Practice']['id']
			)
		);  ?>
		</td>
    </tr>
    <?php endforeach; ?>
</table>
<p><a href="/users/add">Create a new practice</a></p>
<p><a href="/users">Click here to manage users</a></p>
</div>
