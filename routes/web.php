<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();
// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');

Route::group(['middleware' => 'auth'], function (){

    $this->resource('user','UsersController');
    $this->resource('category', 'CategoryController');
    $this->get('reports/category/list', 'CategoryController@listCategories')->name('reports.categories.list');

    $this->resource('client', 'ClientController');
    $this->resource('productandservice', 'ProductAndServiceController');
    $this->resource('budget', 'BudgetController');
    $this->resource('event_type', 'EventTypeController');

    $this->post('client/{client}/committeeMembers', 'CommitteeMemberController@store')->name('client.committeemembers.store');
    $this->put('client/{client}/committeeMembers/{committeeMember}', 'CommitteeMemberController@update')->name('client.committeemembers.update');



    $this->get('budget/in/categories', 'BudgetController@categories')->name('budget.in.categories');
    $this->post('budget/in/categories', 'BudgetController@categoriesStore')->name('budget.in.categories.store');
    $this->put('budget/in/categories/{eventtype}', 'BudgetController@categoriesUpdate')->name('budget.in.categories.update');
    $this->delete('budget/in/categories/{eventtype}', 'BudgetController@categoriesDelete')->name('budget.in.categories.delete');
    $this->get('budget/in/home', 'BudgetController@home')->name('budget.in.home');
    $this->get('budget/in/show/{budget}', 'BudgetController@show')->name('budget.in.show');
    $this->get('budget/in/prod/edit/{prod}', 'BudgetController@prodEdit')->name('budget.in.prod.edit');
    $this->put('budget/in/prod/update/{prod}', 'BudgetController@prodUpdate')->name('budget.in.prod.update');
    $this->get('budget/in/viewlink', 'BudgetController@viewLink')->name('budget.in.viewlink');

    $this->get('budget/duplicate/{budget}', 'BudgetController@duplicate')->name('budget.duplicate');
    $this->get('budget/custom/{budget}', 'BudgetController@custom')->name('budget.custom');
    $this->get('budget_for_client/{client}', 'BudgetController@create_for_client')->name('budget_for_client');

    $this->post('image-upload/{budget}', 'BudgetController@imageUploadPost')->name('image.upload.post');

    $this->get('/home', 'HomeController@index')->name('home');

    /*
     * API
     */
    $this->get('api/client/{client}', 'ClientController@apiGetClientMaxParcels')->name('api.client');
    $this->get('api/budget/products', 'BudgetController@apiProducts')->name('api.budget.products');
    $this->get('api/budget/products/add/{product}', 'BudgetController@apiAddProduct')->name('api.budget.products.add');
    $this->get('api/budget/products/refresh', 'BudgetController@refreshProds')->name('api.budget.refresh.prods');
    $this->get('api/budget/products/update/amount/{prod}', 'BudgetController@updateAmount')->name('api.budget.update.amount');
    $this->get('api/budget/products/delete/{prod}', 'BudgetController@deleteProd')->name('api.budget.prod.delete');

});


$this->get('budget/in/viewLinkExternal/{token_access}', 'BudgetController@viewLinkExternal')->name('budget.in.viewlinkExternal');