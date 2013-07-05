/**
 * seedrand.js: A micro-lib to get a seedable Math.random().
 * This is based on Adam Hyland's invwk PRNG:
 *      https://gist.github.com/Protonk/5367430#file-prng-js-L91
 *
 * Licence: MIT
 * URL: github.com/bfontaine/seedrand.js
 **/
(function() {

    'use strict';

    var max  = Math.pow( 2, 32 ),
        seed = false;

    // keep a copy to the original .random()
    Math._random = Math.random;

    /**
     * Override the original .random(). If two arguments are given, the first
     * one is assumed to be a minimum, and the second one a maximum. The
     * random number will then be an integer between the minimum (included)
     * and the maximum (excluded). If no argument is given, the function
     * behaves like the original .random(). 
     **/
    Math.random = function _seedrand_random( min, upto ) {

        var rand;

        if ( seed === false ) { Math.seed(); }

        seed += ( seed * seed ) | 5;
        rand = ( seed >>> 32 ) / max;

        return arguments.length === 2
                    ? Math.floor(rand * ( upto - min ) + min)
                    : rand;
            
    }

    /**
     * Set a seed for the RNG. If no argument is given, a random seed is used.
     **/
    Math.seed = function _seedrand_seed( val ) {
        seed = val || Math.round( Math._random() * max );
    };

    /**
     * Get the current seed.
     **/
    Math.getSeed = function _seedrand_getSeed() { return seed; };

})();
