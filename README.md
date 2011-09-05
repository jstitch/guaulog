Guau! Baby Log v0.1
===================

Wish you could remember all those moments when your new-born baby
started to do things you teach him/her? When did it said 'Dad' for the
first time? When was he/she capable of standing up by him/herself?

Guau! Baby Log is a webapp that allows you to take note on the
*important* moments you wish or need to remember about the first
months of life of your baby. It has support for a **photo
gallery**. It also hides all the information behind a
password-protected account, away from the public eye.

Enjoy, and remember...



INSTALLATION
------------

You need:

- PHP 5
- MySQL 5
- Symfony 1.4
- A web server (such as Apache httpd)

Download the code of Guau! Baby Log
git clone git://github.com/jstitch/guaulog.git

You need a MySQL server running already!
Run **guaulog/config/install.sh** (edit as desired)

Edit **guaulog/config/ProjectConfiguration.class.php** to fit your
symfony installation

Configure a VirtualHost for Guau! Baby Log, you may use these as an
example:

http://www.symfony-project.org/jobeet/1_4/Doctrine/en/01#chapter_01_web_server_configuration_the_secure_way



LICENSE
-------

Guau! Baby Log is under the Gnu Affero General Public License v3.
Read the **LICENSE** file for more information.



TODO
----

- Add a 'calendar generator', which takes pictures from moths already
  uploaded and generates a calendar for that month

- Allow users to select a picture to display in the month screen by
 clicking on it

- Enhance user management. (Make it a social network?)



ABOUT
-----

Guau! Baby Log v0.1, by Javier Novoa Cataño.
GitHub site: https://github.com/jstitch/guaulog
