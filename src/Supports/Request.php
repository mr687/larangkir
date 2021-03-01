<?php

namespace Mr687\Larangkir\Supports;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Mr687\Larangkir\RajaOngkir;

class Request
{
  protected $_path;
  protected $_fields;
  protected $_headers;

  public $response;
  public $code;
  public $successful;
  public $result;

  public function __construct()
  {
    $this->_headers = [
      'key' => config('larangkir.api_key')
    ];
  }

  public function getEndpointUrl()
  {
    $accountVersion = config('larangkir.version');
    if ($accountVersion == 'starter')
      return RajaOngkir::URL_STARTER_API;
    if ($accountVersion == 'basic')
      return RajaOngkir::URL_BASIC_API;
    if ($accountVersion == 'pro')
      return RajaOngkir::URL_PRO_API;
  }

  protected function request($httpMethod = 'get')
  {
    $this->response = Http::withHeaders($this->_headers)
      ->{$httpMethod}(
        $this->getEndpointUrl() . $this->_path,
        $this->_fields
      );
    $this->code = $this->response->status();
    $this->successful = $this->response->successful();
    $this->result = collect(json_decode($this->response->body()));

    $result = null;
    if (!$this->response->failed()) {
      if ($this->result['rajaongkir']->status->code == 200) {
        $result = $this->result['rajaongkir']->results;
      } else {
        $result = $this->result['rajaongkir']->status;
      }
    } else {
      $result = $this->result['rajaongkir']->status;
    }

    return $result;
  }

  public function __call($method, $args)
  {
    $property = '_' . Str::camel($method);
    if (property_exists($this, $property)) {
      $this->{$property} = $args[0];
      return $this;
    }

    if (in_array($method, ['get', 'post', 'patch', 'put', 'delete'])) {
      return $this->request($method);
    }
  }
}
