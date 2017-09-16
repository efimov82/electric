$(function(){
  // var url = '/game.php';
  
  doRequest('state');
  /*$.ajax({
    url: url+'?action=state',
  }).done(function( responce ) {
    var data = $.parseJSON(responce);
    
    renderGame(data.matrix);
    $('#count_moves').text(data.count_moves);
  });*/
   

});

function newGame() {
  doRequest('start');
}

function doMove(number) {
  doRequest('move', number);
}
   
function doRequest(action, value='') {
  $.ajax({
    url: '/game.php?action='+action+'&value='+value,
  }).done(( responce ) => {
    var data = JSON.parse(responce);
    
    renderGame(data.matrix);
    $('#count_moves').text(data.count_moves);
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