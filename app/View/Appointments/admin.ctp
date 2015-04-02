<!-- File: /app/View/Appointments/admin.ctp -->
<?php if ($admin): ?>
	<h2>All Appointment Requests</h2>
<?php else: ?>
	<h2>Appointment Requests for <?php echo __($practice['Practice']['name']); ?></h2>
<?php endif; ?>

<table>
	<tr>
	    <th>Name</th>
	    <th>Phone #</th>
	    <th>Preferred Provider</th>
	    <th>Requested Time</th>
	    <th>Health Insurance</th>
	    <th>&nbsp;</th>
	</tr>
	<?php foreach ($appts as $appt): ?>
    <tr>
        <td>
            <?php echo $this->Html->link($appt['Appointment']['first_name']." ".$appt['Appointment']['last_name'],
array('controller' => 'appointments', 'action' => 'view', $appt['Appointment']['id'])); ?>
        </td>
        <td><?php echo __($appt['Appointment']['phone']); ?></td>
        <td><?php echo __($appt['Appointment']['preferred_provider']); ?></td>
        <td><?php echo __($appt['Appointment']['preferred_time']); ?></td>
        <td><?php echo ('other_trigger' == $appt['Appointment']['health_insurance'])? __($appt['Appointment']['health_ins_other']): __($appt['Appointment']['health_insurance']); ?></td>
        <td><?php echo $this->Html->link(
    		'edit',
			array(
				'controller' => 'appointments',
				'action' => 'edit',
				$appt['Appointment']['id']
			)
		);  ?></td>
    </tr>
    <?php endforeach; ?>
</table>