<?php

return [

    'empty_all_field' => 'Please fill in all the required fields.',
    'empty_field' => 'The content field is required.',
    'empty_password' => 'Enter your password.',
    'empty_confirm_password' => 'Enter your confirm password.',
    'no_selected' => 'Please select at least one (1) page.',

    'pages' => [
        'create' => 'Create a Page',
        'status_confirm' => 'You are about to change the status to :STATUS on multiple pages.',
        'status_success' => 'The Page status has been changed to :STATUS.',
        'delete_confirm' => 'You are about to delete page(s). Do you want to continue?',
        'delete_success' => 'The Page has been deleted.',
        'delete_failed' => 'Failed to delete a page. Please try again.',
        'update_success' => 'The Page has been updated.',
        'create_success' => 'The Page has been added.',
        //'same_slug' => 'The title page used is already taken.',
        //'incorrect_dimension' => 'The page banner image has incorrect dimensions.',
        //'exceed_size' => 'The image has exceeded the maximum file size.',
        'invalid_dimension' => 'The image has invalid dimensions. ',
        'restore_success' => 'The Page has been restored.',
    ],

    'banner' => [
        'restore_success' => 'The Album has been restored.',
        'delete_confirm' => 'You are about to delete an album.',
        'delete_success' => 'The Album has been deleted.',
        'delete_failed' => 'Failed to delete an album. Please try again.',
        'update_success' => 'The Album has been updated.',
        'remove_image' => 'Are you sure you want to remove the image?',
        //'exceed_size' => 'The image has exceeded the maximum file size. The required maximum file size is :size.',
        //'file_type' => 'The image has invalid file type. Please follow the required file types - :type .',
        //'incorrect_dimension' => 'The Banner image has invalid dimensions. Please follow the required dimensions :width by :height.',
        'create_success' => 'The Album has been created.',
        'empty_transition' => 'Please select an item from the list.',
        'exceed_file_size' => 'The image uploaded has exceeded the maximum file size.',
        'invalid_type' => 'The image uploaded has invalid file type.',
        'invalid_dimension' => 'The image uploaded has invalid dimensions.',
    ],

    'news' => [
        'article' => [
            'create' => 'Create a News',
            //'status_confirm' => 'You are about to change the status to :STATUS on multiple pages. Do you want to continue?',
            'status_success' => 'The News status has been changed to :STATUS.',
            'delete_confirm' => 'You are about to delete article(s). Do you want to continue?',
            'delete_success' => 'The News has been deleted.',
            'create_success' => 'The News page has been created.',
            'update_success' => 'The News has been updated.',
            'incorrect_dimension' => 'The page banner image has incorrect dimensions.',
            'exceed_size' => 'The Banner image has exceeded the maximum file size.',
            'invalid_dimension' => 'The image has invalid dimensions.',
            'teaser' => 'If empty, the system will automatically get an excerpt from your content and set it as your Teaser.',
            'restore_success' => 'The News has been restored.',
            ],
        'category' => [
            //'delete_confirm' => 'You are about to delete a category. Do you want to continue?',
            'delete_success' => 'The News Category has been deleted.',
            'update_success' => 'The News Category has been updated.',
            'create_success' => 'The News Category has been created.',
            'restore_success' => 'The News Category has been restored.',
        ],
    ],

    'menu' => [
        'update_success' => 'The Menu has been updated.',
        'create_success' => 'The Menu has been created.',
        'delete_success' => 'The Menu has been deleted.',
        'delete_failed' => 'Failed to delete a menu.',
        'delete_confirm' => 'Are you sure you want to delete this menu(s)? Please be reminded that you cannot revert this action once done.',
        'invalid_url' => 'Invalid Web Address.',
        'restore_success' => 'The menu has been restored.',
    ],

    'settings' => [
        'account' => [
            'update_success' => 'The account has been updated.',
            'update_failed' => 'Account update failed.',
            'update_email' => 'The email has been changed. You may now login using the new email.',
            'update_email_failed' => 'Failed to change email address. Try again later.',
            'email_no_domain' => 'The email address has no domain extension. Please use the standard format for email address.',
            'update_password' => 'The password has been changed. You may now login using the new password.',
            'update_password_failed' => 'Error changing password. Try again later.',
            'password_not_match' => 'The new password and its confirmation do not match.',
            'password_current_incorrect' => 'The current password entered is incorrect.',
            'update_avatar' => 'The Avatar has been changed.',
            'invalid_dimension' => 'Invalid image dimension.',
            'invalid_type' => 'Please take note of the following required criteria for avatar:',
        ],

        'website' => [
            'update_success' => 'The Website setting has been updated.',
            'update_failed' => 'Website settings not updated!',
            'remove_logo_success' => 'The Company Logo has been removed.',
            'remove_favicon_success' => 'The Website Icon has been removed.',
            'contact_update_success' => 'The Website Contact Setting has been updated .',
            'contact_update_failed' => 'Contacts not updated!',
            'invalid_email' => 'Invalid email address.',
            'social_updates_success' => 'The Social Media account has been updated.',
            'social_remove_success' => 'The Social Media account has been removed.',
            'privacy_updates_success' => 'The Data Privacy setting has been updated.',
            'remove_logo_confirmation' => 'Are you sure you want to remove the logo?',
            'remove_logo_confirmation_title' => 'Remove Company Logo',
            'remove_icon_confirmation' => 'Are you sure you want to remove the icon?',
            'remove_icon_confirmation_title' => 'Remove Website Icon',
            'remove_social_account_confirmation' => 'Are you sure you want to remove the account ?',
            'remove_social_account_confirmation_title' => 'Remove Social Media Account',
            'tip_helper' => 'You can input multiple items in each field below. For example, input a mobile number then click Enter.',
            'pop-up_helper' => 'This is the pop-up/dialog box displayed when someone visits your site.',
        ],

        'website_menu' => [
            'delete_confirm' => 'You are about to delete a category. Do you want to continue?',
            'delete_success' => 'The Menu has been deleted.',
            'quick_delete_confirm' => 'Are you sure you want to delete this menu? Please be reminded that you cannot revert this action once done.',
            'update_success' => 'The Menu has been updated.',
            'remove' => 'Are you sure you want to remove this item? Please be reminded that you cannot revert this action once done.',
            'create_success' => 'The Menu has been created.',
        ],
    ],

    'users' => [
        'status_confirm' => 'You are about to :status this user. Do you want to continue?',
        'status_success' => 'The User Account has been :status.',
        'update_success' => 'The User Account has been updated.',
        'create_success' => 'The User Account has been created.',
        'exist_name' => 'The user’s name you have entered is already in the list.',
        'required_char' => 'The password must have at least 8 characters.',
        'duplicate_email' => 'The email address you have entered is already existing.',
        'invalid_email' => 'Invalid email address',
        //'invalid_password' => 'Invalid Password Format Please be reminded that a password must have a Minimum of eight (8) alphanumeric characters (combination of letters and numbers) with at least one (1) upper case and one (1) special character',
        'invalid_password' => 'Invalid Password Format.',
        'user_status' => 'You are about to :status this user. Do you want to continue?',
        'password_requirement' => 'Requirement: The acceptable password should have 8 characters, at least 1 uppercase, lowercase, number, and at least 1 special character.',
        'password_not_match' => 'The new password and its confirmation do not match.',
        'password_current_incorrect' => 'The current password entered is incorrect.',

    ],

    'account_management' => [
        'access_rights' => [
            'update_success' => 'The Access Permission has been updated.',
        ],

        'roles' => [
            'delete_confirm' => 'You are about to delete this role. Do you want to continue?',
            'delete_success' => 'The Role has been deleted.',
            'update_success' => 'The Role has been updated.',
            'create_success' => 'The Role has been created.',
            'duplicate_role' => 'The role you have entered is already in the list.',
            'delete_confirmation_title' => 'Delete Role',
            'delete_confirmation' => 'You are about to delete this role. Do you want to continue?',
            'restore_success' => 'Successfully restored the role',
        ],

        'permissions' => [
            'delete_confirm' => 'You are about to delete this permission. Do you want to continue?',
            'delete_success' => 'The Access Permission has been deleted.',
            'update_success' => 'The Access Permission has been updated.',
            'create_success' => 'The Access Permission has been created.',
            'duplicate_permission' => 'The Access Permission that you have entered is already in the list.',
            'restore_success' => 'Successfully restored the page',
            'delete_confirmation_title' => 'Delete permission',
            'delete_confirmation' => 'You are about to delete this permission. Do you want to continue?',

        ],
    ],

    'seo' => [
        'title' => 'The Title must not exceed the maximum limit of 60 characters.',
        'description' => 'It is highly recommended to keep your description not longer than 160 characters to maximize the functionalities of search engines.',
        'keywords' => 'It is highly recommended to keep your keywords maximum of 3 key phrases and separated with comma (,).',
    ],

    'products' => [
        'product' => [
            'create' => 'Create a Product',
            'create_success' => 'The product has been added.',
            'update_success' => 'The product has been updated.',
            'update_status_success' => 'The product status has been changed to :STATUS',
            'single_delete_success' => 'The product has been deleted.',
            'restore_product_success' => 'Successfully restored the product.',
            'change_status_success' => 'The products status has been changed to :STATUS',
            'multiple_delete_success' => 'Successfully deleted the products.',

            ],
        'category' => [
            'create' => 'Create a Category',
            'create_category_success' => 'The product category has been added.',
            'update_success' => 'The products category has been updated.',
            'single_delete_success' => 'The product category has been deleted.',
            'restore_category_success' => 'Successfully restored the product category.',
            'multiple_delete_success' => 'Selected product categories has been deleted.',
            'category_update_success' => 'Selected product category status has been changed to :STATUS',
        ],
    ],

    'promos' => [
        'create_success' => 'Promo has been added.',
        'promo_update_success' => 'Selected promo status has been changed to :STATUS',
        'single_delete_success' => 'The promo has been deleted.',
        'promo_update_success' => 'Selected promo status has been changed to :STATUS',
        'multiple_delete_success' => 'Selected promos has been deleted.',
        'restore_promo_success' => 'Successfully restored the promo.',
        'promo_update_details_success' => 'Promo details has been updated.'
    ],

    'locations' => [
        'create_success' => 'The Location has been created.',
        'status_update_success' => 'The Location status has been changed to :STATUS',
        'single_delete_success' => 'The Location has been deleted.',
        'multiple_status_update_success' => 'Selected Location(s) status has been changed to :STATUS',
        'multiple_delete_success' => 'Selected Location(s) has been deleted.',
        'update_details_success' => 'The Location has been updated.'
    ],

    'customers' => [
        'status_success' => 'The Customer has been :status' 
    ],

    'coupons' => [
        'status_update_success' => 'The Coupon status has been changed to :STATUS',
        'single_delete_success' => 'The Coupon has been deleted.',
        'restore_promo_success' => 'The Coupon has been restored.',
        'multiple_status_update_success' => 'Selected Coupon(s) status has been changed to :STATUS',
        'multiple_delete_success' => 'Selected Coupon(s) has been deleted.'
    ],

];
