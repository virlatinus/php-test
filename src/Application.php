<?php
namespace Virlatinus\PhpTest;

class Application {
    public function start() {
        echo "<h1>Hello, World!</h1>" . PHP_EOL;
        echo "<hr/>" . PHP_EOL;
        $this->testDecorator();
    }

    // Decorator pattern
    public function testDecorator() {
        $s = new NormalService();
        echo "Car Service: " . $s->GetCost() . PHP_EOL;
        $t = new TireChange($s);
        echo "Car Service with tire change: " . $t->GetCost() . PHP_EOL;
    }
}
