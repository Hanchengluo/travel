<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 * @property HtmlHelper $Html
 * @property PaginatorHelper $Paginator
 */
class AppHelper extends Helper {

    var $helpers = array('Paginator', 'Html');

    function Boolean2Zh($value) {
        return $value ? '是' : '否';
    }

    function yn2Zh($value){
        $value = strtolower($value);
        $attr = array('y'=>'是','n'=>'否');
        return @$arrt[$value];
    }

    function bootstrap_operate_link($url,$link_name, $style = 'edit') {
        $style_maps = array(
                'edit' => array('编辑', 'btn btn-small btn-primary', 'icon-pencil icon-white'),
                'del' => array('删除', 'btn btn-small btn-danger', 'icon-remove icon-white'),
        );
        if (!isset($style_maps[$style])) {
            return false;
        }
        list($text, $a_class, $i_class) = $style_maps[$style];
        if ($link_name) $text=$link_name;
        $tag_i = $this->Html->tag('i', '', array('class' => $i_class));
        return $this->Html->link($tag_i.' '.$text, $url, array('class'=>$a_class, 'escape'=>false));
    }

    /**
     * bootstrap风格分页
     * 有bug 不能用， 不支持类似 /index/page:5?type=MerchantProductOrder.id&keyword=%E6%B5%8B%E8%AF%95
     *
     * @param arry $options
     * @return boolean|string
     */
    function bootstrap_paginator($options = array()) {
        if ($options === true) {
            $options = array(
                    'before' => ' | ', 'after' => ' | ', 'first' => 'first', 'last' => 'last'
            );
        }

        $defaults = array(
                'tag' => 'li', 'before' => null, 'after' => null, 'model' => $this->Paginator->defaultModel(), 'class' => null,
                'modulus' => '8', 'separator' => '', 'first' => null, 'last' => null, 'ellipsis' => '...', 'currentClass' => 'active'
        );
        $options += $defaults;

        $params = (array)$this->Paginator->params($options['model']) + array('page' => 1);
        unset($options['model']);

        if ($params['pageCount'] <= 1) {
            return false;
        }

        extract($options);
        unset($options['tag'], $options['before'], $options['after'], $options['model'],
                $options['modulus'], $options['separator'], $options['first'], $options['last'],
                $options['ellipsis'], $options['class'], $options['currentClass']
        );

        $out = '';

        if ($modulus && $params['pageCount'] > $modulus) {
            $half = intval($modulus / 2);
            $end = $params['page'] + $half;

            if ($end > $params['pageCount']) {
                $end = $params['pageCount'];
            }
            $start = $params['page'] - ($modulus - ($end - $params['page']));
            if ($start <= 1) {
                $start = 1;
                $end = $params['page'] + ($modulus - $params['page']) + 1;
            }

            if ($first && $start > 1) {
                $offset = ($start <= (int)$first) ? $start - 1 : $first;
                if ($offset < $start - 1) {
                    $out .= $this->first($offset, compact('tag', 'separator', 'ellipsis', 'class'));
                } else {
                    $out .= $this->first($offset, compact('tag', 'separator', 'class', 'ellipsis') + array('after' => $separator));
                }
            }

            $out .= $before;

            for ($i = $start; $i < $params['page']; $i++) {
                $out .= $this->Html->tag($tag, $this->link($i, array('page' => $i), $options), compact('class')) . $separator;
            }

            if ($class) {
                $currentClass .= ' ' . $class;
            }
            $out .= $this->Html->tag($tag, $params['page'], array('class' => $currentClass));
            if ($i != $params['pageCount']) {
                $out .= $separator;
            }

            $start = $params['page'] + 1;
            for ($i = $start; $i < $end; $i++) {
                $out .= $this->Html->tag($tag, $this->link($i, array('page' => $i), $options), compact('class')) . $separator;
            }

            if ($end != $params['page']) {
                $out .= $this->Html->tag($tag, $this->link($i, array('page' => $end), $options), compact('class'));
            }

            $out .= $after;

            if ($last && $end < $params['pageCount']) {
                $offset = ($params['pageCount'] < $end + (int)$last) ? $params['pageCount'] - $end : $last;
                if ($offset <= $last && $params['pageCount'] - $end > $offset) {
                    $out .= $this->last($offset, compact('tag', 'separator', 'ellipsis', 'class'));
                } else {
                    $out .= $this->last($offset, compact('tag', 'separator', 'class', 'ellipsis') + array('before' => $separator));
                }
            }

        } else {
            $out .= $before;

            for ($i = 1; $i <= $params['pageCount']; $i++) {
                if ($i == $params['page']) {
                    if ($class) {
                        $currentClass .= ' ' . $class;
                    }
                    $out .= $this->Html->tag($tag, $this->link($i, array('page' => $i), $options), array('class' => $currentClass));
                } else {
                    $out .= $this->Html->tag($tag, $this->link($i, array('page' => $i), $options), compact('class'));
                }
                if ($i != $params['pageCount']) {
                    $out .= $separator;
                }
            }

            $out .= $after;
        }
        return '<div class="pagination"><ul>' . $out . '</ul></div>';
    }
    
    public function bootstrap_link($title, $url = null, $options = array(), $confirmMessage = false) {
        $iconclass = isset($options['iconclass']) ? $options['iconclass'] : 'icon-th-list';
        unset($options['iconclass']);
        $options['escape'] = false;
        $span = sprintf('<i class="%s"></i><span>%s</span>', $iconclass, $title);
        return $this->link($span, $url, $options, $confirmMessage);
    }

    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function formatMoney($string)
    {
        return sprintf("%.2f", $string);
    }
    

    public function yn_image($path, $options = array()) {
        if (is_array($path)) {
            $path = $this->url($path);
            $path = YN_STATIC_URL . $path;
        } elseif (strpos($path, '://') === false) {
            if ($path[0] !== '/') {
                $path = IMAGES_URL . $path;
            }
            $path = $this->assetTimestamp($this->webroot($path));
            $path = YN_STATIC_URL . $path;
        }
        if (!isset($options['alt'])) {
            $options['alt'] = '';
        }

        $url = false;
        if (!empty($options['url'])) {
            $url = $options['url'];
            unset($options['url']);
        }

        $image = sprintf($this->_tags['image'], $path, $this->_parseAttributes($options, null, '', ' '));

        if ($url) {
            return sprintf($this->_tags['link'], $this->url($url), null, $image);
        }
        return $image;
    }

    public function yn_script($url, $options = array()) {
        if (is_bool($options)) {
            list($inline, $options) = array($options, array());
            $options['inline'] = $inline;
        }
        $options = array_merge(array('block' => null, 'inline' => true, 'once' => true), $options);
        if (!$options['inline'] && empty($options['block'])) {
            $options['block'] = __FUNCTION__;
        }
        unset($options['inline']);

        if (is_array($url)) {
            $out = '';
            foreach ($url as $i) {
                $out .= "\n\t" . $this->script($i, $options);
            }
            if (empty($options['block'])) {
                return $out . "\n";
            }
            return null;
        }
        if ($options['once'] && isset($this->_includedScripts[$url])) {
            return null;
        }
        $this->_includedScripts[$url] = true;

        if (strpos($url, '//') === false) {
            if ($url[0] !== '/') {
                $url = JS_URL . $url;
            }
            if (strpos($url, '?') === false && substr($url, -3) !== '.js') {
                $url .= '.js';
            }
            $url = $this->assetTimestamp($this->webroot($url));

            if (Configure::read('Asset.filter.js')) {
                $url = str_replace(JS_URL, 'cjs/', $url);
            }
            $url = YN_STATIC_URL . $url;
        }

        $attributes = $this->_parseAttributes($options, array('block', 'once'), ' ');
        $out = sprintf($this->_tags['javascriptlink'], $url, $attributes);

        if (empty($options['block'])) {
            return $out;
        } else {
            $this->_View->append($options['block'], $out);
        }
    }

    public function yn_css($path, $rel = null, $options = array()) {
        $options += array('block' => null, 'inline' => true);
        if (!$options['inline'] && empty($options['block'])) {
            $options['block'] = __FUNCTION__;
        }
        unset($options['inline']);

        if (is_array($path)) {
            $out = '';
            foreach ($path as $i) {
                $out .= "\n\t" . $this->css($i, $rel, $options);
            }
            if (empty($options['block'])) {
                return $out . "\n";
            }
            return;
        }

        if (strpos($path, '//') !== false) {
            $url = $path;
        } else {
            if ($path[0] !== '/') {
                $path = CSS_URL . $path;
            }

            if (strpos($path, '?') === false) {
                if (substr($path, -4) !== '.css') {
                    $path .= '.css';
                }
            }
            $url = $this->assetTimestamp($this->webroot($path));

            if (Configure::read('Asset.filter.css')) {
                $pos = strpos($url, CSS_URL);
                if ($pos !== false) {
                    $url = substr($url, 0, $pos) . 'ccss/' . substr($url, $pos + strlen(CSS_URL));
                }
            }
        }

        if ($rel == 'import') {
            $out = sprintf($this->_tags['style'], $this->_parseAttributes($options, array('inline', 'block'), '', ' '), '@import url(' . $url . ');');
        } else {
            if ($rel == null) {
                $rel = 'stylesheet';
            }

            $url = YN_STATIC_URL . $url;

            $out = sprintf($this->_tags['css'], $rel, $url, $this->_parseAttributes($options, array('inline', 'block'), '', ' '));
        }

        if (empty($options['block'])) {
            return $out;
        } else {
            $this->_View->append($options['block'], $out);
        }
    }
    
}
