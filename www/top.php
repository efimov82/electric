<!DOCTYPE html>
<html lang="en">

<head>
  <title>Electric</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/style.css?v=3" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">

  <!-- Latest compiled and minified JavaScript -->
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  <script src="/js/functions.js"></script>
  <!-- My flip counter script, REQUIRED -->
	<script type="text/javascript" src="/js/flipcounter.min.js"></script>
	<!-- Style sheet for the counter, REQUIRED -->
	<link rel="stylesheet" type="text/css" href="/css/counter.css" />
  
  <!-- Global Site Tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-106534993-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments)};
    gtag('js', new Date());

    gtag('config', 'UA-106534993-1');
  </script>


</head>

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
          <th>Counts</th>
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