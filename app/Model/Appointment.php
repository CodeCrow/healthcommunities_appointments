<?php

class Appointment extends AppModel {
    public $name = 'Appointment';
    public $belongsTo = array('Practice');
    
    /* Leave this out until after Kate's done looking around */
    public $validate = array(
		'first_name' => array(
			'rule' => '/^[\D]+$/i', //no numbers in your name.
			'message' => 'Invalid name.',
			'required' => true,
			'allowEmpty' => false
		),
		'last_name' => array(
			'rule' => '/^[\D]+$/i', //no numbers in your name.
			'message' => 'Invalid name.',
			'required' => true,
			'allowEmpty' => false
		),
		'address_1' => array(
			'rule' => '/^[a-zA-Z0-9 .#-]+$/i',
			'message' => '',
			'required' => false,
			'allowEmpty' => true
		),
		'city' => array(
			'rule' => '/^[\D]+$/i',
			'message' => 'Invalid city.',
			'required' => false,
			'allowEmpty' => true
		),
		'state' => array(
			'rule' => '/^[a-zA-Z]{2}$/i',
			'message' => 'State should be abbreviation; ex: NY, MA',
			'required' => false,
			'allowEmpty' => true
		),
		'zip_code' => array(
			'rule' => '/^[\d -]{5,10}$/i',
			'message' => 'Zip Code can only contain numbers, spaces or dashes.',
			'required' => false,
			'allowEmpty' => true
		),
		'phone' => array(
			'rule' => '/^[\d]?.*[\d]{0,3}.*[\d]{3}.*[\d]{4}$/i',
			'message' => 'Phone number must be 7-11 digits',
			'required' => true,
			'allowEmpty' => false
		),
		'date_of_birth' => array(
			'rule' => 'date',
			'message' => 'Must be valid date.',
			'required' => false
		),
		'gender' => array(
			'rule' => 'alphaNumeric',
			'required' => false
		),
		'health_insurance' => array(
			'message' => 'Please choose your health insurance.',
			'rule' => '/^.*$/', // need a regex so it *'s the field.
			'required' => false
		),

    ); // */
    
    public function inPractice($appt, $user) {
	    return $this->field('id', array('id' => $appt, 'practice_id' => $user)) === $appt;
	}
	
	function parse_phone($phone) {
		$phone = preg_replace("/[^0-9]/", "", $phone);
		if (strlen($phone) == 7) {
			return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
		} elseif (strlen($phone) == 10) {
			return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
		} elseif (strlen($phone) == 11) {
			return preg_replace("/1([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
		}
	}	
	
}

?>