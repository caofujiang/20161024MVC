<?php
namespace framework\core;
use \Smarty;    //导入全局的Smarty类
class Controller
{
    //受保护的属性，保存smarty对象
    protected $smarty;
    public function __construct()
    {
        //初始化smarty对象
        $this -> initSmarty();
    }

    private function initSmarty()
    {
        require './framework/vendor/smarty/Smarty.class.php';
        
        $this -> smarty = new Smarty();
        
        $this -> smarty -> setTemplateDir('./view/tpls/');
    }
    
}