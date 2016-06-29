<?php
/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

// admin authenticated
Route::filter('adminAuth', function() {
    // get access IP
    $clientIp = Request::getClientIp();
    Log:debug('IP client -> '.$clientIp);
//    $model = new DebugIpTbl();
//    $allowIps = $model->getDebugIps();
//    //10進数化して値比較
//    $intCheckAddr = sprintf('%u', ip2long($clientIp));
//    foreach ($allowIps as $val) {
//        $intStartAddr = sprintf('%u', ip2long($val->start_addr));
//        $intEndAddr = sprintf('%u', ip2long($val->end_addr));
//        if ( $intCheckAddr >= $intStartAddr && $intCheckAddr <= $intEndAddr ) {
//            if (!Session::has('userData')) {
//                // セッションが無い場合はログイン画面へ強制遷移
//                return Redirect::route('admin');
//            } else {
//                $ses = unserialize(Session::get('userData'));
//                // 権限が無ければログイン画面へ強制遷移
//                if ($ses->authority_id > 1) {
//                    return Redirect::route('admin');
//                }
//            }
//        }
//    }
});

Route::filter('adminAuth',function(){
    $now=\Carbon\Carbon::now();
    if(($now->hour > 13) && ($now->hour <14))
        return 'not allowed to see';
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
