<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-11-17
 * Time: 18:26
 */

namespace SuperForm;
class FormBuild extends FormInit
{
    public function __construct($mdl = null)
    {
        parent::__construct($mdl);
    }

    public function build(){
        $model = model($this->mdl);
        $form = $model->form();//得到表单属性值、然后进行分析、组装成字符串返回出去
        $item = $this->installForm($form);
        $this->assign(["form"=>$item]);
        echo $this->fetch();
    }
}