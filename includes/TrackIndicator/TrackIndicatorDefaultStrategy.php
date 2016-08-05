<?php

namespace Spec;

/**
 * Default strategy for indicators
 *
 * file
 * @ingroup Extensions
 *
 * @license GNU GPL v2+
 * @author John Erling Blad
 */
class TrackIndicatorDefaultStrategy extends TrackIndicatorBaseStrategy {

	/**
	 * @param array structure from extension setup
	 */
	public function __construct( array $opts ) {
		$this->opts = array_merge( [], $opts, [ 'name' => 'unknown' ] );
	}
}