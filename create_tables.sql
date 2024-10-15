DROP TABLE IF EXISTS fSales;


drop table if exists dCustomers;
create table dCustomers(
Customer_key serial primary key,
customer_Id int,
customer_name text, 
customer_surname text
);
select * from dCustomers;


drop table if exists dProducts;
create table dProducts(
product_key serial primary key,
product_id int,
product_name text
);
select * from dproducts;


drop table if exists dStores;
create table dStores(
store_key serial primary key,
store_id int,
store_name text
);
select * from dStores;


drop table if exists dRegions;
create table dRegions(
region_key serial primary key,
region_name text
);
select * from dRegions;


drop table if exists dProduct_main_cat;
create table dProduct_main_cat(
product_mc_key serial primary key,
product_mc_name text
);
select * from dProduct_main_cat;


drop table if exists dProduct_sub_cat;
create table dProduct_sub_cat(
product_sc_key serial primary key,
product_sc_name text
);
select * from dProduct_sub_cat;


drop table if exists dSales_reps;
create table dSales_reps(
sales_rep_key serial primary key,
sales_rep_id int,
sales_rep_name text,
sales_rep_surname text
);
select * from dSales_reps;


CREATE TABLE fSales(
FACT_key serial,
customer_key int,
product_key int,
store_key int,
region_key int,
product_mc_key int,
product_sc_key int,
sales_rep_key int,
PRIMARY KEY (FACT_key, customer_key, product_key, store_key, region_key, product_mc_key, product_sc_key, sales_rep_key),
FOREIGN KEY (customer_key) REFERENCES dCustomers(customer_key),
FOREIGN KEY (product_key) REFERENCES dProducts(product_key),
FOREIGN KEY (store_key) REFERENCES dStores(store_key),
FOREIGN KEY (region_key) REFERENCES dRegions(region_key),
FOREIGN KEY (product_mc_key) REFERENCES dProduct_main_cat(product_mc_key),
FOREIGN KEY (product_sc_key) REFERENCES dProduct_sub_cat(product_sc_key),
FOREIGN KEY (sales_rep_key) REFERENCES dSales_reps(sales_rep_key),
qty int,
price numeric(21,2)
);

SELECT * FROM fSales;





