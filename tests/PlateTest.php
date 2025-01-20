<?php

use PHPUnit\Framework\TestCase;

class PlateTest extends TestCase {
    private Plate $plate;

    protected function setUp(): void {
        $this->plate = new Plate();
        $this->game = new Game();
    }

    public function testgetCellIndexByCoords(): void {

        $cellsIndex = array();
        for($i = 0; $i<8; $i++){
            for ($j=0;$j<8;$j++){
                $index = $this->plate->getCellIndexByCoords($i,$j);
                $this->assertNotContains($index,$cellsIndex);
                $cellsIndex[] = $index;
            }
        }



    }
}