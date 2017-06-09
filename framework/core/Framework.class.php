<?php
namespace framework\core;
/*
 * 封装入口文件
 */
class Framework
{
    public function __construct()
    {
        $this->initConst();
        $this->initAutoload();
        
        //合并配置文件（先合并框架的配置和公共的配置）
        $config1 = $this -> loadFrameworkConfig();
        $config2 = $this -> loadCommonConfig();
        $GLOBALS['config'] = array_merge($config1,$config2);
        
        $this->initMCA();
        
        //loadModuleConfig里面用到了Module常量，但是这个常量在initMCA方法中定义的
        $config3 = $this -> loadModuleConfig();
        
        $GLOBALS['config'] = array_merge($GLOBALS['config'],$config3);
        
        $this->initDispatch();
    }
    //初始化路径常量
    public function initConst()
    {
        //框架的根目录
        // echo getcwd();  //获得get current working directory获得当前文件的工作目录
        //D:\tnwamp\apache\htdocs\20161024MVC/   绝对路径，不用担心目录结构发生变化
        define('ROOT_PATH',str_replace('\\', '/', getcwd().'/'));
        
        //框架路径常量
        define('FRAMEWORK_PATH',ROOT_PATH.'framework/');
        
        //项目路径常量
        define('APP_PATH',ROOT_PATH.'application/');
    }
    //自动加载函数
    public function userAutoload($className)
    {
        //echo $className.'<br>';  //framework\core\Controller  home\controller\Goods
        $arr = explode('\\', $className);
        if($arr[0]=='framework'){
            $basic = './';
        }else{
            $basic = APP_PATH;
        }
        $sub_path = str_replace('\\', '/', $className);
    
        $base_path = $basic.$sub_path;
    
        //判断一下，如果类名中后面的字符包含 I_,就应该是接口文件  I_DAO   I_MOBILE
        //framework\tools\dao\I_DAO   framework\tools\I_MOBILE
        if(substr($arr[count($arr)-1],0,2)=='I_'){
            //说明这个是接口文件
            $fix = '.interface.php';
        }else{
            $fix = '.class.php';
        }
        $classFile = $base_path.$fix;
    
        if(file_exists($classFile)){
            require $classFile;
        }
        //     var_dump($classFile);
        //最终要拼接成'./application/home/controller/GoodsController.class.php';
    }
    //注册自动加载函数
    public function initAutoload()
    {
        //如果项目时多人同时开发，每个人会写很多类，每个人都可能会使用到自动加载
        //可以使用自动加载注册
        //如果回调函数时一个普通的函数，只需要将函数名传递进来即可
        //但是如果回调函数是一个对象的方法，需要以数组的形式传递，下标为0的是对象，下标为1的是方法名
        spl_autoload_register(array($this,"userAutoload"));
    }
    //接收MCA参数
    public function initMCA()
    {
        //接收传递的参数
        $c = isset($_GET['c'])?$_GET['c']:$GLOBALS['config']['default_controller'];
        define('CONTROLLER',$c);
        
        $a = isset($_GET['a'])?$_GET['a']:$GLOBALS['config']['default_action'];
        define('ACTION',$a);
        
        //接收用户传递的m参数，判断是前台操作还是后台操作
        $m = isset($_GET['m'])?$_GET['m']:$GLOBALS['config']['default_module'];
        //将模块定义成常量，没有作用域的限制
        define('MODULE', $m);
    }
    //分发参数
    public function initDispatch()
    {
        //实例化控制器，并调用方法
        $controller_name = 'home\\controller\\'.CONTROLLER.'Controller';
        $controller = new $controller_name;  //new home\controller\GoodsController
        $a = ACTION;
        $controller -> $a();
    }
    
    //加载框架的配置文件
    public function loadFrameworkConfig()
    {
        $config_file = FRAMEWORK_PATH.'conf/config.php';
        if(file_exists($config_file)){
            //将require加载过来的配置信息
            return require $config_file;
        }else{
            //因为将来array_merge() 合并数组
            return array();
        }
    }
    //加载公共的配置文件
    public function loadCommonConfig()
    {
        $config_file = APP_PATH.'common/conf/config.php';
        if(file_exists($config_file)){
            //将require加载过来的配置信息
            return require $config_file;
        }else{
            //因为将来array_merge() 合并数组
            return array();
        }
    }
    //加载应用程序独立的配置文件
    public function loadModuleConfig()
    {
        $config_file = APP_PATH.MODULE.'/conf/config.php';
        if(file_exists($config_file)){
            //将require加载过来的配置信息
            return require $config_file;
        }else{
            //因为将来array_merge() 合并数组
            return array();
        }
    }
}