<?php
define("SITE_ROOT", $_SERVER["DOCUMENT_ROOT"], true);
include_once SITE_ROOT.'/common/logger.php';

function LoadFromFolders( $rootPath )
{
	$fullPath = $rootPath;
	if( is_dir( $rootPath ) && $rootPath != "." && $rootPath != ".." )
	{
		if( $dh = opendir( $rootPath ) )
		{
			while( ( $file = readdir( $dh ) ) !== false )
			{
				if( $file != "." && $file != ".." )
				{
					$fileWithRoot = $fullPath."/".$file;
					if( is_dir( $fileWithRoot ) )
					{
						LoadFromFolders( $fileWithRoot );
					}
					else
					{
						if( $file == "_package.php" && file_exists( $fileWithRoot ) )
						{
							Logger::Debug( 'Loading: '.$fullPath );
							include $fileWithRoot;
						}
					}
					unset($fileWithRoot);
				}
			}
			unset($file);
			closedir( $dh );
		}
	}
	unset($fullPath, $rootPath);
}

$local_root = SITE_ROOT;
LoadFromFolders( $local_root );
unset( $local_root );