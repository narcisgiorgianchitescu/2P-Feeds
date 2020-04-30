# 2P-Feeds

Prestashop setup: https://hostadvice.com/how-to/how-to-install-prestashop-on-ubuntu-18-04-server/
This module was tested on prestashop_1.7.6.4


Installation: 

1. Copy the folder in prestashop modules directory

2. Login as admin in the back office

3. Go to Improve section -> Modules -> Module Catalog and search for this module ("narcis")

4. Install the module

5. Visit the admin page for exporting feeds: /adminXXXXXX/index.php?controller=AdminFeeds

6. Click on Export Products

7. Go to /adminXXXXXX/products.csv and download the file manually, or curl base_url/adminXXXXXX/products.csv -o products.csv will save the file 

8. Import the csv via url: base_url/adminXXXXXX/products.csv or via csv file 
