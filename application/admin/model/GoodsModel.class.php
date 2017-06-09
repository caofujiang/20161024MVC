<?php
namespace admin\model;
class GoodsModel extends Model
{    
    /*
     * 增加商品
     */
    public function goods_add()
    {
        $sql = "INSERT INTO goods('goods_name','shop_price') VALUES('肾',300000)";
        //执行sql语句
        //实例化dao对象
        return $this->dao -> exec($sql);
    }    
    /*
     * 查询商品
     */
    public function goods_select()
    {
        $sql = "SELECT * FROM goods";
        return $this -> dao -> getAll($sql);
    }
}