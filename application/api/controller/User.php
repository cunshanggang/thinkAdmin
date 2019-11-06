<?php
namespace app\api\controller;

use think\Controller;

class User extends Controller
{
    public function saveUserData()
    {
        print_r($this->request->post());
    }
}