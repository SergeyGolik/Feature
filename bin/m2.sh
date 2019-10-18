#!/bin/bash

bin/magento maintenance:enable
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento setup:static-content:deploy -f en_US de_DE --jobs 4
bin/magento indexer:reindex
bin/magento cache:clean
bin/magento cache:flush
bin/magento maintenance:disable


#bin/magento maintenance:enable
#bin/magento setup:upgrade && bin/magento setup:di:compile
#git checkout HEAD -- pub/media/.htaccess pub/media/customer/.htaccess pub/media/downloadable/.htaccess pub/media/import/.htaccess pub/media/theme_customization/.htaccess
#php bin/magento setup:static-content:deploy de_DE --jobs 3
#bin/magento maintenance:disable
#cd /home/essenab9/www.essenzshop.at/version/137/src/pub && rm -rf media; ln -s ../../shared/pub/media/ media
