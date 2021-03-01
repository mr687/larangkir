<?php

namespace Mr687\Larangkir\Classes;

use Mr687\Larangkir\RajaOngkir;
use Mr687\Larangkir\Supports\Request;

class Region extends Request
{
  public function provinces($provinceId = null)
  {
    $localProvinces = $this->localProvinces($provinceId);
    if ($localProvinces)
      return $localProvinces;
    return $this->path('province')
      ->fields([
        'id' => $provinceId ?? null
      ])->get();
  }

  public function cities($provinceId = null, $cityId = null)
  {
    $localCities = $this->localCities($provinceId, $cityId);
    if ($localCities)
      return $localCities;
    return $this->path('city')
      ->fields([
        'id' => $cityId ?? null,
        'province' => $provinceId ?? null
      ])->get();
  }

  public function subdistricts($cityId = null, $subdistrictId = null)
  {
    if (!$cityId && config('larangkir.version') != 'pro')
      return null;
    return $this->path('subdistrict')
      ->fields([
        'id' => $subdistrictId ?? null,
        'city' => $cityId ?? null
      ])->get();
  }

  protected function localProvinces($provinceId = null)
  {
    $provinces = collect(json_decode(file_get_contents(RajaOngkir::LARANGKIR_PATH . '/json/province.json')));
    return $provinceId ? $provinces->firstWhere('province_id', $provinceId) ?? null : $provinces ?? null;
  }

  protected function localCities($provinceId = null, $cityId = null)
  {
    $cities = collect(json_decode(file_get_contents(RajaOngkir::LARANGKIR_PATH . '/json/city.json')));
    if ($provinceId) {
      $cities = $cities->where('province_id', $provinceId);
    }
    if ($cityId) {
      $cities = $cities->firstWhere('city_id', $cityId);
    }
    return $cities ?? null;
  }
}
