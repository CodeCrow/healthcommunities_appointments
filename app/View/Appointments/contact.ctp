<!-- File: /app/View/Appointments/index.ctp -->
<?php if ($valid): ?>
<div class="appts form">
<?php echo $this->Form->create('Appointment');?>

    <?php
        echo $this->Form->input('practice_id', array('type' => 'hidden','value'=>$practice['Practice']['id']));
        echo $this->Form->input( 'first_name', array( 'div' => array( 'class'=>'fn input text' ) ) );
        echo $this->Form->input( 'middle_initial', array( 'div' => array( 'class'=>'mi input text' ) ) );
        echo $this->Form->input( 'last_name', array( 'div' => array( 'class'=>'ln input text' ) ) );
        echo $this->Form->input( 'phone', array( 'placeholder' => '555 555-1234', 'div' => array( 'class'=>'phone input text' ) ) );
        echo $this->Form->input( 'additional_info', array( 'label'=>"How can we help you?", 'div' => array( 'class'=>'ttc input text' ) ) );
    ?>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<?php else: ?>
<div class="appts form">
    <h2 class="alert error">Error</h2>
</div>
<?php endif; ?>
