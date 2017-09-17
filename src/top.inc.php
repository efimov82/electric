<?php
/*
 * Get data from Top users table
 */

namespace src;

require_once "../bootstrap.php";
//include_once '../src/Entity/GameResult.php';
//use GameResult;

$sql = "SELECT * FROM ".TBL_USERS_RESULTS."
        ORDER BY scores ASC, time ASC, date_create DESC
        LIMIT 0, 10";
$stmt = $db->query($sql);

$res = '';
while ($row = $stmt->fetch()) {
  $date = date('d-m-Y H:i', strtotime($row['date_create']));
  $time = date('i:s', $row['time']);
  $res .= "<tr>
          <td><strong>{$row['name']}</strong></td>
          <td>{$row['scores']}</td>
          <td>{$time}</td>
          <td>{$date}</td>
        </tr>";
}

//$results = $entityManager->find('GameResult', '');

echo ($res);
