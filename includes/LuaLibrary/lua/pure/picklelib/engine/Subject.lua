--- Subclass to do specialization of the Adapt class
-- This is the spesialization to register access to subjects

-- pure libs
local Stack = require 'picklelib/Stack'

-- @var class var for lib
local Subject = {}

-- non-pure libs
local Adapt = require 'picklelib/engine/Adapt'

--- Lookup of missing class members
-- @param string used for lookup of member
-- @return any
function Subject:__index( key ) -- luacheck: no self
	return Subject[key]
end

-- @var metatable for the class
local mt = { __index = Adapt }

--- Get a clone or create a new instance
-- @param vararg conditionally passed to create
-- @return self
function Subject:__call( ... ) -- luacheck: no self
	local t = { ... }
	self:subjects():push( #t == 0 and self:subjects():top() or Subject.create( ... ) )
	return self:subjects():top()
end

setmetatable( Subject, mt )

-- @var class var for stack, holding a references to defined subjects
Subject.stack = Stack.create()

-- @var class var for other, holding a reference to the expects
Subject.other = nil

--- Create a new instance
-- @param vararg set to temporal
-- @return self
function Subject.create( ... )
	local self = setmetatable( {}, Subject )
	self:_init( ... )
	return self
end

--- Initialize a new instance
-- @private
-- @param vararg set to temporal
-- @return self
function Subject:_init( ... )
	Adapt._init( self, ... )
	if Subject.other ~= nil then
		self._other = Subject.other
	end
	self._reorder = function( a, b ) return b, a end
	return self
end

--- Set the reference to the subjects collection
-- This keeps a reference, the object is not cloned.
-- @param table that somehow maintain a collection
function Subject:setSubjects( obj )
	assert( type( obj ) == 'table' )
	self._subjects = obj
	return self
end

--- Expose reference to subjects
function Subject:subjects()
	return self._subjects
end

-- Return the final class
return Subject
