<?php

function readData() {
  $data = [];

  $file = new SplFileObject('test.in');

  while (!$file->eof()) {
    $data = explode(',', trim($file->fgets()));
  }

  $file = null;
  return $data;
}

function solve($data) {
  sort($data);

  $max = max($data);
  $min = min($data);
  $fuel = 999999999999;
  $tFuel = 0;

  for ($i = $min; $i < $max; $i++) { 
    $tFuel = 0;
    foreach ($data as $v) {
      $tFuel += sumUpTo(abs($i-$v));
    }

    $fuel = $tFuel < $fuel ? $tFuel : $fuel;
  }

  return $fuel;
}

function sumUpTo($n) {  
  return $n + ($n * ($n-1)) / 2 ;
}

echo PHP_EOL . 'Answer: ' . solve(readData()) . PHP_EOL;
// 95852366 - Too high
// 95851351 - Too high
// 95851341 - Too high
// 95495476 - Too LOW
// 95851339 - Correct