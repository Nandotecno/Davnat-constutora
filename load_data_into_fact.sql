insert into fSales(customer_key, product_key, store_key, region_key, product_mc_key, product_sc_key, sales_rep_key, qty, price)

select
    (select dcustomers.customer_key from dcustomers where dcustomers.customer_id = temp_sales.customer_id),
    (select dproducts.product_key from dproducts where dproducts.product_id = temp_sales.product_id),
    (select dstores.store_key from dstores where dstores.store_id = temp_sales.store_id),
    (select dregions.region_key from dregions where dregions.region_name = temp_sales.region),
    (select dproduct_main_cat.product_mc_key from dproduct_main_cat where dproduct_main_cat.product_mc_name = temp_sales.product_main_cat),
    (select dproduct_sub_cat.product_sc_key from dproduct_sub_cat where dproduct_sub_cat.product_sc_name = temp_sales.product_sub_cat),
    (select dsales_reps.sales_rep_key from dsales_reps where dsales_reps.sales_rep_id = temp_sales.sales_rep_id),
    temp_sales.qty,
    temp_sales.product_price as price
from temp_sales;

select * from fSales
