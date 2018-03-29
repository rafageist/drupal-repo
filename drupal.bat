rem Create Drupal repository
color 1f
del projects

del download.bat
wget -c --no-proxy --no-check-certificate --secure-protocol=TLSv1 https://ftp-origin.drupal.org/files/projects
del projects.gz
ren projects projects.gz
gzip -d projects.gz
php drupal.php

call download.bat
