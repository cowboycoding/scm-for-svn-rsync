<?php
namespace commands;


Class Branches
{
	/**
	 * Creates a branch from a repo trunk
	 */
	public static function create($args)
	{
		if(count($args) !== 4)
			\commands\Help::show('Not enough arguments');

		$productName = $args[2];
		$branchName = $args[3];

		if(!\helpers\Svn::repoExists($productName))
		{
			printf("%s does not exists in the repo (%s).",
				$productName,
				\Config::get('repoPath').$productName);
			exit(0);
		}

		$path1 = \Config::get('svnProtocol').\Config::get('repoPath').$productName.'/trunk';
		$path2 = \Config::get('svnProtocol').\Config::get('repoPath').$productName.'/branches/'.$branchName;

		\helpers\Svn::exec('copy', $path1, $path2, 'Created branch '.$branchName.' of '.$productName);
		echo ".. Branch created\n";
		exit(0);
	}

	/**
	 * Checks out a brnach from repo branches
	 */
	public static function checkout($args)
	{
		if(count($args) !== 4)
			\commands\Help::show('Not enough arguments');

		$productName = $args[2];
		$branchName = $args[3];

		if(!\helpers\Svn::repoExists($productName))
		{
			printf("%s does not exists in the repo (%s).",
				$productName,
				\Config::get('repoPath').$productName);
			exit(0);
		}
		
		$path1 = \Config::get('$svnProtocol').\Config::get('repoPath').$productName.'/branches/'.$branchName;
		$path2 = \helpers\User::getUserDir().$branchName.'.'.$productName;
		
		if(file_exists($path2))
		{
			printf("%s already exists.", $path2);
			exit(0);
		}

		\helpers\Svn::exec('checkout', $path1, $path2);
		printf(".. Branch checkout to %s\n", $path2);
		exit(0);
	}

	/**
	 * Syncs a brnach with trunk
	 */
	public static function sync($args)
	{
		if(count($args) !== 4)
			\commands\Help::show('Not enough arguments');

		$productName = $args[2];
		$branchName = $args[3];

		if(!\helpers\Svn::repoExists($productName))
		{
			printf("%s does not exists in the repo (%s).",
				$productName,
				\Config::get('repoPath').$productName);
			exit(0);
		}
		
		$path1 = \Config::get('svnProtocol').\Config::get('repoPath').$productName.'/trunk';
		$path2 = \helpers\User::getUserDir().$branchName.'.'.$productName;
		
		if(!file_exists($path2))
		{
			printf("%s does not exist.", $path2);
			exit(0);
		}
		
		echo \helpers\Svn::exec('merge', $path1, $path2);
		exit(0);
	}

	/**
	 * Merges a branch back to into to trunk
	 */
	public static function merge($args)
	{
		if(count($args) !== 4)
			\commands\Help::show('Not enough arguments');

		$productName = $args[2];
		$branchName = $args[3];

		if(!\helpers\Svn::repoExists($productName))
		{
			printf("%s does not exists in the repo (%s).",
				$productName,
				\Config::get('repoPath').$productName);
			exit(0);
		}
		
		$path1 = \Config::get('svnProtocol').\Config::get('repoPath').$productName.'/branches/'.$branchName;
		$path2 = \helpers\User::getUserDir().'trunk.'.$productName;
		
		if(!file_exists($path2))
		{
			printf("%s does not exist.", $path2);
			exit(0);
		}
		
		echo \helpers\Svn::exec('merge --reintegrate', $path1, $path2);
		exit(0);
	}
}







