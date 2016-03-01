<?php
App::uses('AppController', 'Controller');
/**
 * AgentUsers Controller
 *
 * @property AgentUser $AgentUser
 */
class AgentUsersController extends AppController {

/**
 * agent_index method
 *
 * @return void
 */
	public function agent_index($agent_id = 0) {
		$this->paginate = array(
			'conditions'=>array('AgentUser.agent_id','AgentUser.active>=0')
		);
		$this->AgentUser->recursive = 0;
		$this->set('data', $this->paginate());
		$this->set(compact('agent_id'));
	}

/**
 * agent_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function agent_view($id = null) {
		$this->AgentUser->id = $id;
		if (!$this->AgentUser->exists()) {
			throw new NotFoundException('代理不存在！');
		}
		$this->set('agentUser', $this->AgentUser->read(null, $id));
	}

/**
 * agent_add method
 *
 * @return void
 */
	public function agent_add($agent_id = 0) {
		if ($this->request->is('post')) {
			$this->AgentUser->create();
			if ($this->AgentUser->save($this->request->data)) {
				$this->succ('添加成功 ！');
				$this->redirect(array('action' => 'index',$agent_id));
			} else {
				$this->error('添加失败 ！');
			}
		}
		$this->set(compact('agent_id'));
	}

/**
 * agent_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function agent_edit($id = null) {
		$this->AgentUser->id = $id;
		if (!$this->AgentUser->exists()) {
			throw new NotFoundException(__('Invalid agent user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->AgentUser->save($this->request->data)) {
				$this->succ('编辑成功 ！');
				$this->redirect($this->referer());
			} else {
				$this->error('编辑失败 ！');
			}
		} else {
			$this->request->data = $this->AgentUser->read(null, $id);
		}
	}

/**
 * agent_delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function agent_del($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->AgentUser->id = $id;
		if (!$this->AgentUser->exists()) {
			throw new NotFoundException(__('Invalid agent user'));
		}
		if ($this->AgentUser->saveField('active','-1')) {
			$this->succ('删除成功！');
			$this->redirect(array('action' => 'index',$agent_id));
		}
		$this->error('删除失败！');
		$this->redirect(array('action' => 'index',$agent_id));
	}	
}
