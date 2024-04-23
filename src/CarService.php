<?php
namespace Virlatinus\PhpTest;

interface CarService {
    public function GetCost();
}

class NormalService implements CarService {
    public function GetCost() {
        return 100.00;
    }
}

class TireChange implements CarService {
    private $service;
    public function __construct(CarService $service) {
        $this->service = $service;
    }

    public function GetCost() {
        return $this->service->GetCost() + 15.00;
    }
}
