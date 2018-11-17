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
    public $method = "POST";//表单提交方式
    public $mdl = "";
    public $action = "";
    public function __construct($mdl=null)
    {
        parent::__construct();
        //判断如果传递了模型、则使用模型名称、否则使用当前控制器名作为模型名称获取表单的值、并且根据数据库的字段来作为表单的type属性
        if ($mdl){
            $this->mdl = $mdl;//使用传递的值
        }else{
            $this->mdl = request()->controller();//获取当前控制器作为当前使用的模型
        }
        $this->action = request()->action();//获取当前操作方法
    }
    private $radio = [];//单选框
    private $checkbox = [];//复选框
    private $textarea = "";//文本域
    private $password = "";//密码狂
    private $select = [];//下拉选择框

    protected function installForm($form)
    {
        $item = "";
        foreach ($form as $key => $val) {
            $start = '<div class="layui-form-item">
                <label class="layui-form-label">'.$val['label'].'</label>
                <div class="layui-input-block">';
            $input = "";
            if ($val['type'] == 'text') {
                $input = $this->text($key,$val);
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
        return '<form class="layui-form" action="" method="'.$this->method.'">';
    }
    public function footer(){
        return '</form>';
    }

    public function text($name,$val)
    {
        return '<input type="text" name="'.$name.'" required="'.$val['required'].'" placeholder="'.$val['placeholder'].'" class="'.$val['class'].'">';
    }
}