<?php

namespace app\dto;

class RusReestrDTO
{
    public $cadastr_number;
    public $address;
    public $price;
    public $area;
    public $date_update;

    public function __construct($cadastr_number, $address, $price, $area, $date_update)
    {
        $this->cadastr_number = $cadastr_number;
        $this->address = $address;
        $this->price = $price;
        $this->area = $area;
        $this->date_update = $date_update;
    }
}