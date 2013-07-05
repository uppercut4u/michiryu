<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

  public $components = array(
	'Auth' => array(
		'authenticate' => array(
			'MyForm' => array('scope' => array('User.del_flg' => 0)),
		),
		'loginRedirect'  => array('controller' => 'users', 'action' => 'menu'),
		'logoutRedirect' => array('controller' => 'login', 'action' => 'index'),
		'loginAction'    => array('controller' => 'login', 'action' => 'index'),
	),
	'Session',
	// 'DebugKit.Toolbar',
	'Search.Prg',
	'Convert',
	'Round',
	'Security',
	'Cookie',
  );
  
  public $helpers = array(
	'Js',
	'Session',
	'Html' => array('className' => 'TwitterBootstrap.BootstrapHtml'),
	'Form' => array('className' => 'TwitterBootstrap.BootstrapForm'),
	'Paginator' => array('className' => 'TwitterBootstrap.BootstrapPaginator'),
  );
    
  public $layout = 'TwitterBootstrap.default';

  public function beforeFilter(){
	$this->Security->validatePost = false;
	if(!isset($_SERVER['HTTP_X_SAKURA_FORWARDED_FOR'])){
		$this->Security->blackHoleCallback = 'forceSecure';
		$this->Security->requireSecure();
	}
	
	$this->Cookie->name = 'mrt_cookies';
	$this->Cookie->time = '1 hour';
	$this->Cookie->secure = true;
  }

  public function forceSecure(){
	$this->redirect('https://' . env('SERVER_NAME') . $this->here);
  }
}
