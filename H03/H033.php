<?php
//opdracht \: 9 apen for loop
for ($i = 1; $i <= 10; $i++){
    echo "<img src = '../img/q".$i.".jpg'>";
}
echo "<br><br><br><br>";


//opdracht: 9 apen while loop 2e manier
$i = 1;
while($i<=10) {
    echo "<img src='../img/q".$i.".jpg'>";
    $i ++;
}


echo "dit is het eind van opdracht 1";
echo "<br><br><br><br>";



//opdracht 2 sterren toren
for($i = 0; $i <=10; $i++) {
    for($j = 0; $j<$i; $j++) {
        echo "*";
    }
    echo "<br><br><br><br>";
}

echo "dit is het eind van opdracht 2";
echo "<br><br><br><br>";

//opdracht 3
for($a = 35; $a >= 25; $a--){
    echo "Hoppelepee <br><br><br><br>";
}


echo "dit is het eind van opdracht 3";
echo "<br><br><br><br>";


//opdracht 4
//staat op page <-- H0344.php
echo "<br><br><br><br>";


//opdracht 5
$leeftijd = 2;

if ($leeftijd < 3) {
    echo "Je hoeft niks te betalen.";
} elseif ($leeftijd >= 3 && $leeftijd <= 12){
    echo "Je moet €5 betalen.";
} elseif ($leeftijd > 65){
    echo "Je moet €5 betalen.";
} else {
    echo "Je moet de volledige kosten van €10 betalen.";
}

echo "dit is het eind van opdracht 5";
echo "<br><br><br><br>";




