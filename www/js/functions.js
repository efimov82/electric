$(function(){
  window.gameCounter = new flipCounter('flip-counter', {value:0000, inc:1, auto:false});
  doRequest('state');
  
});

var audio = new Audio('/sounds/click.wav');


function newGame() {
  doRequest('start');
}

function doMove(gameCounter, number) {
  doRequest('move', number);
  
}
   
function doRequest(action, value='') {
  $.ajax({
    url: '/game.php?action='+action+'&value='+value,
  }).done(( responce ) => {
    var data = JSON.parse(responce);
    
    renderGame(data.matrix);
    console.log($('#count_moves').text());
    console.log(data.count_moves);
    
    if (window.gameCounter.getValue() !== data.count_moves) {
      gameCounter.add(1);
  audio.play();
    }
    window.gameCounter.setValue(data.count_moves);
    // $('#count_moves').text(data.count_moves);
  });
}
   
function renderGame(data) {
  var res = Object.keys(data).map((val) => {
    if (data[val]) {
      $("#cell-"+val).addClass('lightOn');
    } else {
      $("#cell-"+val).removeClass('lightOn');
    }
  });
}