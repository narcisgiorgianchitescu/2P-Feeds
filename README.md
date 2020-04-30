# 2P-Feeds

Prestashop setup: https://hostadvice.com/how-to/how-to-install-prestashop-on-ubuntu-18-04-server/

This module was tested on prestashop_1.7.6.4

Copy the folder in prestashop modules directory
Login as admin in the back office
Go to Improve section -> Modules -> Module Catalog and search for this module ("narcis")
Install the module
Visit the admin page for exporting feeds: /adminXXXXXX/index.php?controller=AdminFeeds
Click on Export Products
Go to /adminXXXXXX/products.csv and download the file manually, or curl base_url/adminXXXXXX/products.csv -o products.csv
