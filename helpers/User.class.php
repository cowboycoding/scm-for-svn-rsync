<?php
namespace helpers;

Class User
{
	/**
	 * Gets user info
	 * @return array
	 */
	private static function getUserInfo()
	{
		return posix_getpwuid(getmyuid());
	}

	/**
	 * Gets user dir
	 * @return string
 	 */
	public static function getUserDir()
	{
		// $user = self::getUserInfo();
		// return $user['dir'].'/';
		return getenv('HOME').'/';
	}
}
