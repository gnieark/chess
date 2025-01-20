<?php

class Piece {
    // Couleur de la pièce (blanc ou noir)
    private bool $color; //true = white false=black

    public function __construct(bool $is_white) {
        $this->color = $is_white;
    }



    public function isWhite(): bool {
        return $this->color;
    }

   
    public function isBlack(): bool {
        return !$this->color;
    }
}