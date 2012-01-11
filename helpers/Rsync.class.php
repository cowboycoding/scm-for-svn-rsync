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
			\Config::get('releaseUser'),
			$path1,
			\Config::get('releaseServer'),
			$path2,
			\Config::get('releaseServer'),
			$path2);

		if($dryRun)
			$cmd .= ' --dry-run';

		return shell_exec($cmd);
	}

	public static function colorSync($string)
	{
		$strings = explode("\n", $string);
	
		$r = "\n";	
		foreach($strings as $string)
		{
			$case = explode(" ", $string);
			switch($case[0])
			{
				case 'send':
					$r .= sprintf("\033[32m%s\033[0m\n", $string);
					break;

				case 'recv':
					$r .= sprintf("\033[34m%s\033[0m\n", $string);
					break;
				
				case 'del.':
					$r .= sprintf("\033[31m%s\033[0m\n", $string);
					break;

				default:
					$r .= $string."\n";
			}
		}

		return $r;
	}
}
