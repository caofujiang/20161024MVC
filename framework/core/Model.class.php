<?php
namespace framework\core;
use framework\dao\DAOPDO;

class Model
{
    //该属性保存dao对象
    protected $dao;
    //该属性保存当前操作的真实表 两边加上反引号
    protected $true_table;
    //该属性保存数据表的字段
    protected $field_list = array();
    public function __construct()
    {
        //实例化daopdo对象
        $this -> initDAO();
        //初始化表名
        $this -> initTable();
        //初始化字段名称
        $this -> initFields();
    }


    private function initDAO()
    {
        $options = $GLOBALS['config'];
        $this->dao = DAOPDO::getSingleton($options);
    }



    //初始化字段名称
    private function initFields()
    {
        $sql = "DESC $this->true_table";
        $fileds = $this -> dao -> getAll($sql);
        
        foreach ($fileds as $k=>$v){
            if($v['Key']=='PRI'){
                //主键字段的名称保存到
                $this->field_list['pk'] = $v['Field'];
            }
        }
    }
    private function initTable()
    {
        $this -> true_table = '`'.$this->logic_table.'`';
    }


   
    /*
     * 自动插入数据
     * @param   $data = array('goods_name'=>'iPhone','shop_price'=>1)插入的数据 
     *          下标就是字段的名称，值就是字段的值
     * @return  返回刚刚插入的数据的主键值
     */
    protected function insert($data)
    {
        //最终拼接的结果是：
        //INSERT INTO `goods`(`goods_name`,`shop_price`) VALUES('肾',1)
        $sql = "INSERT INTO $this->true_table";
        
        //下一步拼接字段名称，字段名称就是传递的数组的下标
        $fields = array_keys($data);
        //array_map() 将第二个参数的值使用前面的回调函数进行处理
        $fields = array_map(function($v){
            return '`'.$v.'`';
        }, $fields);
        
        $field_list = implode(',', $fields);
        $sql .= '('.$field_list.')';
              
        //下一步拼接字段对应的值
        $values = array_values($data);
        $values = array_map(array($this->dao,'quoteValue'),$values);
        $values = implode(',', $values);
        
        $sql .= " VALUES(".$values.")";        
        //执行sql语句
        $this -> dao -> exec($sql);
        return $this->dao->lastInsertId();  
    }
    /*
     * 自动删除
     * @param   $id 删除的记录的主键的值
     * @return  删除成功返回true，删除失败返回false
     */
    protected function delete($id)
    {
        //最终的需求:DELETE FROM `表名` WHERE 主键字段=$id
        $sql = "DELETE FROM $this->true_table WHERE {$this->field_list['pk']}=$id";
        return $this -> dao -> exec($sql);
    }
    
    
    
    
}