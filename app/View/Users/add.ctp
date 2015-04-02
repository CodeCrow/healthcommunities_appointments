<!-- app/View/Users/add.ctp -->
<div class="users form">
<?php echo $this->Form->create('User');?>
    <fieldset>
        <legend><?php echo __('Add User'); ?></legend>
    <?php
        echo $this->Form->input('username');
    ?>
	<fieldset>
		<legend>Existing Practice</legend>
		<?php echo $this->Form->input('practice_id', array('label'=>'')); ?>
        <legend>Add Practice</legend>
        <?php echo $this->Form->input('practice_name'); ?>
        <legend>Practice Slug</legend>
        <?php echo $this->Form->input('practice_slug'); ?>
    </fieldset>
    <?php
        echo $this->Form->input('password');
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
