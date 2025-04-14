<?php

/**
  * @author Elvis Vargas  elvisvc85@gmail.com
  * @author Elvis Vargas  Cel: 5116419141  https://incared.net
  * @package    Convertir numero a Letras
  * @link      https://incared.net/
  */

require_once 'numeroaletras.php';

//llamamos a la(s) clases
$modelonumero = new modelonumero();
$numeroaletras = new numeroaletras();




$numero2 = '128.44';
$numero = $_GET["numero"];
echo '<h3>OPCION 1 --> NUMERO A LETRAS SIN MONEDA</h3>';


echo $modelonumero->numtoletras(abs($numero2)).'<br>';
echo $modelonumero->numtoletras(abs($numero)).'<br>';

echo '<h3>OPCION 2 --> NUMERO A LETRAS CON MONEDA</h3>';
echo $modelonumero->numtoletras(abs($numero2),'Soles','centimos').'<br>';
echo $modelonumero->numtoletras(abs($numero),'Soles','').'<br>';


echo '<h3>OPCION 3 --> NUMERO A LETRAS SIN MONEDA</h3>';

echo $numeroaletras->convertir($numero).'<br>';
echo $numeroaletras->convertir($numero2).'<br>';


echo '<h3>OPCION 4 --> NUMERO A LETRAS CON MONEDA MONEDA</h3>';

echo $numeroaletras->convertir($numero,'soles','centimos').'<br>';
echo $numeroaletras->convertir($numero2,'soles','').'<br>';
echo '<br>';
echo '<a href="index.php?numero=20101112">lINK PARA OBTENER FECHA POR METOS GET</a>';

