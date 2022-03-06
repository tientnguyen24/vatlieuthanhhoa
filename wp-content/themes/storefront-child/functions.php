<?php

/**
 * Đặt các đoạn code cần tùy biến của bạn vào bên dưới
 */

/**
 * Xóa đi các thành phần không sử dụng trong homepage
 * @hook after_setup_theme
 *
 * template-homepage.php
 * @hook homepage
 * @hooked storefront_homepage_content - 10
 * @hooked storefront_product_categories - 20
 * @hooked storefront_recent_products - 30
 * @hooked storefront_featured_products - 40
 * @hooked storefront_popular_products - 50
 * @hooked storefront_on_sale_products - 60
 * @hooked storefront_best_selling_products - 70
 */
function tp_homepage_blocks() {
    /*
    * Sử dụng: remove_action( 'homepage', 'tên_hàm_cần_xóa', số thứ tự mặc định );
    */
    //remove_action( 'homepage', 'storefront_homepage_content', 10 );
    remove_action( 'homepage', 'storefront_product_categories', 20 );
    //remove_action( 'homepage', 'storefront_recent_products', 30 );
    remove_action( 'homepage', 'storefront_featured_products', 40 );
    remove_action( 'homepage', 'storefront_popular_products', 50 );
    //remove_action( 'homepage', 'storefront_on_sale_products', 60 );
    //remove_action( 'homepage', 'storefront_best_selling_products', 70 );
   }
   add_action( 'after_setup_theme', 'tp_homepage_blocks', 10 );


   /**
 * Tùy biến Product by Category
 * @hook storefront_product_categories_args
 *
 */

 