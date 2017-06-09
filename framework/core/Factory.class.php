<?php
namespace framework\core;
/*
 * 工厂类，顾名思义，就是生产对象的
 * 我们封装一个方法实例化单例对象
 */
class Factory
{
    /*
     * M()方法用来实例化单例对象
     * @param   $className 模型的类名  Factory::M('GoodsModel')
     */
    public static function M($className)
    {
        static $model_list = array();
        $model_name = MODULE.'\\model\\'.$className;
        //如果该数组里面没有$className类的对象的时候
        if(!isset($model_list[$model_name])){
            //为了方便查找，定义数组的时候，让类名作为数组的下标 GoodsModel            
            $model_list[$model_name] = new $model_name;
        }
        return $model_list[$model_name];
    }
}