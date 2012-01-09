<?php

// Include config
require_once('Config.class.php');

// Helpers
require_once('helpers/Svn.class.php');
require_once('helpers/User.class.php');

// Commands
require_once('commands/Products.class.php');
require_once('commands/Help.class.php');

$method = @$argv[1];
switch($method)
{
	case '--checkout-product':
		\commands\Products::checkout($argv);	
	break;
			
	default:
		\commands\Help::show();
	break;	
}

