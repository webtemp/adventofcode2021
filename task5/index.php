<?php

function readData() {
  $data = [];

  $file = new SplFileObject('test.in');
  while (!$file->eof()) {
    $data[] = str_split($file->fgets());
  }

  $file = null;

  return $data;
}

function solve($data) {
  $set = [
    0 => [0 => 0, 1 => 0],
    1 => [0 => 0, 1 => 0],
    2 => [0 => 0, 1 => 0],
    3 => [0 => 0, 1 => 0],
    4 => [0 => 0, 1 => 0],
    5 => [0 => 0, 1 => 0],
    6 => [0 => 0, 1 => 0],
    7 => [0 => 0, 1 => 0],
    8 => [0 => 0, 1 => 0],
    9 => [0 => 0, 1 => 0],
    10 => [0 => 0, 1 => 0],
    11 => [0 => 0, 1 => 0]
  ];

  $gamma = $epsilon = 0;

  foreach ($data as $bits) {
    for ($i=0;$i<12;$i++) {
      $set[$i][$bits[$i]]++;
    }
  }

  $gString = $eString = '';

  for ($i=0;$i<12;$i++) {
    if ($set[$i][0] > $set[$i][1]) {
      $gString .= 0;
      $eString .= 1;
    }
    else {
      $gString .= 1;
      $eString .= 0;
    }
  }

  $gamma = bindec($gString);
  $epsilon = bindec($eString);

  return $gamma * $epsilon;
}

echo solve(readData()) . PHP_EOL;
