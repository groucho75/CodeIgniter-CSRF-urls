CodeIgniter-CSRF-urls
=====================

This helper extends the CI Security class and allows users easily to append CSRF variables to desired links.
I tested it with CodeIgniter 2.0 and 2.1.3.


## Concept
[CSRF](https://www.owasp.org/index.php/Cross-Site_Request_Forgery_%28CSRF%29) is an attack which forces an end user to execute unwanted actions on a web application in which he/she is currently authenticated.

CI gives you a default protection when submitting forms. This helper lets you protect desired links of your site from attacks.

In the admin area of your site you could have a button that deletes an item. The url can be like:

`/index.php/admin/delete/item/1`

To make it less vulnerable to attack this helper appends CSRF variables to url. So it becomes:

`/index.php/admin/delete/item/1/your_csrf_token_name/your_csrf_token_value`


## Installation
1. Download the files inside your **application** folder of your CI installation (make sure you copy all files/folders).
2. Be sure to have **csrf_protection** configuration item set tu true: edit it in *application/config/config.php* or add it in *index.php*.
3. Visit the test controller `/index.php/csrf_test/` and try the sample.


## Helper functions
You have 2 functions:

#### csrf_site_url ( *uri* ) ####
* append CSRF token name and value to the *uri* and return it (it uses *site_url()* )

#### check_csrf_url ()####
* put this function in a controller method to check the CSRF variables appended in url against the values stored in a cookie: if the check fails an error is shown

You can view the *csrf_test* controller code to see the sample.





