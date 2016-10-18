<!-- File: /app/View/Appointments/view.ctp -->
<?php $a = $appt['Appointment']; $p = $appt['Practice'] ?>
<?php 
	$out = array(
		array('', $this->Html->link( 'print', array(
			'controller' => 'appointments',
			'action' => 'view/print',
			$a['id']
		)) ." | ". $this->Html->link( 'edit', array(
			'controller' => 'appointments',
			'action' => 'edit',
			$a['id']
		)) ." | ". $this->Form->postLink(
		    'archive',
		    array('action' => 'delete', $a['id']),
		    array('confirm' => "Archiving this item will make it no longer appear in the list of appointments. Are you sure you want to archive this item?")
		) ),
		array('Practice Name', $p['name']),
		array('First Name', $a['first_name']),
		array('Middle Initial', $a['middle_initial']),
		array('Last Name', $a['last_name']),
		array('Address', $a['address_1']."<br />".$a['address_2']),
		array('City', $a['city']),
		array('State', $a['state']),
		array('Zip Code', $a['zip_code']),
		array('Date of Birth', $a['date_of_birth']),
		array('Gender', $a['gender']),
		array('Health Insurance', $a['health_insurance']),
		array('Health Insurance (Other)', $a['health_ins_other']),
		array('Phone', $a['phone']),
		array('Time to call', $a['time_to_call']),
		array('How can we help?', $a['additional_info']),
		array('Preferred Provider', $a['preferred_provider']),
		array('Preferred Time', $a['preferred_time']),
	);
	
	if ( !empty($a['guardian_last_name']) ){
		$out[] = array('Guardian First Name', $a['guardian_first_name']);
		$out[] = array('Guardian Middle Initial', $a['guardian_middle_initial']);
		$out[] = array('Guardian Last Name', $a['guardian_last_name']);
	}
	
	$out[] = array('Created', $this->Time->format('M d, Y h:i A', $a['created']) );
	$out[] = array('Modified', $this->Time->format('M d, Y h:i A', $a['modified']) );
	
	$out[] = array('',$this->Html->link( 'print', array(
			'controller' => 'appointments',
			'action' => 'view/print',
			$a['id']
		)) ." | ". $this->Html->link( 'edit', array(
			'controller' => 'appointments',
			'action' => 'edit',
			$a['id']
		)) ." | ". $this->Form->postLink(
            'archive',
            array('action' => 'delete', $a['id']),
            array('confirm' => "Archiving this item will make it no longer appear in the list of appointments. Are you sure you want to archive this item?")
		)
	);
?>
<h2><?php echo $a['first_name']?> <?php echo $a['last_name']?></h2>

<table>
	<?php echo $this->Html->tableCells($out,array('class' => 'darker')); ?>
</table>

