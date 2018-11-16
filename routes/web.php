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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/category', 'CategoryController')->name('index', 'category.index');
Route::resource('/wallet', 'WalletController')->name('index', 'wallet.index');
Route::resource('/', 'WalletController')->name('index', 'wallet.index');
Route::resource('/budget', 'BudgetController')->name('index', 'budget.index');
Route::get('/transaction/chart', 'TransactionController@categoriesForChart')->name('transaction.chart');

Route::resource('/transaction', 'TransactionController')->name('index', 'transaction.index');
Route::get('/transaction/budget/{budgetId}', 'TransactionController@transactionsByBudgetId')->name('transaction.budget')->where('budgetId', '[0-9]+');
Route::get('/transaction/category/{categoryId}', 'TransactionController@transactionsByCategoryId')->name('transaction.category')->where('categoryId', '[0-9]+');
Route::get('/transaction/tag/{categoryId}', 'TransactionController@transactionsByTag')->name('transaction.category')->where('tag', '[a-zA-Z0-9]+');
