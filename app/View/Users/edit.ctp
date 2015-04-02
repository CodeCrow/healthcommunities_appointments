<!-- File: /app/View/Users/edit.ctp -->
<div class="users form">
<?php echo $this->Form->create('User', array('action' => 'edit'));?>
    <fieldset>
        <legend><?php echo __('Edit User'); ?></legend>
    <?php
        echo $this->Form->input('username');
        echo $this->Form->input('practice_id');
        echo $this->Form->input('password');
        
        echo $this->Form->input('id', array('type' => 'hidden'));
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Save User'));?>
</div>