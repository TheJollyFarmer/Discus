<?php

/**
 * Home
 */

use App\Trending;

View::composer('*', function ($view) {
    $trending = new Trending();

    $view->with('trending', $trending->get());
});

Auth::routes();

/**
 * Homepage
 */
Route::get('/', 'ThreadsController@index')->name('home');

/**
 * Search
 */
Route::get('threads/search', "SearchController@show");

/**
 * Threads
 */
Route::get('threads/{channel?}', 'ThreadsController@index')->name('threads.index');
Route::get('threads/create', 'ThreadsController@create')->middleware('verified')->name('threads.create');
Route::post('threads', 'ThreadsController@store')->middleware('verified')->name('threads.store');
Route::get('threads/{channel}/{thread?}', 'ThreadsController@show')->name('threads.show');
Route::patch('threads/{channel}/{thread}', 'ThreadsController@update')->name('threads.update');
Route::delete('threads/{channel}/{thread}', 'ThreadsController@destroy')->name('threads.destroy');

/**
 * Locked Threads
 */
Route::post('locked-threads/{thread}', 'LockedThreadsController@store')
     ->name('locked-threads.store')
     ->middleware('admin');
Route::delete('locked-threads/{thread}', 'LockedThreadsController@destroy')
     ->name('locked-threads.destroy')
     ->middleware('admin');

/**
 * Thread Subscriptions
 */
Route::post('threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')
     ->middleware('auth')
     ->name('thread-subscriptions.store');
Route::delete('threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')
     ->middleware('auth')
     ->name('thread-subscriptions.destroy');

/**
 * Replies
 */
Route::get('threads/{channel}/{thread}/replies', 'RepliesController@index')->name('replies.index');
Route::post('threads/{channel}/{thread}/replies', 'RepliesController@store')->name('replies.store');
Route::get('replies/{reply}', 'RepliesController@show')->name('replies.show');
Route::patch('replies/{reply}', 'RepliesController@update')->name('replies.update');
Route::delete('replies/{reply}', 'RepliesController@destroy')->name('replies.destroy');

/**
 * Best Replies
 */
Route::post('replies/{reply}/best', 'BestRepliesController@store')->name('best-comments.store');
Route::patch('replies/{reply}/best', 'BestRepliesController@update')->name('best-comments.update');

/**
 * Favourite Replies
 */
Route::post('replies/{reply}/favourites', 'FavouritesController@store')->name('favourites.store');
Route::delete('replies/{reply}/favourites', 'FavouritesController@destroy')->name('favourites.destroy');

/**
 * Profiles
 */
Route::get('profiles/{user}', 'ProfilesController@show')->name('profiles.show');
Route::get('profiles/{user}/activities', 'ProfilesController@index')->name('profiles.activities');
Route::get('settings')->name('settings');
Route::get('messages')->name('messages');

/**
 * Friendships
 */
Route::get('profiles/{user}/friendships', 'FriendshipsController@index')->name('friendships.index');
Route::get('users/{user}/friends/requests', 'FriendshipsController@index')->name('friends.requests.index');
Route::get('profiles/{user}/friendships/friend', 'FriendshipsController@show')->name('friendships.show');
Route::post('profiles/{user}/friendships', 'FriendshipsController@store')->name('friendships.store');
Route::patch('profiles/friendships/{friendship}', 'FriendshipsController@update')->name('friendships.update');
Route::delete('profiles/friendships/{friendship}', 'FriendshipsController@destroy')->name('friendships.destroy');

/**
 * Notifications
 */
Route::get('profiles/{user}/notifications', 'UserNotificationsController@index')->name('notifications.index');
Route::patch('profiles/{user}/notifications/{notification?}', 'UserNotificationsController@update')
     ->name('notifications.update');
Route::delete('profiles/{user}/notifications', 'UserNotificationsController@destroy')
     ->name('notifications.destroy');

/**
 * Converstions - chat windows.
 */
Route::resource('groups', 'GroupController');
Route::resource('conversations', 'ConversationController');

/**
 * Registration Verifications
 */
Route::get('register/verify', 'Auth\RegistrationVerificationController@index')->name('register.verify');

/**
 * Admin
 */
Route::group([
    'prefix' => 'admin',
    'middleware' => 'admin',
    'namespace' => 'Admin'
], function () {
    Route::get('', 'AdminController@index')->name('admin.index');

    /**
     * Channels
     */
    Route::get('channels', 'ChannelsController@index')->name('admin.channels.index');
    Route::patch('channels/{channel}', 'ThreadsController@update')->name('admin.channels.update');
    Route::post('channels', 'ChannelsController@store')->name('admin.channels.store');

    /**
     * Threads
     */
    Route::get('threads', 'ThreadsController@index')->name('admin.threads.index');
    Route::patch('threads/{thread}', 'ThreadsController@update')->name('admin.threads.update');
    Route::post('threads', 'ThreadsController@store')->name('admin.threads.store');
});

/**
 * API
 */
Route::get('api/users', 'Api\UsersController@index')->name('users.index');
Route::get('api/channels', 'Api\ChannelsController@index')->name('channels.index');
Route::post('api/users/{user}/avatar', 'Api\UserAvatarsController@store')->name('avatar');
