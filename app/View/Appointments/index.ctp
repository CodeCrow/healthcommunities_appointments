<!-- File: /app/View/Appointments/index.ctp -->
<?php if ($valid): ?>
<div class="appts form">
<?php echo $this->Form->create('Appointment');?>
	<fieldset>
		<legend><?php echo __('Request Appointment at ').$practice['Practice']['name']; ?></legend>
	<?php
		echo $this->Form->input( 'first_name', array( 'div' => array( 'class'=>'fn input text' ) ) );
		echo $this->Form->input( 'middle_initial', array( 'div' => array( 'class'=>'mi input text' ) ) );
		echo $this->Form->input( 'last_name', array( 'div' => array( 'class'=>'ln input text' ) ) );
	?>
		<fieldset>
			<legend>Contact Information</legend>
	<?php
		echo $this->Form->input( 'address_1', array( 'type' => 'text', 'div' => array( 'class'=>'a1 input text' ) ) );
		echo $this->Form->input( 'address_2', array( 'type' => 'text', 'div' => array( 'class'=>'a2 input text' ) ) );
		echo $this->Form->input( 'city', array( 'div' => array( 'class'=>'city input text' ) ) );
		echo $this->Form->input( 'state', array( 'div' => array( 'class'=>'state input text' ) ) );
		echo $this->Form->input( 'zip_code', array( 'div' => array( 'class'=>'zip input text' ) ) );
		echo $this->Form->input( 'phone', array( 'placeholder' => '555 555-1234', 'div' => array( 'class'=>'phone input text' ) ) );
		echo $this->Form->input( 'time_to_call', array( 'label'=>"Best time for you to call me", 'div' => array( 'class'=>'ttc input text' ) ) );
	?>
		</fieldset>
		<fieldset>
			<legend>Personal Information</legend>
	<?php
		echo $this->Form->input( 'date_of_birth', array( 'minYear' => date('Y') - 100, 'maxYear' => date('Y'), 'div' => array( 'class'=>'dob input date' ) ) );
		echo $this->Form->input( 'gender', array( 'options' => array('Male' => 'Male', 'Female'=>'Female', 'Other'=>'Other'), 'div' => array( 'class'=>'gen input text' ) ) );
		if (empty($practice['Practice']['insurance_policy'])):
			foreach (explode('\n', $practice['Practice']['insurance']) as $v) {
				$insurance_list[trim($v)] = trim($v);
			}
			$insurance_list['other_trigger'] = "Other (please specify)";
			echo $this->Form->input( 'health_insurance', array( 'options' => $insurance_list, 'div' => array( 'class'=>'hi input text' ) ) );
			echo $this->Form->input( 'health_ins_other', array( 'div' => array( 'class'=>'hio hidden input text' ), 'label' => 'Health Insurance (Other)' ) );
		else:
			echo $this->Form->input( 'health_insurance', array('type' => 'hidden','value'=>'') );
			echo '<div class="gen input text"><label for="AppointmentInsurancePolicy"><strong>Insurance and Payment Information</strong></label><p>'.$practice['Practice']['insurance_policy']."</p></div>";
		endif;
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
		if ( empty($practice['Practice']['physicians']) ) {
			echo $this->Form->input( 'preferred_provider', array( 'div' => array( 'class'=>'pp input text' ) ) );
		} elseif ( 1 == count($p = explode('\n', $practice['Practice']['physicians'])) ){
			echo $this->Form->input( 'preferred_provider', array( 'value' => __($p[0]), 'disabled', 'div' => array( 'class'=>'pp input text' ) ) );
		} else {
			$physicians = array('First available' => '- First available -');
			foreach ($p as $v) {
				$physicians[trim($v)] = trim($v); 
			}
			echo $this->Form->input( 'preferred_provider', array( 'options' => $physicians, 'div' => array( 'class'=>'pp input text' ) ) );
		}
		echo $this->Form->input( 'preferred_time', array( 'label'=>"My preferred appointment time(s)", 'div' => array( 'class'=>'pt input text' ) ) );

		echo $this->Form->input('practice_id', array('type' => 'hidden','value'=>$practice['Practice']['id']));
	?>	
    </fieldset>
    <p>All fields marked * are required.</p>
    <p>Communications with our office via this website are not intended to replace an office visit. Please do not include any personal health information when completing this form. This form should be used only for routine and non-urgent matters. If you are experiencing a medical emergency, please call 911 or go to your nearest hospital emergency room.</p>
    <fieldset>
    	<?php echo $captcha; ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<?php else: ?>
<div class="appts form">
	<h2 class="alert error">Error</h2>
</div>
<?php endif; ?>
