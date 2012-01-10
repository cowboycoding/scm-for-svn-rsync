<?php
/**
 * SCM By Rasmus Theodoer Styrl
 * Jan. 2012. rts@ordbogen.com
 */

// Include config
require_once('Config.class.php');

// Helpers
require_once('helpers/Svn.class.php');
require_once('helpers/Rsync.class.php');
require_once('helpers/User.class.php');

// Commands
require_once('commands/Products.class.php');
require_once('commands/Branches.class.php');
require_once('commands/Help.class.php');

$method = @$argv[1];
switch($method)
{
	case '--checkout-product':
	case 'checkout-product':
		\commands\Products::checkout($argv);	
		break;
	
	case '--release-product':
	case 'release-product':
		\commands\Products::release($argv);
		break;	
	
	case '--create-branch':
	case 'create-branch':
		\commands\Branches::create($argv);	
		break;
	
	case '--checkout-branch':
	case 'checkout-branch':
		\commands\Branches::checkout($argv);
		break;
			
	case '--sync-branch':
	case 'sync-branch':
		\commands\Branches::sync($argv);
		break;
			
	case '--merge-branch':
	case 'merge-branch':
		\commands\Branches::merge($argv);
		break;

	default:
		\commands\Help::show();
	break;	
}

