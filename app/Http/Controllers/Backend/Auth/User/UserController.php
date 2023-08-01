<?php

namespace App\Http\Controllers\Backend\Auth\User;

use App\Events\Backend\Auth\User\UserDeleted;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\User\ManageUserRequest;
use App\Http\Requests\Backend\Auth\User\StoreUserRequest;
use App\Http\Requests\Backend\Auth\User\UpdateUserRequest;
use App\Models\Auth\User as Users;
use App\Repositories\Backend\Auth\PermissionRepository;
use App\Repositories\Backend\Auth\RoleRepository;
use App\Repositories\Backend\Auth\UserRepository;
use Illuminate\Validation\Rule;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use LdapRecord\Models\OpenLDAP\User;
use Illuminate\Support\Collection;
use LdapRecord\Container;

/**
 * Class UserController.
 */
class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * UserController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param ManageUserRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ManageUserRequest $request)
    {
        return view('backend.auth.user.index')
            ->withUsers($this->userRepository->getActivePaginated(25, 'display_name', 'asc'));
    }

    public function search(ManageUserRequest $request)
    {
        $search = $request->input('search');
        $users = Users::query()
        ->where('username', 'LIKE', "%{$search}%")
        ->orWhere('display_name', 'LIKE', "%{$search}%")
        ->orWhere('email', 'LIKE', "%{$search}%")
        ->orWHere('created_at', 'LIKE', "%{$search}%")
        ->orderby('display_name')
        ->paginate(100);
        //->get();

        return view('backend.auth.user.index', compact('users'));
       // ->withUsers($this->userRepository->getActivePaginated(25, 'id', 'asc'));

    }

    /**
     * @param ManageUserRequest    $request
     * @param RoleRepository       $roleRepository
     * @param PermissionRepository $permissionRepository
     *
     * @return mixed
     */
    public function create(ManageUserRequest $request, RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        return view('backend.auth.user.create')
            ->withRoles($roleRepository->with('permissions')->get(['id', 'name']))
            ->withPermissions($permissionRepository->get(['id', 'name']));
    }

    /**
     * @param StoreUserRequest $request
     *
     * @throws \Throwable
     * @return mixed
     */
    public function store(StoreUserRequest $request)
    {
       	$uservalue;
        $usertype_value = $request->has('usertype');
        
        if($usertype_value == 1)
        $uservalue = "true";
        else
        $uservalue = "false";	

	$connection = Container::getConnection('default');
        $upd = true;
	$dn = 'inum='.($request->username).',ou=people,o=gluu';
        try {
            $user = Auth::user();
    	    $connection->connect();
     	    $query = $connection->query();
            $user = new User([
                'cn' => $request->display_name,
                'inum' => strval($request->username),
                'displayName' => strtoupper($request->display_name),
                'mail' => $request->email,
                'userPassword' => $request->password,
                'uid' => $request->username,
                'gluuStatus' => "active",
                'employeeType' => $uservalue
            ]);
                $user->setDn('inum='.strval($request->username).',ou=people,o=gluu');
                $user->save();
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
                $time = date('Y-m-d H:i:s');
                DB::table('users')->insert([
                'email' =>$request->email,
                'display_name' => strtoupper($request->display_name),
                'username' => $request->username,
                //'no_tel_jabatan' => $request->notel_jabatan,
                //'jabatan' => $request->jabatan,
                'password' => Hash::make($request->katalaluan),
                'confirmed' => true,
                'created_at' => $time,
                'updated_at' => $time,
                'user_type' => $uservalue,
                'uuid' => Uuid::uuid4()->toString()
                ]);
                $authUser2 = DB::table('users')->where('username', $request->username)->first();

				DB::table('model_has_roles')->insert([
				'role_id' => '2',
				'model_type' => 'App\Models\Auth\User',
				'model_id' => $authUser2->id
                ]);
        return redirect()->route('admin.auth.user.index')->withFlashSuccess(__('alerts.backend.users.created'));
    }

    /**
     * @param ManageUserRequest $request
     * @param User              $user
     *
     * @return mixed
     */
    public function show(ManageUserRequest $request, Users $user)
    {
        return view('backend.auth.user.show')
            ->withUser($user);
    }

    /**
     * @param ManageUserRequest    $request
     * @param RoleRepository       $roleRepository
     * @param PermissionRepository $permissionRepository
     * @param User                 $user
     *
     * @return mixed
     */
     public function edit(ManageUserRequest $request, RoleRepository $roleRepository, PermissionRepository $permissionRepository, Users $user)
    {
        return view('backend.auth.user.edit')
            ->withUser($user)
            ->withRoles($roleRepository->get())
            ->withUserRoles($user->roles->pluck('name')->all())
            ->withPermissions($permissionRepository->get(['id', 'name']))
            ->withUserPermissions($user->permissions->pluck('name')->all());
    }
    /**
     * @param UpdateUserRequest $request
     * @param User              $user
     *
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     * @return mixed
     */
    public function update(UpdateUserRequest $request, Users $user)
    {
        //$users = Auth::user();
        $inum = $user->username;
        //$connection = Container::getDefaultConnection();
        $connection = Container::getConnection('default');
        $query = $connection->query();
        $dn = 'inum='.$inum.',ou=people,o=gluu';

	$uservalue;
        $usertype_value = $request->has('usertype');
        
        if($usertype_value == 1)
        $uservalue = "true";
        else
        $uservalue = "false";
	

	        try {
            
	    $this->userRepository->update($user, $request->only('display_name','jabatan','email','roles','permissions','user_type'));
	     DB::table('users')->where('username', $user->username)->update(['display_name' => strtoupper($request->display_name), 'user_type' => $uservalue]);


            $query->updateAttributes($dn, ['displayName' => [$request->display_name], 'mail' => [$request->email], 'gluuStatus' => 'active', 'employeeType' => $uservalue]);

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

        return redirect()->route('admin.auth.user.index')->withFlashSuccess(__('alerts.backend.users.updated'));
    }
    /**
     * @param ManageUserRequest $request
     * @param User              $user
     *
     * @throws \Exception
     * @return mixed
     */
    public function destroy(ManageUserRequest $request, Users $user)
    {
        $this->userRepository->deleteById($user->id);
        event(new UserDeleted($user));
        
        //$users = Auth::user();
        $inum = $user->username;
        //$connection = Container::getDefaultConnection();
        $connection = Container::getConnection('default');
        $query = $connection->query();
        $dn = 'inum='.$inum.',ou=people,o=gluu';
        $query->delete($dn);

        return redirect()->route('admin.auth.user.index')->withFlashSuccess(__('alerts.backend.users.deleted'));
    }}
