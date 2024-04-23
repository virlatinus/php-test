<?php

namespace Virlatinus\PhpTest;

class NormalService implements CarService
{
    public function GetCost(): float
    {
        return 100.00;
    }
}
