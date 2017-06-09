<?php
/*
 * 工厂类，顾名思义，就是生产对象的
 * 我们封装一个方法实例化单例对象
 */
class Factory
{
    /*
     * M()方法用来实例化单例对象
     * @param   $className 模型的类名
     */
    public static function M($className)
    {
        static $model_list = array();
        //如果该数组里面没有$className类的对象的时候
        if(!isset($model_list[$className])){
            //为了方便查找，定义数组的时候，让类名作为数组的下标   './model/GoodsModel.class'
            require './model/'.$className.'.class.php';
            
            $model_list[$className] = new $className;
        }
        return $model_list[$className];
    }
}
class Beauty
{
    
}
$b1 = Factory::M('beauty');
$b2 = Factory::M('beauty');
$b3 = Factory::M('beauty');
echo '<pre>';
var_dump($b1);

var_dump($b2);

var_dump($b3);
