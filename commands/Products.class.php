<?php
namespace commands;

Class Products
{
	public static function checkout($args)
	{
		if(count($args) !== 3)
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
		$path2 = \helpers\User::getUserDir().'trunk.'.$productName;
		
		if(file_exists($path2))
		{
			printf("%s already exists.", $path2);
			exit(0);
		}

		echo \helpers\Svn::exec('checkout', $path1, $path2);
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

		echo \helpers\Rsync::remote($path1, $path2, true);
	
		echo "\nAre you sure you? Type 'yes' to continue: ";

		$handle = fopen ("php://stdin","r");
		$line = fgets($handle);
		if(trim($line) != 'yes'){
		    echo ".. ABORTING!\n";
		    exit(0);
		}

		echo \helpers\Rsync::remote($path1, $path2);
	}
}
