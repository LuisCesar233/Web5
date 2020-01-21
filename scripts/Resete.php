
<?php
function obtenCaracterAleatorio($arreglo) {
        $clave_aleatoria = array_rand($arreglo, 1); //obten clave aleatoria
        return $arreglo[ $clave_aleatoria ];    //devolver item aleatorio
    }
 
    function obtenCaracterMd5($car) {
        $md5Car = md5($car.Time()); //Codificar el caracter y el tiempo POSIX (timestamp) en md5
        $arrCar = str_split(strtoupper($md5Car));   //Convertir a array el md5
        $carToken = obtenCaracterAleatorio($arrCar);    //obten un item aleatoriamente
        return $carToken;
    }
 
    function obtenToken($longitud) {
        //crear alfabeto
        $mayus = "ABCDEFGHIJKMNPQRSTUVWXYZ";
        //$mayusculas = str_split($mayus);    //Convertir a array
        //crear array de numeros 0-9
        $numeros = "1324567890";
        //revolver arrays
        shuffle($mayus);
        shuffle($numeros);
        //Unir arrays
        $arregloTotal = array_merge($mayusculas,$numeros);
        $newToken = "";
        
        for($i=0;$i<=$longitud;$i++) {
                $miCar = obtenCaracterAleatorio($arregloTotal);
                $newToken += obtenCaracterMd5($miCar);
        }
        return $newToken;
    }
    function shuffle(arra1) {
    var ctr = arra1.length, temp, index;

// While there are elements in the array
    while (ctr > 0) {
// Pick a random index
        index = Math.floor(Math.random() * ctr);
// Decrease ctr by 1
        ctr--;
// And swap the last element with it
        temp = arra1[ctr];
        arra1[ctr] = arra1[index];
        arra1[index] = temp;
    }
    return arra1;
}
?>