# seedrand.js

`seedrand.js` is a micro library which allows you to seed `Math.random()`. It’s
mainly written for testing functions that require random numbers.

## Usage

The library can be included server- and/or client-side. It moves the original
`Math.random` to `Math._random`, and use a custom pseudo-random number generator
(PRNG) to replace it.

## Client-side

```html
<script src="/path/to/seedrand.min.js"></script>
<script>
var mySeed = +new Date(),
    a, b;

Math.seed( mySeed );
a = Math.random();

Math.seed( mySeed );
b = Math.random();

console.log( a === b ); // true
</script>
```

## NodeJS

```js
require( 'seedrand' );

var mySeed = +new Date(),
    a, b;

Math.seed( mySeed );
a = Math.random();

Math.seed( mySeed );
b = Math.random();

console.log( a === b ); // true
```

# Install

On the client-side, include the `seedrand.min.js` file in your page. On the
server-side, install the `seedrand` npm package:

```
[sudo] npm -g install seedrand
```

# Acknowledgments

The code of the PRNG is based on [Adam Hyland][adam-twitter]’s
[implementation][invwk] of “Webkit2’s crazy invertible mapping generator”.


[adam-twitter]: https://twitter.com/therealprotonk
[invwk]: https://gist.github.com/Protonk/5367430#file-prng-js-L91
