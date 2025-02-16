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
    public function testBishopMoves(): void {


        $diags = [
            [0],
            [8, 1],
            [16, 9, 2],
            [24, 17, 10, 3],
            [32, 25, 18, 11, 4],
            [40, 33, 26, 19, 12, 5],
            [48, 41, 34, 27, 20, 13, 6],
            [56, 49, 42, 35, 28, 21, 14, 7],
            [57, 50, 43, 36, 29, 22, 15],
            [58, 51, 44, 37, 30, 23],
            [59, 52, 45, 38, 31],
            [60, 53, 46, 39],
            [61, 54, 47],
            [62, 55],
            [63],
            [56],
            [48, 57],
            [40, 49, 58],
            [32, 41, 50, 59],
            [24, 33, 42, 51, 60],
            [16, 25, 34, 43, 52, 61],
            [8, 17, 26, 35, 44, 53, 62],
            [0, 9, 18, 27, 36, 45, 54, 63],
            [1, 10, 19, 28, 37, 46, 55],
            [2, 11, 20, 29, 38, 47],
            [3, 12, 21, 30, 39],
            [4, 13, 22, 31],
            [5, 14, 23],
            [6, 15],
            [7]
        ];


        for ($i = 0; $i < 64; $i++){
            $nPlate = new Plate();
            $nPlate->placePiece(new Bishop(true), $i);
            $movements = $nPlate->getPiece($i)->get_available_destinations($i);
            $alldestsdiag = array();
            foreach($diags as $diag){
                if( in_array($i, $diag)   ){
                    //foreach ( $movements as $movement ){
                    //    var_dump($movement);
                    //    $this->assertContains( $movement->get_dest(), $diag );
                    //}

                }

            }


        }


    }


}