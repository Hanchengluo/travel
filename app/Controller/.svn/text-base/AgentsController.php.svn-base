<?php
App::uses('AppController', 'Controller');
/**
 * Agents Controller
 *
 * @property Agent $Agent
 */
class AgentsController extends AppController {

/**
 * agent_index method
 *
 * @return void
 */
	public function agent_index() {
		$this->UserAuth->hasPurview('agent_index');

		$conditions = array(
			'Agent.active>=0',
		);
		$query = $this->request->query;
        if($query['name']){
            $conditions['Agent.name'.' like'] = '%'.$query['name'].'%';
        }
        $this->request->data['Agent'] = $query;

       	$this->paginate = array(
       		'conditions'=>$conditions
       	);
		$this->Agent->recursive = 0;
		$this->set('data', $this->paginate());
		$this->set($this->Agent->getArr());
	}

/**
 * agent_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function agent_view($id = null) {
		$this->Agent->id = $id;
		if (!$this->Agent->exists()) {
			throw new NotFoundException(__('Invalid agent'));
		}
		$this->set('agent', $this->Agent->read(null, $id));
	}

/**
 * agent_add method
 *
 * @return void
 */
	public function agent_add() {
		$this->UserAuth->hasPurview('agent_add');
		
		if ($this->request->is('post')) {
			$this->Agent->create();
			if ($this->Agent->save($this->request->data)) {
				$this->Session->setFlash(__('The agent has been saved'));
				$this->succ('添加成功 ！');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->error('添加失败 ！');
			}
		}
		$this->set($this->Agent->getArr());
	}

/**
 * agent_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function agent_edit($id = null) {
		$this->Agent->id = $id;
		if (!$this->Agent->exists()) {
			throw new NotFoundException(__('Invalid agent'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Agent->save($this->request->data)) {
				$this->succ('编辑成功 ！');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->error('编辑失败 ！');
			}
		} else {
			$this->request->data = $this->Agent->read(null, $id);
		}
		$this->set($this->Agent->getArr());
	}

/**
 * agent_delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function agent_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Agent->id = $id;
		if (!$this->Agent->exists()) {
			throw new NotFoundException(__('Invalid agent'));
		}
		if ($this->Agent->delete()) {
			$this->succ('删除成功！');
			$this->redirect(array('action' => 'index'));
		}
		$this->error('删除失败！');
		$this->redirect(array('action' => 'index'));
	}
}
