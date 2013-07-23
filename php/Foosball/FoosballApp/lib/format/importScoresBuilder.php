<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jsrawan
 * Date: 1/31/12
 * Time: 8:56 AM
 * To change this template use File | Settings | File Templates.
 */
 
class importScoresBuilder {

    protected $importedstring;

    public function __construct($importedstring)
    {
        $this->importedstring = $importedstring;
    }

    public function buildcollection($type)
    {
        $classname = "{$type}ImportScoresDelegate";

        /**
         * @var importScoresInterface $delegate
         */
        $delegate = new $classname;
        $delegate->setcontents($this->importedstring);
        $array = $delegate->getArray();

        return $array;
    }

}
