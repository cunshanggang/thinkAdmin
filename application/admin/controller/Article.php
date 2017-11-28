<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/28
 * Time: 11:32
 */
namespace app\admin\controller;

use controller\BasicAdmin;
use service\DataService;
use think\Db;

class Article extends BasicAdmin {
    public function index() {
        return $this->fetch();
    }

    public function add() {
//        echo "<pre>";
//        print_r($_POST);
//        echo "</pre>";
        return $this->fetch();
    }
}