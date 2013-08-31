Golden Contact Computing - JRush
-------------------



About:
-----------------
This tool is a command line application for controlling Joomla.

Works with Joomla 1.5.x, Joomla 2.5.x and Joomla 3.x. As yet its untested with Joomla 1.6 or 1.7, but there's no reason
that it wouldn't work. If your site is in either of these versions, give it a whirl and let us know if you have any
problems with it.

JRush performs a silent bootstrap of the Joomla Framework, so all standard Joomla library classes are available.

Adding standard Joomla Commands involving these classes will be easy.



Installation
-----------------

To install jrush cli on your machine do the following. If you already have php5 and git installed skip line 1:

sudo apt-get install php5 git

git clone https://github.com/phpengine/jrush && sudo php jrush/install-silent

or...

git clone https://github.com/phpengine/jrush && sudo php jrush/install
(if you want to choose the install location)

... that's it, now the jrush command should be available at the command line for you.




Available Commands:
---------------------------------------

cache         - Currently clearing the cache only works when using the file cache. This is fine for J1.5 as thats
                the only cache method that works, but for Joomla 3.0, we'll be implementing a couple of extras soon to
                clear whichever cache you're using.

              - site-clear
                Clear the site cache
                example: jrush cache site-clear --config-file="/var/www/website/configuration.php"

              - admin-clear
                Clear the admin cache
                example: jrush cache admin-clear --config-file="/var/www/website/configuration.php"

user          - info
                get info about a user
                example: jrush user info --user-id="XX" --config-file="/var/www/website/configuration.php"
                example: jrush user info --username="xxxx" --config-file="/var/www/website/configuration.php"
                example: jrush user info --user-email="xxx@xxx.xx" --config-file="/var/www/website/configuration.php"

              - delete
                delete a user. requires parameter --user-id, --user-email or --username
                example: jrush user delete --user-id="XX" --config-file="/var/www/website/configuration.php"
                example: jrush user delete --username="xxxx" --config-file="/var/www/website/configuration.php"
                example: jrush user delete --user-email="xxx@xxx.xx" --config-file="/var/www/website/configuration.php"

              - add @todo
                Add a new Joomla User
                example: jrush install autopilot

jfeature      - feature-install
                Install the metadata for a database migration, fileset, or both from the GC Features component
                example jrush jfeature feature-install --feature-file="/var/www/website/XXX_XXX.zip" --config-file="/var/www/website/configuration.php"

              - feature-pull
                perform a pull on an installed feature so it is integrated into the site, db and file changes executed.
                example jrush jfeature feature-pull --pull-unique-time="XXX_XXX" --config-file="/var/www/website/configuration.php"
                example jrush jfeature feature-pull --pull-id="XX" --config-file="/var/www/website/configuration.php"

              - feature-push
                perform a push on an installed feature so it is saved locally.
                example jrush jfeature feature-push --profile-unique="XXX" --config-file="/var/www/website/configuration.php" --push-type="local"

              - group-install
                Install the metadata for a database migration, fileset, or both from the GC Features component
                example jrush jfeature group-install --group-file="/var/www/website/XXXX.group" --config-file="/var/www/website/configuration.php"

              - group-push
                perform a push of a group profile into a locally saved file.
                example jrush jfeature group-push --group-unique="XXXXXXXXXXXXXXXX" --config-file="/var/www/website/configuration.php"

              - group-pull
                perform a pull on all installed features in the specified group so they are integrated into the site, db and
                file changes executed.
                example jrush jfeature group-pull --pull-unique-time="XXX_XXX" --config-file="/var/www/website/configuration.php"
                example jrush jfeature group-pull --pull-id="XX" --config-file="/var/www/website/configuration.php"

version       - joomla
                Report the info about the Major and Minor Version number of Joomla.
                example jrush version joomla --config-file="/var/www/website/configuration.php"

              - available
                List available versions of Joomla
                example jrush version available --config-file="/var/www/website/configuration.php"