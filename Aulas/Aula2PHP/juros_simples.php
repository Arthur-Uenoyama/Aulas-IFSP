<?php
  $capital = 600;
  $taxa = 12 / 100;
  $tempo = 5;

  echo "<table border='1'>
          <tr>
            <th>Tempo</th>
            <th>Montante</th>
            <th>Juro</th>
          </tr>";

  for ($t = 0; $t <= $tempo; $t++) {
    $juro = $capital * $taxa * $t;
    $montante = $capital + $juro;
    echo "<tr>
            <td>$t</td>
            <td>$montante</td>
            <td>$juro</td>
          </tr>";
  }

  echo "</table>";
?>
