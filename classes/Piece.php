<?php

class Piece {
    // Couleur de la pièce (blanc ou noir)
    private string $color;

    /**
     * Constructeur pour initialiser une pièce avec une couleur.
     * 
     * @param string $color La couleur de la pièce ("white" ou "black").
     */
    public function __construct(string $color) {
        if (!in_array($color, ['white', 'black'])) {
            throw new InvalidArgumentException("La couleur doit être 'white' ou 'black'.");
        }
        $this->color = $color;
    }

    /**
     * Obtient la couleur de la pièce.
     * 
     * @return string La couleur ("white" ou "black").
     */
    public function getColor(): string {
        return $this->color;
    }

    /**
     * Vérifie si la pièce est blanche.
     * 
     * @return bool Retourne true si la pièce est blanche.
     */
    public function isWhite(): bool {
        return $this->color === 'white';
    }

    /**
     * Vérifie si la pièce est noire.
     * 
     * @return bool Retourne true si la pièce est noire.
     */
    public function isBlack(): bool {
        return $this->color === 'black';
    }
}