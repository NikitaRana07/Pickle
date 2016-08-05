<?php

namespace Spec;

/**
 * Set of singletons
 */
class Singletons implements ISingletons {

	private static $classes = [];

	private function __construct() {
		$this->instances = [];
	}

	/**
	 * Who am I
	 */
	public static function who() {
		return __CLASS__;
	}

	/**
	 * Get the instance and if necessary initialize the singleton
	 * This does an injection of the class name to make it possible to instantiate a subclass.
	 */
	public static function getInstance( $className = null ) {
		if ( $className === null ) {
			$className = static::who();
		}
		if ( ! array_key_exists( $className, self::$classes ) ) {
			self::$classes[$className] = new $className();
		}
		return self::$classes[$className];
	}

	/**
	 * @see \Spec\IStrategy::export()
	 */
	public function export() {
		return $this->instances;
	}

	/**
	 * @see \Spec\IStrategy::import()
	 */
	public function import( array $arr = null ) {
		$this->instances = $arr;
		return $this->instances;
	}

	/**
	 * @see \Spec\IStrategy::reset()
	 */
	public function reset() {
		$this->instances = [];
	}

	/**
	 * @see \Spec\IStrategy::register()
	 */
	public function register( array $struct ) {
		$instance = new $struct['class']( $struct );
		$this->instances[] = $instance;
		return $instance;
	}

	/**
	 * @see \Spec\IStrategy::isEmpty()
	 */
	public function isEmpty() {
		return ( $this->instances === [] );
	}
}