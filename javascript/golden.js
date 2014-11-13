require('seedrand')
require('./game.js')

var _ = require('underscore'),
    argv = require('optimist').argv,
    seed = argv.seed || 42,
    repeat = argv.times || 100

Math.seed(seed)

_(repeat).times(function() {
  var notAWinner = false
  var game = new Game()

  game.add('Chet')
  game.add('Pat')
  game.add('Sue')

  do {
    game.roll(Math.floor(Math.random()*6) + 1)
    if (Math.floor(Math.random()*10) == 7) {
      notAWinner = game.wrongAnswer()
    } else {
      notAWinner = game.wasCorrectlyAnswered()
    }
  } while (notAWinner)
})
