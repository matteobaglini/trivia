var chai    = require( 'chai' ),
    mocha   = require( 'mocha' ),
    expect  = chai.expect,
    should  = chai.should;

require( __dirname + '/../src/seedrand' );

describe( 'Math._random', function() {

    it( 'should exist', function() {

        expect( Math._random ).to.be.a( 'function' );

    });

});

describe( 'Math.random', function() {

    it( 'should return a number between 0 and 1', function() {

        var n = 10, r;

        while ( n --> 0 ) {

            r = Math.random();

            expect( r ).to.be.at.least( 0 );
            expect( r ).to.be.below( 1 );
        }

    });

    it( 'should accept min/max arguments', function() {

        var min = 5,
            max = 10,
            n = 10;

        while ( n --> 0 ) {
            expect( Math.random( min, max ) ).to.be.within( min, max - 1 );
        }

    });

});

describe( 'Math.seed', function() {
    
    it( 'should set the seed of Math.random()', function() {

        var a, b;

        Math.seed( 42 );
        a = Math.random();

        Math.seed( 42 );
        b = Math.random();

        expect( b ).to.equal( a );

    });

});

describe( 'Math.getSeed', function() {
    
    it( 'should return the current seed', function() {

        var seed, a, b;

        Math.seed(); // initialize to a random seed
        seed = Math.getSeed();

        a = Math.random();

        Math.seed( seed );
        b = Math.random();

        expect( b ).to.equal( a );

    });

});
