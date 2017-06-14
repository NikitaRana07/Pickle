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
class FrameReportTest extends Scribunto_LuaEngineTestBase {

	protected static $moduleName = 'FrameReportTest';

	/**
	 * @see Scribunto_LuaEngineTestBase::getTestModules()
	 */
	function getTestModules() {
		return parent::getTestModules() + [
			'FrameReportTest' => __DIR__ . '/FrameReportTest.lua'
		];
	}
}
