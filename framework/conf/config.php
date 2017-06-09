<?php
/*
 * 框架的配置文件
 */

return array(
    /*
     * 数据库的配置信息
     */
    'host'      =>  'localhost',
    'dbname'    =>  'shop',
    'user'      =>  'root',
    'pass'      =>  'root',
    'port'      =>  3306,
    'charset'   =>  'utf8',
    
    /*
     * 默认的模块、控制器、方法
     */
    'default_module'        =>  'home',
    'default_controller'    =>  'Index',
    'default_action'        =>  'index'
);