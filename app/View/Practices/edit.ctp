<!-- File: /app/View/Practices/edit.ctp -->
<div class="practices form">
<?php echo $this->Form->create('Practice', array('action' => 'edit', 'type'=>'file'));?>
    <fieldset>
        <legend><?php echo __('Practice Settings'); ?></legend>
    <?php
        echo $this->Form->input('name');
        echo $this->Form->input('slug');
        echo $this->Form->input('email');
        echo $this->Form->input('theme', array('options' => array(
        	'Blue' => 'Blue',
        	'Earth' => 'Earth',
        	'Grey' => 'Grey',
        	'Mint' => 'Mint',
        	'Water' => 'Aqua'
        )));
        echo $this->Form->input('logo', array('type' => 'text'));
        echo $this->Form->input('website', array('placeholder' => 'http://'));
        echo $this->Form->input('phone', array('placeholder' => '555 555-1234'));
        echo $this->Form->input('physicians');
        echo $this->Form->input('insurance');
        echo $this->Form->input('insurance_policy', array('label'=>'Insurance and Payment Information'));
        echo $this->Form->input('thank_you', array('between'=>"<p><small><a target='_blank' href='/app/".$this->request->data['Practice']['slug']."/thankyou'>View current thank you page</a></small></p>"));
        
        echo $this->Form->input('id', array('type' => 'hidden'));
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Save Settings'));?>
</div>