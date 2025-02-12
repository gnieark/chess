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
        $nPlate = new Plate();
        $nPlate -> placePiece(new King(false), 1);
        $movements  = $nPlate -> getPiece(1)->get_available_destinations(1);
        $availabledestsMustBe = array(0,2,8,9,10);
        $testDests = array();
        foreach($movements as $movement){
            $this->assertContains($movement->get_dest(), $availabledestsMustBe);
            $this->assertNotContains( $movement->get_dest(),$testDests );
            $testDests[] = $movement->get_dest();
        }

        $nPlate = new Plate();
        $nPlate -> placePiece(new King(false), 63);
        $movements  = $nPlate -> getPiece(63)->get_available_destinations(63);
        $availabledestsMustBe = array(62,54,55);
        $testDests = array();
        foreach($movements as $movement){
            $this->assertContains($movement->get_dest(), $availabledestsMustBe);
            $this->assertNotContains( $movement->get_dest(),$testDests );
            $testDests[] = $movement->get_dest();
        }
    }

    public function testKnightMoves(): void {
        for($i = 0; $i<64; $i++ ){
            $nPlate = new Plate();
            $nPlate -> placePiece(new Knight(false), $i);
            $movements  = $nPlate -> getPiece($i)->get_available_destinations($i);
            $this->assertLessThan(9, count($movements) );
            foreach($movements as $movement){
                $this->assertGreaterThan(-1, $movement->get_dest());
                $this->assertLessThan(64, $movement->get_dest());
            }
        }

        $nPlate = new Plate();
        $nPlate -> placePiece(new Knight(false), 63);
        $movements  = $nPlate -> getPiece(63)->get_available_destinations(63);
        $availabledestsMustBe = array(53,46);
        $testDests = array();
        foreach($movements as $movement){
            $this->assertContains($movement->get_dest(), $availabledestsMustBe);
            $this->assertNotContains( $movement->get_dest(),$testDests );
            $testDests[] = $movement->get_dest();
        }

    }
    public function testPawnMoves(): void {
        // Test des pions blancs
        for ($i = 8; $i < 16; $i++) {
            $nPlate = new Plate();
            $nPlate->placePiece(new Pawn(true), $i);
            $movements = $nPlate->getPiece($i)->get_available_destinations($i);
            
            // Un pion sur sa ligne de départ doit pouvoir avancer de 1 ou 2 cases
            $availabledestsMustBe = [$i + 8, $i + 16, $i+7, $i+9];
            $testDests = [];
            foreach ($movements as $movement) {
                //fwrite(STDERR, print_r($movement, TRUE));
                $this->assertContains($movement->get_dest(), $availabledestsMustBe);
                $this->assertNotContains($movement->get_dest(), $testDests);
                $testDests[] = $movement->get_dest();
            }
        }
    
        // Test des pions noirs
        for ($i = 48; $i < 56; $i++) {
            $nPlate = new Plate();
            $nPlate->placePiece(new Pawn(false), $i);
            $movements = $nPlate->getPiece($i)->get_available_destinations($i);
    
            // Un pion noir sur sa ligne de départ doit pouvoir avancer de 1 ou 2 cases
            $availabledestsMustBe = [$i - 8, $i - 16, $i - 7, $i - 9];
            $testDests = [];
            foreach ($movements as $movement) {
                $this->assertContains($movement->get_dest(), $availabledestsMustBe);
                $this->assertNotContains($movement->get_dest(), $testDests);
                $testDests[] = $movement->get_dest();
            }
        }
    

    }


}