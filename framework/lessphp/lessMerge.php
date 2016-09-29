<?
    $bundleFile = SITE_ROOT."/content/bundle.less";
    if( file_exists( $bundleFile ) )
    {
        unlink( $bundleFile );
    }
    
    function MergeFilesText( $rootPath, $ext )
    {
        $fullPath = $rootPath;
        $content = "";
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
	                        $content .= MergeFilesText( $file, $ext );
	                   }
	                   else
	                   {
	                        if( End_With( $file, '.'.$ext ) && file_exists( $file ) )
	                        {
	                            $fhandler = fopen( $file, "rb" );
	                            $data = fread( $fhandler, filesize( $file ) );
	                            fclose( $fhandler );
	                            $content .= $data . "\r\n";
	                        }
	                   }
	               }
               } 
               closedir( $dh ); 
           } 
        }
        return $content;
    }

    $cssText = MergeFilesText( SITE_ROOT, 'less' );
    
    $Saved_File = fopen( $bundleFile, 'w+' );
    fwrite( $Saved_File, $cssText );
    fclose( $Saved_File );
    
    $less = new lessc;
    $less->checkedCompile( $bundleFile, SITE_ROOT."/content/bundle.css" );

    if( file_exists( $bundleFile ) )
    {
        unlink( $bundleFile );
    }