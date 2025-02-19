<?php
class Queen extends Piece {
    public function get_moves($current): array {
        $bishop = new Bishop($this->color);
        $rook = new Rook($this->color);

        return array_merge(
                             $bishop->get_moves($current)
                            ,$rook-> get_moves($current)
                          );

    }
}