<?php

App::uses('FormHelper', 'View/Helper');

class QuickFormHelper extends FormHelper {

    var $format_input = '<div class="control-group"><label class="control-label">%s</label><div class="controls">%s</div></div>';

    /**
     * 快速自动创建表单
     * 目的是减少写的代码，根据表结构的字段生成表单，
     * 
     * @param string $modelName
     * @param array $opts
     *  lang 数组 'feild' => 'label' 字段对应中文
     *  fields 二维数组 array( $item ) 等效$this->Form->input(...);
     *  submit 提交按钮, 如果为false 不会产生button
     *  endform 如果为false不会带form闭合标签
     *  hideother 2013.4.7新增参数，没有在lang里定义的字段不会显示出来，避免新增字段造成显示错误
     *
     * @return boolean
     */
    function quick_build($modelName, $opts = array()) {
        $model = $this->_getModel($modelName);
        if ($model == null) {
            return false;
        }
        $default_options = array('lang' => array(), 'fields' => array(), 'submit' => '提交', 'endform' => true, 'hideother'=>true);
        $opts = array_merge($default_options, $opts);

        $schema = $model->schema();
        $formarray = array('class' => 'form-horizontal');
        if (@$opts['form'])
        {
            $formarray = $opts['form']+$formarray ;
        }
        $out = $this->create($modelName, $formarray);
        if (@$opts['order']) {
            $orderarray = array_flip($opts['order']);
            $schemanew = array();
            foreach ($schema as $field => $attr) {
                $arrayorder = '999999999';
                if (isset($orderarray[$field]))
                    $arrayorder = $orderarray[$field];
                $schemanew[$field] = $attr + array('arrayorder' => $arrayorder);
            }
            $schema = $this->array_sort($schemanew, 'arrayorder');
            reset($schema);
            unset($schemanew);
        }
        foreach ($schema as $field => $attr) {
            unset($schema[$field]['arrayorder']);
            $label = isset($opts['lang'][$field]) ? $opts['lang'][$field] : __($field);
            if (!isset($opts['fields'][$field])) {
                switch ($field) {
                    case 'id':
                        $out.= $this->hidden($field);
                        break;
                    case 'active':
                        $out.= $this->hidden($field, array('default' => '0'));
                        break;
                    case 'created':
                    case 'modified':
                    case 'updated':
                        $out.= $this->hidden($field, array('default' => time()));
                        break;
                    default:
                        
                        if ($opts['hideother'] && !isset($opts['lang'][$field])) {
                            if (substr($field, -3) == '_id') {
                                $out.= $this->hidden($field, array('default' => 0));
                            }
                            continue;
                        }
                        $input = $this->input($field, array('div' => false, 'label' => false));
                        $out.= sprintf($this->format_input, $label, $input);
                        break;
                }
            } else {
                switch (@$opts['fields'][$field]['type']) {
                    case 'hidden':
                        $out.= $this->hidden($field, $opts['fields'][$field]);
                        break;
                    default:
                        $input = $this->input($field, array_merge(array('legend' => false, 'div' => false, 'label' => false), $opts['fields'][$field]));
                        $out.= sprintf($this->format_input, $label, $input);
                        break;
                }
                unset($opts['fields'][$field]);
            }
        }
        foreach ($opts['fields'] as $key => $attr) {
            $label = isset($opts['lang'][$key]) ? $opts['lang'][$key] : __($field);
            $input = $this->input($key, array_merge(array('legend' => false, 'div' => false, 'label' => false), $attr));
            if ($attr['type']=='hidden')
                $out.= $input;
            else
                $out.= sprintf($this->format_input, $label, $input);
        }

        if ($opts['submit']) {
            $input = $this->submit($opts['submit'], array('div' => false,'id'=>$modelName.'Sumbit', 'class' => 'btn btn-primary'));
            $out.= sprintf($this->format_input, '', $input);
        }
        if ($opts['endform']) {
            $out.= $this->end();
        }
        return $out;
    }

    function array_sort($arr, $keys, $type = 'asc') {
        $keysvalue = $new_array = array();
        foreach ($arr as $k => $v) {
            $keysvalue[$k] = $v[$keys];
        }
        if ($type == 'asc') {
            asort($keysvalue);
        } else {
            arsort($keysvalue);
        }
        reset($keysvalue);
        foreach ($keysvalue as $k => $v) {
            $new_array[$k] = $arr[$k];
        }
        return $new_array;
    }

}