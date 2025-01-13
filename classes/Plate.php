<?php

class Plate {
    // Dimensions du plateau (constantes)
    private const SIZE = 8;

    // Tableau bidimensionnel pour représenter les cases
    private array $board;

    public function __construct() {
        $this->initializeBoard();
    }

    /**
     * Initialise le plateau avec des cases vides.
     */
    private function initializeBoard(): void {
        $this->board = [];
        for ($row = 0; $row < self::SIZE; $row++) {
            $this->board[$row] = [];
            for ($col = 0; $col < self::SIZE; $col++) {
                $this->board[$row][$col] = null; // Une case vide est représentée par `null`
            }
        }
    }
    
    public function initializeBoardWithPieces(): void {
        // Place les pions
        for ($col = 0; $col < self::SIZE; $col++) {
            $this->placePiece(new Pawn('white'), 6, $col); // Pions blancs
            $this->placePiece(new Pawn('black'), 1, $col); // Pions noirs
        }

        // Place les tours
        $this->placePiece(new Rook('white'), 7, 0);
        $this->placePiece(new Rook('white'), 7, 7);
        $this->placePiece(new Rook('black'), 0, 0);
        $this->placePiece(new Rook('black'), 0, 7);

        // Place les cavaliers
        $this->placePiece(new Knight('white'), 7, 1);
        $this->placePiece(new Knight('white'), 7, 6);
        $this->placePiece(new Knight('black'), 0, 1);
        $this->placePiece(new Knight('black'), 0, 6);

        // Place les fous
        $this->placePiece(new Bishop('white'), 7, 2);
        $this->placePiece(new Bishop('white'), 7, 5);
        $this->placePiece(new Bishop('black'), 0, 2);
        $this->placePiece(new Bishop('black'), 0, 5);

        // Place les dames
        $this->placePiece(new Queen('white'), 7, 3);
        $this->placePiece(new Queen('black'), 0, 3);

        // Place les rois
        $this->placePiece(new King('white'), 7, 4);
        $this->placePiece(new King('black'), 0, 4);
    }


    /**
     * Place une pièce sur le plateau.
     * 
     * @param Piece $piece La pièce à placer.
     * @param int $row Ligne de la case (0-7).
     * @param int $col Colonne de la case (0-7).
     * @return bool Retourne true si le placement a réussi, false sinon.
     */
    public function placePiece(Piece $piece, int $row, int $col): bool {
        if ($this->isValidPosition($row, $col) && $this->board[$row][$col] === null) {
            $this->board[$row][$col] = $piece;
            return true;
        }
        return false;
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
