<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-11-17
 * Time: 18:37
 */

namespace SuperForm;

use think\Controller;

class FormInit extends Controller
{
    protected $methods = "post";//表单提交方式
    protected $mdl = "";
    protected $action = "";
    protected $url = "";
    protected $form = [];
    public function __construct($mdl=null)
    {
        parent::__construct();
        //判断如果传递了模型、则使用模型名称、否则使用当前控制器名作为模型名称获取表单的值、并且根据数据库的字段来作为表单的type属性
        if ($mdl){
            $this->mdl = $mdl;//使用传递的值
        }else{
            $this->mdl = request()->controller();//获取当前控制器作为当前使用的模型
        }
        $this->url = request()->controller().'/'.request()->action();
        $this->action = request()->action();//获取当前操作方法
    }

    protected function installForm($form,$data=[])
    {
        $this->form = $form;//设置当前操作的表单元素
        $item = "";
        foreach ($this->form as $key => $val) {
            $start = '<div class="layui-form-item">
                <label class="layui-form-label">'.$val['label'].'</label>
                <div class="layui-input-block">';
            $input = "";
            if ($val['type'] == 'text') {
                $input = $this->text($key,$val,$data);
            }elseif ($val['type'] == 'password'){
                $input = $this->password($key,$val,$data);
            }elseif ($val['type'] == 'email'){
                $input = $this->email($key,$val,$data);
            }elseif ($val['type'] == 'radio'){
                $input = $this->radio($key,$val,$data);
            }elseif ($val['type'] == 'checkbox'){
                $input = $this->checkbox($key,$val,$data);
            }
            $end = '</div>
                    </div>';
            $item.=$start.$input.$end;
        }
        //将表单的头部、内容、和底部拼接返回
        return $this->header().$item.$this->footer();
    }
    public function header(){
        //疑问：表单的提交的方式 和 判断是否 更新 和添加操作 如何实现？
        return '<form class="layui-form" action="'.url($this->url).'" method="'.$this->methods.'">';
    }
    public function footer(){
        return '<div class="layui-form-item">
                    <div class="layui-input-block">
                      <button class="layui-btn layui-btn-sm layui-btn-primary" lay-submit >立即提交</button>
                      <button type="reset" class="layui-btn layui-btn-primary layui-btn-sm" >重置表单</button>
                    </div>
                  </div>
                  </form>';
    }

    public function text($name,$val,$data)
    {
        if (isset($data[$name]) && $data[$name]){
            $value = $data[$name];
        }else{
            $value = '';
        }
        return '<input type="text" value="'.$value.'" name="'.$name.'" required="'.$val['required'].'" placeholder="'.$val['placeholder'].'" class="'.$val['class'].'" autocomplete="off">';
    }
    public function password($name,$val,$data){
        if (isset($data[$name]) && $data[$name]){
            $value = $data[$name];
        }else{
            $value = '';
        }
        return '<input type="password" value="'.$value.'" name="'.$name.'" required="'.$val['required'].'" placeholder="'.$val['placeholder'].'" class="'.$val['class'].'" autocomplete="off">';
    }
    public function email($name,$val,$data){
        if (isset($data[$name]) && $data[$name]){
            $value = $data[$name];
        }else{
            $value = '';
        }
        return '<input type="email" value="'.$value.'" name="'.$name.'" placeholder="'.$val['placeholder'].'" class="'.$val['class'].'" autocomplete="off">';
    }
    public function radio($name,$val,$data){
        $opstions = $this->form[$name]['options'];
        $radio = "";
        if (isset($opstions['model']) && $opstions['type'] == 'model' && class_exists($opstions['model'])){
            $radio = "";
        }elseif ($opstions['type'] == 'custom' && $opstions['custom']){
            foreach ($opstions['custom'] as $k=>$v){
                if (isset($data[$name])){
                    $checked = $data[$name] == $k?'checked':'';
                }else{
                    $checked = '';
                }
                $radio.='<input '.$checked.' type="radio" title="'.$v.'" value="'.$k.'" name="'.$name.'" class="'.$val['class'].'" autocomplete="off">';
            }
        }
        return $radio;
    }
    public function checkbox($name,$val,$data){
        $opstions = $this->form[$name]['options'];
        $checkbox = "";
        if (isset($opstions['model']) && $opstions['type'] == 'model' && class_exists($opstions['model'])){
            $model = model($opstions['model'])->select();
            foreach ($model as $k=>$v){
                if (isset($data[$name]) && $v['id'] == $data[$name]){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $checkbox.='<input '.$checked.' type="checkbox" title="'.$v[$val['options']['label']].'" value="'.$k.'" name="'.$name.'[]" class="'.$val['class'].'" autocomplete="off">';
            }
        }elseif ($opstions['type'] == 'custom' && $opstions['custom']){
            foreach ($opstions['custom'] as $k=>$v){
                if (isset($data[$name])){
                    $checked = $data[$name] == $k?'checked':'';
                }else{
                    $checked = '';
                }
                $checkbox.='<input '.$checked.' type="checkbox" title="'.$v.'" value="'.$k.'" name="'.$name.'" class="'.$val['class'].'" autocomplete="off">';
            }
        }
        return $checkbox;
    }
}