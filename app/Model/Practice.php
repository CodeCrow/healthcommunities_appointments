<?php
// app/Model/Practice.php
class Practice extends AppModel {
    public $name = 'Practice';
    public $hasMany = array('User','Appointment');
    
    public $validate = array(
    	'website' => array(
    	    'rule' => array('url'),
    	    'message' => 'Please supply a valid URL.',
    	    'required' => false,
    	    'allowEmpty' => true
    	),
    	'phone' => array(
    		'rule' => '/^\(?[\d]{3}\)? *[\d]{3} *-? *[\d]{4}$/i',
    		'message' => 'Phone number must look like: 555 555-1234',
    		'required' => false,
    		'allowEmpty' => true
    	),
    	'email' => 'email',

    );
}
