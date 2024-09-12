<?php

return [
	/*
	|--------------------------------------------------------------------------
	| Require Resolvers
	|--------------------------------------------------------------------------
	|
	| By default, if you add a case to your feature enum, Quartermaster 
	| requires a matching resolver. For example, a "BetaApi" case would require
	| that a "resolveBetaApi()" method exists. If you want to silently ignore
	| missing resolvers, you can disable that here.
	|
	*/
	
	'require_resolvers' => true,
];
