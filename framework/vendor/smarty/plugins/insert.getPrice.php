<?php
/*
 * 时时获得商品价格
 */
function smarty_insert_getPrice($params)
{
    //传递一个商品的id，根据商品id查询该商品的价格
    //echo '<pre>';
    //var_dump($params);
    $goods_id = $params['id'];
    //声明使用全局的$dao对象
    global $dao;
    //通过商品id查询商品价格
    $sql = "SELECT shop_price FROM goods WHERE goods_id=$goods_id";
    return $dao -> getOne($sql);    
}