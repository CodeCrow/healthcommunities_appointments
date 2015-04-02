<?php
// app/Controller/UsersController.php
App::uses('Sanitize', 'Utility');
class UsersController extends AppController {

	public function beforeFilter() {
	    parent::beforeFilter();
        $this->Auth->allow('login');
	}
	
	public function beforeRender() {
	    parent::beforeRender();
	    $p = false;
		if (null !== $this->Auth->user('practice_id')) {
			$this->set('user',$this->Auth->user());
			$this->User->Practice->id = $this->Auth->user('practice_id');
			if ($this->User->Practice->exists()){
				$p = $this->User->Practice->read();	
				$this->set('practice', Sanitize::clean($p));
			} else {
				$this->set('practice', false);
			}
		} else {
			$this->set('practice', false);
		}
		if ($p && null != $p['Practice']['theme']){
			$this->theme = $p['Practice']['theme'];
		}
	}
	
	public function isAuthorized($user) {
	    if (!parent::isAuthorized($user)) {
	        if ($this->action === 'logout') {
	            // All registered users can logout
	            return true;
	        }
	        if (in_array($this->action, array('edit', 'view'))) {
	            $user_id = $this->request->params['pass'][0];
	            if ($this->Auth->user('id') == $user_id){
	            	return true;
	            }
	        }
	        $this->Session->setFlash(__('You don\'t have access to this.'));
	        return false;
	    }
	    return true;
	}
	
	public function login() {
	    if ($this->Auth->login()) {
	        $this->redirect($this->Auth->redirect());
	    } elseif ($this->request->is('post')) {
	        $this->Session->setFlash(__('Invalid username or password, try again'));
	    }
	}
	
	public function logout() {
	    $this->redirect($this->Auth->logout());
	}

    public function index() {
        $this->set('users', Sanitize::clean($this->User->find('all')));
        //$this->User->recursive = 0;
        //$this->set('users', $this->paginate());
    }

    public function view($id = null) {
    	$this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('v_user', Sanitize::clean($this->User->read(null, $id)));
    }

    public function add() {
    	$this->set('practices', $this->User->Practice->find('list'));
    	//var_dump($this->request->data);
        if ($this->request->is('post')) {
	        if ( !empty($this->request->data['User']['practice_name']) ) {
	        	$this->User->Practice->create();
	        	$new_practice = array( 
	        		'Practice' => array(
                        'name' => $this->request->data['User']['practice_name'],
                        'slug' => $this->request->data['User']['practice_slug']
	        		)
	        	);
	        	if ( $this->User->Practice->save($new_practice) ) {
		       		$this->Session->setFlash(__('The practice has been added'));
		       		$this->request->data['User']['practice_id'] = $this->User->Practice->id;
		       	} else {
		       		$this->Session->setFlash(__('The practice could not be added, user not saved. Please, try again'));
		       		return;
		       	}
            }
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        }
    }

    public function edit($id = null) {
	    $this->set('practices', $this->User->Practice->find('list'));
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }

    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            $this->redirect(array('action'=>'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}