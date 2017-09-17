<?php
/*
 * Get data from Top users table
 */

namespace src;

require_once "../bootstrap.php";
//include_once '../src/Entity/GameResult.php';
//use GameResult;

$sql = "SELECT * FROM ".TBL_USERS_RESULTS."
        ORDER BY scores ASC, date_create DESC
        LIMIT 0, 10";
$stmt = $db->query($sql);

$res = '';
while ($row = $stmt->fetch()) {
  $date = date('d-m-Y H:i', strtotime($row['date_create']));
  $res .= "<tr>
          <td><strong>{$row['name']}</strong></td>
          <td>{$row['scores']}</td>
          <td>{$date}</td>
        </tr>";
}

//$results = $entityManager->find('GameResult', '');

echo ($res);
