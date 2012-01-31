<?php
class autoloader
{
	public static function moduleautoloader($class)
	{
		$path = $_SERVER['DOCUMENT_ROOT'] . "/lib/common/{$class}.php";
		if (is_readable($path)) require $path;
	}
	
	public static function logicautoloader($class)
	{
		$path = $_SERVER['DOCUMENT_ROOT'] . "/lib/logic/{$class}.php";
		if (is_readable($path)) require $path;
	}
	
	public static function dalautoloader($class)
	{
		$path = $_SERVER['DOCUMENT_ROOT'] . "/lib/DAL/{$class}.php";
		if (is_readable($path)) require $path;
	}
	public static function daoautoloader($class)
	{
		$path = $_SERVER['DOCUMENT_ROOT'] . "/lib/DAO/{$class}.php";
		if (is_readable($path)) require $path;
	}

	public static function formatautoloader($class)
	{
		$path = $_SERVER['DOCUMENT_ROOT'] . "/lib/format/{$class}.php";
		if (is_readable($path)) require $path;
	}

	public static function modelautoloader($class)
	{
		$path = $_SERVER['DOCUMENT_ROOT'] . "/model/{$class}.php";
		if (is_readable($path)) require $path;
	}
	
	public static function controlautoloader($class)
	{
		$path = $_SERVER['DOCUMENT_ROOT'] . "/control/{$class}.php";
		if (is_readable($path)) require $path;
	}


	
}

spl_autoload_register('autoloader::moduleautoloader');
spl_autoload_register('autoloader::logicautoloader');
spl_autoload_register('autoloader::dalautoloader');
spl_autoload_register('autoloader::daoautoloader');
spl_autoload_register('autoloader::modelautoloader');
spl_autoload_register('autoloader::controlautoloader');
spl_autoload_register('autoloader::formatautoloader');



?>