<?php

namespace Virlatinus\PhpTest;

class TireChange implements CarService
{
    private $service;

    public function __construct(CarService $service)
    {
        $this->service = $service;
    }

    public function GetCost(): float
    {
        return $this->service->GetCost() + 15.00;
    }
}
