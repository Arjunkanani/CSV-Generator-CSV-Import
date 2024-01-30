CSV Generator & CSV Import to SQLite database HTML Form


Following are the form details which user needs to added by user

1. For CSV generation
- Enter no. of records that needs to be generated in CSV

> Here, Generate CSV button is used to generate the CSV file.

2. For CSV Import
- Choose the CSV file that was generated & needs to be imported

> Here, Import CSV button is used to imported the CSV data generated. This imported data will be stored in SQLite database
<br />
<br />

For best practice, to use this form we would suggest to use following configurations

1. PHP version - 7.0 & later
2. SQLite version - 3.22.0

We would recommend to set following configurations as mentioned below in order to import more than 1000000 records.

memory_limit = 2048M
post_max_size = 1000M
max_execution_time = 900
upload_max_filesize = 1000M

