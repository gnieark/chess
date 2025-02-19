<?php
class Rook extends Piece {

    public function get_unicode_char(){
        return( $this->color? "♖" : "♜");
    }

    public function get_moves($current): array {

        $mvts = array();

        $x = $current % 8;
        $y = intdiv($current, 8);

        //up
        $steps = array();
        for( $destX = $x + 1; $destX < 8; $destX++ ){
            $nmvt = new Movement();
            $nmvt->set_origin($current)->set_dest( $y * 8 + $destX);
            foreach( $steps as $step ){
                $nmvt->add_cell_to_path($step);
            }
            $mvts[] = $nmvt;
            $steps[] = $y * 8 + $destX;

        }

        //down
        $steps = array();
        for ( $destX = $x-1; $destX > -1; $destX--){
            $nmvt = new Movement();
            $nmvt->set_origin($current)->set_dest( $y * 8 + $destX);
            foreach( $steps as $step ){
                $nmvt->add_cell_to_path($step);
            }
            $mvts[] = $nmvt;
            $steps[] = $y * 8 + $destX;
        }

        //left
        $steps = array();
        for( $destY = $y + 1; $destY < 8; $destY ++){
            $nmvt = new Movement();
            $nmvt->set_origin($current)->set_dest( $destY * 8 + $x);
            foreach( $steps as $step ){
                $nmvt->add_cell_to_path($step);
            }
            $mvts[] = $nmvt;
            $steps[] = $destY * 8 + $x;
        }
        //right
        $steps = array();
        for( $destY = $y - 1; $destY > -1; $destY --){
            $nmvt = new Movement();
            $nmvt->set_origin($current)->set_dest( $destY * 8 + $x);
            foreach( $steps as $step ){
                $nmvt->add_cell_to_path($step);
            }
            $mvts[] = $nmvt;
            $steps[] = $destY * 8 + $x;
        }

        return $mvts;
    }
}