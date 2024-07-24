<?php
function imie($imie){
    $ostatnia = mb_substr($imie, -1);
    if ($imie == 'Ania') {
        return 'Anno';
    }elseif ($imie == 'Magdalena'){
        return "Magdaleno";
    }elseif ($ostatnia == 'a'){
        return str_replace($ostatnia, "o", $imie);
    }
    elseif ($imie == 'Kacper'){
        return 'Kacprze';
    }
    elseif ($imie == 'Aleksander'){
        return 'Aleksandrze';
    }
    elseif ($ostatnia == 'r') {
        return $imie.'ze';
    }
    elseif ($ostatnia == 'n'){
        return $imie.'ie';
    }
    elseif ($ostatnia == 'f'){
        return $imie.'ie';
    }
    elseif ($ostatnia == 'w'){
        return $imie.'ie';
    }
    elseif ($imie == 'Michał'){
        return 'Michale';
    }
    elseif ($imie == "Paweł"){
        return 'Pawle';
    }
    elseif ($ostatnia == 'b'){
        return $imie.'ie';
    }
    elseif ($ostatnia == 'j'){
        return $imie.'u';
    }
    elseif ($ostatnia == 'm'){
        return $imie.'ie';
    }
    elseif ($ostatnia == 'z'){
        return $imie.'u';
    }
    elseif ($ostatnia == 'd'){
        return $imie.'zie';
    }else{
        return $imie;
    }
}