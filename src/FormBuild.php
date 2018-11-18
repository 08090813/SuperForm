<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-11-17
 * Time: 18:26
 */

namespace SuperForm;
use SuperForm\model\Model;

class FormBuild extends FormInit
{
    protected $form = [];
    public $method = "";
    public $params = [];
    public $setPk = 0;
    public function __construct($mdl = null)
    {
        if (!$mdl){
            $mdl = request()->controller();
        }
        parent::__construct($mdl);
        $model = model($this->mdl);
        $this->form = $model->form();//得到表单属性值、然后进行分析、组装成字符串返回出去
    }
    public function build(){
        $item = $this->methodHandle();
        return $item;
    }
    //表单提交
    public function created(){

    }
    //表单修改
    public function modify(){

    }
    ## 表单只有两种情况 修改和增加 只允许两种情况 GET 和 POST
    public function methodHandle(){
        $this->method = request()->method();//获取当前请求的类型
        if ($this->method == 'POST'){
            if ($this->action == 'created'){
                //执行添加
                $this->success('添加成功','');
            }elseif ($this->action == 'modify'){
                //执行修改
                $this->success('修改成功','');
            }
        }elseif ($this->method == 'GET'){
            if ($this->action == 'created'){
                //直接输出表单样式
                $item = $this->installForm($this->form);
            }elseif ($this->action == 'modify'){
                $model  = (new Model());
                $user = $model->Handle($this->mdl)->where('id',$this->setPk)->find();
                //读取原数据显示在表单上
                $item = $this->installForm($this->form,$user);
            }
            return $item;
        }
    }
    //获取数据
    public function getData($pk){

    }
}