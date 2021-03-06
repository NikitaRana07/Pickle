--- Class for extractor strategies.
-- This should be a strategy pattern.
-- @classmod TranslatorStrategies
-- @alias Translators

-- @var class var for lib
local Translators = {}

--- Lookup of missing class members.
-- @tparam string key lookup of member
-- @return any
function Translators:__index( key ) -- luacheck: no self
	return Translators[key]
end

--- Create a new instance.
-- @tparam vararg ... list of strategies
-- @treturn self
function Translators.create( ... )
	local self = setmetatable( {}, Translators )
	self:_init( ... )
	return self
end

--- Initialize a new instance.
-- @local
-- @tparam vararg ... list of strategies
-- @treturn self
function Translators:_init()
	self._strategies = {}
	return self
end

--- Register a new strategy.
-- @tparam string key lookup of translator
-- @tparam Translator strategy to be registered
-- @treturn self
function Translators:register( key, strategy )
	self._strategies[ key ] = strategy
	return self
end

--- Removes all registered translators.
-- @treturn self
function Translators:flush()
	self._strategies = {}
	return self
end

--- Find a matching extractor.
-- @raise On missing source
-- @tparam string key lookup of translator
-- @treturn Translator,number,number strategy,first,last
function Translators:find( key )
	assert( key )

	return self._strategies[ key ]
end

-- Return the final class.
return Translators
