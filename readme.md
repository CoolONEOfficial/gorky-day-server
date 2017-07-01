# Description

This is server for Travel Quest

# Installation for ArchLinux

- Install php,
          MySQL (mariadb). Instructions in archwiki.
	sudo mysql_install_db --user=mysql --basedir=/usr --datadir=/var/lib/mysql
	sudo mysql_secure_installation
          Adminer

  Exec syncOut.sh. Enter MySQL login and password.
	sudo bash ./syncOut.bat

- Set 755 attributes in this dir

	chmod -R 755 /path/to/this/dir

- If this dir in your home dir set execute (x) attributes all dirs from ~/ to your dir

Example: your dir is ~/folder/subolder/TravelQuestDir

	chmod +x ~/
	chmod +x ~/folder
	chmod +x ~/folder/subfolder
	chmod +x ~/folder/subfolder/TravelQuestDir


- Restart httpd and mariadb

	sudo systemctl restart httpd
