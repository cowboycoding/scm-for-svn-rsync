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
}
