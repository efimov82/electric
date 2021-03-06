<?php
/*
 * Get data from Top users table
 */

namespace src;

require_once "../bootstrap.php";
//include_once '../src/Entity/GameResult.php';
//use GameResult;

$sql = "SELECT * FROM ".TBL_USERS_RESULTS."
        ORDER BY level DESC, scores ASC, time ASC, date_create DESC
        LIMIT 0, 10";
$stmt = $db->query($sql);

$res = '';
$i = 0;
while ($row = $stmt->fetch()) {
  $date = date('d-m-Y H:i', strtotime($row['date_create']));
  $time = date('i:s', $row['time']);
  $level = getLevelName($row['level']);
  $i++;
  $res .= "<tr>
          <td>{$i}</td>
          <td><strong>{$row['name']}</strong></td>
          <td>{$row['game']}</td>
          <td>{$level}</td>
          <td>{$row['scores']}</td>
          <td>{$time}</td>
          <td>{$date}</td>
        </tr>";
}

echo ($res);


function getLevelName($level) {
  if ($level == 1)
    return 'EASY';
  if ($level == 2)
    return 'NORMAL';
  if ($level == 3)
    return 'HARD';
}