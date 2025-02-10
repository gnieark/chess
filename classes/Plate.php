<?php

class Plate {
    // Dimensions du plateau (constantes)
    private const SIZE = 8;

    // Tableau bidimensionnel pour représenter les cases
    private array $board;

    public function __construct() {
        $this->initializeBoard(true);
    }

    /**
     * Initialise le plateau avec des cases vides.
    * 56  57  58  59  60  61  62  63  
    * 48  49  50  51  52  53  54  55  
    * 40  41  42  43  44  45  46  47  
    * 32  33  34  35  36  37  38  39  
    * 24  25  26  27  28  29  30  31  
    * 16  17  18  19  20  21  22  23  
    * 8   9  10  11  12  13  14  15  
    * 0   1   2   3   4   5   6   7  
     */

    public function getCellIndexByCoords(int $x,int $y) :int{
        return $x + $y *8;
    }
    public function getCellIndexByPNGNotation(string $str) : int{
        $x = ord(strtolower($str[0])) - ord('a'); 
        $y = (int)$str[1];
        return $this->getCellIndexByCoords($x, $y);
    }

    private function initializeBoard(bool $withPieces): void {
        $this->board = [];
        for( $i = 0; $i<56; $i++){
            $this->board[$i] = null;
        }
        if( $withPieces ){
            $this->initializeBoardWithPieces();
        }
    }
    
    public function initializeBoardWithPieces(): void {

    }

    public function placePiece(Piece $piece, int $cellIndex): Plate {
        if( $cellIndex < 0 || $cellIndex > 63 ){
            throw new \UnexpectedValueException(
                "cellIndex must be in [0-63]"
            );
        }
        $this->board[$cellIndex] = $piece;
        return $this;
    }

    public function getPiece(int $cellIndex ): ?Piece {
      
            return $this->board[$cellIndex];
        
        return null;
    }
    public function movePiece(int $indexOrigi, $indexDest) : Plate{
        $this->board[$indexDest] = $this->board[$indexOrigi];
        $this->board[$indexOrigi] = null;
        return $this;
    }
/*
    public function listAvailableDestinations(int $origin): array{
        $this->getPiece($origin)->getAvailableDestinationsIfEmptyFrom($origin);



        
    }
*/
}
