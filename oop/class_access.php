<?php 


class Cars {

    // "public" voidaan käyttää joka sivulla
    // "Private" voidaan käyttää vain luokan sisällä.
    // "Protected"  ne luokat, jotka periytyvät määrittelevästä luokasta jossa data määritellään, voivat nähdä ja muokata dataa koska nämä attribuutit ovat nyt perineen luokan attribuutteja. Muut luokat eivät kuitenkaan voi nähdä tai muokata attribuutteja.
    
	public     $wheel_count = 4;
	Private    $door_count = 4;
	Protected  $seat_count = 2;



    function car_detail(){

        echo $this->wheel_count;
        echo $this->door_count;
        echo $this->seat_count;
	}


}

$bmw = new Cars();

// echo $bmw->wheel_count;  // Näkyy koska julkinen.
// echo $bmw->door_count; // Private joten tätä ei voida nähdä luokan ulkopuolella.
// echo $bmw->seat_count; // Protected ei myöskään näy luokan ulkopuolella.

$bmw->car_detail(); // Luokan sisällä näkyy kaikki.





 ?>
