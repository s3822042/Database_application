# Database Application Group 1

## Contribution:
Team member: 
Huỳnh Vân Anh (s3836320)
Võ Thành Luân (s3822042)
Phạm Gia Nguyễn (s3819521)
Nguyễn Xuân Thành (s3915468)

 - All contributions from team members are the same and equal across the board.

Link to YouTube video: https://www.youtube.com/watch?v=7Kph0RcPGN4&t=323s

## Instructions:
Before running the application:
 1. Start your MySQL server and MongoDB local server.
 2. Open the config_mysql.php file and change the variables into suitable values for your MySQL server. 
    The variables names are self explanatory.
 3. If you have a different MongoDB uri than the default one, i.e. "mongodb://localhost:27017"
    Please also open the configmongodb.php and change the uri.
 4. Run the schema.sql so that the necessary
    tables and procedures and triggers are created for the application to work.
 5. Install Composer for PHP libraries and run "composer install" on folder root to
    install the necessery libraries for the application.
 6. Also make sure you have the PHP MongoDB extension installed. The guide for this can be
    found here: https://docs.mongodb.com/drivers/php/

Creating account:
1. Sign up to create an account (your account is always for user access)
2. Choose one of three type user account (customer, vendor, or shipper)
    + Vendor: able to list products, add a product, and edit a product
    + Customer: able to view products, search products, search vendors based on distance,
    buy product
    + Shipper: able to view orders at the assigned hub, update an order status
3. Fill personal information in the sign up form
4. Sign up to get access to your user account type