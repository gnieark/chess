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
     * 
     * 7 |56| | | | | | |63|
     * 6 |48| | | | | | |55|
     * 5 | | | | | | | | |
     * 4 | | | | | | | | |
     * 3 |24| | | | | | | |
     * 2 |16| | | | | | | |
     * 1 |8|9| | | | | | |
     * 0 |0|1| | | | | | |
     *   |a|b|c|d|e|f|g|h|
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
