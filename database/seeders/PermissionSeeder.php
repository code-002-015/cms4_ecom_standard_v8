<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Permission::insert([
            ['name' => 'View Page','module' => 'page','description' => 'User can view page list and detail','routes' => '["pages.index","pages.show","pages.index.advance-search"]','methods' => '["index","show","advance_index"]','user_id' => '1','is_view_page' => '1'],
            ['name' => 'Create Page','module' => 'page','description' => 'User can create pages','routes' => '["pages.create","pages.store"]','methods' => '["create","store"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Edit Page','module' => 'page','description' => 'User can edit pages','routes' => '["pages.edit","pages.update"]','methods' => '["edit","update"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Delete/Restore page','module' => 'page','description' => 'User can delete and restore pages','routes' => '["pages.destroy","pages.delete","pages.restore"]','methods' => '["destroy","delete","restore"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Change Status of Page','module' => 'page','description' => 'User can change status of pages','routes' => '["pages.change.status"]','methods' => '["change_status"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'View Album','module' => 'banner','description' => 'User can view album list and detail','routes' => '["albums.index","albums.show"]','methods' => '["index","show"]','user_id' => '1','is_view_page' => '1'],
            ['name' => 'Create Album','module' => 'banner','description' => 'User can create albums','routes' => '["albums.create","albums.store"]','methods' => '["create","store"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Edit Album','module' => 'banner','description' => 'User can edit albums','routes' => '["albums.edit","albums.update","albums.quick_update"]','methods' => '["edit","update","quick_update"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Delete/Restore album','module' => 'banner','description' => 'User can delete and restore albums','routes' => '["albums.destroy","albums.destroy_many","albums.restore"]','methods' => '["destroy","destroy_many","restore"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Manage File manager','module' => 'file_manager','description' => 'User can manage file manager','routes' => '["file-manager.show","file-manager.upload","file-manager.index"]','methods' => '["show","upload","index"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'View menu','module' => 'menu','description' => 'User can view menu list and detail','routes' => '["menus.index","menus.show"]','methods' => '["index","show"]','user_id' => '1','is_view_page' => '1'],
            ['name' => 'Create Menu','module' => 'menu','description' => 'User can create menus','routes' => '["menus.create","menus.store"]','methods' => '["create","store"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Edit Menu','module' => 'menu','description' => 'User can edit menus','routes' => '["menus.edit","menus.update"]','methods' => '["edit","update"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Delete/Restore menu','module' => 'menu','description' => 'User can delete and restore menus','routes' => '["menus.destroy","menus.destroy_many","menus.restore"]','methods' => '["destroy","destroy_many","restore"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'View news','module' => 'news','description' => 'User can view news list and detail','routes' => '["news.index","news.show","news.index.advance-search"]','methods' => '["index","show","advance_index"]','user_id' => '1','is_view_page' => '1'],
            ['name' => 'Create News','module' => 'news','description' => 'User can create news','routes' => '["news.create","news.store"]','methods' => '["create","store"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Edit news','module' => 'news','description' => 'User can edit news','routes' => '["news.edit","news.update"]','methods' => '["edit","update"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Delete/Restore News','module' => 'news','description' => 'User can delete and restore news','routes' => '["news.destroy","news.delete","news.restore"]','methods' => '["destroy","delete","restore"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Change Status of News','module' => 'news','description' => 'User can change status of news','routes' => '["news.change.status"]','methods' => '["change_status"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'View News Category','module' => 'news_category','description' => 'User can view news category list and details','routes' => '["news-categories.index","news-categories.show"]','methods' => '["index","show"]','user_id' => '1','is_view_page' => '1'],
            ['name' => 'Create news category','module' => 'news_category','description' => 'User can create news categories','routes' => '["news-categories.create","news-categories.store"]','methods' => '["create","store"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Edit news category','module' => 'news_category','description' => 'User can edit news categories','routes' => '["news-categories.edit","news-categories.update"]','methods' => '["edit","update"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Delete/Restore news category','module' => 'news_category','description' => 'User can delete and restore news categories','routes' => '["news-categories.destroy","news-categories.delete","news-categories.restore"]','methods' => '["destroy","delete","restore"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Edit website settings','module' => 'website_settings','description' => 'User can edit website settings','routes' => '["website-settings.edit","website-settings.update","website-settings.update-contacts","website-settings.update-media-accounts","website-settings.update-data-privacy","website-settings.remove-logo","website-settings.remove-icon","website-settings.remove-media"]','methods' => '["edit","update","update_contacts","update_media_accounts","update_data_privacy","remove_logo","remove_icon","remove_media"]','user_id' => '1','is_view_page' => '1'],
            ['name' => 'View audit logs','module' => 'audit_logs','description' => 'User can view audit logs','routes' => '["audit-logs.index"]','methods' => '["index"]','user_id' => '1','is_view_page' => '1'],
            ['name' => 'View users','module' => 'user','description' => 'User can view user list and detail','routes' => '["users.index","users.show","user.search","user.activity.search"]','methods' => '["index","show","search","filter"]','user_id' => '1','is_view_page' => '1'],
            ['name' => 'Create user','module' => 'user','description' => 'User can create users','routes' => '["users.create","users.store"]','methods' => '["create","store"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Edit user','module' => 'user','description' => 'User can edit users','routes' => '["users.edit","users.update"]','methods' => '["edit","update"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Change status of user','module' => 'user','description' => 'User can change status of users','routes' => '["users.deactivate","users.activate"]','methods' => '["deactivate","activate"]','user_id' => '1','is_view_page' => '0'],


            ['name' => 'View Product','module' => 'product','description' => 'User can view product list, details and reports','routes' => '["products.index","products.show","product.index.advance-search","report.product.list"]','methods' => '["index","show","advance_index","product_list"]','user_id' => '1','is_view_page' => '1'],
            ['name' => 'Create Product','module' => 'product','description' => 'User can create products','routes' => '["products.create","products.store"]','methods' => '["create","store"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Edit Product','module' => 'product','description' => 'User can edit products','routes' => '["products.edit","products.update"]','methods' => '["edit","update"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Delete Product','module' => 'product','description' => 'User can delete and restore products','routes' => '["products.destroy","product.single.delete","product.restore","products.multiple.delete"]','methods' => '["destroy","single_delete","restore","multiple_delete"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Change Status of Product','module' => 'product','description' => 'User can change status of products','routes' => '["product.single-change-status","product.multiple.change.status"]','methods' => '["change_status","multiple_change_status"]','user_id' => '1','is_view_page' => '0'],

            ['name' => 'View Product Category','module' => 'product_category','description' => 'User can view product category list and details','routes' => '["product-categories.index","product-categories.show"]','methods' => '["index","show"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Create Product Category','module' => 'product_category','description' => 'User can create product categories','routes' => '["product-categories.create","product-categories.store"]','methods' => '["create","store"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Edit Product Category','module' => 'product_category','description' => 'User can edit product categories','routes' => '["product-categories.edit","product-categories.update"]','methods' => '["edit","update"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Delete/Restore Product Category','module' => 'product_category','description' => 'User can delete and restore product categories','routes' => '["product-categories.destroy","product.category.single.delete","product.category.restore","product.category.multiple.delete"]','methods' => '["destroy","single_delete","restore","multiple_delete"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Change Status of Product Category','module' => 'product_category','description' => 'User can change status of product categories','routes' => '["product.category.change-status","product.category.multiple.change.status"]','methods' => '["update_status","multiple_change_status"]','user_id' => '1','is_view_page' => '0'],

            ['name' => 'View Product Review','module' => 'product_reviews','description' => 'User can view product reviews','routes' => '["product-review.list","product-review.list.advance-search"]','methods' => '["index","advance_index"]','user_id' => '1','is_view_page' => '1'],
            ['name' => 'Delete/Restore Product Review','module' => 'product_reviews','description' => 'User can delete and restore product reviews','routes' => '["product-review.delete","product-review.restore"]','methods' => '["delete","restore"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Change Status of Product Review','module' => 'product_reviews','description' => 'User can change status of product reviews','routes' => '["product-review.change_status"]','methods' => '["change_status"]','user_id' => '1','is_view_page' => '0'],

            ['name' => 'View Customer','module' => 'customer','description' => 'User can view customer list, details and reports','routes' => '["customers.index","customers.show","report.customer.list"]','methods' => '["index","show","customer_list"]','user_id' => '1','is_view_page' => '1'],
            ['name' => 'Change Status of Customer','module' => 'customer','description' => 'User can change status of customers','routes' => '["customer.deactivate","customer.activate"]','methods' => '["deactivate","activate"]','user_id' => '1','is_view_page' => '0'],

            ['name' => 'View Sales Transaction','module' => 'sales_transaction','description' => 'User can view sales transaction list, details and reports','routes' => '["sales-transaction.index","sales-transaction.show","sales-transaction.view","sales-transaction.view_payment","report.sales.list","report.sales.unpaid","report.sales.payments"]','methods' => '["index","show","show","view_payment","sales_list","unpaid_list","sales_payments"]','user_id' => '1','is_view_page' => '1'],
            ['name' => 'Add/Cancel Sales Transaction','module' => 'sales_transaction','description' => 'User can add or cancel sales transaction','routes' => '["sales-transaction.destroy","payment.add.store"]','methods' => '["destroy","payment_add_store"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Change delivery status of Sales Transaction','module' => 'sales_transaction','description' => 'User can change delivery status of sales transaction','routes' => '["sales-transaction.delivery_status"]','methods' => '["delivery_status"]','user_id' => '1','is_view_page' => '0'],

            ['name' => 'View Inventory','module' => 'inventory','description' => 'User can view inventory list, details and reports','routes' => '["inventory.index","inventory.show","inventory.view","report.inventory.list","report.inventory.reorder_point"]','methods' => '["index","show","view","inventory_list","inventory_reorder_point"]','user_id' => '1','is_view_page' => '1'],
            ['name' => 'Download and Upload Inventory Template','module' => 'inventory','description' => 'User can download and upload inventory template','routes' => '["inventory.download.template","inventory.upload.template"]','methods' => '["download_template","upload_template"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Post/Cancel Inventory','module' => 'inventory','description' => 'User can post or cancel inventory','routes' => '["inventory.post","inventory.cancel"]','methods' => '["post","cancel"]','user_id' => '1','is_view_page' => '0'],

            ['name' => 'View Delivery Flat Rate','module' => 'delivery_flat_rate','description' => 'User can view delivery flat rate list and detail','routes' => '["locations.index","locations.show"]','methods' => '["index","show"]','user_id' => '1','is_view_page' => '1'],
            ['name' => 'Create Delivery Flat Rate','module' => 'delivery_flat_rate','description' => 'User can create delivery flat rates','routes' => '["locations.create","locations.store"]','methods' => '["create","store"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Edit Delivery Flat Rate','module' => 'delivery_flat_rate','description' => 'User can edit delivery flat rates','routes' => '["locations.edit","locations.update"]','methods' => '["edit","update"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Delete Delivery Flat Rate','module' => 'delivery_flat_rate','description' => 'User can delete delivery flat rates','routes' => '["locations.destroy","locations.delete"]','methods' => '["destroy","delete"]','user_id' => '1','is_view_page' => '0'],
            ['name' => 'Change Status of Delivery Flat Rate','module' => 'delivery_flat_rate','description' => 'User can change status of delivery flat rates','routes' => '["locations.enable","locations.disable"]','methods' => '["enable","disable"]','user_id' => '1','is_view_page' => '0']
        ]);
    }
}
