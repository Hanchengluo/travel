<?php
App::uses('AppController', 'Controller');
/**
 * Devices Controller
 *
 * @property Device $Device
 */
class DevicesController extends AppController {

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
        $this->UserAuth->hasPurview('admin_device');
		
		$this->Device->recursive = 0;
		$this->paginate = array(
			'order'=>array('id desc')
		);
		$this->set('data', $this->paginate());
		$this->set($this->Device->getArr());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Device->id = $id;
		if (!$this->Device->exists()) {
			throw new NotFoundException(__('Invalid device'));
		}
		$this->set('device', $this->Device->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Device->create();
			if ($this->Device->save($this->request->data)) {
				$this->succ('添加成功！');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->error('添加失败！');
			}
		}
		$this->set($this->Device->getArr());
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Device->id = $id;
		if (!$this->Device->exists()) {
			throw new NotFoundException(__('Invalid device'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Device->save($this->request->data)) {
				$this->succ('保存成功！');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->error('保存失败!');
			}
		} else {
			$this->request->data = $this->Device->read(null, $id);
		}
		$this->set($this->Device->getArr());
	}

	/**
	 * admin_delete method
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_lock($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Device->id = $id;
		if (!$this->Device->exists()) {
			throw new NotFoundException(__('Invalid device'));
		}
		if ($this->Device->saveField('active',-1)) {
			$this->succ('锁定成功！');
			$this->redirect(array('action' => 'index'));
		}
		$this->error('锁定失败！');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_active($id = null) {
		$this->Device->id = $id;
		if (!$this->Device->exists()) {
			throw new NotFoundException(__('Invalid device'));
		}
		if ($this->Device->saveField('active',0)) {
			$this->succ('激活成功！');
			$this->redirect(array('action' => 'index'));
		}
		$this->error('激活失败！');
		$this->redirect(array('action' => 'index'));
	}
}
