<?php

namespace Mr687\Larangkir\Classes;

use Mr687\Larangkir\Supports\Request;

class Bill extends Request
{
  public function cost($origin = null, $originType = null, $destination = null, $destinationType = null, $weight = null, $courier = null)
  {
    $this->path('cost')
      ->fields([
        'origin' => $origin ?? null,
        'originType' => $originType ?? null,
        'destination' => $destination ?? null,
        'destinationType' => $destinationType ?? null,
        'weight' => $weight ?? null,
        'courier' => $courier ?? 'jne:pos:tiki:rpx:pandu:wahana:sicepat:jnt:pahala:sap:jet:indah:dse:slis:first:ncs:star:ninja:lion:idl:rex:ide:sentral'
      ])->post();
    return $this->successful ? $this->result : null;
  }

  public function waybill($waybill = null, $courier = null)
  {
    // Kode kurir: pos, wahana, jnt, sap, sicepat, jet, dse, first, ninja, lion, idl, rex, ide, sentral
    if (!$waybill || !$courier)
      return null;
    return $this->path('waybill')
      ->fields([
        'waybill' => $waybill ?? null,
        'courier' => $courier ?? null
      ])->post();
  }

  public function serialize($data = null)
  {
    if (!$data) return null;
    $result = null;
    foreach ($data as $key => $value) {
      if (is_array($value['costs'])) {
        if (count($value['costs']) > 0) {
          $result[] = $value;
        }
      }
    }
    return $result;
  }
}
