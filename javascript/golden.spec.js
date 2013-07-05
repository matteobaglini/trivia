var fs = require('fs'),
    path = require('path'),
    util = require('util'),
    async = require('async'),
    exec = require('child_process').exec,
    spawn = require('child_process').spawn,
    _ = require('underscore'),
    times = 100,
    seed = 42

require('./game.js')


describe(times + ' games with a known seed', function() {
    
  beforeEach(function(done) {
    var self = this
    fs.readFile(path.join(__dirname, '.golden'), function(err, data) {
      if (!err) {
        self.golden = data.toString()
        done()
      } else {
        run(seed, times, function(err, current) {
          fs.writeFile(path.join(__dirname, '.golden'), current, function(err) {
            self.golden = current
            done()
          })
        })
      }
    })
  })

  it('should always have the same output', function(done) {
    var self = this
    run(seed, times, function(err, current) {
      expect(err).toBe(null)
      expect(self.golden).toEqual(current)
      done()
    })
  })
})


function run(seed, times, done) {
  var golden = spawn('node', ['./golden.js', '--seed', seed, '--times', times]),
      chunks = []

  golden.stdout.on('data', function(chunk) {
    chunks.push(chunk)
  })

  golden.on('close', function(code) {
    done(code === 0 ? null : 'unexpected exit code: ' + code, Buffer.concat(chunks).toString())
  })
}
