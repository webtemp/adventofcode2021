<?php

function readData() {
  $data = [];

  $file = new SplFileObject('test.in');
  $i = 0;
  while (!$file->eof()) {
    $line = $file->fgets();
    preg_match_all('/(?P<x1>\d{1,4}),(?P<y1>\d{1,4})\s\->\s(?P<x2>\d{1,4}),(?P<y2>\d{1,4})/', $line, $out);
    $data[$i]['x1'] = $out['x1'][0];
    $data[$i]['y1'] = $out['y1'][0];
    $data[$i]['x2'] = $out['x2'][0];
    $data[$i++]['y2'] = $out['y2'][0];
  }

  $file = null;
  return $data;
}

function setupBoard(&$board, $size) {
  for ($i=0; $i < $size; $i++) { 
    for ($j=0; $j < $size; $j++) { 
      $board[$i][$j] = 0;
    }
  }
}

function printBoard(&$board) {
  echo PHP_EOL;
  for ($i=0; $i < count($board); $i++) { 
    for ($j=0; $j < count($board[0]); $j++) { 
      echo $board[$i][$j] . ' ';
    }
    echo PHP_EOL;
  }
  echo PHP_EOL;
}

function setCoord(&$board, $x1, $y1, $x2, $y2) {
  // Diagonals ?
  if ($x1 > $x2) {
    $tmp = $x1;
    $x1 = $x2;
    $x2 = $tmp;
  }
  if ($y1 > $y2) {
    $tmp = $y1;
    $y1 = $y2;
    $y2 = $tmp;
  }
  for ($i=$x1; $i <= $x2; $i++) {
    for ($j=$y1; $j <= $y2; $j++) {
      $board[$j][$i]++;
    }
  }
}

function findDanger(&$board) {
  $danger = 0;
  for ($i=0; $i < 999; $i++) {
    for ($j=0; $j < 999; $j++) {
      if($board[$j][$i] > 1) {
        $danger++;
      }
    }
  }
  return $danger;
}

function solve($data) {
  $board = [];
  setupBoard($board, 999);
  $danger = 0;

  foreach($data as $coords) {
    if($coords['x1'] == $coords['x2'] || $coords['y1'] == $coords['y2']) {
      $danger = setCoord($board, $coords['x1'],$coords['y1'], $coords['x2'], $coords['y2']);
    }
  }

  printBoard($board);

  return findDanger($board);
}

echo PHP_EOL . 'Answer: ' . solve(readData()) . PHP_EOL;
