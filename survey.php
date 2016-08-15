<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 15/08/16
 * Time: 04:28 PM
 */

//cabeceras necesarias para trabajar con EventSource
header('Content-Type: text/event-stream');
//importante no guardar en cache
header('Cache-Control: no-cache');

//abrimos el archivo donde tenemos la información formateada
$array = explode("\n", file_get_contents("votos.txt"));

//sumamos un random a si y no de 0 a 3
$si = $array[0]+rand(0,3);//array[0] primera linea
$no = $array[1]+rand(0,3);//array[1] segunda linea

//formateamos la info para guardarla en el archivo de nuevo
$data = $si."\n".$no;

//guardamos la info
file_put_contents("votos.txt", $data);

//json con la respuesta
$response = json_encode(array("si" => $array[0], "no" => $array[1]));

//nombre del evento
echo "event: votaciones\n";
//cada cuantos segundos queremos ejecutar
echo "retry: 5000\n";
//respuesta que devolvemos
echo "data: {$response}\n\n";
flush();