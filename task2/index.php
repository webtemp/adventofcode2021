<?php

function readData() {
  $data = [];

  $file = new SplFileObject("tests.in");
  $data[-1] = $data[-2] = 0;
  while (!$file->eof()) {
    $data[] = preg_replace('/\s+/', '', $file->fgets());
  }

  var_export($data);

  $file = null;

  echo PHP_EOL . 'Total: entries: ' . (count($data)-2) . PHP_EOL;
  return $data;
}

function getSum($id, &$data) {
  return $data[$id] + $data[$id-1] + $data[$id-2];
}

function solve($data) {
  $current = getSum(0, $data);
  $count = 0;
  $entries = count($data);
  for($i=1;$i<$entries -2 -($entries%3);$i++){
    $node = getSum($i, $data);
    if($node > $current){
      $count++;
    }

    echo $node . ' ' . $count . PHP_EOL;
    $current = $node;
  }
}

$data = readData();
solve($data);