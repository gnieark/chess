<?php

use PHPUnit\Framework\TestCase;

class PlateTest extends TestCase {
    private Plate $plate;

    protected function setUp(): void {
        $this->plate = new Plate();
        $this->game = new Game();
    }

    public function testInitializeBoard(): void {
        $reflection = new ReflectionClass($this->plate);
        $property = $reflection->getProperty('board');
        $property->setAccessible(true);
        $board = $property->getValue($this->plate);

        $this->assertCount(8, $board, 'Le plateau doit avoir 8 rangées.');
        foreach ($board as $row) {
            $this->assertCount(8, $row, 'Chaque rangée doit avoir 8 colonnes.');
            foreach ($row as $cell) {
                $this->assertNull($cell, 'Chaque cellule doit être initialisée à null.');
            }
        }
    }

    public function testPlacePiece(): void {
        $rook = new Rook('white');
        $result = $this->plate->placePiece($rook, 0, 0);

        $this->assertTrue($result, 'La pièce doit être placée avec succès.');
    }

    public function testPlacePieceInvalidPosition(): void {
        $rook = new Rook('white');
        $result = $this->plate->placePiece($rook, 8, 8);

        $this->assertFalse($result, 'Le placement d\'une pièce en dehors du plateau doit échouer.');
    }

    public function testPlacePieceOnOccupiedCell(): void {
        $rook1 = new Rook('white');
        $rook2 = new Rook('black');
        $this->plate->placePiece($rook1, 0, 0);
        $result = $this->plate->placePiece($rook2, 0, 0);

        $this->assertFalse($result, 'Une pièce ne peut pas être placée sur une cellule déjà occupée.');
    }

    public function testPlacePieceByPGNNotation(): void {
        $rook = new Rook('white');
        $result = $this->plate->placePieceByPGNNotation($rook, 'a1');

        $this->assertTrue($result, 'La pièce doit être placée avec succès en utilisant la notation PGN.');
    }

    public function testPlacePieceByPGNNotationInvalid(): void {
        $rook = new Rook('white');
        $result = $this->plate->placePieceByPGNNotation($rook, 'z9');

        $this->assertFalse($result, 'Le placement avec une notation PGN invalide doit échouer.');
    }

    public function testInitializeBoardWithPieces(): void {
        $this->plate->initializeBoardWithPieces();

        // Vérification des pions
        for ($col = 0; $col < 8; $col++) {
            $this->assertInstanceOf(Pawn::class, $this->getPiece(1, $col), 'Un pion noir doit être en rangée 2.');
            $this->assertInstanceOf(Pawn::class, $this->getPiece(6, $col), 'Un pion blanc doit être en rangée 7.');
        }

        // Vérification des autres pièces
        $this->assertInstanceOf(Rook::class, $this->getPiece(0, 0), 'Une tour noire doit être en a8.');
        $this->assertInstanceOf(Rook::class, $this->getPiece(7, 0), 'Une tour blanche doit être en a1.');
        $this->assertInstanceOf(Queen::class, $this->getPiece(0, 3), 'La dame noire doit être en d8.');
        $this->assertInstanceOf(King::class, $this->getPiece(7, 4), 'Le roi blanc doit être en e1.');
    }

    private function getPiece(int $row, int $col): ?Piece {
        $reflection = new ReflectionClass($this->plate);
        $property = $reflection->getProperty('board');
        $property->setAccessible(true);
        $board = $property->getValue($this->plate);

        return $board[$row][$col] ?? null;
    }
    public function testInitializeGame(): void {
        $reflection = new ReflectionClass($this->game);
        $board = $this->game->start()->get_plate();



    }
}