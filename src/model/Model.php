<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-11-17
 * Time: 18:36
 */

namespace SuperForm\model;

use think\Model as thinkModel ;

## 用于处理模型数据的、模型之间的关联解析等关系
class Model extends thinkModel
{
    protected $table = "";

    public function Handle($mdl){
        $this->table =$mdl;
        return $this;
    }
}