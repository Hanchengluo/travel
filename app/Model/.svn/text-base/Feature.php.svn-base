<?php
App::uses('AppModel', 'Model');
/**
 * Feature Model
 *
 */
class Feature extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';


    public function getTree(){
        $result = array();
        $root_arr = $this->find('all',array(
            'fields'=>array('Feature.name','Feature.id','Feature.root_id')
        ));
        $data = array();
        foreach ($root_arr as $key => $value) {
            $data[] = $value['Feature'];
        }
        $result = $this->build_tree($data,0);
        return $result;
    }

    function build_tree($rows,$root_id){
        $childs = array();
        $childs = $this-> findChild($rows,$root_id);

        foreach ($childs as $key => $value) {
            $sub_childs = $this->findChild($rows,$value['id']);
            if(!empty($childs)){
                $childs[$key]['childs'] = $sub_childs;
            }
        }
        return $childs;
    }

    function findChild(&$arr,$id){
        $childs=array();
         foreach ($arr as $k => $v){
             if($v['root_id']== $id){
                $childs[] = $v;
             }
        }
        return $childs;
    }

	public function getOwnList($user_id)
	{
		$this->recursive = 0;
		$data = $this->find('list',array(
			'fields'=>array('Feature.alias'),
            'joins' => array(
                array(
                    'table' => 'user_accesses',
                    'alias' => 'UserAccess',
                    'type' => 'inner',
                    'conditions' => 'Feature.id=UserAccess.feature_id'
                ),
            ),
            'conditions'=>array(
            	'UserAccess.user_id'=>$user_id
            )
		));
		return $data;
	}
}
