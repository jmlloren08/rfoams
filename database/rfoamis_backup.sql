LOAD DATA INFILE 'listofda.csv'
INTO TABLE department_agencies
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(department_agencies, address, contact_number);