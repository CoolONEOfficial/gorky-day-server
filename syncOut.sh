#!/bin/bash

echo 'Sync MySQL databases struct'

CURRENTDIR=$(pwd)
USER=user
PASS=pass

echo "MYSQL user:"
read USER
echo "MySQL pass:"
read PASS

echo 'Sync MySQL database structure...'
mysql -u ${USER} -p${PASS} db < ${CURRENTDIR}/dbStruct.sql

echo 'Put in new httpd this path (new document root)'
find -type f -name ${CURRENTDIR}/httpd.conf -exec sed -i -r 's/%DOCUMENTROOT%/"${CURRENTDIR}/root"/g' {} \;

echo 'Sync apache conf (httpd.conf)'
sudo cp -f ${CURRENTDIR}/httpd.conf /etc/httpd/conf/httpd.conf

