<?php
namespace helpers;

Class Svn
{
	/**
	 * Executes svn command, like svn merge $path1 $path2
	 * @param string $cmd
	 * @param string $path1
	 * @param string $path2
	 */
	public static function exec($cmd, $path1 = '', $path2 = '')
	{
		$cmd = sprintf("svn %s %s %s", $cmd, $path1, $path2);
		return shell_exec($cmd);
	}

	/**
	 * Checks if a repo exits (ie product)
	 * @param string $repo
	 * @return bool
	 */
	public static function repoExists($repo)
	{
		return file_exists(\Config::$repoPath.$repo);
	}
}
