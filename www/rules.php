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
      <li><a href="/top.php">TOP10</a></li>
      <li class="active"><a href="/rules.php">Rules</a></li>
    </ul>
  </div>
</nav>

<div class="container">
    <h2 style="text-align: center;">Rules</h2>

    <div class="textPage"><p>The game takes place on a field of 5x5 cells, where each cell represents a "light bulb".</p>
      <p>A light bulb can have two states: "On" or "Off". The "electrician" (i.e. the player)</p>
      <p>by clicking on any cell takes it to the "On" state, while all nearby light bulbs (including diagonal ones)</p>
      <p>change their current state to the opposite one.</p>
      <br/>
      <p><strong>Purpose of the game:</strong></p>
      <p>Do so that all the light bulbs burn simultaneously for the minimum number of moves.</p>

      <p><strong>Gameplay:</strong></p>
      <p>You can choose difficulty level of game:</p>
      <p><strong>Easy:</strong> You have 3 Freeze tool and simple gameplay.</p>
      <p><strong>Normal:</strong> You have 2 Freeze tool and medium gameplay.</p>
      <p><strong>Hard:</strong>You have 1 Freeze tool and medium gameplay.</p>
      <br/>
      <p><strong>Game Tools:</strong></p>
      <ul>
        <li><img src="/img/lamp.png" height="50" width="50" /> - Reverse states of light bulbs around clicked include diagonals.</li>
        <li><img src="/img/lamp_freezed.png" height="50" width="50"> - Freeze current state of clicked light bulb (ON or OFF) on 1 next move.
        You can Freeze several bulbs at once. The number depends on the difficulty level of the game.</li>
        <li><img src="/img/tools_vline.png" height="50" width="50"> - Reverse statuses light bulbs by vertical line.</li>
        <li><img src="/img/tools_gline.png" height="50" width="50"> - Reverse states of light bulbs by horizontal line.</li>
        <li><img src="/img/tools_cross.png" height="50" width="50"> - Reverse states of light bulbs by cross.</li>
      </ul>
    </div>
</body>



</html>