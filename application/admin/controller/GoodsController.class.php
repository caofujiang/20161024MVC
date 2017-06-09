<?php
namespace admin\controller;

class GoodsController extends Controller
{
    /*
     * 查询商品信息并显示到网页中
     */
    public function selectAction()
    {
        //命令模型查询数据
        require './model/Factory.class.php';
        $model = Factory::M('GoodsModel');
        $goods = $model -> goods_select();
        echo '<pre>';
        var_dump($goods);
        die;
        //给视图分配数据并显示
        //实例化smarty对象
        $this -> smarty -> assign("goods",$goods);
        $this -> smarty -> display('goods.html');
    }


     public function selectAction()
    {
       
          $sql="select * from goods";
          $option=array('host'=>'localhost');
          
          $dao=PDODAO::getSingleTon($option);
          return $dao->exec($sql);
        
    }







}