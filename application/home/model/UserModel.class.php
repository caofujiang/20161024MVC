<?php
class GoodsModel
{
    //该属性保存dao对象
    public $dao;
    public function __construct()
    {
        //实例化daopdo对象
        $this -> initDAO();        
    }
    private function initDAO()
    {
        $options = array(
            'host'      =>  'localhost',
            'dbname'    =>  'php_4',
            'user'      =>  'root',
            'pass'      =>  'root',
            'port'      =>  3306,
            'charset'   =>  'utf8'
        );
        $this->dao = DAOPDO::getSingleton($options);
    }
    /*
     * 增加商品
     */
    public function goods_add()
    {
        $sql = "INSERT INTO goods VALUES('iPhone6s')";
        $this -> dao -> exec($sql);
        
        return $this -> dao -> insert($data);
    }    
    /*
     * 查询商品
     */
    public function goods_select()
    {
        
    }
}