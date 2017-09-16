<?php

/*
 * Get data from Top table
 */
require_once "../bootstrap.php";

$queryBuilder->select('*')
    ->from('top_users')
    ->orderBy('count_moves', 'ASC');


$res = '<tr>
          <td>John</td>
          <td>Doe</td>
          <td>john@example.com</td>
        </tr>';
echo ($res);

