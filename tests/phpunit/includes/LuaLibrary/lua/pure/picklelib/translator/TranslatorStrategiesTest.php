<?php

namespace Pickle\Test;

use Scribunto_LuaEngineTestBase;

/**
 * @group Pickle
 *
 * @license GNU GPL v2+
 *
 * @author John Erling Blad < jeblad@gmail.com >
 */
class TranslatorStrategiesTest extends Scribunto_LuaEngineTestBase {

	protected static $moduleName = 'TranslatorStrategiesTest';

	/**
	 * @see Scribunto_LuaEngineTestBase::getTestModules()
	 */
	function getTestModules() {
		return parent::getTestModules() + [
			'TranslatorStrategiesTest' => __DIR__ . '/TranslatorStrategiesTest.lua'
		];
	}
}
