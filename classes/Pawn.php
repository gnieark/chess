<?php
class Pawn extends Piece{

    public function get_available_destinations($current): array {
        $mvts = array();
        if( $this -> isWhite() ){
            if(($current > 7) && ($current <16)){
                //the pawn is on the second row
                $mvt = new Movement();
                $mvt-> set_origin($current)
                    ->add_cell_to_path($current + 8)
                    ->set_dest($current + 16 )
                    ->set_destCanBeAnOpponent(false);
                $mvts[] = $mvt;
            }
            if( $current < 56 ){
                $mvt = new Movement();
                $mvt->set_origin($current)
                    ->set_dest($current + 8 )
                    ->set_destCanBeAnOpponent(false);
            }


        }else{


        }
        return $mvts;
    }

}