<?php 
class UsersController extends AppController {

    public $allow = array('register','login');
    public $uses = array('User','UserLog','Group','UserAccesses');

    public  function login( $action = '/sell/orders/index' ) {

        $this->layout = 'user';
        if ( $this->request->isPost() ) {
            $this->request->data['User']['username'] = trim( $this->request->data['User']['username'] );
            $this->request->data['User']['password'] = trim( $this->request->data['User']['password'] );

            $postData = $this->data;

            $username = $postData['User']['username'];
            $password = $postData['User']['password'];
            $this->User->recursive = -1;
            $this->User->cache=false;
            $user = $this->User->findByUsername( $username );
            if ( empty( $user ) && strlen( $username ) == 11 && is_numeric( $username ) ) {
                $user = $this->User->findByName( $username );
                if ( empty( $user ) ) {
                    $this->User->validationErrors = array(
                        'username' => array( "用户不存在" )
                    );
                    $this->error( '用户不存在' );
                    return;
                }
            }
            if ( $user['User']['password'] === md5($password)) {
                $this->UserAuth->login( $user );
                $this->_exchange_log($user['User']['id'],'login');
                $uri = $this->Session->read(UserAuthComponent::originAfterLogin );
                if ( !$uri ) {
                    $uri = $action;
                }
                CakeSession::delete( 'Message.flash' );
                $this->Session->delete( UserAuthComponent::originAfterLogin );
                $this->redirect( $uri );
            }
            $this->User->validationErrors = array(
                'password' => array( "密码错误" )
            );
            $this->error( '密码错误' );
            return;
        }
    }

    public function logout() {
        $this->layout = 'user';
        $this->UserAuth->logout();
        $this->_exchange_log($this->UserAuth->getUserId(),'logout');

        $this->redirect( array( 'action' => 'login' ) );
    }

    /**
     * ************ 权限管理模块部分 ************
     */

    /**
     * 用户管理
     */
    public function purview_index() {
        $this->UserAuth->hasPurview('purview_user');

        $conditions = array();
        if($this->request->query['keyword']){
            $conditions[$this->request->query['type'].' like'] = '%'.$this->request->query['keyword'].'%';
            $this->request->data['User'] = $this->request->query;
        }
        $this->paginate = array(
            'order'=>array('User.id desc'),
            'conditions'=>$conditions,
        );
        $data = $this->paginate();

        $groups = $this->Group->find('list',array(
            'fields'=>array('Group.id','Group.name'),
            'order'=>'Group.id desc',
        ));

        $this->set(compact('groups'));
        $this->set($this->User->getArr());
        $this->set('data',$data);
    }

    /**
     * 添加
     */
    public function purview_add(){
        $this->UserAuth->hasPurview('purview_user_add');

        $this->loadModel('Group');
        $this->loadModel('Feature');
        $group_arr = $this->Group->find('list');
        $user_access_arr = $this->Feature->getTree();
        $this->set($this->User->getArr());
        $this->set(compact('group_arr','user_access_arr'));

        if($this->request->is('post')){
            $post_data = $this->request->data;
            $post_data['User']['password'] = md5($post_data['User']['password']);
            $user = $this->User->save($post_data);
            if(!$user){
                $this->error('添加错误！');
                return ;
            }
            $feature_data = array();
            if(is_array($post_data['feature'])){
                foreach ($post_data['feature'] as $key => $feature_id) {
                    $user_id = $user['User']['id'];
                    $feature_data[] = array(
                        'user_id' => $user_id,
                        'feature_id' =>$feature_id
                    );
                }
            }
            $this->loadModel('UserAccesses');
            $this->UserAccesses->saveMany($feature_data);
            $this->_user_log($this->UserAuth->getUserId(),'添加了用户'.$user['User']['username']);
            $this->succ('添加成功！');
            $this->redirect(array('action'=>'index','purview'=>true));
        }
    }

    /**
     * 删除
     */
    public function purview_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        $user = $this->User->read();
        if (!$user) {
            throw new NotFoundException('用户不存在');
        }
        if ($this->User->delete($id)) {
            $this->succ('删除成功！');
            $this->_user_log($this->UserAuth->getUserId(),'删除了用户'.$user['User']['username']);
            $this->redirect(array('action' => 'index'));
        }
        $this->error('删除失败！');
        $this->redirect(array('action' => 'index'));
    }

    public function purview_edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException('用户不存在!');
        }
        $this->loadModel('Group');
        $this->loadModel('Feature');
        $group_arr = $this->Group->find('list');
        $user_access_arr = $this->Feature->getTree();

        $this->UserAccesses->cache = false;
        $user_access_data = $this->UserAccesses->find(
            'list',array(
                'fields'=>array('UserAccesses.id','UserAccesses.feature_id'),
                'conditions'=>array('UserAccesses.user_id'=>$id)
            )
        );

        $this->set($this->User->getArr());
        $this->set(compact('group_arr','user_access_arr','user_access_data'));

        if ($this->request->is('post') || $this->request->is('put')) {
            $post_data = $this->request->data;
            
            $feature_data = array();
            if(is_array($post_data['feature'])){
                foreach ($post_data['feature'] as $key => $feature_id) {
                    $feature_data[] = array(
                        'user_id' => $id,
                        'feature_id' =>$feature_id
                    );
                }
            }
            $this->UserAccesses->cache = false;
            $this->UserAccesses->deleteAll(array('user_id'=>$id));
            if ($this->User->save($post_data) && $this->UserAccesses->saveMany($feature_data)) {
                $this->succ('保存成功！');

                $user= $this->User->read(null,$id);
                $log_content = "对".$user['User']['username']."进行了用户信息变更";
                $this->_user_log($this->UserAuth->getUserId(),$log_content);
                $this->redirect(array('action' => 'index'));
            } else {
                $this->error('保存失败！');
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
        }
        $this->set($this->User->getArr());
    }

    public function purview_password($id){
        $this->User->id = $id;
        $user = $this->User->read(null,$id);
        if (!$user) {
            throw new NotFoundException('用户不存在!');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $post_data = $this->request->data;
            if(!$post_data['User']['password']){
                $this->error('必须填写！');
                return;
            }
            if($post_data['User']['cpassword'] != $post_data['User']['password']){
                $this->error('两次输入必须一致！');
                return;
            }
            if($this->User->saveField('password',md5($post_data['User']['password']))){
                $this->succ('修改成功!');
                $user= $this->User->read(null,$id);
                $log_content = "对".$user['User']['username']."进行了密码修改";
                $this->_user_log($this->UserAuth->getUserId(),$log_content);
            }else{
                $this->error('修改错误！');
            }
        }else{
            $this->request->data = $this->User->read(null,$id);
        }
    }

    public function purview_view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException('无效用户');
        }
        $this->set('user', $this->User->read(null, $id));
    }

    public function purview_log(){
        $this->UserAuth->hasPurview('purview_user_log');
        
        $conditions = array();
        $query = $this->request->query;
        if($query['name']){
            $conditions['User.name'.' like'] = '%'.$this->request->query['name'].'%';
        }
        if($query['start_time']){
            $conditions['UserLog.created'.' >='] = strtotime($query['start_time']);
        }
        if($query['end_time']){
            $conditions['UserLog.created'.' <='] = strtotime($query['end_time']);
        }
        $this->request->data['User'] = $query;
        $this->paginate = array(
            'order'=>'UserLog.id desc',
            'conditions'=>$conditions
        );
        $this->set('data',$this->paginate('UserLog'));
    }

    /**
     * ***********  管理模块部分 *******
     */
    /**
     * 交办记录
     */
    public function admin_log(){
        $this->UserAuth->hasPurview('admin_exchange_record');

        $conditions = array();
        $query = $this->request->query;
        if($query['name']){
            $conditions['User.name'.' like'] = '%'.$this->request->query['name'].'%';
        }
        if($query['start_time']){
            $conditions['StaffExchange.created'.' >='] = strtotime($query['start_time']);
        }
        if($query['end_time']){
            $conditions['StaffExchange.created'.' <='] = strtotime($query['end_time']);
        }
        $this->request->data['User'] = $query;
        $this->paginate = array(
            'order'=>'StaffExchange.id desc',
            'conditions'=>$conditions
        );
        $this->loadModel('StaffExchange');
        $this->StaffExchange->cache = false;
        $this->set('data',$this->paginate('StaffExchange'));
        $this->set($this->StaffExchange->getArr());
    }

    /**
     * 用户改变日志
     */
    public function _user_log($user_id,$logs){
        $data = array(
            'user_id'=>$user_id,
            'logs'=>$logs,
            'created'=>time()
        );

        $this->loadModel('UserLog');
        $this->UserLog->create();
        return $this->UserLog->save($data);
    }

    public function _exchange_log($user_id,$action){
        $data = array(
            'user_id'=>$user_id,
            'action'=>$action,
            'created'=>time()
        );

        $this->loadModel('StaffExchange');
        $this->StaffExchange->create();
        return $this->StaffExchange->save($data);
    }
}
 ?>