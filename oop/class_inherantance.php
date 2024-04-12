<?php 


class Cars {

    var $wheels = 5;


    function greeting(){

	   return "hello";
	}

}


$bmw = new Cars();


            // "extends" lisätään luokka luokkaan.
class Trucks extends Cars {

}


$tacoma = new Trucks();

echo $tacoma->wheels;








 ?>
