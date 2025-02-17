<?php
class Queen extends Piece {
    public function get_available_destinations($current): array {
        $bishop = new Bishop($this->color);
        $rook = new Rook($this->color);

        return array_merge(
                             $bishop->get_available_destinations($current)
                            ,$rook-> get_available_destinations($current)
                          );

    }
}