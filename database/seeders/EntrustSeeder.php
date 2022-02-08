<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EntrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $adminRole = Role::create([
            'name'                              =>'admin',
            'display_name'                      =>'Administraion',
            'description'                       =>'Adminstrator',
            'allowed_route'                     =>'admin',
        ]);
        $supervisorRole = Role::create([
            'name'                              =>'supervisor',
            'display_name'                      =>'Supervisor',
            'description'                       =>'Supervisor',
            'allowed_route'                     =>'admin',
        ]);
        $customerRole = Role::create([
            'name'                              =>'customer',
            'display_name'                      =>'Customer',
            'description'                       =>'Customer',
            'allowed_route'                     =>null,
        ]);

        $admin = User::create([
            'first_name'                        =>'Admin',
            'last_name'                         =>'System',
            'username'                          =>'admin',
            'email'                             =>'Admin@gmail.com',
            // مكتبه الكاربون 
            'email_verified_at'                 =>now(),
            'mobile'                            =>'01061597973',
            'password'                          =>bcrypt('123456789'),
            // 'user_image'                        =>'avatar.svg',
            'status'                             =>1,
            'remember_token'                    =>Str::random(10),
        ]);
        $admin->attachRole($adminRole);


        $supervisor = User::create([
            'first_name'                        =>'Supervisor',
            'last_name'                         =>'System',
            'username'                          =>'supervisor',
            'email'                             =>'supervisor@gmail.com',
            // مكتبه الكاربون 
            'email_verified_at'                 =>now(),
            'mobile'                            =>'01007649921',
            'password'                          =>bcrypt('123456789'),
            // 'user_image'                        =>'avatar.svg',
            'status' =>1,
            'remember_token'                    =>Str::random(10),
        ]);
        $supervisor->attachRole($supervisorRole);


        $customer = User::create([
            'first_name'                        =>'mohamed',
            'last_name'                         =>'srage',
            'username'                          =>'ahmed',
            'email'                             =>'srage@gmail.com',
            // مكتبه الكاربون 
            'email_verified_at'                 =>now(),
            'mobile'                            =>'01091538214',
            'password'                          =>bcrypt('123456789'),
            // 'user_image'                        =>'avatar.svg',
            'status'                            =>1,
            'remember_token'                    =>Str::random(10),
        ]);
        $customer->attachRole($customerRole);

        // for($i = 1; $i <= 20; $i++) {
        //     $random_customer = User::create([
        //         'first_name' =>$faker->firstName,
        //         'last_name' =>$faker->lastName,
        //         'username' =>$faker->userName,
        //         'email' =>$faker->unique()->safeEmail,
        //         // مكتبه الكاربون 
        //         'email_verified_at' =>now(),
        //         'mobile' =>'0109' . $faker->numberBetween(100000,99999),
        //         'password' =>bcrypt('123456789'),
        //         'user_image' =>'avatar.svg',
        //         'status' =>1,
        //         'remember_token' =>Str::random(10),
        //     ]);
        //     $random_customer->attachRole($customerRole); 
        // }

              /*
         * Create 1000 fake users with their addresses.
         */

        $managMain = Permission::create([
            'name'                          =>'main',
            'display_name'                  =>'Main',
            // 'description'                =>'',
            'route'                         =>'index',
            'module'                        =>'index',
            'as'                            =>'index',
            'icon'                          =>'fas fa-home',
            'parent'                        =>'0',
            'parent_original'               =>'0',
            'sidebar_link'                  =>'1',
            'appear'                        =>'1',
            'ordering'                      =>'1',
        ]);

        $managMain->parent_show = $managMain->id;
        $managMain->save();

        //categorys

        $managCategories = Permission::create([
            'name'                          =>'manag_categories',
            'display_name'                  =>'Categories',
            // 'description'                =>'',
            'route'                         =>'categories',
            'module'                        =>'categories',
            'as'                            =>'categories.index',
            'icon'                          =>'fas fa-file-archive',
            'parent'                        =>'0',
            'parent_original'               =>'0',
            'sidebar_link'                  =>'1',
            'appear'                        =>'1',
            'ordering'                      =>'5',
        ]);
        $managCategories->parent_show = $managCategories->id;
        $managCategories->save();


        $showCategories = Permission::create([
            'name'                          =>'show_categories',
            'display_name'                  =>'Categories',
            // 'description'                =>'',
            'route'                         =>'categories',
            'module'                        =>'categories',
            'as'                            =>'categories.index',
            'icon'                          =>'fas fa-file-archive',
            'parent'                        =>$managCategories->id,
            'parent_original'               =>$managCategories->id,
            'parent_show'                   =>$managCategories->id,
            'sidebar_link'                  =>'1',
            'appear'                        =>'1',
            // 'ordering'                   =>'5',
        ]);

        $createCategories = Permission::create([
            'name'                          =>'create_categories',
            'display_name'                  =>'Create Category',
            // 'description'                =>'',
            'route'                         =>'categories',
            'module'                        =>'categories',
            'as'                            =>'categories.create',
            'icon'                          =>null,
            'parent'                        =>$managCategories->id,
            'parent_original'               =>$managCategories->id,
            'parent_show'                   =>$managCategories->id,
            'sidebar_link'                  =>'1',
            'appear'                        =>'0',
            // 'ordering' =>'5',
        ]);

        $displayCategories = Permission::create([
            'name'                          =>'display_categories',
            'display_name'                  =>'Show Category',
            // 'description'                =>'',
            'route'                         =>'categories',
            'module'                        =>'categories',
            'as'                            =>'categories.show',
            'icon'                          =>null,
            'parent'                        =>$managCategories->id,
            'parent_original'               =>$managCategories->id,
            'parent_show'                   =>$managCategories->id,
            'sidebar_link'                  =>'1',
            'appear'                        =>'0',
            // 'ordering'                   =>'5',
        ]);

        $updateCategories = Permission::create([
            'name'                          =>'update_categories',
            'display_name'                  =>'Update Category',
            // 'description'                =>'',
            'route'                         =>'categories',
            'module'                        =>'categories',
            'as'                            =>'categories.edit',
            'icon'                          =>null,
            'parent'                        =>$managCategories->id,
            'parent_original'               =>$managCategories->id,
            'parent_show'                   =>$managCategories->id,
            'sidebar_link'                  =>'1',
            'appear'                        =>'0',
            // 'ordering'                   =>'5',
        ]);


        $deleteCategories = Permission::create([
            'name'                          =>'delete_categories',
            'display_name'                  =>'Delete Category',
            // 'description'                =>'',
            'route'                         =>'categories',
            'module'                        =>'categories',
            'as'                            =>'categories.destroy',
            'icon'                          =>null,
            'parent'                        =>$managCategories->id,
            'parent_original'               =>$managCategories->id,
            'parent_show'                   =>$managCategories->id,
            'sidebar_link'                  =>'1',
            'appear'                        =>'0',
            // 'ordering'                   =>'5',
        ]);



        //Tags

        $managTags = Permission::create([
            'name'                          =>'manag_tags',
            'display_name'                  =>'Tag',
            // 'description'                =>'',
            'route'                         =>'tags',
            'module'                        =>'tags.index',
            'as'                            =>'tags.index',
            'icon'                          =>'fas fa-fas fa-tags',
            'parent'                        =>'0',
            'parent_original'               =>'0',
            'sidebar_link'                  =>'1',
            'appear'                        =>'1',
            'ordering'                      =>'10',
        ]);
        $managTags->parent_show = $managTags->id;
        $managTags->save();


        $showTags = Permission::create([
            'name'                          =>'show_tags',
            'display_name'                  =>'Tag',
            // 'description'                =>'',
            'route'                         =>'tags',
            'module'                        =>'tags',
            'as'                            =>'tags.index',
            'icon'                          =>'fas fa-tags',
            'parent'                        =>$managTags->id,
            'parent_original'               =>$managTags->id,
            'parent_show'                   =>$managTags->id,
            'sidebar_link'                  =>'1',
            'appear'                        =>'1',
            // 'ordering'                   =>'5',
        ]);

        $createTags = Permission::create([
            'name'                          =>'create_tags',
            'display_name'                  =>'Create Tag',
            // 'description'                =>'',
            'route'                         =>'tags',
            'module'                        =>'tags',
            'as'                            =>'tags.create',
            'icon'                          =>null,
            'parent'                        =>$managTags->id,
            'parent_original'               =>$managTags->id,
            'parent_show'                   =>$managTags->id,
            'sidebar_link'                  =>'1',
            'appear'                        =>'0',
            // 'ordering' =>'5',
        ]);

        $displayTags = Permission::create([
            'name'                          =>'display_tags',
            'display_name'                  =>'Show Tag',
            // 'description'                =>'',
            'route'                         =>'tags',
            'module'                        =>'tags',
            'as'                            =>'tags.show',
            'icon'                          =>null,
            'parent'                        =>$managTags->id,
            'parent_original'               =>$managTags->id,
            'parent_show'                   =>$managTags->id,
            'sidebar_link'                  =>'1',
            'appear'                        =>'0',
            // 'ordering'                   =>'5',
        ]);

        $updateTags = Permission::create([
            'name'                          =>'update_tags',
            'display_name'                  =>'Update Tag',
            // 'description'                =>'',
            'route'                         =>'tags',
            'module'                        =>'tags',
            'as'                            =>'tags.edit',
            'icon'                          =>null,
            'parent'                        =>$managTags->id,
            'parent_original'               =>$managTags->id,
            'parent_show'                   =>$managTags->id,
            'sidebar_link'                  =>'1',
            'appear'                        =>'0',
            // 'ordering'                   =>'5',
        ]);


        $deleteTags = Permission::create([
            'name'                          =>'delete_tags',
            'display_name'                  =>'Delete Tag',
            // 'description'                =>'',
            'route'                         =>'tags',
            'module'                        =>'tags',
            'as'                            =>'tags.destroy',
            'icon'                          =>null,
            'parent'                        =>$managTags->id,
            'parent_original'               =>$managTags->id,
            'parent_show'                   =>$managTags->id,
            'sidebar_link'                  =>'1',
            'appear'                        =>'0',
            // 'ordering'                   =>'5',
        ]);


        //PRODUCTS 

        $managProducts = Permission::create([
            'name'                          =>'manag_products',
            'display_name'                  =>'Product',
            // 'description'                =>'',
            'route'                         =>'products',
            'module'                        =>'products',
            'as'                            =>'products.index',
            'icon'                          =>'fas fa-file-archive',
            'parent'                        =>'0',
            'parent_original'               =>'0',
            'sidebar_link'                  =>'1',
            'appear'                        =>'1',
            'ordering'                      =>'15',
        ]);
        $managProducts->parent_show = $managProducts->id;
        $managProducts->save();


        $showProducts = Permission::create([
            'name'                          =>'show_products',
            'display_name'                  =>'Product',
            // 'description'                =>'',
            'route'                         =>'products',
            'module'                        =>'products',
            'as'                            =>'products.index',
            'icon'                          =>'fas fa-file-archive',
            'parent'                        =>$managProducts->id,
            'parent_original'               =>$managProducts->id,
            'parent_show'                   =>$managProducts->id,
            'sidebar_link'                  =>'1',
            'appear'                        =>'1',
            // 'ordering'                   =>'5',
        ]);

        $createProducts = Permission::create([
            'name'                          =>'create_products',
            'display_name'                  =>'Create Product',
            // 'description'                =>'',
            'route'                         =>'Products',
            'module'                        =>'Products',
            'as'                            =>'Products.create',
            'icon'                          =>null,
            'parent'                        =>$managProducts->id,
            'parent_original'               =>$managProducts->id,
            'parent_show'                   =>$managProducts->id,
            'sidebar_link'                  =>'1',
            'appear'                        =>'0',
            // 'ordering' =>'5',
        ]);

        $displayProducts = Permission::create([
            'name'                          =>'display_Products',
            'display_name'                  =>'Show Product',
            // 'description'                =>'',
            'route'                         =>'products',
            'module'                        =>'products',
            'as'                            =>'products.show',
            'icon'                          =>null,
            'parent'                        =>$managProducts->id,
            'parent_original'               =>$managProducts->id,
            'parent_show'                   =>$managProducts->id,
            'sidebar_link'                  =>'1',
            'appear'                        =>'0',
            // 'ordering'                   =>'5',
        ]);

        $updateProducts = Permission::create([
            'name'                          =>'update_products',
            'display_name'                  =>'Update Product',
            // 'description'                =>'',
            'route'                         =>'products',
            'module'                        =>'products',
            'as'                            =>'products.edit',
            'icon'                          =>null,
            'parent'                        =>$managProducts->id,
            'parent_original'               =>$managProducts->id,
            'parent_show'                   =>$managProducts->id,
            'sidebar_link'                  =>'1',
            'appear'                        =>'0',
            // 'ordering'                   =>'5',
        ]);


        $deleteProducts = Permission::create([
            'name'                          =>'delete_products',
            'display_name'                  =>'Delete Product',
            // 'description'                =>'',
            'route'                         =>'products',
            'module'                        =>'products',
            'as'                            =>'products.destroy',
            'icon'                          =>null,
            'parent'                        =>$managProducts->id,
            'parent_original'               =>$managProducts->id,
            'parent_show'                   =>$managProducts->id,
            'sidebar_link'                  =>'1',
            'appear'                        =>'0',
            // 'ordering'                   =>'5',
        ]);



         // PRODUCT COUPONS
         $manageProductCoupons = Permission::create([
            'name'                                                  =>'manage_product_coupons',
            'display_name'                                          =>'Coupons',
            'route'                                                 =>'product_coupons',
            'module'                                                =>'product_coupons',
            'as'                                                    =>'product_coupons.index',
            'icon'                                                  =>'fas fa-percent',
            'parent'                                                =>'0',
            'parent_original'                                       =>'0',
            'sidebar_link'                                          =>'1',
            'appear'                                                =>'1',
            'ordering'                                              =>'20',
        ]);
         $manageProductCoupons->parent_show = $manageProductCoupons->id; $manageProductCoupons->save();
         $showProductCoupons = Permission::create([
            'name'                                                  =>'show_product_coupons',
            'display_name'                                          =>'Coupons',
            'route'                                                 =>'product_coupons',
            'module'                                                =>'product_coupons',
            'as'                                                    =>'product_coupons.index',
            'icon'                                                  =>'fas fa-percent',
            'parent'                                                =>$manageProductCoupons->id,
            'parent_original'                                       =>$manageProductCoupons->id,
            'parent_show'                                           =>$manageProductCoupons->id,
            'sidebar_link'                                          =>'1',
            'appear'                                                =>'1'
        ]);
         $createProductCoupons = Permission::create([
        'name'                                                      =>'create_product_coupons',
        'display_name'                                              =>'Create Coupon',
        'route'                                                     =>'product_coupons',
        'module'                                                    =>'product_coupons',
        'as'                                                        =>'product_coupons.create',
        'icon'                                                      =>null,
        'parent'                                                    =>$manageProductCoupons->id,
        'parent_original'                                           =>$manageProductCoupons->id,
        'parent_show'                                               =>$manageProductCoupons->id,
        'sidebar_link'                                              =>'1',
        'appear'                                                    =>'0'
        ]);
         $displayProductCoupons = Permission::create([
        'name'                                                      =>'display_product_coupons',
        'display_name'                                              =>'Show Coupon',
        'route'                                                     =>'product_coupons',
        'module'                                                    =>'product_coupons',
        'as'                                                        =>'product_coupons.show',
        'icon'                                                      =>null,
        'parent'                                                    =>$manageProductCoupons->id,
        'parent_original'                                           =>$manageProductCoupons->id,
        'parent_show'                                               =>$manageProductCoupons->id,
        'sidebar_link'                                              =>'1',
        'appear'                                                    =>'0'
        ]);
         $updateProductCoupons = Permission::create([
        'name'                                                      =>'update_product_coupons',
        'display_name'                                              =>'Update Coupon',
        'route'                                                     =>'product_coupons',
        'module'                                                    =>'product_coupons',
        'as'                                                        =>'product_coupons.edit',
        'icon'                                                      => null,
        'parent'                                                    => $manageProductCoupons->id,
        'parent_original'                                           => $manageProductCoupons->id,
        'parent_show'                                               => $manageProductCoupons->id,
        'sidebar_link'                                              => '1',
        'appear'                                                    => '0'
        ]);
        $deleteProductCoupons = Permission::create([
        'name'                                                      =>'delete_product_coupons',
        'display_name'                                              =>'Delete Coupon',
        'route'                                                     =>'product_coupons',
        'module'                                                    =>'product_coupons',
        'as'                                                        =>'product_coupons.destroy',
        'icon'                                                      =>null,
        'parent'                                                    =>$manageProductCoupons->id,
        'parent_original'                                           =>$manageProductCoupons->id,
        'parent_show'                                               =>$manageProductCoupons->id,
        'sidebar_link'                                              =>'1',
        'appear'                                                    =>'0'
        ]);




        // PRODUCT REVIEWS
        $manageProductReviews = Permission::create([
        'name'                                                      =>'manage_product_reviews',
        'display_name'                                              =>'Reviews',
        'route'                                                     =>'product_reviews',
        'module'                                                    =>'product_reviews',
        'as'                                                        =>'product_reviews.index',
        'icon'                                                      =>'fas fa-comment',
        'parent'                                                    =>'0',
        'parent_original'                                           =>'0',
        'sidebar_link'                                              =>'1',
        'appear'                                                    =>'1',
        'ordering'                                                  =>'20',
        ]);
        $manageProductReviews->parent_show = $manageProductReviews->id; $manageProductReviews->save();
        $showProductReviews = Permission::create([
        'name'                                                      =>'show_product_reviews',
        'display_name'                                              =>'Reviews',
        'route'                                                     =>'product_reviews',
        'module'                                                    =>'product_reviews',
        'as'                                                        =>'product_reviews.index',
        'icon'                                                      =>'fas fa-comment',
        'parent'                                                    =>$manageProductReviews->id,
        'parent_original'                                           =>$manageProductReviews->id,
        'parent_show'                                               =>$manageProductReviews->id,
        'sidebar_link'                                              =>'1',
        'appear'                                                    =>'1'
        ]);
        $createProductReviews = Permission::create([
        'name'                                                       =>'create_product_reviews',
        'display_name'                                               => 'Create Review', 
        'route'                                                      =>'product_reviews', 
        'module'                                                     =>'product_reviews', 
        'as'                                                         =>'product_reviews.create', 
        'icon'                                                       =>null, 
        'parent'                                                     =>$manageProductReviews->id, 
        'parent_original'                                            =>$manageProductReviews->id, 
        'parent_show'                                                =>$manageProductReviews->id, 
        'sidebar_link'                                               =>'1', 
        'appear'                                                     =>'0'
        ]);
        $displayProductReviews = Permission::create([
        'name'                                                      => 'display_product_reviews',
        'display_name'                                              => 'Show Review',
        'route'                                                     => 'product_reviews',
        'module'                                                    => 'product_reviews',
        'as'                                                        => 'product_reviews.show',
        'icon'                                                      => null,
        'parent'                                                    => $manageProductReviews->id,
        'parent_original'                                           => $manageProductReviews->id,
        'parent_show'                                               =>$manageProductReviews->id,
        'sidebar_link'                                              =>'1',
        'appear'                                                    =>'0'
        ]);
        
        $updateProductReviews = Permission::create([
        'name'                                                      => 'update_product_reviews',
        'display_name'                                              => 'Update Review',
        'route'                                                     => 'product_reviews',
        'module'                                                    => 'product_reviews',
        'as'                                                        => 'product_reviews.edit',
        'icon'                                                      => null,
        'parent'                                                    => $manageProductReviews->id,
        'parent_original'                                           => $manageProductReviews->id,
        'parent_show'                                               => $manageProductReviews->id,
        'sidebar_link'                                              => '1',
        'appear'                                                    => '0'
        ]);
        $deleteProductReviews = Permission::create([
        'name'                                                      => 'delete_product_reviews',
        'display_name'                                              => 'Delete Review',
        'route'                                                     => 'product_reviews',
        'module'                                                    => 'product_reviews',
        'as'                                                        => 'product_reviews.destroy',
        'icon'                                                      => null,
        'parent'                                                    => $manageProductReviews->id,
        'parent_original'                                           => $manageProductReviews->id,
        'parent_show'                                               => $manageProductReviews->id,
        'sidebar_link'                                              => '1',
        'appear'                                                    => '0'
        ]);



        //  CUSTOMERS
        $manageCustomers = Permission::create([
        'name'                                                      =>'manage_customers',
        'display_name'                                              =>'Customers',
        'route'                                                     =>'customers',
        'module'                                                    =>'customers',
        'as'                                                        =>'customers.index',
        'icon'                                                      =>'fas fa-user',
        'parent'                                                    =>'0',
        'parent_original'                                           =>'0',
        'sidebar_link'                                              =>'1',
        'appear'                                                    =>'1',
        'ordering'                                                  =>'21',
        ]);
        $manageCustomers->parent_show = $manageCustomers->id; $manageCustomers->save();
        $showCustomers = Permission::create([
        'name'                                                      =>'show_customers',
        'display_name'                                              =>'Customer',
        'route'                                                     =>'customers',
        'module'                                                    =>'customers',
        'as'                                                        =>'customers.index',
        'icon'                                                      =>'fas fa-user',
        'parent'                                                    =>$manageCustomers->id,
        'parent_original'                                           =>$manageCustomers->id,
        'parent_show'                                               =>$manageCustomers->id,
        'sidebar_link'                                              =>'1',
        'appear'                                                    =>'1'
        ]);
        $createCustomers = Permission::create([
        'name'                                                       =>'create_customers',
        'display_name'                                               =>'Create Customers', 
        'route'                                                      =>'customers', 
        'module'                                                     =>'customers', 
        'as'                                                         =>'customers.create', 
        'icon'                                                       =>null, 
        'parent'                                                     =>$manageCustomers->id, 
        'parent_original'                                            =>$manageCustomers->id, 
        'parent_show'                                                =>$manageCustomers->id, 
        'sidebar_link'                                               =>'1', 
        'appear'                                                     =>'0'
        ]);
        $displayCustomers = Permission::create([
        'name'                                                      => 'display_customers',
        'display_name'                                              => 'Show Customers',
        'route'                                                     => 'customers',
        'module'                                                    => 'customers',
        'as'                                                        => 'customers.show',
        'icon'                                                      => null,
        'parent'                                                    => $manageCustomers->id,
        'parent_original'                                           => $manageCustomers->id,
        'parent_show'                                               => $manageCustomers->id,
        'sidebar_link'                                              =>'1',
        'appear'                                                    =>'0'
        ]);
        
        $updateCustomers = Permission::create([
        'name'                                                      => 'update_customers',
        'display_name'                                              => 'Update Customers',
        'route'                                                     => 'customers',
        'module'                                                    => 'customers',
        'as'                                                        => 'customers.edit',
        'icon'                                                      => null,
        'parent'                                                    => $manageCustomers->id,
        'parent_original'                                           => $manageCustomers->id,
        'parent_show'                                               => $manageCustomers->id,
        'sidebar_link'                                              => '1',
        'appear'                                                    => '0'
        ]);
        $deleteCustomers = Permission::create([
        'name'                                                      => 'delete_customers',
        'display_name'                                              => 'Delete Customers',
        'route'                                                     => 'customers',
        'module'                                                    => 'customers',
        'as'                                                        => 'customers.destroy',
        'icon'                                                      => null,
        'parent'                                                    => $manageCustomers->id,
        'parent_original'                                           => $manageCustomers->id,
        'parent_show'                                               => $manageCustomers->id,
        'sidebar_link'                                              => '1',
        'appear'                                                    => '0'
        ]);






        //  STATES
        $manageStates = Permission::create([
        'name'                                                      =>'manage_states',
        'display_name'                                              =>'States',
        'route'                                                     =>'states',
        'module'                                                    =>'states',
        'as'                                                        =>'states.index',
        'icon'                                                      =>'fas fa-map-marker-alt',
        'parent'                                                    =>'0',
        'parent_original'                                           =>'0',
        'sidebar_link'                                              =>'1',
        'appear'                                                    =>'1',
        'ordering'                                                  =>'40',
        ]);
        $manageStates->parent_show = $manageStates->id; $manageStates->save();
        $showStates = Permission::create([
        'name'                                                      =>'show_states',
        'display_name'                                              =>'State',
        'route'                                                     =>'states',
        'module'                                                    =>'states',
        'as'                                                        =>'states.index',
        'icon'                                                      =>'fas fa-map-marker-alt',
        'parent'                                                    =>$manageStates->id,
        'parent_original'                                           =>$manageStates->id,
        'parent_show'                                               =>$manageStates->id,
        'sidebar_link'                                              =>'1',
        'appear'                                                    =>'1'
        ]);
        $createStates = Permission::create([
        'name'                                                       =>'create_states',
        'display_name'                                               =>'Create States', 
        'route'                                                      =>'states', 
        'module'                                                     =>'states', 
        'as'                                                         =>'states.create', 
        'icon'                                                       =>null, 
        'parent'                                                     =>$manageStates->id, 
        'parent_original'                                            =>$manageStates->id, 
        'parent_show'                                                =>$manageStates->id, 
        'sidebar_link'                                               =>'1', 
        'appear'                                                     =>'0'
        ]);
        $displayStates = Permission::create([
        'name'                                                      => 'display_states',
        'display_name'                                              => 'Show States',
        'route'                                                     => 'states',
        'module'                                                    => 'states',
        'as'                                                        => 'states.show',
        'icon'                                                      => null,
        'parent'                                                    => $manageStates->id,
        'parent_original'                                           => $manageStates->id,
        'parent_show'                                               => $manageStates->id,
        'sidebar_link'                                              =>'1',
        'appear'                                                    =>'0'
        ]);
        
        $updateStates = Permission::create([
        'name'                                                      => 'update_states',
        'display_name'                                              => 'Update States',
        'route'                                                     => 'states',
        'module'                                                    => 'states',
        'as'                                                        => 'states.edit',
        'icon'                                                      => null,
        'parent'                                                    => $manageStates->id,
        'parent_original'                                           => $manageStates->id,
        'parent_show'                                               => $manageStates->id,
        'sidebar_link'                                              => '1',
        'appear'                                                    => '0'
        ]);
        $deleteStates = Permission::create([
        'name'                                                      => 'delete_states',
        'display_name'                                              => 'Delete States',
        'route'                                                     => 'states',
        'module'                                                    => 'states',
        'as'                                                        => 'states.destroy',
        'icon'                                                      => null,
        'parent'                                                    => $manageStates->id,
        'parent_original'                                           => $manageStates->id,
        'parent_show'                                               => $manageStates->id,
        'sidebar_link'                                              => '1',
        'appear'                                                    => '0'
        ]);



        //  COUNTRIES
        $manageCountries = Permission::create([
        'name'                                                      =>'manage_countries',
        'display_name'                                              =>'Country',
        'route'                                                     =>'countries',
        'module'                                                    =>'countries',
        'as'                                                        =>'countries.index',
        'icon'                                                      =>'fas fa-globe',
        'parent'                                                    =>'0',
        'parent_original'                                           =>'0',
        'sidebar_link'                                              =>'1',
        'appear'                                                    =>'1',
        'ordering'                                                  =>'45',
        ]);
        $manageCountries->parent_show = $manageCountries->id; $manageCountries->save();
        $showCountries = Permission::create([
        'name'                                                      =>'show_countries',
        'display_name'                                              =>'Country',
        'route'                                                     =>'countries',
        'module'                                                    =>'countries',
        'as'                                                        =>'countries.index',
        'icon'                                                      =>'fas fa-globe',
        'parent'                                                    =>$manageCountries->id,
        'parent_original'                                           =>$manageCountries->id,
        'parent_show'                                               =>$manageCountries->id,
        'sidebar_link'                                              =>'1',
        'appear'                                                    =>'1'
        ]);
        $createCountries = Permission::create([
        'name'                                                       =>'create_countries',
        'display_name'                                               =>'Create Countries', 
        'route'                                                      =>'countries', 
        'module'                                                     =>'countries', 
        'as'                                                         =>'countries.create', 
        'icon'                                                       =>null, 
        'parent'                                                     =>$manageCountries->id, 
        'parent_original'                                            =>$manageCountries->id, 
        'parent_show'                                                =>$manageCountries->id, 
        'sidebar_link'                                               =>'1', 
        'appear'                                                     =>'0'
        ]);
        $displayCountries = Permission::create([
        'name'                                                      => 'display_countries',
        'display_name'                                              => 'Show Countries',
        'route'                                                     => 'countries',
        'module'                                                    => 'countries',
        'as'                                                        => 'countries.show',
        'icon'                                                      => null,
        'parent'                                                    => $manageCountries->id,
        'parent_original'                                           => $manageCountries->id,
        'parent_show'                                               => $manageCountries->id,
        'sidebar_link'                                              =>'1',
        'appear'                                                    =>'0'
        ]);
        
        $updateCountries = Permission::create([
        'name'                                                      => 'update_countries',
        'display_name'                                              => 'Update Countries',
        'route'                                                     => 'countries',
        'module'                                                    => 'countries',
        'as'                                                        => 'countries.edit',
        'icon'                                                      => null,
        'parent'                                                    => $manageCountries->id,
        'parent_original'                                           => $manageCountries->id,
        'parent_show'                                               => $manageCountries->id,
        'sidebar_link'                                              => '1',
        'appear'                                                    => '0'
        ]);
        $deleteCountries = Permission::create([
        'name'                                                      => 'delete_countries',
        'display_name'                                              => 'Delete Countries',
        'route'                                                     => 'countries',
        'module'                                                    => 'countries',
        'as'                                                        => 'countries.destroy',
        'icon'                                                      => null,
        'parent'                                                    => $manageCountries->id,
        'parent_original'                                           => $manageCountries->id,
        'parent_show'                                               => $manageCountries->id,
        'sidebar_link'                                              => '1',
        'appear'                                                    => '0'
        ]);



        //  CITIES
        $manageCities = Permission::create([
        'name'                                                      =>'manage_cities',
        'display_name'                                              =>'Cities',
        'route'                                                     =>'cities',
        'module'                                                    =>'cities',
        'as'                                                        =>'cities.index',
        'icon'                                                      =>'fas fa-university',
        'parent'                                                    =>'0',
        'parent_original'                                           =>'0',
        'sidebar_link'                                              =>'1',
        'appear'                                                    =>'1',
        'ordering'                                                  =>'50',
        ]);
        $manageCities->parent_show = $manageCities->id; $manageCities->save();
        $showCities = Permission::create([
        'name'                                                      =>'show_cities',
        'display_name'                                              =>'City',
        'route'                                                     =>'cities',
        'module'                                                    =>'cities',
        'as'                                                        =>'cities.index',
        'icon'                                                      =>'fas fa-university',
        'parent'                                                    =>$manageCities->id,
        'parent_original'                                           =>$manageCities->id,
        'parent_show'                                               =>$manageCities->id,
        'sidebar_link'                                              =>'1',
        'appear'                                                    =>'1'
        ]);
        $createCities = Permission::create([
        'name'                                                       =>'create_cities',
        'display_name'                                               =>'Create Cities', 
        'route'                                                      =>'cities', 
        'module'                                                     =>'cities', 
        'as'                                                         =>'cities.create', 
        'icon'                                                       =>null, 
        'parent'                                                     =>$manageCities->id, 
        'parent_original'                                            =>$manageCities->id, 
        'parent_show'                                                =>$manageCities->id, 
        'sidebar_link'                                               =>'1', 
        'appear'                                                     =>'0'
        ]);
        $displayCities = Permission::create([
        'name'                                                      => 'display_cities',
        'display_name'                                              => 'Show Cities',
        'route'                                                     => 'cities',
        'module'                                                    => 'cities',
        'as'                                                        => 'cities.show',
        'icon'                                                      => null,
        'parent'                                                    => $manageCities->id,
        'parent_original'                                           => $manageCities->id,
        'parent_show'                                               => $manageCities->id,
        'sidebar_link'                                              =>'1',
        'appear'                                                    =>'0'
        ]);
        
        $updateCities = Permission::create([
        'name'                                                      => 'update_cities',
        'display_name'                                              => 'Update Cities',
        'route'                                                     => 'cities',
        'module'                                                    => 'cities',
        'as'                                                        => 'cities.edit',
        'icon'                                                      => null,
        'parent'                                                    => $manageCities->id,
        'parent_original'                                           => $manageCities->id,
        'parent_show'                                               => $manageCities->id,
        'sidebar_link'                                              => '1',
        'appear'                                                    => '0'
        ]);
        $deleteCities = Permission::create([
        'name'                                                      => 'delete_cities',
        'display_name'                                              => 'Delete Cities',
        'route'                                                     => 'cities',
        'module'                                                    => 'cities',
        'as'                                                        => 'cities.destroy',
        'icon'                                                      => null,
        'parent'                                                    => $manageCities->id,
        'parent_original'                                           => $manageCities->id,
        'parent_show'                                               => $manageCities->id,
        'sidebar_link'                                              => '1',
        'appear'                                                    => '0'
        ]);



        //  Neighborhood
        $manageNeighborhoods = Permission::create([
        'name'                                                      =>'manage_neighborhoods',
        'display_name'                                              =>'Neighborhoods',
        'route'                                                     =>'neighborhoods',
        'module'                                                    =>'neighborhoods',
        'as'                                                        =>'neighborhoods.index',
        'icon'                                                      =>'far fa-city',
        'parent'                                                    =>'0',
        'parent_original'                                           =>'0',
        'sidebar_link'                                              =>'1',
        'appear'                                                    =>'1',
        'ordering'                                                  =>'50',
        ]);
        $manageNeighborhoods->parent_show = $manageNeighborhoods->id; $manageNeighborhoods->save();
        $showNeighborhoods = Permission::create([
        'name'                                                      =>'show_neighborhoods',
        'display_name'                                              =>'Neighborhood',
        'route'                                                     =>'neighborhoods',
        'module'                                                    =>'neighborhoods',
        'as'                                                        =>'neighborhoods.index',
        'icon'                                                      =>'far fa-city',
        'parent'                                                    =>$manageNeighborhoods->id,
        'parent_original'                                           =>$manageNeighborhoods->id,
        'parent_show'                                               =>$manageNeighborhoods->id,
        'sidebar_link'                                              =>'1',
        'appear'                                                    =>'1'
        ]);
        $createNeighborhoods = Permission::create([
        'name'                                                       =>'create_neighborhoods',
        'display_name'                                               =>'Create Neighborhoods', 
        'route'                                                      =>'neighborhoods', 
        'module'                                                     =>'neighborhoods', 
        'as'                                                         =>'neighborhoods.create', 
        'icon'                                                       =>null, 
        'parent'                                                     =>$manageNeighborhoods->id, 
        'parent_original'                                            =>$manageNeighborhoods->id, 
        'parent_show'                                                =>$manageNeighborhoods->id, 
        'sidebar_link'                                               =>'1', 
        'appear'                                                     =>'0'
        ]);
        $displayNeighborhoods = Permission::create([
        'name'                                                      => 'display_neighborhoods',
        'display_name'                                              => 'Show Neighborhoods',
        'route'                                                     => 'neighborhoods',
        'module'                                                    => 'neighborhoods',
        'as'                                                        => 'neighborhoods.show',
        'icon'                                                      => null,
        'parent'                                                    => $manageNeighborhoods->id,
        'parent_original'                                           => $manageNeighborhoods->id,
        'parent_show'                                               => $manageNeighborhoods->id,
        'sidebar_link'                                              =>'1',
        'appear'                                                    =>'0'
        ]);
        
        $updateNeighborhoods = Permission::create([
        'name'                                                      => 'update_neighborhoods',
        'display_name'                                              => 'Update Neighborhoods',
        'route'                                                     => 'neighborhoods',
        'module'                                                    => 'neighborhoods',
        'as'                                                        => 'neighborhoods.edit',
        'icon'                                                      => null,
        'parent'                                                    => $manageNeighborhoods->id,
        'parent_original'                                           => $manageNeighborhoods->id,
        'parent_show'                                               => $manageNeighborhoods->id,
        'sidebar_link'                                              => '1',
        'appear'                                                    => '0'
        ]);
        $deleteNeighborhoods = Permission::create([
        'name'                                                      => 'delete_neighborhoods',
        'display_name'                                              => 'Delete Neighborhoods',
        'route'                                                     => 'neighborhoods',
        'module'                                                    => 'neighborhoods',
        'as'                                                        => 'neighborhoods.destroy',
        'icon'                                                      => null,
        'parent'                                                    => $manageNeighborhoods->id,
        'parent_original'                                           => $manageNeighborhoods->id,
        'parent_show'                                               => $manageNeighborhoods->id,
        'sidebar_link'                                              => '1',
        'appear'                                                    => '0'
        ]);






         //  CUSTOMERSADDRES
         $manageCustomerAddresses = Permission::create([
            'name'                                                      =>'manage_customer_addresses',
            'display_name'                                              =>'Customer Addresses',
            'route'                                                     =>'customer_addresses',
            'module'                                                    =>'customer_addresses',
            'as'                                                        =>'customer_addresses.index',
            'icon'                                                      =>'fas fa-map-marked-alt',
            'parent'                                                    =>'0',
            'parent_original'                                           =>'0',
            'sidebar_link'                                              =>'1',
            'appear'                                                    =>'1',
            'ordering'                                                  =>'35',
            ]);
            $manageCustomerAddresses->parent_show = $manageCustomerAddresses->id; $manageCustomerAddresses->save();
            $showCustomers = Permission::create([
            'name'                                                      =>'show_customer_addresses',
            'display_name'                                              =>'Customer Addresses',
            'route'                                                     =>'customer_addresses',
            'module'                                                    =>'customer_addresses',
            'as'                                                        =>'customer_addresses.index',
            'icon'                                                      =>'fas fa-map-marked-alt',
            'parent'                                                    =>$manageCustomerAddresses->id,
            'parent_original'                                           =>$manageCustomerAddresses->id,
            'parent_show'                                               =>$manageCustomerAddresses->id,
            'sidebar_link'                                              =>'1',
            'appear'                                                    =>'1'
            ]);
            $createCustomerAddresses = Permission::create([
            'name'                                                       =>'create_customer_addresses',
            'display_name'                                               =>'Create Customer Addresses', 
            'route'                                                      =>'customer_addresses', 
            'module'                                                     =>'customer_addresses', 
            'as'                                                         =>'customer_addresses.create', 
            'icon'                                                       =>null, 
            'parent'                                                     =>$manageCustomerAddresses->id, 
            'parent_original'                                            =>$manageCustomerAddresses->id, 
            'parent_show'                                                =>$manageCustomerAddresses->id, 
            'sidebar_link'                                               =>'1', 
            'appear'                                                     =>'0'
            ]);
            $displayCustomers = Permission::create([
            'name'                                                      => 'display_customer_addresses',
            'display_name'                                              => 'Show Customer Addresses',
            'route'                                                     => 'customer_addresses',
            'module'                                                    => 'customer_addresses',
            'as'                                                        => 'customer_addresses.show',
            'icon'                                                      => null,
            'parent'                                                    => $manageCustomerAddresses->id,
            'parent_original'                                           => $manageCustomerAddresses->id,
            'parent_show'                                               => $manageCustomerAddresses->id,
            'sidebar_link'                                              =>'1',
            'appear'                                                    =>'0'
            ]);
            
            $updateCustomers = Permission::create([
            'name'                                                      => 'update_customer_addresses',
            'display_name'                                              => 'Update Customer Addresses',
            'route'                                                     => 'customer_addresses',
            'module'                                                    => 'customer_addresses',
            'as'                                                        => 'customer_addresses.edit',
            'icon'                                                      => null,
            'parent'                                                    => $manageCustomerAddresses->id,
            'parent_original'                                           => $manageCustomerAddresses->id,
            'parent_show'                                               => $manageCustomerAddresses->id,
            'sidebar_link'                                              => '1',
            'appear'                                                    => '0'
            ]);
            $deleteCustomers = Permission::create([
            'name'                                                      => 'delete_customer_addresses',
            'display_name'                                              => 'Delete Customer Addresses',
            'route'                                                     => 'customer_addresses',
            'module'                                                    => 'customer_addresses',
            'as'                                                        => 'customer_addresses.destroy',
            'icon'                                                      => null,
            'parent'                                                    => $manageCustomerAddresses->id,
            'parent_original'                                           => $manageCustomerAddresses->id,
            'parent_show'                                               => $manageCustomerAddresses->id,
            'sidebar_link'                                              => '1',
            'appear'                                                    => '0'
            ]);




        //  SUPERVISORS
        $manageSupervisors = Permission::create([
        'name'                                                      =>'manage_supervisors',
        'display_name'                                              =>'Supervisors',
        'route'                                                     =>'supervisors',
        'module'                                                    =>'supervisors',
        'as'                                                        =>'supervisors.index',
        'icon'                                                      =>'fas fa-user',
        'parent'                                                    =>'0',
        'parent_original'                                           =>'0',
        'sidebar_link'                                              =>'1',
        'appear'                                                    =>'1',
        'ordering'                                                  =>'100',
        ]);
        $manageSupervisors->parent_show = $manageSupervisors->id; $manageSupervisors->save();
        $showCustomers = Permission::create([
        'name'                                                      =>'show_supervisors',
        'display_name'                                              =>'Supervisors',
        'route'                                                     =>'supervisors',
        'module'                                                    =>'supervisors',
        'as'                                                        =>'supervisors.index',
        'icon'                                                      =>'fas fa-user',
        'parent'                                                    =>$manageSupervisors->id,
        'parent_original'                                           =>$manageSupervisors->id,
        'parent_show'                                               =>$manageSupervisors->id,
        'sidebar_link'                                              =>'0',
        'appear'                                                    =>'1'
        ]);
        $createCustomers = Permission::create([
        'name'                                                       =>'create_supervisors',
        'display_name'                                               =>'Create Supervisors', 
        'route'                                                      =>'supervisors', 
        'module'                                                     =>'supervisors', 
        'as'                                                         =>'supervisors.create', 
        'icon'                                                       =>null, 
        'parent'                                                     =>$manageSupervisors->id, 
        'parent_original'                                            =>$manageSupervisors->id, 
        'parent_show'                                                =>$manageSupervisors->id, 
        'sidebar_link'                                               =>'1', 
        'appear'                                                     =>'0'
        ]);
        $displayCustomers = Permission::create([
        'name'                                                      => 'display_supervisors',
        'display_name'                                              => 'Show Supervisors',
        'route'                                                     => 'supervisors',
        'module'                                                    => 'supervisors',
        'as'                                                        => 'supervisors.show',
        'icon'                                                      => null,
        'parent'                                                    => $manageSupervisors->id,
        'parent_original'                                           => $manageSupervisors->id,
        'parent_show'                                               => $manageSupervisors->id,
        'sidebar_link'                                              =>'1',
        'appear'                                                    =>'0'
        ]);
        
        $updateCustomers = Permission::create([
        'name'                                                      => 'update_supervisors',
        'display_name'                                              => 'Update Supervisors',
        'route'                                                     => 'supervisors',
        'module'                                                    => 'supervisors',
        'as'                                                        => 'supervisors.edit',
        'icon'                                                      => null,
        'parent'                                                    => $manageSupervisors->id,
        'parent_original'                                           => $manageSupervisors->id,
        'parent_show'                                               => $manageSupervisors->id,
        'sidebar_link'                                              => '1',
        'appear'                                                    => '0'
        ]);
        $deleteCustomers = Permission::create([
        'name'                                                      => 'delete_supervisors',
        'display_name'                                              => 'Delete Supervisors',
        'route'                                                     => 'supervisors',
        'module'                                                    => 'supervisors',
        'as'                                                        => 'supervisors.destroy',
        'icon'                                                      => null,
        'parent'                                                    => $manageSupervisors->id,
        'parent_original'                                           => $manageSupervisors->id,
        'parent_show'                                               => $manageSupervisors->id,
        'sidebar_link'                                              => '1',
        'appear'                                                    => '0'
        ]);



       // SHIPPING COMPANIES
       $manageShippingCompanies = Permission::create([
        'name'                                                      => 'manage_shipping_companies',
        'display_name'                                              => 'Shipping Companies',
        'route'                                                     => 'shipping_companies',
        'module'                                                    => 'shipping_companies',
        'as'                                                        => 'shipping_companies.index',
        'icon'                                                      => 'fas fa-truck',
        'parent'                                                    => '0',
        'parent_original'                                           => '0',
        'appear'                                                    => '1',
        'ordering'                                                  => '90',
        ]);
       $manageShippingCompanies->parent_show = $manageShippingCompanies->id; $manageShippingCompanies->save();
       $showShippingCompanies = Permission::create([
        'name'                                                      => 'show_shipping_companies',
        'display_name'                                              => 'Shipping Companies',
        'route'                                                     => 'shipping_companies',
        'module'                                                    => 'shipping_companies',
        'as'                                                        => 'shipping_companies.index',
        'icon'                                                      => 'fas fa-truck',
        'parent'                                                    => $manageShippingCompanies->id,
        'parent_show'                                               => $manageShippingCompanies->id,
        'parent_original'                                           => $manageShippingCompanies->id,
        'appear'                                                    => '1',
        'ordering'                                                  => '0',
        ]);
       $createShippingCompanies = Permission::create([
        'name'                                                      => 'create_shipping_companies',
        'display_name'                                              => 'Create Shipping Company',
        'route'                                                     => 'shipping_companies/create',
        'module'                                                    => 'shipping_companies',
        'as'                                                        => 'shipping_companies.create',
        'icon'                                                      => null,
        'parent'                                                    => $manageShippingCompanies->id,
        'parent_show'                                               => $manageShippingCompanies->id,
        'parent_original'                                           => $manageShippingCompanies->id,
        'appear'                                                    => '0',
        'ordering'                                                  => '0',
        ]);
       $displayShippingCompanies = Permission::create([
        'name'                                                      => 'display_shipping_companies',
        'display_name'                                              => 'Show Shipping Company',
        'route'                                                     => 'shipping_companies/{shipping_companies}',
        'module'                                                    => 'shipping_companies',
        'as'                                                        => 'shipping_companies.show',
        'icon'                                                      => null,
        'parent'                                                    => $manageShippingCompanies->id,
        'parent_show'                                               => $manageShippingCompanies->id,
        'parent_original'                                           => $manageShippingCompanies->id,
        'appear'                                                    => '0',
        'ordering'                                                  => '0',
        ]);
       $updateShippingCompanies = Permission::create([
        'name'                                                      => 'update_shipping_companies',
        'display_name'                                              => 'Update Shipping Company',
        'route'                                                     => 'shipping_companies/{shipping_companies}/edit',
        'module'                                                    => 'shipping_companies',
        'as'                                                        => 'shipping_companies.edit',
        'icon'                                                      => null,
        'parent'                                                    => $manageShippingCompanies->id,
        'parent_show'                                               => $manageShippingCompanies->id,
        'parent_original'                                           => $manageShippingCompanies->id,
        'appear'                                                    => '0',
        'ordering'                                                  => '0',
     ]);
       $destroyShippingCompanies = Permission::create([
        'name'                                                      => 'delete_shipping_companies',
        'display_name'                                              => 'Delete Shipping Company',
        'route'                                                     => 'shipping_companies/{shipping_companies}',
        'module'                                                    => 'shipping_companies',
        'as'                                                        => 'shipping_companies.delete',
        'icon'                                                      => null,
        'parent'                                                    => $manageShippingCompanies->id,
        'parent_show'                                               => $manageShippingCompanies->id,
        'parent_original'                                           => $manageShippingCompanies->id,
        'appear'                                                    => '0',
        'ordering'                                                  => '0',
     ]);

    


    }
}
