<?php
session_start();
date_default_timezone_set('America/Bogota');

use Config\Autoload;
use Config\Router;

define('__DS__', DIRECTORY_SEPARATOR);
define('__ROOT__', realpath(dirname(__FILE__)) . __DS__);

include_once(__ROOT__ . 'Config/Autoload.php');

try {
  Autoload::run();
  new Router();
} catch (\Throwable $th) {
  //throw $th;
  echo json_encode(array(
    'type' => 'danger',
    'code' => $th->getCode(),
    'msg' => $th->getMessage(),
    'dev' => array(
      'file' => $th->getFile(),
      'line' => $th->getLine()
    )
  ), JSON_PRETTY_PRINT);
}
