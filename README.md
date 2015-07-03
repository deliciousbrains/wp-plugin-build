plugin-build
============

Shell script we use to create builds of our WordPress plugins.

Features
--------

* Verifies that the version numbers in PHP files are correct
* Reads a list of files to exclude from the build
* Copies files to a folder and zips them up

Installation
------------

Install the `plugin-build` script in one of the folders in your PATH. Make
sure it has execute permissions (i.e. chmod +x plugin-build).

Usage
-----

Go to your plugin folder on the command line and execute:

    $ plugin-build <plugin-slug>[.php] <version>

Example:

    $ plugin-build wp-migrate-db 0.6

build Folder
------------

You need to create a `build` folder within your plugin folder. It houses
configuration and hook files to customize the build. It also houses temporary
files when running a build.

Inside the `build` folder, you need a `config.php` file. This can be empty but
it must exist.

All of these following files are optional:

**version-check.php** - PHP array of regular expressions to check if version
number given on the command line matches those in the plugin's PHP files.

```php
$version_checks = array(
	"$plugin_slug.php" => array(
		'@Version:\s+(.*)\n@' => 'header'
	)
);
```

**filter** - List of files to exclude from the zip. `rsync` format. Example:

```
- .sass-cache
- .DS_Store
- /.git
- /.gitignore
```

**filter.php** - Customize your filtering files with some code. See the
`build-example` folder in this repo for how we build the free and pro editions of WP
Migrate DB.

**pre-zip.php** - Code to execute just before zipping up. See the `build-example`
folder in this repo for an example of this and a way to make SVN deployment to
WordPress.org and GitHub a part of the build process.

Example build Folder
--------------------

For WP Migrate DB, we have one git repo for both editions: lite and pro. The
`build-example` folder in this repo is the `build` folder we use for WP
Migrate DB. It filters out certain files depending on the edition (lite or
pro) and if it's the lite version, gives us the option of deploying to
WordPress.org and a public GitHub repo.
