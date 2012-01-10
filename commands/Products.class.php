<?php
namespace commands;

Class Products
{
	const ERROR_BAD_CHECKOUT_PATH = 111;

	public static function checkout($args)
	{
		if(count($args) !== 3 && count($args) !== 4)
			\commands\Help::show('Not enough arguments');

		$productName = $args[2];

		if(!\helpers\Svn::repoExists($productName))
		{
			printf("%s does not exists in the repo (%s).",
				$productName,
				\Config::$repoPath.$productName);
			exit(0);
		}

		$path1 = \Config::$svnProtocol.\Config::$repoPath.$productName.'/trunk';

		// Assuming that the third argument is a path to place the
		// code in
		if (count($args) === 4)
		{
			$checkoutPath = @$args[3];
			// absolute path? ow append current working dir
			if (@$checkoutPath[0] !== '/')
				$checkoutPath = getcwd().'/'.$checkoutPath;

			print_r(getcwd());
			print_r(array('dirname' => array($checkoutPath => dirname($checkoutPath))));
			if (!is_dir(dirname($checkoutPath)))
			{
				printf('Cannot create checkout path in %s.', dirname($checkoutPath));
				exit(self::ERROR_BAD_CHECKOUT_PATH);
			}
		}
		else
		{
			$checkoutPath = getcwd();
		}

		$checkoutPath = $checkoutPath.'/trunk.'.$productName.'/';
		
		if (file_exists($checkoutPath))
		{
			printf("%s already exists.", realpath($checkoutPath));
			exit(0);
		}

		echo \helpers\Svn::exec('checkout', $path1, $checkoutPath);
		exit(0);
	}

	public static function release($args)
	{
		if(count($args) !== 4)
			\commands\Help::show('Not enough arguments');

		$productName = $args[2];
		$destination = $args[3];

		$path1 = \helpers\User::getUserDir().'trunk.'.$productName;
		$path2 = \Config::$releasePath.$destination; 

		if(!file_exists($path2))
		{
			printf("%s does not exists.", $path2);
			exit(0);
		}
		
		$dryRun = \helpers\Rsync::remote($path1, $path2, true);
		echo \helpers\Rsync::colorSync($dryRun);
	
		echo "Are you sure you? Type 'yes' to continue: ";

		$handle = fopen ("php://stdin","r");
		$line = fgets($handle);
		if(trim($line) != 'yes'){
		    echo ".. ABORTING!\n";
		    exit(0);
		}

		$sync = \helpers\Rsync::remote($path1, $path2);
		echo \helpers\Rsync::colorSync($sync);
	}
}
