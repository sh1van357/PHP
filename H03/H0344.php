//dit is mijn tweede poging op opdracht 3.4 colored borders
<head>
    <style>
        .red {
            border: 6px red solid;
        }
        .green {
            border: 6px green solid;
        }

    </style>
</head>
<body>

<?php

for($a = 1; $a <= 9; $a++){
    if($a % 2 == 0){
        echo "<img class='red' src='../img/q".$a.".jpg'>";
    }else{
        echo "<img class='green' src='../img/q".$a.".jpg'>";
    }
}

?>

