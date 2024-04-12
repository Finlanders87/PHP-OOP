<?php
    // Etsiin tiedosto polun.
   echo __FILE__ . "<br>";


    // Millä rivillä koodi on.
   echo __LINE__ . "<br>";

    // Etsii pää kansion jossa ollaan.
   echo __DIR__ . "<br>";

    // Onko tiedosto olemassa.
    if(file_exists(__DIR__)) {
        echo "YES. <br>";
    }




    // On tiedosto.
    if(is_file(__DIR__)) {
        echo "YES. <br>";
    }
    else {
        echo "NO <br>";
    }

    if(is_file(__FILE__)) {
        echo "YES. <br>";
    }
    else {
        echo "NO <br>";
    }





    if(is_dir(__FILE__)) {
        echo "YES. <br>";
    }
    else {
        echo "NO <br>";
    }



    // ? = "Then do this."
    // : = "ELSE. "
echo file_exists(__FILE__) ? "Yes." : "no";



?>
