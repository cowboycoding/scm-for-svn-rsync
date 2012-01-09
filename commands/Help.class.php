<?php
namespace commands;

Class Help
{
	/**
	 * Shows help
	 * @param string $msg Optional message to pass to user
	 */
	public static function show($msg = '')
	{
		if(strlen($msg) > 0)
			echo $msg."\n\n";

		echo 'This is help';

		exit(0);
	}
}



