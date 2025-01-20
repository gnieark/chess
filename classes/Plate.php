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
     * 7 | | | | | | |63|
     * 6 | | | | | | | |
     * 5 | | | | | | | |
     * 4 | | | | | | | |
     * 3 | | | | | | | |
     * 2 | | | | | | | |
     * 1 |8| | | | | | |
     * 0 |0| | | | | | |
     *   |a|b|c|d|e|f|g|
     */

    public function getCellIndexByCoords(int $x,int $y) :int{
        return $x + $y *8;
    }
    private function getCellIndexByPNGNotation(string $str) : int{

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
            $this->board[$cellIndex] = $piece;
            return $this;
    }

    public function placePieceByPGNNotation(Piece $piece, string $cell): bool {
        $coordinates = $this->convertPGNToCoordinates($cell);
        if ($coordinates) {
            [$row, $col] = $coordinates;
            return $this->placePiece($piece, $row, $col);
        }
        return false;
    }

    private function convertPGNToCoordinates(string $cell): ?array {
        if (strlen($cell) !== 2) {
            return null;
        }

        $col = ord(strtolower($cell[0])) - ord('a'); // Convertit la lettre de colonne en index (0-7)
        $row = self::SIZE - (int)$cell[1]; // Convertit le numéro de ligne en index (0-7)

        if ($this->isValidPosition($row, $col)) {
            return [$row, $col];
        }
        return null;
    }
    /**
     * Obtient une pièce sur le plateau.
     * 
     * @param int $row Ligne de la case (0-7).
     * @param int $col Colonne de la case (0-7).
     * @return Piece|null La pièce sur la case, ou null si vide.
     */
    public function getPiece(int $row, int $col): ?Piece {
        if ($this->isValidPosition($row, $col)) {
            return $this->board[$row][$col];
        }
        return null;
    }

    /**
     * Vérifie si une position est valide sur le plateau.
     * 
     * @param int $row Ligne à vérifier.
     * @param int $col Colonne à vérifier.
     * @return bool Retourne true si la position est valide.
     */
    private function isValidPosition(int $row, int $col): bool {
        return $row >= 0 && $row < self::SIZE && $col >= 0 && $col < self::SIZE;
    }

    /**
     * Affiche le plateau (pour debug).
     */
    public function display(): void {
        for ($row = 0; $row < self::SIZE; $row++) {
            for ($col = 0; $col < self::SIZE; $col++) {
                $piece = $this->board[$row][$col];
                echo $piece ? get_class($piece)[0] : '.';
                echo ' ';
            }
            echo PHP_EOL;
        }
    }
}
