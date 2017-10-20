<?php
App::uses('AppController', 'Controller');
/**
 * Attenders Controller
 *
 * @property Attender $Attender
 * @property PaginatorComponent $Paginator
 * @property UtilComponent $Util
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class AttendersController extends AppController {

/**
 * Helpers
 *
 * @var array
 */


/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Util', 'Session', 'Flash','RequestHandler');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Attender->recursive = 0;
		$this->set('attenders', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Attender->exists($id)) {
			throw new NotFoundException(__('Invalid attender'));
		}
		$options = array('conditions' => array('Attender.' . $this->Attender->primaryKey => $id));
		$this->set('attender', $this->Attender->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Attender->create();
			if ($this->Attender->save($this->request->data)) {
				$this->Flash->success(__('The attender has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The attender could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Attender->exists($id)) {
			throw new NotFoundException(__('Invalid attender'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Attender->save($this->request->data)) {
				$this->Flash->success(__('The attender has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The attender could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Attender.' . $this->Attender->primaryKey => $id));
			$this->request->data = $this->Attender->find('first', $options);
		}
	}

/**
 * search method
 *
 * @throws NotFoundException
 * @param string $key
 * @return string $result
 */
    var $name = "Task";

	public function search($key = "") {
		$this->Attender->id = $id;
		if (!$this->Attender->exists()) {
			throw new NotFoundException(__('Invalid attender'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Attender->delete()) {
			$this->Flash->success(__('The attender has been deleted.'));
		} else {
			$this->Flash->error(__('The attender could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}




