<?php
namespace framework\dao;
use framework\dao\I_DAO;
use \PDO;

class DAOPDO implements I_DAO
{
    //保证这个类只实例化一个对象，单例模式
    //定义私有的静态属性来保存该对象
    private static $instance;
    private $pdo;
    
    //私有的构造方法
    private function __construct($options)
    {
        //初始化数据库服务器的信息
        $this -> initOptions($options);
        //初始化PDO对象
        $this -> initPDO();
    }
    
    //初始化数据库服务器的配置
    private function initOptions($options)
    {
        $this -> host = isset($options['host'])?$options['host']:'';
        $this -> dbname = isset($options['dbname'])?$options['dbname']:'';
        $this -> user = isset($options['user'])?$options['user']:'';
        $this -> pass = isset($options['pass'])?$options['pass']:'';
        $this -> port = isset($options['port'])?$options['port']:'';
        $this -> charset = isset($options['charset'])?$options['charset']:'';
    }
    //初始化pdo对象
    private function initPDO()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->dbname;port=$this->port;charset=$this->charset";
        $this -> pdo = new PDO($dsn,$this->user,$this->pass);
    }
    //私有的克隆方法
    private function __clone()
    {
        
    }    
    //公共的静态方法实例化当前类的对象
    public static function getSingleton($options)
    {
        if(!self::$instance instanceof self){
            self::$instance = new self($options);
        }
        return self::$instance;
    }
    //查询所有数据的方法
    public function getAll($sql='')
    {
        $pdo_statement = $this -> pdo -> query($sql); 
        //获得执行查询操作受影响的记录数
        $this -> totalRows = $pdo_statement -> rowCount();
        if($pdo_statement==false){
            //说明sql有错误，输出错误信息
            $error_info = $this -> pdo -> errorInfo();
            $error_str = "SQL语句有错误，详细信息如下:<br>".$error_info[2];
            echo $error_str;
            return false;
        }
        return $pdo_statement -> fetchAll(PDO::FETCH_ASSOC);
    }
    //查询一条记录的方法
    public function getRow($sql='')
    {
        $pdo_statement = $this -> pdo -> query($sql);
        if($pdo_statement==false){
            //说明sql有错误，输出错误信息
            $error_info = $this -> pdo -> errorInfo();
            $error_str = "SQL语句有错误，详细信息如下:<br>".$error_info[2];
            echo $error_str;
            return false;
        }
        return $pdo_statement -> fetch(PDO::FETCH_ASSOC);
    }
    //查询一个字段的值
    public function getOne($sql='')
    {
        $pdo_statement = $this -> pdo -> query($sql);
        if($pdo_statement==false){
            //说明sql有错误，输出错误信息
            $error_info = $this -> pdo -> errorInfo();
            $error_str = "SQL语句有错误，详细信息如下:<br>".$error_info[2];
            echo $error_str;
            return false;
        }
        return $pdo_statement -> fetchColumn();
    }
    //受影响的记录数
    public function affectedRows(){
        //通常是用来获得查询语句返回的所有的结果数
        return $this -> totalRows;
    }
    //执行增、删、改操作的方法,通常返回成功与否
    public function exec($sql=''){
        //返回执行成功、失败
        $result = $this -> pdo -> exec($sql);
        return $result;
    }
    //查询刚刚执行插入操作返回的主键的值
    public function lastInsertId(){
        return $this->pdo->lastInsertId();
    }
    //封装引号转义并包裹
    public function quoteValue($data)
    {
        return $this->pdo->quote($data);
    }
}