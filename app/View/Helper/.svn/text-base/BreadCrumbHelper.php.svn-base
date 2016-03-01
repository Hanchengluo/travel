<?php
App::uses('Helper', 'View');
App::uses('HtmlHelper', 'View/Helper');

/**
 * undocumented class
 *
 * @package default
 * @author Lin Yang
 */
class BreadCrumbHelper extends HtmlHelper
{
    /**
     * undocumented variable
     *
     * @var string
     */
    var $data = array();
    
    /**
     * undocumented function
     *
     * @return void
     * @author Lin Yang
     */
    public function cleanData()
    {
        $this->data = array();
    }

    /**
     * 添加
     *
     * @param string $name 
     * @param string $link 
     * @param string $icon 
     * @return void
     * @author Lin Yang
     */
    public function add($name, $link, $icon = false)
    {
        $this->data[] = compact('name', 'link', 'icon');
    }
    
    /**
     * 渲染
     *
     * @return void
     * @author Lin Yang
     */
    public function render($opt = array())
    {
        $out = '';
        for ($i=0, $c=count($this->data); $i < $c; $i++) {
            $options = array();
            extract($this->data[$i]);
            $label = $name;
            if ($icon) {
                $label = sprintf('<i class="%s"></i>%s', $icon, $name);
            }
            if ($link) {
                $link = $this->link($label, $link, array('escape'=>false));
            }
            else {
                $link = $label;
            }
            if ($i==0) {
                $options = array('class'=>'first');
            }
            elseif ($i + 1 == $c) {
                $options = array('class'=>'last');
            }
            else {
                $link = sprintf('<span>%s</span><div class="chevronOverlay"></div>', $link);
            }
            $out.= $this->tag('li', $link, $options);
        }
        $out = $this->tag('ul', $out,$opt);
        echo $this->tag('div', $out,array('class'=>'breadCrumb module'));
    }
}

?>