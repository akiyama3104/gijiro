<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */

class AppController extends Controller {
//    var $components = array('DebugKit.Toolbar');

    public $components = array('Session', 'DebugKit.Toolbar',"Auth","Acl");

    public $helpers = array(
        'Session',
        'Html' => array('className' => 'TwitterBootstrap.BootstrapHtml'),
        'Form' => array('className' => 'TwitterBootstrap.BootstrapForm'),
        'Paginator' => array('className' => 'TwitterBootstrap.BootstrapPaginator'),
    );
    function beforeFilter(){
        $this->set("title_for_layout","gijiro!");
        //未ログイン状態であると、ログイン画面、登録画面しか行けないようにする

//        $this->Auth->actionPath = 'controllers/';
//        $this->Auth->authorize = 'actions';
//
//
        $this->Auth->authError = 'ログインしてください';
        $this->Auth->loginError = 'ログインに失敗しました。';
//
//        $this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'index');
//        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
//

    }



}
