<?php
Route::get('/', function() {
    return redirect(route('admin.index'));
});

Route::get('home', function() {
    return redirect(route('admin.index'));
});
Route::name('painel.')->prefix('painel')->middleware('auth')->group(function() {
    Route::resource('clientes', 'ClientesController', [
        'names' => [
            'index' => 'clientes',
            'show' => 'clientes.ver',
            'create' => 'clientes.novo'
        ]
    ]);

    Route::resource('processos', 'ProcessosController', [
        'names' => [
            'index' => 'processos',
            'show' => 'processos.ver',
            'create' => 'processos.novo'
        ]
    ]);

});
Route::name('admin.')->prefix('sistema')->middleware('auth')->group(function() {
    Route::get('dashboard', 'DashboardController')->name('index');
    Route::get('marcar_lido', function(){
        auth()->user()->unreadNotifications->markAsRead();
    })->name('marcar_lido');

    Route::get('users/roles', 'UserController@roles')->name('users.roles');
    Route::resource('users', 'UserController', [
        'names' => [
            'index' => 'users'
        ]
    ]);
});

\Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
    Log::info( json_encode($query->sql) );
    Log::info( json_encode($query->bindings) );
    Log::info( json_encode($query->time)   );
});

Route::middleware('auth')->get('logout', function() {
    Auth::logout();
    return redirect(route('login'))->withInfo('You have successfully logged out!');
})->name('logout');

Auth::routes(['verify' => true]);

Route::name('js.')->group(function() {
    Route::get('dynamic.js', 'JsController@dynamic')->name('dynamic');
});

// Get authenticated user
Route::get('users/auth', function() {
    return response()->json(['user' => Auth::check() ? Auth::user() : false]);
});
