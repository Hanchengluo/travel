<?php
App::uses('AppController', 'Controller');
/**
 * Categories Controller
 *
 * @property Category $Category
 */
class CategoriesController extends AppController {
	
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->UserAuth->hasPurview('admin_category');

		if ($this->request->is('post')) {
			$this->Category->create();
			if ($this->Category->save($this->request->data)) {
				$this->succ('添加成功！');
				$this->redirect($this->referer());
			} else {
				$this->error('添加失败！');
			}
		}
		$this->paginate = array(
			'conditions'=>array('Category.active>=0')
		);
		$this->Category->recursive = 0;
		$this->set('categories', $this->paginate());
		$this->set($this->Category->getArr());
	}

	/**
	 * admin_view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException('无效请求！');
		}
		$category = $this->Category->read(null, $id);
		if($this->request->is('ajax')){
			echo json_encode($category['Category']);
			$this->_stop();
		}	
		$this->set('category',$category);
	}

	/**
	* admin_edit method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public function admin_edit($id = null) {
		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException('票种不存在!');
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Category->save($this->request->data)) {
				$this->succ('保存成功！');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->error('保存失败！');
			}
		} else {
			$this->request->data = $this->Category->read(null, $id);
		}
		$this->set($this->Category->getArr());
	}

	/**
	 * admin_delete method
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException('票种不存在');
		}
		if ($this->Category->saveField('active',-1)) {
			$this->succ('删除成功！');
			$this->redirect(array('action' => 'index'));
		}
		$this->error('删除失败！');
		$this->redirect(array('action' => 'index'));
	}
}
