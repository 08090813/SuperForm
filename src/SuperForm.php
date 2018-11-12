<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-11-12
 * Time: 19:45
 */

namespace SuperForm;


class SuperForm
{
    protected $form = [];//表单元素
    protected $field = [];//表单字段
    public function __construct()
    {
        //初始化表单、引入Layui相关地址
        $this->form = [
            [
                'title'=>'标题',//表单label
                'type'=>'text',//表单类型
                'name'=>'username',//表单name值
                'class'=>'layui-input',//表单额外的style样式
            ],
            [
                'title'=>'标题',//表单label
                'type'=>'radio',//表单类型
                'name'=>'username',//表单name值
                'class'=>'layui-input',//表单额外的style样式
                'options'=>[
                    
                ]
            ],
            [],
        ];
    }
}