<?php
define("SITE_ROOT", $_SERVER["DOCUMENT_ROOT"], true);
include_once SITE_ROOT.'/common/common.php';
include_once 'Storage.php';

function RegisterNamespaces( $rootPath )
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
						RegisterNamespaces( $fileWithRoot );
					}
					else if( End_With($file, '.php') && file_exists( $fileWithRoot ) )
					{
						$namespace = DOMAIN.str_replace( '/', '.', str_replace( SITE_ROOT, '', str_replace('.php', '', $fileWithRoot) ) );
						Namespaces::Add($namespace, $fileWithRoot);
						Logger::Debug( 'Registering: '.$fileWithRoot.' as '.$namespace );
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

function using( $namespace )
{
	$file = Namespaces::Get($namespace);
	if( isset($file) && file_exists( $file ) )
	{
		require_once $file;
		Logger::Debug( 'Import: '.$file );
	}
}

$local_root = SITE_ROOT;
RegisterNamespaces( $local_root );
unset( $local_root );
