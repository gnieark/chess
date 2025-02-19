<?php
class Pawn extends Piece{

    public function get_moves($current): array {
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
                $mvts[] = $mvt;

                if( fmod( $current , 8 ) > 0  ){
                    $mvt = new Movement();
                    $mvt->set_origin($current)
                        ->set_dest($current + 7 )
                        ->set_destMustBeAnOpponent(true);
                    $mvts[] = $mvt;

                }
                if( fmod( $current , 8 ) < 7   ){
                    $mvt = new Movement();
                    $mvt->set_origin($current)
                        ->set_dest($current + 9 )
                        ->set_destMustBeAnOpponent(true);
                    $mvts[] = $mvt;

                }
            }

        }else{

            if (($current > 47) && ($current < 56)) {
                // Le pion est sur la septième rangée (ligne de départ)
                $mvt = new Movement();
                $mvt->set_origin($current)
                    ->add_cell_to_path($current - 8)
                    ->set_dest($current - 16)
                    ->set_destCanBeAnOpponent(false);
                $mvts[] = $mvt;
            }
            if ($current > 7) {
                $mvt = new Movement();
                $mvt->set_origin($current)
                    ->set_dest($current - 8)
                    ->set_destCanBeAnOpponent(false);
                $mvts[] = $mvt;

                if (fmod($current, 8) > 0) {
                    $mvt = new Movement();
                    $mvt->set_origin($current)
                        ->set_dest($current - 9)
                        ->set_destMustBeAnOpponent(true);
                    $mvts[] = $mvt;
                }
                if (fmod($current, 8) < 7) {
                    $mvt = new Movement();
                    $mvt->set_origin($current)
                        ->set_dest($current - 7)
                        ->set_destMustBeAnOpponent(true);
                    $mvts[] = $mvt;
                }
            }
        }
        return $mvts;
    }

}