CREATE DATABASE IF NOT EXISTS guaulog;
USE 'guaulog';
CREATE USER 'guaulog'@'%' IDENTIFIED BY 'guaulog_user';
GRANT ALL PRIVILEGES ON *.* TO 'guaulog'@'%';
COMMIT;
