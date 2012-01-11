<?php

Class Config
{
	private static $defaults = array(

	/**
	 * Where is svn repo stored
	 * @parma string
	 **/
	'repoPath' => '/srv/svn-repos/',
	
	/**
	 * What protocol to use, file:/// for local filesystem
	 * @param string
	 */
	'svnProtocol' => 'file:///',

	/**
	 * Release path
	 * @param string
	 */
	'releasePath' => '/srv/sites/',

	/**
	 * Release user (ssh user)
	 * @param string
	 */
	'releaseUser' => 'rasmus',

	/**
	 * Release server
	 * @param string
	 */
	'releaseServer' => 'localhost'

	);

	/**
	 * Currently loaded config
	 * 
	 * @param array
	 */
	private static $config = null;

	/**
	 * Gets a config value
	 *
	 * @param string $key
	 * @return mixed
	 */
	public static function get($key)
	{
		if(self::$config === null)
			self::loadConfig();

		if(array_key_exists($key, (array) self::$config))
			return self::$config[$key];
		
		printf("%s does not exists in config, required.", $key);
		exit(0);
	}

	/**
	 * Loads config file from user dir or use defaults
	 **/
	private static function loadConfig()
	{
		// Load default config
		self::$config = self::$defaults;
		
		// If user have own config file, load it and override defaults	
		$userConfig = \helpers\User::getUserDir().'.scmrc';
		if(is_file($userConfig))
		{
			$config = file_get_contents($userConfig);
			
			if(function_exists('yaml_parse'))
			{	
				// TODO: Test if this works on a system with yaml_parse support				
				$config = yaml_parse($config);
				foreach($config as $setting => $value)
				{
					self::$config[trim($setting)] = trim($value);
				}
			}
			else
			{
				foreach(explode(PHP_EOL, $config) as $data)
				{
					if(@$data[0] === "#") // line is a comment, skip it
						continue;

					preg_match('#(.*):"(.*?)"#', $data, $matches);
					
					if(count($matches) === 3)
					{
						$setting = $matches[1];
						$value = $matches[2];

						self::$config[trim($setting)] = trim($value);
					}
				}
			}	
		}
	}
}
