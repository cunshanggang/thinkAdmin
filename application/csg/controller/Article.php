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
use app\csg\model\Article as Art;
use PHPExcel_IOFactory;
use PHPExcel;

class Article extends BasicAdmin {

    public function __construct() {
        parent::__construct();
        //集体引入类库
        vendor("phpexcel.Classes.PHPExcel.PHPExcel");
        //5后面如果没有.的话也会报错
        vendor("phpexcel.Classes.PHPExcel.Writer.Excel5.");
        //7后面如果没有.的话也会报错
        vendor("phpexcel.Classes.PHPExcel.Writer.Excel2007.");
        vendor("phpexcel.Classes.PHPExcel.IOFactory");

    }

    /**
     * 指定当前数据表
     * @var string
     */
    public $table = "CsgArticle";

    public function index() {

//        $str = "dddd";
//        $arr = array(1,2,3,4,5,6);
//        $this->assign('arr',$arr);
//        $this->assign('str',$str);
//        return $this->fetch('article/add');//映射到另外一个模板上
//        return $this->fetch('article/index');
//        return $this->fetch();
//        return view();
//        $this->title = '文章管理';
//        echo "<pre>";
//        print_r($this->title);
//        echo "</pre>";
//        $list = db("csg_article")->select();
//        echo "<pre>";
//        print_r($list);
//        echo "</pre>";
//        $this->assign('list',$list);
//        return $this->fetch();
//        echo "<pre>";
////        print_r($db);
//        print_r(parent::_list($db));
//        echo "</pre>";
//        return parent::_list($db);
        //--------------------------
        $this->title = '文章管理';
        $get = $this->request->get();
        $db = Db::name($this->table);
        foreach (['title', 'author', 'content'] as $key) {
            (isset($get[$key]) && $get[$key] !== '') && $db->whereLike($key, "%{$get[$key]}%");
        }
        if (isset($get['time']) && $get['time'] !== '') {
            list($start, $end) = explode('-', str_replace(' ', '', $get['time']));
            $db->whereBetween('time', ["{$start} 00:00:00", "{$end} 23:59:59"]);
        }
//        echo "<pre>";
//        print_r(parent::_list($db));
//        echo "</pre>";
        return parent::_list($db);
    }

    public function add() {
//        echo "<pre>";
//        print_r($_POST);
//        echo "</pre>";

        return $this->_form($this->table, 'form');
//        return $this->fetch('article/form');
    }

    public function edit() {
//        echo "<pre>";
//        print_r($_REQUEST);
//        echo "</pre>";

        return $this->_form($this->table, 'form');
    }

//    public function _form_filter(&$data)
//    {
//        if ($this->request->isPost()) {
//            if (isset($data['authorize']) && is_array($data['authorize'])) {
//                $data['authorize'] = join(',', $data['authorize']);
//            }
//            if (isset($data['id'])) {
//                unset($data['username']);
//            } elseif (Db::name($this->table)->where(['username' => $data['username']])->count() > 0) {
//                $this->error('用户账号已经存在，请使用其它账号！');
//            }
//        } else {
//            $data['authorize'] = explode(',', isset($data['authorize']) ? $data['authorize'] : '');
//            $this->assign('authorizes', Db::name('SystemAuth')->where(['status' => '1'])->select());
////            echo "<pre>";
////            print_r($_REQUEST);
////            echo "</pre>";
////            $result = Db::name($this->table)->select();
////            $this->assign('vo',$result);
////            echo "<pre>";
////            print_r($result);
////            echo "</pre>";
//        }
//    }

    //更改状态
    public function check() {
        if (DataService::update($this->table)) {
            $this->success("审核成功！", '');
        }
        $this->error("审核失败，请稍候再试！");
    }
    //删除文章
    public function del() {
        if (DataService::update($this->table)) {
            $this->success("文章删除成功！", '');
        }
        $this->error("文章删除失败，请稍候再试！");

    }

    //测试
    public function test() {
        //实例化模板并使用里面的方法
        $obj = new Art();
//        $obj->test();
//        Art::test();//该方法不行
//        echo "<hr />";
//        echo "<pre>";
//        print_r($obj->select());
//        echo "</pre>";
        return $this->fetch('article/test');
    }

    //上传
    public function upload() {
//        $obj = $this->request->post();
        echo "<pre>";
//        print_r($this->request->post());
        print_r($_POST);
        echo "</pre>";
        echo "yaoMing";
        echo "<br>";
//        echo $obj.data.msg;
    }

    //导入表格
    public function import() {
//        echo "<pre>";
//        print_r($_FILES);
//        echo "</pre>";
        if(request()->isPost()) {
            $excel = request()->file('myfile')->getInfo();
            $objPHPExcel = \PHPExcel_IOFactory::load($excel['tmp_name']);//读取上传的文件
            $arrExcel = $objPHPExcel->getSheet(0)->toArray();//获取其中的数据
//            echo "<pre>";
//            print_r($arrExcel);
//            echo "</pre>";
//            die;
            return json_encode($arrExcel);
        }
        return $this->fetch();
    }

    //导出表格
    public function export() {
//        echo "123";
        if(request()->isPost()) {
            $field = Db::query("SELECT COLUMN_NAME,column_comment FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = 'csg_article' AND table_schema = 'thinkadmin'");
//            echo "<pre>";
//            print_r($field);
//            echo "</pre>";
            $order = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
//            echo count($order);
            $str = '';
            for($i=0;$i<count($field);$i++) {
                $str.="setCellValue('{$order[$i]}1','{$field[$i]['column_comment']}')"."->";
            }
//            echo $str;
//            exit;
            $str = substr($str,0,-2);
            $str = $str.';';
            echo $str;
            $data = Db::table('csg_article')->select();
            $objPHPExcel = new \PHPExcel();
            $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->$str;
//            $objPHPExcel->setActiveSheetIndex(0)
//                ->setCellValue('A1','序号')
//                ->setCellValue('B1','标题')
//                ->setCellValue('C1','作者')
//                ->setCellValue('D1','图片路径')
//                ->setCellValue('E1','内容')
//                ->setCellValue('F1','时间')
//                ->setCellValue('G1','状态');

            //        $i=2;  //定义一个i变量，目的是在循环输出数据是控制行数
            $count = count($data);  //计算有多少条数据
            for ($i = 2; $i <= $count+1; $i++) {
                $objPHPExcel->getActiveSheet()->setCellValue($field[$i-2] . $i, $data[$i - 2][$field[$i-2]['COLUMN_NAME']]);
                $objPHPExcel->getActiveSheet()->setCellValue($field[$i-2] . $i, $data[$i - 2][$field[$i-2]['COLUMN_NAME']]);
                $objPHPExcel->getActiveSheet()->setCellValue($field[$i-2] . $i, $data[$i - 2][$field[$i-2]['COLUMN_NAME']]);
                $objPHPExcel->getActiveSheet()->setCellValue($field[$i-2] . $i, $data[$i - 2][$field[$i-2]['COLUMN_NAME']]);
                $objPHPExcel->getActiveSheet()->setCellValue($field[$i-2] . $i, $data[$i - 2][$field[$i-2]['COLUMN_NAME']]);
                $objPHPExcel->getActiveSheet()->setCellValue($field[$i-2] . $i, $data[$i - 2][$field[$i-2]['COLUMN_NAME']]);
                $objPHPExcel->getActiveSheet()->setCellValue($field[$i-2] . $i, $data[$i - 2][$field[$i-2]['COLUMN_NAME']]);
            }

            $objPHPExcel->getActiveSheet()->setTitle('artitlce');      //设置sheet的名称
            $objPHPExcel->setActiveSheetIndex(0);                   //设置sheet的起始位置
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');   //通过PHPExcel_IOFactory的写函数将上面数据写出来
            $PHPWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,"Excel2007");
            header('Content-Disposition: attachment;filename="article.xlsx"');
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            $PHPWriter->save("php://output"); //表示在$path路径下面生成demo.xlsx文件
        }
        return $this->fetch();
    }
}