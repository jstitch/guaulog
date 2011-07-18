#!/bin/bash
echo "Cache and Log dirs assume that HTTP user has same group as project creator. You may change permissions. The thing is that HTTP user must have write access in to these directories"

mkdir ../cache
chmod g+w ../cache
mkdir ../log
chmod g+w ../log

echo "Same goes for uploads subdirs..."
chmod g+w ../web/uploads
chmod -R g+w ../web/uploads/fotos
chmod -R g+w ../web/uploads/.reduced
chmod -R g+w ../web/uploads/.thumbnails

echo "WARNING: mysql server must be running!!!"

mysql -u root -p < install.sql
mysql -u root -p -D guaulog < guaulog_dev_data.sql

echo "You must edit config/ProjectConfiguration.class.php so that
require_once statement points to right path in your symfony
installation."

echo "If you wish you may use the symbolic link at lib/vendor/symfony
to point there."

echo ""

echo "You need to setup a Virtual Host for guaulog.yourdomain in your
system".

echo ""

echo "If you are using Git, you may create a .gitignore at the root of
your project and add cache/*, log/* and .gitignore entries"
