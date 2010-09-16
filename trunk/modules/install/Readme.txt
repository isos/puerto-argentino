This patch will fix the problem where the database update is skipped when moving from version 1.9p to veriosn 2.0. 
Various errors may appear mostly related to missing field heading_only in the chart_of_accounts table.

This patch needs to be applied immediately after Version 2.0 is installed and before the first login.

The problem is the updater script skips installing the updates to the database tables by not checking the 
version numbers properly.

Replace the file updater.php with the file in directory: /modules/install/

Naviagte to your login page and log in. The database update will be successfull if you have a new constant in 
Company -> Inventory Defaults -> Length of SKU for Bar code readers in order screens towards the bottom of the 
list.

