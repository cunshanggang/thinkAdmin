<?php
namespace app\api\controller;

use think\Controller;
use app\model\SystemUser;
use think\Model;
use app\common\logic\SystemUser as STU;
class User extends Controller
{
    public function saveUserData()
    {
//        $logic = logic("SystemUser");
//        echo $logic;exit;
        $logic = new STU();
        echo $logic->test();
        exit;
//        print_r($this->request->post());
//        $model = model("SystemUser");
//        $result = $model->select();
//        echo "<pre>";
//        print_r($result);
    }
}