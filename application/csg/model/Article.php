<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/5
 * Time: 17:04
 */
namespace app\csg\model;
use think\Model;
use think\Db;
class Article extends Model {
    protected $name="csg_article";

    //测试
    public function test() {
        echo "您好！姚明";
    }

    public function select() {
        return Db::name($this->name)->select();
    }
}