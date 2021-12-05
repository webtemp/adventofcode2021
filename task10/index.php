<?php

class MAX {
  public static int $MAX = 998;
}

function readData() {
  $data = [];

  $file = new SplFileObject('test.in');
  $i = 0;

  $maxX = $maxY = 0;
  while (!$file->eof()) {
    $line =trim($file->fgets());
    if(preg_match_all('/(?P<x1>\d{1,4}),(?P<y1>\d{1,4})\s\->\s(?P<x2>\d{1,4}),(?P<y2>\d{1,4})/', $line, $out)) {
      $data[$i]['x1'] = (int)$out['x1'][0];
      $data[$i]['y1'] = (int)$out['y1'][0];
      $data[$i]['x2'] = (int)$out['x2'][0];
      $data[$i]['y2'] = (int)$out['y2'][0];

      $maxX = max($data[$i]['x1'], $maxX);
      $maxX = max($data[$i]['x2'], $maxX);

      $maxY = max($data[$i]['y1'], $maxY);
      $maxY = max($data[$i]['y2'], $maxY);

      $i++;
    }
  }

  $file = null;
  return $data;
}

function setupBoard(&$board, $size) {
  for ($i=0; $i < $size + 1; $i++) { 
    for ($j=0; $j < $size + 1; $j++) { 
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

function findDanger(&$board) {
  $danger = 0;
  for ($i=0; $i <= MAX::$MAX; $i++) {
    for ($j=0; $j <= MAX::$MAX; $j++) {
      if($board[$j][$i] > 1) {
        $danger++;
      }
    }
  }
  return $danger;
}

function setCoord(&$board, $x1, $y1, $x2, $y2) {
  if ($x1 == $x2) {
    if ($y2 < $y1) {
      $tmp = $y1;
      $y1 = $y2;
      $y2 = $tmp;
    }
    for ($j = $y1; $j <= $y2; $j++) {
      $board[$j][$x1]++;
    }
  }
  else if ($y1 == $y2) {
    if ($x2 < $x1) {
      $tmp = $x1;
      $x1 = $x2;
      $x2 = $tmp;
    }
    for ($j = $x1; $j <= $x2; $j++) {
      $board[$y1][$j]++;
    }
  }
}

function solve($data) {
  $board = [];
  setupBoard($board, MAX::$MAX);

  foreach($data as $coords) {
    $x1 = $coords['x1'];
    $x2 = $coords['x2'];
    $y1 = $coords['y1'];
    $y2 = $coords['y2'];

    // Lines
    if ($x1 == $x2 || $y1 == $y2) {
      setCoord($board, $x1, $y1, $x2, $y2);
    }

    // Diagonals
    if (abs($x1 - $x2) == abs($y1 - $y2)) {
      // X1 > X2, Y1 < Y2
      if ($x1 >= $x2 && $y1 <= $y2) {
        for (
            $i = $coords['x1'], $j = $coords['y1'];
            $i >= $coords['x2'], $j <= $coords['y2'];
            $i--, $j++
          ) { 
          $board[$j][$i]++;
        }
      }
      // X1 < X2, Y1 > Y2
      else if ($x1 <= $x2 && $y1 >= $y2) {
        for (
            $i = $coords['x1'], $j = $coords['y1'];
            $i <= $coords['x2'], $j >= $coords['y2'];
            $i++, $j--
          ) { 
          $board[$j][$i]++;
        }
      }
      // X1 > X2, Y1 > Y2
      else if ($x1 >= $x2 && $y1 >= $y2) {
        for (
            $i = $coords['x1'], $j = $coords['y1'];
            $i >= $coords['x2'], $j >= $coords['y2'];
            $i--, $j--
          ) { 
          $board[$j][$i]++;
        }
      }
      // X1 < X2, Y1 < Y2
      else if ($x1 <= $x2 && $y1 <= $y2) {
        for (
            $i  = $coords['x1'], $j =  $coords['y1'];
            $i <= $coords['x2'], $j <= $coords['y2'];
            $i++, $j++
          ) { 
          $board[$j][$i]++;
        }
      }
    }

  }

  return findDanger($board);
}

echo PHP_EOL . 'Answer: ' . solve(readData()) . PHP_EOL;
