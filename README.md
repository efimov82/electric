# electric
Simple game "Electric"

Rules
The game takes place on a field of 5x5 cells, where each cell represents a "light bulb".

A light bulb can have two states: "On" or "Off". The "electrician" (i.e. the player) 
by clicking on any cell takes it to the "On" state, while all nearby light bulbs (including diagonal ones) 
change their current state to the opposite one.

Purpose of the game:

Do so that all the light bulbs burn simultaneously for the minimum number of moves.

Live demo:
http://electric.kapkap.info

Run tests
```
php ./tests/testElectricGame.php
```
