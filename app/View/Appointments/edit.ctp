<!-- File: /app/View/Appointments/edit.ctp -->
<div class="appts form">
<?php echo $this->Form->create('Appointment', array('action' => 'edit'));?>
	<fieldset>
		<legend><?php echo __('Edit Appointment Request for '.$practice['Practice']['name']); ?></legend>
	<?php
		echo $this->Form->input( 'first_name', array( 'div' => array( 'class'=>'fn input text' ) ) );
		echo $this->Form->input( 'middle_initial', array( 'div' => array( 'class'=>'mi input text' ) ) );
		echo $this->Form->input( 'last_name', array( 'div' => array( 'class'=>'ln input text' ) ) );
	?>
		<fieldset>
			<legend>Contact Information</legend>
	<?php
		echo $this->Form->input( 'address_1', array( 'type'=>'text', 'div' => array( 'class'=>'a1 input text' ) ) );
		echo $this->Form->input( 'address_2', array( 'type'=>'text', 'div' => array( 'class'=>'a2 input text' ) ) );
		echo $this->Form->input( 'city', array( 'div' => array( 'class'=>'city input text' ) ) );
		echo $this->Form->input( 'state', array( 'div' => array( 'class'=>'state input text' ) ) );
		echo $this->Form->input( 'zip_code', array( 'div' => array( 'class'=>'zip input text' ) ) );
		echo $this->Form->input( 'phone', array( 'div' => array( 'class'=>'phone input text' ) ) );
		echo $this->Form->input( 'time_to_call', array( 'div' => array( 'class'=>'ttc input text' ) ) );
	?>
		</fieldset>
		<fieldset>
			<legend>Personal Information</legend>
	<?php
		echo $this->Form->input( 'date_of_birth', array( 'minYear' => date('Y') - 100, 'maxYear' => date('Y'), 'div' => array( 'class'=>'dob input date' ) ) );
		echo $this->Form->input( 'gender', array( 'options' => array('Male' => 'Male', 'Female'=>'Female', 'Other'=>'Other'), 'div' => array( 'class'=>'gen input text' ) ) );
		$insurance_list = array();
		foreach (explode('\n', $practice['Practice']['insurance']) as $v) {
			$insurance_list[trim($v)] = trim($v); 
		}
		$insurance_list['other_trigger'] = "Other (please specify)";
		echo $this->Form->input( 'health_insurance', array( 'options' => $insurance_list, 'div' => array( 'class'=>'hi input text' ) ) );
		echo $this->Form->input( 'health_ins_other', array( 'div' => array( 'class'=>'hio input text' ), 'label' => 'Health Insurance (Other)' ) );
	?>		
		</fieldset>
		<fieldset>
			<legend>Parent/Guardian Information</legend>
	<?php
		echo $this->Form->input( 'guardian_first_name', array( 'div' => array( 'class'=>'gfn input text' ), 'label' => 'First Name') );
		echo $this->Form->input( 'guardian_middle_initial', array( 'div' => array( 'class'=>'gmi input text' ), 'label' => 'Middle Initial' ) );
		echo $this->Form->input( 'guardian_last_name', array( 'div' => array( 'class'=>'gln input text' ), 'label' => 'Last Name' ) );
	?>
		</fieldset>
	<?php
		if ( 1 == count($p = explode('\n', $practice['Practice']['physicians'])) ){
			echo $this->Form->input( 'preferred_provider', array( 'value' => __($p[0]), 'disabled', 'div' => array( 'class'=>'pp input text' ) ) );
		} else {
			$physicians = array('First available' => '- First available -');
			foreach ($p as $v) {
				$physicians[trim($v)] = trim($v); 
			}
			echo $this->Form->input( 'preferred_provider', array( 'options' => $physicians, 'div' => array( 'class'=>'pp input text' ) ) );
		}
		echo $this->Form->input( 'preferred_time', array( 'div' => array( 'class'=>'pt input text' ) ) );

		echo $this->Form->input('practice_id', array('type' => 'hidden','value'=>$practice['Practice']['id']));
	?>	
    </fieldset>
    <p>All fields marked * are required.</p>
<?php echo $this->Form->end(__('Submit'));?>
</div>