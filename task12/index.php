<?php

function readData() {
  $data = '';

  $file = new SplFileObject('test.in');
  $i = 0;

  $maxX = $maxY = 0;
  while (!$file->eof()) {
    $data = explode(',', trim($file->fgets()));
  }

  $file = null;
  return $data;
}

function show(&$data) {
  for ($k = 0; $k < 8; $k++) { 
      echo $data[$k] . ' ';
    }
    echo PHP_EOL;
}

function solve($data) {
  $counter = [0,0,0,0,0,0,0,0,0];
  foreach ($data as $val) {
    $counter[$val]++;
  }

  show($counter);
  for ($i=0; $i < 256; $i++) {
    $zeros = $counter[0];

    for ($j=1; $j < 9; $j++) { 
      $counter[$j-1] = $counter[$j];
    }

    $counter[6] += $zeros;
    $counter[8] = $zeros;
  }

  show($counter);

  $sum = 0;
  foreach ($counter as $val) {
    $sum = bcadd($val, $sum);
  }

  echo $sum . PHP_EOL;

  return array_sum($counter);
}

echo PHP_EOL . 'Answer: ' . solve(readData()) . PHP_EOL;
