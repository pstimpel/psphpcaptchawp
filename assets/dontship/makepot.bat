REM needs gettext installed https://mlocati.github.io/articles/gettext-iconv-windows.html
REM needs word press dev sources checked out svn http://develop.svn.wordpress.org/trunk/ to c:\dev_wordpress_org

c:\

cd \dev_wordpress_org\tools\i18n

c:\xampp\php\php.exe makepot.php wp-plugin c:\xampp\htdocs\wordpress\wp-content\plugins\psphpcaptchawp c:\xampp\htdocs\wordpress\wp-content\plugins\psphpcaptchawp\languages\psphpcaptchawp.pot

