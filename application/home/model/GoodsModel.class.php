<?php
namespace home\model;
use framework\core\Model;   //导入需要的Model类
class GoodsModel extends Model
{    
    protected $logic_table = 'goods';
    /*
     * 增加商品
     */
    public function goods_add()
    {
        $data = array('goods_name'=>'iPhone','shop_price'=>1);
        $id = $this -> insert($data);
        var_dump($id);
    }
    /*
     * 删除商品
     */
    public function goods_delete()
    {
        return $this -> delete(505); //删除主键是505的记录
    }
}