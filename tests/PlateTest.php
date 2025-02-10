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
    public function testgetCellIndexByPNGNotation(): void{
        $cellsIndexes = array();
        $cols = array("a","b","c","d","e","g","h");
        foreach ($cols as $col){
            for ($i = 0; $i < 8; $i++){
                $PGN = $col.$i;
                $index = $this->plate->getCellIndexByPNGNotation($PGN);
                $this->assertNotContains( $index, $cellsIndexes);
            }

        }

    }
    public function testPlacePlieces(): void {
        $nPlate = new Plate();
        $nPlate -> placePiece(new King(false), 43);
        $nPlate -> movePiece(43,50);
        $this->assertNull($nPlate->getPiece(43));
        $this->assertInstanceOf('King', $nPlate->getPiece(50) );
        
    
    }
    public function testKingMoves(): void {
        for($i = 0; $i<64; $i++ ){
            $nPlate = new Plate();
            $nPlate -> placePiece(new King(false), $i);
            $movements  = $nPlate -> getPiece($i)->get_available_destinations($i);
            $this->assertLessThan(9, count($movements) );
            foreach($movements as $movement){
                $this->assertGreaterThan(-1, $movement->get_dest());
                $this->assertLessThan(64, $movement->get_dest());
            }
        }
    }
}