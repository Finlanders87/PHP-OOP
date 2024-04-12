<?php 


class Cars {

                    // Luokassa kaikkiu pitää olla "static". 
	static $wheel_count = 4;
	static $door_count = 4;



        // "static" käytetään luokka::$wheel_count;
static function car_detail(){

echo Cars::$wheel_count;
echo Cars::$door_count;

	}


}

            // :: saadaan "static" näkymään. 
echo Cars::$door_count;

Cars::car_detail();



 ?>