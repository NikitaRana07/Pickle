--- Tests for the base extractor module.
-- This is a preliminary solution.
-- @license GPL-2.0-or-later
-- @author John Erling Blad < jeblad@gmail.com >


local testframework = require 'Module:TestFramework'

local lib = require 'picklelib/extractor/ExtractorStrategyBase'
assert( lib )
local name = 'extractor'

local function makeTest( ... )
	return lib.create( ... )
end

local function testExists()
	return type( lib )
end

local function testCreate( ... )
	return type( makeTest( ... ) )
end

local function testType( ... )
	return makeTest( ... ):type()
end

local function testFind( str, ... )
	return makeTest( ... ):find( str, 1 )
end

local function testPlaceholder()
	return makeTest():placeholder()
end

local tests = {
	{
		name = name .. ' exists',
		func = testExists,
		type = 'ToString',
		expect = { 'table' }
	},
	{
		name = name .. '.create (nil value type)',
		func = testCreate,
		type = 'ToString',
		args = { nil },
		expect = { 'table' }
	},
	{
		name = name .. '.create (single value type)',
		func = testCreate,
		type = 'ToString',
		args = { 'a' },
		expect = { 'table' }
	},
	{
		name = name .. '.create (multiple value type)',
		func = testCreate,
		type = 'ToString',
		args = { 'a', 'b', 'c' },
		expect = { 'table' }
	},
	{
		name = name .. '.type ()',
		func = testType,
		expect = { 'base' }
	},
	{
		name = name .. '.find (not matched)',
		func = testFind,
		args = { 'foo bar baz', { 'test', 0, 0 } },
		expect = {}
	},
	{
		name = name .. '.find (matched)',
		func = testFind,
		args = { 'foo bar baz', { '^foo', 0, 0 } },
		expect = { 1, 3 }
	},
	{
		name = name .. '.find (matched)',
		func = testFind,
		args = { 'foo bar baz', { 'bar', 0, 0 } },
		expect = { 5, 7 }
	},
	{
		name = name .. '.find (matched)',
		func = testFind,
		args = { 'foo bar baz', { 'baz$', 0, 0 } },
		expect = { 9, 11 }
	},
	{
		name = name .. '.placeholder ()',
		func = testPlaceholder,
		args = {},
		expect = {}
	},
}

return testframework.getTestProvider( tests )
