# Electric
Simple game "Electric"

![Alt text](ts/elect_2.0.png?raw=true "Game play")

Game rules:
The game takes place on a field of 5x5 cells, where each cell represents a "light bulb".

A light bulb can have two states: "On" or "Off". The "electrician" (i.e. the player) 
by clicking on any cell takes it to the "On" state, while all nearby light bulbs (including diagonal ones) 
change their current state to the opposite one.

Purpose of the game:

Do so that all the light bulbs burn simultaneously for the minimum number of moves.

Live demo:
http://electric.kapkap.info

Next version:
http://electric-dev.kapkap.info

Install:

Run command

```composer install```

Edit file ```config/database.php```

Create Database and run SQL:
```
CREATE TABLE `users_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `date_create` timestamp NULL DEFAULT NULL,
  `scores` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
```

Run tests:
```
php ./tests/testElectricGame.php
```


TODO List:

1. For tools V-Line, G-Line && Cross add check Freezen lamps when apply to game field.

