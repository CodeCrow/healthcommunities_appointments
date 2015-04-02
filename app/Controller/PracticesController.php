<?php
App::uses('Sanitize', 'Utility');
class PracticesController extends AppController {
    public $helpers = array ('Html','Form');
    public $name = 'Practices';

	public function beforeFilter() {
	    parent::beforeFilter();
	}
	
	public function beforeRender() {
	    parent::beforeRender();
	    $p = false;
		if (null !== $this->Auth->user('practice_id')) {
			$this->set('user',$this->Auth->user());
			$this->Practice->id = $this->Auth->user('practice_id');
			if ($this->Practice->exists()){
				$p = $this->Practice->read();
				$this->set('practice', Sanitize::clean($p));
			}
		}
		if ($p && null != $p['Practice']['theme']){
			$this->theme = $p['Practice']['theme'];
		}
		if ('edit' == $this->action){
			$this->Practice->id = $this->request->params['pass'][0];
			$p = $this->Practice->read();
		}
		$this->set('current_practice', $p['Practice']);
	}
	
	public function isAuthorized($user) {
	    if (!parent::isAuthorized($user)) {
	    	if ($this->action === 'admin'){
	    		return true;
	    	}
	        if ( 'index' == $this->action ) {
	        	// not admin, index should redirect to edit your settings.
	        	$this->redirect('/practices/edit/'.$user['practice_id']);
	        } else if ('edit' == $this->action) {
		        $practiceID = $this->request->params['pass'][0];
		        if ($user['practice_id'] != $practiceID) 
			        $this->redirect('/practices/edit/'.$user['practice_id']);
			    else
			        return true;
	        }
	        return false;
	    }
	    return true;
	}
    
    public function index($id = null) {
        $this->set('practices', Sanitize::clean($this->Practice->find('all')));
    }
    
    public function edit($id = null) {
		$this->Practice->id = $id;
		if (!$this->Practice->exists()) {
			throw new NotFoundException(__('Invalid practice'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$dup = $this->Practice->find('count', array(
				'conditions' => array(
					'slug' => $this->request->data['Practice']['slug'],
					'id !=' => $this->request->data['Practice']['id'],
				)
			));
			if (!$dup){
				//var_dump($this->request->data);
				if ($this->Practice->save($this->request->data)) {
					$this->Session->setFlash(__('The practice settings have been saved'));
					$this->redirect(array('action' => 'edit', $id));
				} else {
					$this->Session->setFlash(__('The practice settings could not be saved. Please try again.'));
				}
			} else {
				$this->request->data['Practice']['slug'] = '';
				$this->Session->setFlash(__('Slug already in use by another practice. Please use a unique identifier.'));
			}
		} else {
			$this->request->data = $this->Practice->read(null, $id);
		}
    }
    
}
?>