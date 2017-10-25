<?php
App::uses('AppController', 'Controller');
/**
 * Attenders Controller
 *
 * @property Attender $Attender
 * @property PaginatorComponent $Paginator
 */
class AttendersController extends AppController {

/**
 *  Layout
 *
 * @var string
 */
	public $layout = 'bootstrap';

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('TwitterBootstrap.BootstrapHtml', 'TwitterBootstrap.BootstrapForm', 'TwitterBootstrap.BootstrapPaginator');
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
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
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Attender->id = $id;
		if (!$this->Attender->exists()) {
			throw new NotFoundException(__('Invalid %s', __('attender')));
		}
		$this->set('attender', $this->Attender->read(null, $id));
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
				$this->Session->setFlash(
					__('The %s has been saved', __('attender')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('attender')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Attender->id = $id;
		if (!$this->Attender->exists()) {
			throw new NotFoundException(__('Invalid %s', __('attender')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Attender->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('attender')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('attender')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->Attender->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Attender->id = $id;
		if (!$this->Attender->exists()) {
			throw new NotFoundException(__('Invalid %s', __('attender')));
		}
		if ($this->Attender->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('attender')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('attender')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}

}
