<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jsrawan
 * Date: 1/31/12
 * Time: 9:14 AM
 * To change this template use File | Settings | File Templates.
 */
 
class importAdapter {



    /**
     *
     * @static
     * @param $type
     * @return csvImportAdapter
     */
    public static function factory($type)
    {
        $classname = "{$type}ImportAdapter";
        return new $classname;
    }

}
