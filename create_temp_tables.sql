drop table if exists temp_Sales;
create table temp_Sales(
customer_Id int,
customer_name text,
customer_surname text,
product_id int,
product_name text,
product_price numeric (21,2),
qty int,
store_id int,
store_name text,
region text, 
product_main_cat text,
product_sub_cat text,
purchase_date date,
sales_rep_id int
);

copy temp_Sales from 'C:\Program Files\PostgreSQL\16\data\base\Temp\Sales_Data.csv' with csv header;

drop table if exists temp_Reps;
create table temp_Reps(
rep_id int,
rep_name text
);

copy temp_Reps from 'C:\Program Files\PostgreSQL\16\data\base\Temp\Sales_Rep_Data.csv' with csv header;

select * from temp_Sales;
select * from temp_Reps;
