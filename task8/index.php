<?php

function readData() {
  $data = [];

  $file = new SplFileObject('test.in');
  while (!$file->eof()) {
    $data[] = preg_replace('/\n/', '', $file->fgets());
  }

  $file = null;
  $numbers = explode(',', $data[0]);

  unset($data[0], $data[1]);

  $board = [];
  $pos = $x = $y = 0;
  foreach ($data as $line) {
    if ($line == '') {
      // This breaks boards apart;
      $pos++;
      $x = $y = 0;
      continue;
    }

    $line = explode(' ', preg_replace('/\s+/', ' ', trim($line)));
    for ($y=0; $y < 5; $y++) { 
      $board[$pos][$x][$y]['v'] = $line[$y];
      $board[$pos][$x][$y]['m'] = false;
    }
    $x++;
  }

  return [$numbers, $board];
}

function checkBoard($board) {
  $row = $col = false;
  $rows = $cols = 0;

  for ($x=0; $x < 5; $x++) {
    for ($y=0; $y < 5; $y++) {
      if ($board[$y][$x]['m']) {
        $cols++;
      }
    }
    if ($cols == 5) {
      return true;
    }
    $cols = 0;
  }

  // Check rows
  $rows = $cols = 0;
  for ($x=0; $x < 5; $x++) {
    for ($y=0; $y < 5; $y++) {
      if ($board[$x][$y]['m']) {
        $rows++;
      }
    }
    if ($rows == 5) {
      return true;
    }
    $rows = 0;
  }

  return false;
}

function countUnmarked($board) {
  $sum = 0;
  for ($x=0; $x < 5; $x++) {
    for ($y=0; $y < 5; $y++) {
      if (!$board[$x][$y]['m']) {
        $sum += $board[$x][$y]['v'];
      }
    }
  }

  return $sum;
}

function unMarkAll(&$board) {
  for ($i=0; $i < count($board); $i++) { 
    for ($x=0; $x < 5; $x++) {
      for ($y=0; $y < 5; $y++) {
        $board[$i][$x][$y]['m'] = false;
      }
    }
  }
}

function setMarked(&$board, $number) {
  for ($i=0; $i < count($board); $i++) { 
    for ($x=0; $x < 5; $x++) {
      for ($y=0; $y < 5; $y++) {
        if ($number == $board[$i][$x][$y]['v']) {
          $board[$i][$x][$y]['m'] = true;
        }
      }
    }
  }
}

function printR($board) {
  echo '-----------------------------' . PHP_EOL ;
  for ($i=0; $i < count($board); $i++) { 
    for ($x=0; $x < 5; $x++) {
      for ($y=0; $y < 5; $y++) {
        if($board[$i][$x][$y]['m']) {
         echo $board[$i][$x][$y]['v'] . ' ';
        }
        else {
          echo 'X ';
        }
      }
      echo PHP_EOL;
    }
  }
  echo '-----------------------------' . PHP_EOL ;
}

function solve($numbers, $data) {
  $count = count($data);
  $winner = -1;
  $winners = [];
  $wNumber = -1;

  for ($j=0; $j < count($numbers); $j++) {
    setMarked($data, $numbers[$j]);
    $wNumber = $numbers[$j];

    for ($i=0; $i < $count; $i++) {
      if(!in_array($i, $winners)){
        if (checkBoard($data[$i])) {
          $winner = $i;
          $winners[] = $i;

          if (count($winners) == $count) {
            break 2;
          }
        }
      }
    }
  }

  return $wNumber * countUnmarked($data[$winner]);
}

list($numbers, $boards) = readData();

echo PHP_EOL . 'Answer: ' . solve($numbers, $boards) . PHP_EOL;
