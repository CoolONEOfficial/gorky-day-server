#!/bin/sh

echo 'Sync MySQL databases struct'

CURRENTDIR=$(pwd)
USER=user
PASS=pass
DBNAME=dbname

echo 'Enter MySQL username:'
read USER

echo 'Enter MySQL password:'
read PASS

echo 'Enter database name (db):'
read DBNAME

echo 'Copying apache conf (httpd.conf) file...'
cp /etc/httpd/conf/httpd.conf ${CURRENTDIR}/httpd.conf

echp 'Put in copied apache conf document root alias'
find -type f -name ${CURRENTDIR}/httpd.conf -exec sed -i -r 's/"${CURRENTDIR}/root"/%DOCUMENTROOT%/g' {} \;

echo 'Creating table sctructure...'
mysqldump --no-data -u ${USER} -p${PASS} ${DBNAME} > ${CURRENTDIR}/dbStruct.sql

