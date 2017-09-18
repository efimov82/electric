<!DOCTYPE html>
<html lang="en">
  <?php include '_html/header.html'; ?>
<body>
  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Electric game</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="/">Game</a></li>
      <li class="active"><a href="/top.php">TOP10</a></li>
      <li><a href="/rules.php">Rules</a></li>
    </ul>
  </div>
</nav>

<div class="container">
    <h2>TOP 10</h2>

    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Level</th>
          <th>Count Moves</th>
          <th>Time</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
      <?php include '../src/top.inc.php'; ?>
      </tbody>
    </table>
    </div>
</body>

</html>