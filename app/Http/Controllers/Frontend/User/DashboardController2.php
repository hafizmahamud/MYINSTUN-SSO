<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Announcements;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use App\Http\Requests\Backend\Auth\User\ManageUserRequest;
use LdapRecord\Models\OpenLDAP\User;
use LdapRecord\Container;
use Illuminate\Http\Request as RequestForm;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Hash;
use Auth;
use Cookie;
use App\Repositories\Backend\Auth\UserRepository;

use Illuminate\Support\Str;
use Request;


/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
        /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
      $token = '';
      $token = Cookie::get('id_token_hint');
      if (!Request::hasCookie('id_token_hint')) {
         //print_r('ooo\ndsdsadasd');
         return redirect()->away('http://sso.instun.gov.my');
       }
      $announcement_all = Announcements::all();
      $user = Auth::user();
      $nama = DB::table('users')->where('username', $user->username)->first();
      $role = DB::table('model_has_roles')->where('model_id', $user->id)->first();
      if($role == null)
      {
  			DB::table('model_has_roles')->insert([
				'role_id' => '2',
				'model_type' => 'App\Models\Auth\User',
				'model_id' => $user->id
 				]);
      }
      if(($nama->user_type))
      {
        return view ('frontend.user.dashboard',compact('announcement_all','nama','role'));
      } else {
        return view ('frontend.user.non-staff',compact('announcement_all','nama'));
      }
    }

    public function profile()
    {
      $token = '';
       $token = Cookie::get('id_token_hint');
       if (!Request::hasCookie('id_token_hint')) {
         //print_r('ooo\ndsdsadasd');
         return redirect()->away('http://sso.instun.gov.my');
       }
      $user = Auth::user();
      $nama = DB::table('users')->where('username', $user->username)->first();
      $role = DB::table('model_has_roles')->where('model_id', $user->id)->first();
      return view ('frontend.user.profile',compact('nama','role'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
      $user = Auth::user();
      $nama = DB::table('users')->where('username', $user->username)->first();
      $role = DB::table('model_has_roles')->where('model_id', $user->id)->first();
      $connection = Container::getConnection('default');
      $query = $connection->query();
      $dn = 'inum=' . strval($nama->username) . ',ou=people,o=gluu';
      $upd = true;
      try {
      $query->updateAttributes(
        $dn,
        ['displayName' =>[$request->full_name],
        'o' =>[$request->jabatan],
        'telephoneNumber' =>[$request->notel_jabatan],
        'mail' =>[$request->account_email]]
      );
      } catch (\LdapRecord\Exceptions\InsufficientAccessException $ex) {
        // The currently bound LDAP user does not
        // have permission to change passwords.
      } catch (\LdapRecord\Exceptions\ConstraintException $ex) {
          // The users new password does not abide
          // by the domains password policy.
      } catch (\LdapRecord\LdapRecordException $ex) {
          // Failed changing password. Get the last LDAP
          // error to determine the cause of failure.
          $upd = false;
          $error = $ex->getDetailedError();
          echo $error->getErrorCode();
          echo $error->getErrorMessage();
      }
      
      if($upd)
      {
        DB::table('users')->where('username', $user->username)->update(['display_name' => $request->full_name,
        'jabatan' => $request->jabatan,
        'no_tel_jabatan' => $request->notel_jabatan,
        'email' => $request->account_email]);
        return redirect()->route('frontend.user.profile')->withFlashSuccess(__('Profile is Updated'));
      } else {
        return redirect()->route('frontend.user.profile')->withFlashDanger(__($error->getErrorMessage()));
      }
    }
    public function viewRegister()
    {
      return view ('frontend.user.registerUser');
    }

    public function register(RequestForm $request)
    {
      $this->validate($request,[

        'full_name' => 'required',
        'jabatan' => 'required',
        'notel_jabatan' => 'required',
        'account_email' => 'required',
        'katalaluan' => 'required',
        'nokp' => 'required|unique:users,username',
      ],[
        'nokp.unique' => 'No. KP sudah ada!'
      ]);
      $connection = Container::getConnection('default');
      $upd = true;
	$dn = 'inum='.($request->nokp).',ou=people,o=gluu';
      try {
    	$connection->connect();
     	$query = $connection->query();
        $user = User::create([
	  'dn' => "inum=".strval($request->nokp).",ou=people,o=gluu",
          'inum' => strval($request->nokp),
          'displayName' => $request->full_name,
          'o' => $request->jabatan,
          'telephoneNumber' => $request->notel_jabatan,
          'mail' => $request->account_email,
          'userPassword' => $request->katalaluan,
          'uid' => $request->nokp,
          'gluuStatus' => "active",
          'employeeType' => "false"
       ]);
      } catch (\LdapRecord\Exceptions\InsufficientAccessException $ex) {
        // The currently bound LDAP user does not
        // have permission to change passwords.
      } catch (\LdapRecord\Exceptions\ConstraintException $ex) {
          // The users new password does not abide
          // by the domains password policy.
      } catch (\LdapRecord\LdapRecordException $ex) {
          // Failed changing password. Get the last LDAP
          // error to determine the cause of failure.
          $upd = false;
          $error = $ex->getDetailedError();
          echo $error->getErrorCode();
          echo $error->getErrorMessage();
      }
      if($upd)
      { 
        $time = date('Y-m-d H:i:s');
        DB::table('users')->insert([
          'email' =>$request->account_email,
          'display_name' => $request->full_name,
          'username' => $request->nokp,
          'no_tel_jabatan' => $request->notel_jabatan,
          'jabatan' => $request->jabatan,
          'password' => Hash::make($request->katalaluan),
          'confirmed' => true,
          'created_at' => $time,
          'updated_at' => $time,
          'user_type' => false,
          'uuid' => Uuid::uuid4()->toString()
        ]);
        $authUser2 = DB::table('users')->where('username', $request->nokp)->first();

				DB::table('model_has_roles')->insert([
				'role_id' => '2',
				'model_type' => 'App\Models\Auth\User',
				'model_id' => $authUser2->id
 				]);
        return redirect()->route('frontend.register')->withFlashSuccess(__('Registration Successful'));
      } else {
        return redirect()->route('frontend.register')->withFlashDanger(__($error->getErrorMessage()));
      }
            
    }


    public function profilepassword()
    {

        $user = Auth::user();
        $nama = DB::table('users')->where('username', $user->username)->first();
        $role = DB::table('model_has_roles')->where('model_id', $user->id)->first();

        return view ('frontend.user.profilepassword', compact('nama','role'));
    }


    public function update(RequestForm $request)
    {
        $user = Auth::user();

        $inum = $user->username;
        $connection = Container::getDefaultConnection();
        $query = $connection->query();
        $dn = 'inum='.($inum).',ou=people,o=gluu';

        // $request->validate([
        // 'password' => 'required|string|min:6|confirmed',
        // 'password_confirmation' => 'required',
        // ]);
  
        // if (!Hash::check($request->current_password, $user->password)) {
        //     return back()->with('error', 'Current password does not match!');
        // }

        try {
        $password = $request->password;
        $query->updateAttributes($dn, ['userPassword' => [$password]]);

        $user->password = $request->password;
        //DB::table('users')->where('username', $user->username)->update(['password' => $request->password]);
        $user->password_changed_at = now();
        $user->setRememberToken(Str::random(60));
        $user->save();

        

        } catch (\LdapRecord\Exceptions\InsufficientAccessException $ex) {
            $error = $ex->getDetailedError();
            echo $error->getErrorCode();
            echo $error->getErrorMessage();
            echo $error->getDiagnosticMessage();
        } catch (\LdapRecord\Exceptions\ConstraintException $ex) {
            $error = $ex->getDetailedError();
            echo $error->getErrorCode();
            echo $error->getErrorMessage();
            echo $error->getDiagnosticMessage();
        } catch (\LdapRecord\LdapRecordException $ex) {
            $error = $ex->getDetailedError();
            echo $error->getErrorCode();
            echo $error->getErrorMessage();
            echo $error->getDiagnosticMessage();
        }

        // return back()->with('success', 'Password successfully changed!');
        return redirect()->route('frontend.user.dashboard')->withFlashSuccess(__('alerts.backend.users.updated_password'));
    }
}
