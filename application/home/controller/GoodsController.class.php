<?php
namespace home\controller;
use framework\core\Controller;  //导入需要的controller类
use framework\core\Factory;
class GoodsController extends Controller
{
    /*
     * 查询商品信息并显示到网页中
     */
    public function selectAction()
    {
        //命令模型查询数据        
        $model = Factory::M('GoodsModel');
        $goods = $model -> goods_add();
        
        die;
        //给视图分配数据并显示
        //实例化smarty对象
        $this -> smarty -> assign("goods",$goods);
        $this -> smarty -> display('goods.html');
    }
    //删除数据
    public function deleteAction()
    {
        //命令模型删除数据
        $model = Factory::M('GoodsModel');
        $result = $model -> goods_delete();
        var_dump($result);
    }
}