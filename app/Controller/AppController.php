<?php
// app/Controller/AppController.php
class AppController extends Controller {
	public $viewClass = 'Theme';
	public $theme = 'Blue';

    public $components = array(
        'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'appointments', 'action' => 'admin'),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
            'authorize' => array('Controller'),
            'authError' =>"You don't have access to this."
        ),
        'Security'
    );

    function beforeFilter() {
	    $this->Auth->authorize = 'Controller';
        $this->Auth->deny('*');
        $this->Security->blackHoleCallback = 'forceSSL';
        $this->Security->requireSecure();
    }

	public function isAuthorized($user) {
	    if (isset($user['username'])) {
	    	if ($user['username'] === 'admin') {
		        return true; //Admin can access every action
		    }
		}
		return false;
	}

	function forceSSL() {
		 /* Apache */  /* IIS */  /* others */
		if ( !empty($_SERVER['https']) || ($_SERVER['SERVER_PORT'] != 443) ){
			$this->redirect('https://' . env('SERVER_NAME') . $this->here);
		}
	}

}