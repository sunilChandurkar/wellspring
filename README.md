This Web App can be hosted on Local.
I hosted it on a Simple Server UniServerZ.
You can host it on WAMP or MAMP.
Instructions.
1. Create a database called wellspring.
2. Create a table called trains.
3. SQL CREATE TABLE `wellspring`.`trains` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `train_line` VARCHAR(255) NOT NULL , `route_name` VARCHAR(255) NOT NULL , `run_number` VARCHAR(255) NOT NULL , `operator_id` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
4. In your www or htdocs directory clone the repo.
5. git clone https://github.com/sunilChandurkar/wellspring.git
6. Inside the connection.php file set your username and password.
7. The App should be available at http://localhost/wellspring/index.php
8. Create a directory called uploads in the wellspring directory. On the index page Select the file to upload trains_6.csv
9. The table will be populated.
10. You can Add and Edit trains via forms.
11. You can also Delete trains.
12. Trains are sorted by Run Number.
13. All Columns are Sortabel.
14. Pagination after 5 entries.
15. All entries are unique.
16. Rows with blank fields in the CSV will not be inserted.
17. CSV File Headers should be TRAIN_LINE, ROUTE_NAME, RUN_NUMBER, OPERATOR_ID.
18. Thank You for reading this.
19. You can reach me at 516.737.8424 if you have any problems during install.