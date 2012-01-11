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
			printf("%s does not exists in the repo (%s).\n",
				$productName,
				\Config::get('repoPath').$productName);
			exit(0);
		}

		$path1 = \Config::get('svnProtocol').\Config::get('repoPath').$productName.'/trunk';

		if (count($args) === 4)
		{
			$checkoutPath = @$args[3];
			if (@$checkoutPath[0] !== '/')
				$checkoutPath = getcwd().'/'.$checkoutPath;

			if (!is_dir(dirname($checkoutPath)))
			{
				printf('Cannot create checkout path in %s.\n', dirname($checkoutPath));
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
			printf("%s already exists.\n", realpath($checkoutPath));
			exit(0);
		}

		echo \helpers\Svn::exec('checkout', $path1, $checkoutPath);
		exit(0);
	}

	public static function release($args)
	{
		if(count($args) !== 3 && count($args) !== 4)
			\commands\Help::show('Not enough arguments');

		$trunkPath = $args[2];
		$productName = $args[3];

		if (@$trunkPath[0] !== '/')
			$trunkPath = getcwd().'/'.$trunkPath;

		$trunkPath = $trunkPath.'/.';
		
		if (!file_exists($trunkPath))
		{
			printf("%s does not exists.\n", $trunkPath);
			exit(self::ERROR_BAD_CHECKOUT_PATH);
		}

		$releaseDestination = \Config::get('releasePath').$productName; 
		
		echo \helpers\Rsync::colorSync(\helpers\Rsync::remote($trunkPath, $releaseDestination, true));
		
		echo "Are you sure you? Type 'yes' to continue: ";

		$handle = fopen ("php://stdin","r");
		$line = fgets($handle);
		if(trim($line) != 'yes'){
		    echo ".. ABORTING!\n";
		    exit(0);
		}

		echo \helpers\Rsync::colorSync(\helpers\Rsync::remote($trunkPath, $releaseDestination));
		exit(0);
	}
}
