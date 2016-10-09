<?
    require_once 'lessc.inc.php';
    $bundleFile = SITE_ROOT."/content/bundle.less";
    if( file_exists( $bundleFile ) )
    {
        unlink( $bundleFile );
    }
    
    function MergeFilesText( $rootPath, $ext )
    {
        $files = GetAllFiles( $rootPath, $ext );
        $content = "";
        foreach( $files as $key => $file )
        {
            $fhandler = fopen( $file, "rb" );
            $data = fread( $fhandler, filesize( $file ) );
            fclose( $fhandler );
            $content .= $data . "\r\n";
        }
        return $content;
    }

    function GetAllFiles( $rootPath, $ext )
    {
        $fullPath = $rootPath;
        $files = array();
        if( is_dir( $rootPath ) && $rootPath != "." && $rootPath != ".." )
        {
            if( $dh = opendir( $rootPath ) )
            {
                while( ( $file = readdir( $dh ) ) !== false )
                {
                    if( $file != "." && $file != ".." )
                    {
                        $file = $fullPath."/".$file;
                        if( is_dir( $file ) )
                        {
                            $files = array_merge( $files, GetAllFiles( $file, $ext ) );
                        }
                        else
                        {
                            if( End_With( $file, '.'.$ext ) && file_exists( $file ) )
                            {
                                $files[count($files)] = $file;
                            }
                        }
                    }
                }
                closedir( $dh );
            }
        }
        asort($files);
        return $files;
    }

    $cssText = MergeFilesText( SITE_ROOT, 'less' );
    
    $Saved_File = fopen( $bundleFile, 'w+' );
    fwrite( $Saved_File, $cssText );
    fclose( $Saved_File );
    
    $less = new lessc;
    //$less->setFormatter("compressed");
    $less->checkedCompile( $bundleFile, SITE_ROOT.CSS );

    if( file_exists( $bundleFile ) )
    {
        unlink( $bundleFile );
    }
Logger::Debug( 'lessMerge loaded...' );