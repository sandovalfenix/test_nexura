<?php

namespace Config;

class Router
{

	public function __construct()
	{
		$URI = isset($_REQUEST['URI']) ? explode("/", $_REQUEST['URI']) : null;

		$controller = (empty($URI)) ? $this->start_home(__ROOT__ . 'Controllers') : $URI[0] . "Controller";
		$class_controller = "Controllers\\" . $controller;

		$object = new $class_controller;
		$method = (isset($URI[1])) ? $URI[1] : 'home';
		$params = (sizeof($_REQUEST) > 1) ?  array_diff($_REQUEST, array($_REQUEST['URI'])) : array();

		call_user_func(array($object, $method), $params);
	}

	public function start_home($folder)
	{
		$start_home = false;
		if (is_dir($folder)) {
			if ($dir = opendir($folder)) {
				while (($archivo = readdir($dir)) !== false && $start_home == false) {
					if ($archivo != '.' && $archivo != '..' && $archivo != '.htaccess') {
						$rc = new \ReflectionClass("Controllers\\" . str_replace(".php", "", $archivo));
						$start_home = (strrpos($rc->getDocComment(), "@start")) ? str_replace("Controllers\\", "", $rc->getName()) : false;
					}
				}
				closedir($dir);
			}
		}
		return $start_home;
	}
}
