<?php

namespace Spec;

/**
 * Category base
 * Encapsulates the base category as an adapter.
 */
abstract class CategoryBase implements ICategory {

	use TNamedStrategy;

	/**
	 * Get the name
	 *
	 * @return string
	 */
	public function getKey() {
		return 'spec-tracking-category-' . $this->opts['name'];
	}

	/**
	 * @see \Spec\ICategory::addCategorization()
	 */
	public function addCategorization( \Title $title, \ParserOutput $parserOutput ) {

		return $parserOutput->addTrackingCategory( $this->getKey(), $title );
	}
}