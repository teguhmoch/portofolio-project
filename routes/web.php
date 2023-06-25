    <?php

Route::redirect('/', '/login');

Auth::routes(['register' => false]);
Auth::routes(['password/reset' => false]);

// Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
//     // Change password
//     if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
//         Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
//         Route::post('password', 'ChangePasswordController@update')->name('password.update');
//         Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
//         Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
//     }
// });


//User Section

Route::group(['middleware' => ['auth.user','isUser']], function () {
    Route::get('/dashboard', 'HomeController@index')->name('home.index');

    //products
    Route::prefix('products')->group(function () { 

        //get
        Route::get('', 'ProductController@index')->name('product.index')->middleware('auth.admin');
        Route::get('edit/{id}', 'ProductController@edit')->name('product.edit')->middleware('auth.admin');
        Route::get('show/{id}', 'ProductController@show')->name('product.show')->middleware('auth.admin');
        Route::get('create', 'ProductController@create')->name('product.create')->middleware('auth.admin');

        //post
        Route::post('store', 'ProductController@store')->name('product.store');
        Route::post('update/{id}', 'ProductController@update')->name('product.update');
        Route::get('destroy/{id}', 'ProductController@destroy')->name('product.destroy')->middleware(['auth.master']);
     });

         //categories
    Route::prefix('categories')->group(function () { 

        //get
        Route::get('', 'ProductCategoryController@index')->name('category.index')->middleware('auth.admin');
        Route::get('edit/{id}', 'ProductCategoryController@edit')->name('category.edit')->middleware('auth.admin');
        Route::get('show/{id}', 'ProductCategoryController@show')->name('category.show')->middleware('auth.admin');
        Route::get('create', 'ProductCategoryController@create')->name('category.create')->middleware('auth.admin');

        //post
        Route::post('store', 'ProductCategoryController@store')->name('category.store');
        Route::post('update/{id}', 'ProductCategoryController@update')->name('category.update');
        Route::get('destroy/{id}', 'ProductCategoryController@destroy')->name('category.destroy')->middleware(['auth.master']);
     });

              //supplier
    Route::prefix('supplier')->group(function () { 

        //get
        Route::get('', 'SupplierController@index')->name('supplier.index')->middleware('auth.admin');
        Route::get('edit/{id}', 'SupplierController@edit')->name('supplier.edit')->middleware('auth.admin');
        Route::get('show/{id}', 'SupplierController@show')->name('supplier.show')->middleware('auth.admin');
        Route::get('create', 'SupplierController@create')->name('supplier.create')->middleware('auth.admin');

        //post
        Route::post('store', 'SupplierController@store')->name('supplier.store');
        Route::post('update/{id}', 'SupplierController@update')->name('supplier.update');
        Route::get('destroy/{id}', 'SupplierController@destroy')->name('supplier.destroy')->middleware(['auth.master']);
     });

                   //productIn
    Route::prefix('product-in')->group(function () { 

        //get
        Route::get('', 'ProductInController@index')->name('product-in.index')->middleware(['auth.admin-gudang']);
        // Route::get('edit/{id}', 'ProductInController@edit')->name('product-in.edit');
        Route::get('show/{id}', 'ProductInController@show')->name('product-in.show')->middleware(['auth.admin-gudang']);
        Route::get('create', 'ProductInController@create')->name('product-in.create')->middleware(['auth.admin-gudang']);

        //post
        Route::post('store', 'ProductInController@store')->name('product-in.store');
        // Route::post('update/{id}', 'ProductInController@update')->name('product-in.update');
        Route::get('destroy/{id}', 'ProductInController@destroy')->name('product-in.destroy')->middleware(['auth.master']);
     });

                        //productOut
    Route::prefix('product-out')->group(function () { 

        //get
        Route::get('', 'ProductOutController@index')->name('product-out.index')->middleware(['auth.admin-gudang']);
        // Route::get('edit/{id}', 'ProductInController@edit')->name('product-in.edit');
        Route::get('show/{id}', 'ProductOutController@show')->name('product-out.show')->middleware(['auth.admin-gudang']);
        Route::get('create', 'ProductOutController@create')->name('product-out.create')->middleware(['auth.admin-gudang']);

        //post
        Route::post('store', 'ProductOutController@store')->name('product-out.store');
        // Route::post('update/{id}', 'ProductInController@update')->name('product-in.update');
        Route::get('destroy/{id}', 'ProductOutController@destroy')->name('product-out.destroy')->middleware(['auth.master']);
     });

                    //user
    Route::prefix('user')->group(function () { 

        //get
        Route::get('', 'UserController@index')->name('user.index')->middleware('auth.admin');
        Route::get('edit/{id}', 'UserController@edit')->name('user.edit')->middleware('auth.admin');
        Route::get('show/{id}', 'UserController@show')->name('user.show')->middleware('auth.admin');
        Route::get('create', 'UserController@create')->name('user.create')->middleware('auth.admin');

        // //post
        Route::post('store', 'UserController@store')->name('user.store');
        Route::post('update/{id}', 'UserController@update')->name('user.update');
        Route::get('destroy/{id}', 'UserController@destroy')->name('user.destroy')->middleware(['auth.master']);
     });

 
});

//login
Route::get('/login' ,'User\Auth\LoginController@index')->name('user.login');
Route::POST('/login-post' ,'User\Auth\LoginController@login')->name('user.login-post');

Route::get('/logout' ,'User\Auth\LoginController@logout')->name('user.logout');
