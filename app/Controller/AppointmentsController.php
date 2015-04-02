<?php
App::uses('Sanitize', 'Utility');
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', 'recaptchalib');
class AppointmentsController extends AppController {
    public $helpers = array ('Html','Form');
    public $name = 'Appointments';

	public function beforeFilter() {
	    parent::beforeFilter();
        $this->Auth->allow('index','thankyou');
	}

	public function beforeRender() {
	    parent::beforeRender();
	    if (null != $this->Auth->user('username')) {
		    $this->set('user',$this->Auth->user());
	    }
	    $p = false;
		if ( array_key_exists('name', $this->request->params) ) {
			$p = $this->Appointment->Practice->findBySlug( $this->request->params['name'] );
			if ($p){			
				$this->set( 'practice', Sanitize::clean($p) );
				$this->set( 'current_practice', Sanitize::clean($p['Practice']) );
			} else {
				$this->set('practice', false);
			}
		} elseif (null !== $this->Auth->user('practice_id')) {
			$this->Appointment->Practice->id = $this->Auth->user('practice_id');
			if ($this->Appointment->Practice->exists()){
				$p = $this->Appointment->Practice->read();		
				$this->set( 'practice', Sanitize::clean($p) );
				$this->set( 'current_practice', Sanitize::clean($p['Practice']) );
			} else {
				$this->set('practice', false);
			}
		} else {
			$this->set('practice', false);
		}
		if ( array_key_exists('print', $this->request->params) && ($this->request->params['print'] == 'print') ) { //if we're printing,  force the print theme
			$this->theme = "Print";
		} elseif ($p && null != $p['Practice']['theme']){
			$this->theme = $p['Practice']['theme'];
		}
		
		// reCAPTCHA
		// $privatekey in index()
		// Original public key
		// $publickey = "6LcJyM8SAAAAADyd8Zp-37meXkIo7RjytU2EdbLe";
		// Public key for healthcommunities-appointments.com,beyondbasicsphysicaltherapy.com
		$publickey = "6Ld2QvkSAAAAAI5uKx5DupWoc_5Ui5PJWRQ9gKwk";
		$this->set('captcha', recaptcha_get_html($publickey, null, true) );
		
		
		// Add cross-domain JS security header to allow embedding forms on practice's website
		if ( $p && array_key_exists('website', $p['Practice']) ) {
			$ws = $p['Practice']['website'];
			if ($ws){
				$ws = rtrim(Sanitize::clean($ws), '/\\');
				$this->response->header('Access-Control-Allow-Origin', $ws);
			}
		}
	}
	
	public function isAuthorized($user) {
	    if (!parent::isAuthorized($user)) {
	    	if ($this->action === 'admin'){
	    		return true;
	    	}
	        if (in_array($this->action, array( 'view','edit','delete' ))) {
	            $postId = $this->request->params['pass'][0];
	            return $this->Appointment->inPractice($postId, $user['practice_id']);
	        }
	        return false;
	    }
	    return true;
	}
    
    function index() {
    	$this->set('valid', true);
    	if (array_key_exists('name', $this->request->params)) {
    	    $p = $this->Appointment->Practice->findBySlug( $this->request->params['name'] );
    		if (!$p){
    	    	$this->Session->setFlash(__($this->request->params['name'].' is not a valid practice.'));
		    	$this->set('valid',false);
    	    } else {
    	    	$this->set('practice', $p);
    	    	
    	    	// Add cross-domain JS security header to allow embedding forms on practice's website
    	    	if ( $p && array_key_exists('website', $p['Practice']) ) {
    	    		$ws = $p['Practice']['website'];
    	    		if ($ws){
    	    			$ws = rtrim(Sanitize::clean($ws), '/\\');
    	    			$this->response->header('Access-Control-Allow-Origin', $ws);
    	    		}
    	    	}
    	    	
    	    }
    	} else {
    		$this->set('valid',false);
    	}
    	
    	if ($this->request->is('post')) {
    		$this->request->data['Appointment']['phone'] = $this->Appointment->parse_phone($this->request->data['Appointment']['phone']);
    		// var_dump($this->request->data['Appointment'],$_POST,$_SERVER["REMOTE_ADDR"]);

			// reCAPTCHA
    		// Original private key
    		// $privatekey = "6LcJyM8SAAAAAKGdQawQe8frzDKyLiPXOpabV8t6";
    		// Private key for healthcommunities-appointments.com,beyondbasicsphysicaltherapy.com
			$privatekey = "6Ld2QvkSAAAAAHxpPZWIENW40yEIsD84espQRlet";
    		$resp = recaptcha_check_answer ($privatekey,
    		                                $_SERVER["REMOTE_ADDR"],
    		                                $_POST["recaptcha_challenge_field"],
    		                                $_POST["recaptcha_response_field"]);
    		
    		if (!$resp->is_valid) {
	    		// What happens when the CAPTCHA was entered incorrectly
	    		$this->Session->setFlash("The reCAPTCHA wasn't entered correctly. Please try it again.");
    		} else {
	    		// Your code here to handle a successful verification
	    		$this->Appointment->create();
	            if ($this->Appointment->save($this->request->data)) {
	                $this->Session->setFlash(__('The request has been saved'));
					$email = $this->Appointment->Practice->find('first', array(
						'conditions' => array(
							'id' => $this->request->data['Appointment']['practice_id']
						)
					));
					if (!empty($email['Practice']['email'])){
						echo "Email to: ".$email['Practice']['email'];
						$mail = new CakeEmail();
						$mail->from(array('noreply@healthcommunities-appointments.com' => 'Appointment Request'))
						    ->to($email['Practice']['email'])
						    ->subject('Appointment Request Notification')
						    ->send("An appointment request has been made through your website and needs your attention. To view the request, please log in to the Appointment Request Tool: https://www.healthcommunities-appointments.com/users/login");
		            }
	                $this->redirect('/app/'.$this->request->params['name'].'/thankyou');
	            } else {
	                $this->Session->setFlash(__('The request could not be saved. Please, try again.'));
	            }
	    	}
    	}
    }
    
    public function view($id = null) {
	    $this->helpers[] = 'Time';
        $this->Appointment->id = $id;
        $this->set( 'appt', Sanitize::clean($this->Appointment->read()) );
    }

    public function edit($id = null) {
	    $this->Appointment->id = $id;
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Appointment->save($this->request->data)) {
				$this->Session->setFlash(__('The appointment request has been saved'));
				$this->redirect(array('action' => 'view', $this->Appointment->id ));
			} else {
				$this->Session->setFlash(__('The appointment request could not be saved. Please try again.'));
			}
		} else {
			if (!$this->Appointment->exists()) {
				throw new NotFoundException(__('Invalid appointment'));
			}
			$this->request->data = $this->Appointment->read(null, $id);
		}
    }
    
    public function delete($id) {
    	if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        $this->Appointment->read(null, $id);
        $this->Appointment->set('status', 'archived');
        if ($this->Appointment->save()) {
            $this->Session->setFlash('The appointment with id: ' . $id . ' has been archived.');
            $this->redirect(array('action' => 'admin'));
        }
    }
    
    public function thankyou() { }
    
    public function admin() {
    	if ('admin' == $this->Auth->user('username')){
    		$this->set('admin', true);
    		$this->set('appts', Sanitize::clean(
    			$this->Appointment->find('all', array(
    				'conditions' => array(
    					'status' => 'active'
    				),
    				'order' => array( 'created' => 'desc' )
    			))
    		) );
    	} else {
    		$this->set('admin', false);
        	$this->set('appts', Sanitize::clean(
        		$this->Appointment->find(
        			'all',
    				array(
    					'conditions' => array(
    						'practice_id' => $this->Auth->user( 'practice_id' ),
    						'status' => 'active'
    					),
    					'order' => array( 'created' => 'desc' )
    				)
    			)
    		) );
    	}
    }   
}
?>