Opdracht 3:
<?php

function reverseString() {
    $string = 'Herderdier';
    echo strrev($string);
}

reverseString();


//Opdracht 4:


function omdraaienHoofdletters() {
    $string = "Hallo";
    print strtoupper($string) ^ strtolower($string);
}

omdraaienHoofdletters();


//Opdracht 5:


function eeuwVanJaar() {
    $array = [18, 19, 20];
    $year = 1990;
    if($year < 1800) {
        $year = $array[1];
    } elseif ($year < 1900) {
        $year = $array[2];
    } elseif ($year < 2000) {
        $year = $array[3];
    } else {
        print("Niet mogelijk");
    }
    print($year);
}

eeuwVanJaar();


//Opdracht 6:


function randomCijfer() {
    $random = range(0, 20);
    echo $random;
}

randomCijfer();


//Opdracht 7:
function totenmet100() {
    for ($i = 0; $i < 101; $i++) {
        console.log($i);
        $result = $i + $i;
    }
    console.log($result);
}

//totenmet100();

//Opdracht 8:
function kwadraattotenmet100() {
    for ($i = 0; $i < 101; $i++) {
        console.log($i);
        $result = $i * $i;
    }
    console.log($result);
}

kwadraattotenmet100();
?>
