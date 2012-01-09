<?

Class Config
{
	/**
	 * Where is svn repo stored
	 * @parma string
	 **/
	public static $repoPath = '/srv/svn-repos/';

	/**
	 * What protocol to use, file:/// for local filesystem
	 * @param string
	 */
	public static $svnProtocol = 'file:///';

	/**
	 * Release path
	 * @param string
	 */
	public static $releasePath = '/srv/Sites/';

	/**
	 * Release user (ssh user)
	 * @param string
	 */
	public static $releaseUser = 'rasmus';

	/**
	 * Release server
	 * @param string
	 */
	public static $releaseServer = 'localhost';
}
