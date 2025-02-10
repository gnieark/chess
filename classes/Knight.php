<?php
class Knight extends Piece {

    /*
    * 56  57  58  59  60  61  62  63  
    * 48  49  50  51  52  53  54  55  
    * 40  41  42  43  44  45  46  47  
    * 32  33  34  35  36  37  38  39  
    * 24  25  26  27  28  29  30  31  
    * 16  17  18  19  20  21  22  23  
    * 8   9  10  11  12  13  14  15  
    * 0   1   2   3   4   5   6   7  
     */


    public function get_available_destinations($current): array {

        $moves = [
            [-2, -1], [-2, 1], [2, -1], [2, 1],
            [-1, -2], [-1, 2], [1, -2], [1, 2]
        ];
        
        $x = $current % 8;
        $y = intdiv($current, 8);
        $destinations = [];
        $mvts = array();
        foreach ($moves as [$dx, $dy]) {
            $newX = $x + $dx;
            $newY = $y + $dy;
            
            if ($newX >= 0 && $newX < 8 && $newY >= 0 && $newY < 8) {
                $mvt = new Movement();
                $mvt-> set_origin($current)->set_dest( $newY * 8 + $newX);
                $mvts[] = $mvt; 
            }
        }
        
        return $mvts;
    }
       
}