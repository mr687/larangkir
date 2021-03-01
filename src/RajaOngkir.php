<?php

namespace Mr687\Larangkir;

use Exception;
use Illuminate\Support\Str;

class RajaOngkir
{
  public const URL_STARTER_API = 'https://api.rajaongkir.com/starter/';
  public const URL_BASIC_API = 'https://api.rajaongkir.com/basic/';
  public const URL_PRO_API = 'https://pro.rajaongkir.com/api/';
  public const LARANGKIR_PATH = __DIR__;

  public function __call($name, $arguments)
  {
    return $this->make($name);
  }

  public function __get($name)
  {
    return $this->make($name);
  }

  public function make($resource)
  {
    $class = "Mr687\\Larangkir\\Classes\\" . Str::studly($resource);

    if (class_exists($class)) {
      return new $class();
    }

    throw new Exception("Error: Wrong Method.");
  }
}
