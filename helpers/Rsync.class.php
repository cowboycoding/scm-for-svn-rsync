<?php
namespace helpers;

Class Rsync
{
	/**
	 * Syncs a local folder wtih remote destination
	 * @param string $path1 Localpath
	 * @param string $path2 Remote path
	 * @param bool $dryRun
	 */
	public static function remote($path1, $path2, $dryRun = false)
	{
		$cmd = sprintf('rsync -h -r -a -v -e "ssh -l %s" --delete %s %s:%s --exclude=".svn" --log-format="%%o %s:%s/%%n"',
			\Config::$releaseUser,
			$path1,
			\Config::$releaseServer,
			$path2,
			\Config::$releaseServer,
			$path2);

		if($dryRun)
			$cmd .= ' --dry-run';

		return shell_exec($cmd);
	}

}
