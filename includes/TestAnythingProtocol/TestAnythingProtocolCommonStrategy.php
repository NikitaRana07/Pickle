<?php

namespace Spec;

use \Spec\ITestAnythingProtocolStrategy;

/**
 * Squash a tap into its final form
 * This is more or less valid for all previous versions of tap.
 */
class TestAnythingProtocolCommonStrategy extends TestAnythingProtocolBaseStrategy {

	protected $opts;

	/**
	 * @param array structure from extension setup
	 */
	public function __construct( array $opts ) {
		$this->opts = array_merge( [ 'name' => 'tap' ], $opts );
	}

	/**
	 * @see \Spec\ITestAnythingProtocolStrategy::parse()
	 */
	public function parse( $str ) {
		$count = self::getCount( $str );
		if ( $count === false ) {
			// must set count
			return 'bad';
		}
		$stats = $this->stats( $str );
		if ( $stats[0][0] + $stats[1][0] !== $count ) {
			// wrong overall count
			return 'bad';
		}
		if ( $stats[1][0] > $stats[1][1] + $stats[1][2] ) {
			// some tests clearly marked as bad
			return 'bad';
		}
		if ( $stats[0][0] > $stats[0][1] + $stats[0][2] ) {
			// some tests clearly marked as good
			return 'good';
		}
		if ( ( $stats[0][2] + $stats[1][2] ) > 0 ) {
			// some tests clearly marked as todo
			return 'todo';
		}
		if ( ( $stats[0][1] + $stats[1][1] ) > 0 ) {
			// some tests clearly marked as skipped
			return 'skipped';
		}
		// probably a test set without any tests
		return 'unknown';
	}

	/**
	 * @see \Spec\ITestAnythingProtocolStrategy::stats()
	 */
	public function stats( $str ) {
		$good = [ 0, 0, 0 ];
		$bad = [ 0, 0, 0 ];

		$lines = preg_split( '/[\n\r]/', $str );
		foreach ( $lines as $line ) {
			// not really necessary, but blocks further processing
			if ( self::isComment( $line ) || self::isIndex( $line ) === false ) {
				continue;
			}
			// start collecting statistics
			if ( self::isOk( $line ) ) {
				$good[0]++;
				if ( self::isSkip( $line ) ) {
					$good[1]++;
				}
				if ( self::isTodo( $line ) ) {
					$good[2]++;
				}
			} elseif ( self::isNotOk( $line ) ) {
				$bad[0]++;
				if ( self::isSkip( $line ) ) {
					$bad[1]++;
				}
				if ( self::isTodo( $line ) ) {
					$bad[2]++;
				}
			}
		}

		return [ $good, $bad ];
	}

	/**
	 * @see \Spec\ITestAnythingProtocolStrategy::checkValid()
	 */
	public function checkValid( $str ) {
		return ( $this->getVersion( $str ) !== false ?: $this->getCount( $str ) !== false );
	}

}