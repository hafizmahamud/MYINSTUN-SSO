<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\UnverifiedGenericProvider;
use App\Models\Auth\User;
use Ramsey\Uuid\Uuid;
//use Cookie;

session_start();
/*
 * Global Routes
 * Routes that are used between both frontend and backend.
 */

// Switch between the included languages
Route::get('lang/{lang}', [LanguageController::class, 'swap']);

/*
 * Frontend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    include_route_files(__DIR__.'/frontend/');
});
// Route::get('/announcements', 'App\Http\Controllers\Frontend\HomeController@index')->name('frontend.index');
// Route::get('/announcements', [HomeController::class, 'index'])->name('frontend.index');

Route::get('/announcements', 'Backend\Auth\Announcement\AnnouncementController@index')->name('admin.auth.announcements.index');
Route::get('/announcements/create', 'Backend\Auth\Announcement\AnnouncementController@storePage')->name('admin.auth.announcements.create');
Route::post('/announcements/store', 'Backend\Auth\Announcement\AnnouncementController@store')->name('admin.auth.announcement.store');
Route::get('/announcements/edit/{id}', 'Backend\Auth\Announcement\AnnouncementController@updatePage')->name('admin.auth.announcement.update');
Route::patch('/announcements/update/{id}', 'Backend\Auth\Announcement\AnnouncementController@update')->name('admin.auth.announcement.edit');
Route::delete('/announcements/delete/{id}', 'Backend\Auth\Announcement\AnnouncementController@destroy')->name('admin.auth.announcement.destroy');
Route::get('/search', 'Backend\Auth\User\UserController@search')->name('search');
/*
 * Backend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    /*
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     * These routes can not be hit if the password is expired
     */
    include_route_files(__DIR__.'/backend/');
});


Route::get('/auth/espek/callback', function (Request $r) {
    //Artisan::call('cache:clear');
    $provider = new UnverifiedGenericProvider([

	'clientId'                => 'f60a811c-c43c-4079-8ae8-06946692fca1',// The client ID assigned to you by the provider
        'clientSecret'            => '9lk4NJcXca3Q95rkblyiaA7y3pTA2d7sX0qyscAl',// The client password assigned to you by the provider         
	'redirectUri'             => 'https://myinstun.instun.gov.my/auth/espek/callback',
	'urlAuthorize'            => 'https://sso.instun.gov.my/oxauth/restv1/authorize',
        'urlAccessToken'          => 'https://sso.instun.gov.my/oxauth/restv1/token',
        'urlResourceOwnerDetails' => 'https://sso.instun.gov.my/oxauth/restv1/userinfo',
        'verify'                  => true,
    ]);

        if (!isset($_GET['code'])) {
           // $authorizationUrl = $provider->getAuthorizationUrl();
            $authorizationUrl = $provider->getAuthorizationUrl([
              'scope' => [ 'openid+profile+user_name+email+display_name+kakitangan'],
            ]);

	    $_SESSION['id'] = $provider->getState();
            //Session::put('id', $provider->getState());
            //$r->session()->put('key', 'value');
            header('Location: ' . $authorizationUrl);
            exit;
        } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['id'])) {
           unset($_SESSION['id']);
            //Session::forget('id');
            exit('Invalid state');
          } else {
            try {

                $accessToken = $provider->getAccessToken('authorization_code', [
                    'code' => $_GET['code']
                ]);
		
		
		$values = $accessToken->getValues();
		$id_token_hint = $values['id_token'];
		$cookie = Cookie::forever('id_token_hint', $id_token_hint);		


                $resourceOwner = $provider->getResourceOwner($accessToken);
		                
		$resourceOwner = json_encode($resourceOwner->toArray());
                $resourceOwner = json_decode($resourceOwner, true);
		//dd($resourceOwner);		//From $resourceOwner the Gluu User Info

                $username =  $resourceOwner["user_name"];
                $email = $resourceOwner["email"];//adt
                $name = $resourceOwner["name"];//adt
		$time = date('Y-m-d H:i:s');
		$kakitangan = $resourceOwner["type"];

                $request = $provider->getAuthenticatedRequest(
                    'GET','https://sso.instun.gov.my/oxauth/restv1/userinfo', $accessToken
                    // 'GET','http://192.168.0.108:3000/oauth/userinfo', $accessToken
                );

                $authUser = User::where('username', $username)->first();
			
			//If SSO User not available, create new data
			if ($authUser === null){			
				DB::table('users')->insert([
   				'email' =>$email['0'],
				'display_name' => $name,
			        'username' => $username,
				'confirmed' => true,
				'created_at' => $time,
				'updated_at' => $time,
				'user_type' => $kakitangan,
				'uuid' => Uuid::uuid4()->toString()
 				]);

				$authUser2 = User::where('username', $username)->first();
				Auth::loginUsingId($authUser2->id, true);


				DB::table('model_has_roles')->insert([
				'role_id' => '2',
				'model_type' => 'App\Models\Auth\User',
				'model_id' => $authUser2->id
 				]);
				
				return redirect()->intended('/dashboard');
				}

				$displayname = User::where('username', $username)->first();

				if ($displayname != $name){
					DB::table('users')->where('username', $username)->update([
						'display_name' => $name ]);
					}

		        if ($authUser){
				    Auth::loginUsingId($authUser->id, true);
				    return redirect()->intended('/dashboard')->withCookie($cookie);
		        } else {
			        return redirect()->intended('/');
		        }

		//$checkUser = User::where('username', '=', Input::get('username'))->first();
            } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
                exit($e->getMessage());
            }
        }
    }
);

Route::get('/auth/saml/cas', function (Request $r) {
        if (Auth::check()) {
            return redirect()->intended('https://muzium.instun.gov.my/admin');
        }else {
            return redirect()->intended('/');
        }
    }
);
