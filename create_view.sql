create view sales_view as
select fsales.fact_key as "FACT Key",
fsales.customer_key as "Customer Key",
(select dcustomers.customer_id from dcustomers where dcustomers.customer_key = fsales.customer_key) as "Customer ID",
(select dcustomers.customer_name from dcustomers where dcustomers.customer_key = fsales.customer_key) as "Customer Name",
(select dcustomers.customer_surname from dcustomers where dcustomers.customer_key = fsales.customer_key) as "Customer Surname",
fsales.product_key as "Product Key",
(select dproducts.product_id from dproducts where dproducts.product_key = fsales.product_key) as "Product ID",
(select dproducts.product_name from dproducts where dproducts.product_key = fsales.product_key) as "Product Name",
fsales.store_key as "Store Key",
(select dstores.store_id from dstores where dstores.store_key = fsales.store_key) as "Store ID",
(select dstores.store_name from dstores where dstores.store_key = fsales.store_key) as "Store Name",
fsales.region_key as "Region Key",
(select dregions.region_name from dregions where dregions.region_key = fsales.region_key) as "Region",
fsales.product_mc_key as "Main Category Key",
(select dproduct_main_cat.product_mc_name from dproduct_main_cat where dproduct_main_cat.product_mc_key = fsales.product_mc_key) as "Product Main Category",
fsales.product_sc_key as "Product Sub Category Key",
(select dproduct_sub_cat.product_sc_name from dproduct_sub_cat where dproduct_sub_cat.product_sc_key = fsales.product_sc_key) as "Product Sub Category",
fsales.sales_rep_key as "Sales Rep Key",
(select dsales_reps.sales_rep_id from dsales_reps where dsales_reps.sales_rep_key = fsales.sales_rep_key) as "Sales Rep ID",
(select dsales_reps.sales_rep_name from dsales_reps where dsales_reps.sales_rep_key = fsales.sales_rep_key) as "Sales Rep Name",
(select dsales_reps.sales_rep_surname from dsales_reps where dsales_reps.sales_rep_key = fsales.sales_rep_key) as "Sales Rep Surname"
from fsales;

select * from sales_view;