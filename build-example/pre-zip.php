<?php
if ( $edition == 'lite' ) {
	echo "Publish to WP.org? (Y/n) ";
	if ( 'Y' == trim( fgets( STDIN ) ) ) {
		echo `svn co -q http://svn.wp-plugins.org/wp-migrate-db svn`;
		echo `rm -R svn/trunk`;
		echo `mkdir svn/trunk`;
		echo `mkdir svn/tags/$version`;
		echo `rsync -r $plugin_slug/* svn/trunk/`;
		echo `rsync -r $plugin_slug/* svn/tags/$version`;
		echo `svn stat svn/ | grep '^\?' | awk '{print $2}' | xargs -I x svn add x@`;
		echo `svn stat svn/ | grep '^\!' | awk '{print $2}' | xargs -I x svn rm --force x@`;
		echo `svn stat svn/`;

		echo "Commit to WP.org? (Y/n)? ";
		if ( 'Y' == trim( fgets( STDIN ) ) ) {
			echo `svn ci svn/ -m "Deploy version $version"`;
		}
	}

	echo "Publish to Github? (Y/n) ";
	if ( 'Y' == trim( fgets( STDIN ) ) ) {
		system( 'git clone git@github.com:bradt/wp-migrate-db.git github1' );
		system( 'mkdir github' );
		system( 'mv github1/.git* github/' );
		system( 'rm -R github1/' );
		system( "rsync -r $plugin_slug/* github/" );
		chdir( 'github' );
		system( 'git add -A .' );
		system( 'git status' );

		echo "Commit and push to Github? (Y/n)? ";
		if ( 'Y' == trim( fgets( STDIN ) ) ) {
			system( "git commit -m 'Deploying version $version'" );
			system( 'git push origin master' );
			system( "git tag $version" );
			system( 'git push origin --tags' );
		}

		chdir( $tmp_dir );
	}
}
