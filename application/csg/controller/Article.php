<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/28
 * Time: 11:32
 */
namespace app\csg\controller;
//namespace service;
use controller\BasicAdmin;
use service\DataService;
use think\Db;
use think\View;
use think\Request;

class Article extends BasicAdmin {

    /**
     * 指定当前数据表
     * @var string
     */
    public $table = "CsgArticle";

    public function index() {

        $str = "dddd";
        $arr = array(1,2,3,4,5,6);
        $this->assign('arr',$arr);
        $this->assign('str',$str);
//        return $this->fetch('article/add');//映射到另外一个模板上
//        return $this->fetch('article/index');
//        return $this->fetch();
//        return view();
        $this->title = '文章管理';
        $list = db("csg_article")->select();
//        echo "<pre>";
//        print_r($list);
//        echo "</pre>";
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function add() {
//        echo "<pre>";
//        print_r($_POST);
//        echo "</pre>";
        return $this->fetch('article/add');
    }

    //删除文章
    public function del() {
        if (DataService::update($this->table)) {
            $this->success("文章删除成功！", '');
        }
        $this->error("文章删除失败，请稍候再试！");

    }
}