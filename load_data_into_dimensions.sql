select * from temp_sales;
select * from temp_reps;

INSERT INTO dcustomers (customer_id, customer_name, customer_surname)
SELECT DISTINCT customer_id, customer_name, customer_surname FROM temp_sales;
select * from dcustomers;

INSERT INTO dproducts(product_id, product_name)
SELECT DISTINCT product_id, product_name FROM temp_sales;
select * from dproducts;

INSERT INTO dstores(store_id, store_name)
SELECT DISTINCT store_id, store_name FROM temp_sales;
select * from dstores;

INSERT INTO dregions(region_name)
SELECT DISTINCT region FROM temp_sales;
select * from dregions;

INSERT INTO dproduct_main_cat(product_mc_name)
SELECT DISTINCT product_main_cat FROM temp_sales;
select * from dproduct_main_cat;

INSERT INTO dproduct_sub_cat(product_sc_name)
SELECT DISTINCT product_sub_cat FROM temp_sales;
select * from dproduct_sub_cat;

INSERT into dsales_reps(sales_rep_id, sales_rep_name, sales_rep_surname)
select rep_id, 
substring(rep_name, 1, position(' ' in rep_name)),
substring(rep_name, position(' ' in rep_name),length(rep_name))
from temp_reps ;
select * from dsales_reps 


