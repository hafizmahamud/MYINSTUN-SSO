<?php

namespace App\Http\Controllers\Backend\Auth\User;

use App\Events\Backend\Auth\User\UserDeleted;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\User\ManageUserRequest;
use App\Http\Requests\Backend\Auth\User\StoreUserRequest;
use App\Http\Requests\Backend\Auth\User\UpdateUserRequest;
use App\Models\Auth\User;
use App\Repositories\Backend\Auth\PermissionRepository;
use App\Repositories\Backend\Auth\RoleRepository;
use App\Repositories\Backend\Auth\UserRepository;
use DB;
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
        return view('backend.auth.user.index')->withUsers($this->userRepository->getActivePaginated(100,'display_name', 'asc'));
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
        $this->userRepository->create($request->only(
            'first_name',
            'last_name',
            'display_name',
            'email',
            'password',
            'active',
            'confirmed',
            'confirmation_email',
            'roles',
            'permissions'
        ));

        return redirect()->route('admin.auth.user.index')->withFlashSuccess(__('alerts.backend.users.created'));
    }

    /**
     * @param ManageUserRequest $request
     * @param User              $user
     *
     * @return mixed
     */
    public function show(ManageUserRequest $request, User $user)
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
    public function edit(ManageUserRequest $request, RoleRepository $roleRepository, PermissionRepository $permissionRepository, User $user)
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
    public function update(UpdateUserRequest $request, User $user)
    {
        $inum = $user->username;
        $connection = Container::getDefaultConnection();
        $query = $connection->query();
        $dn = 'inum='.$inum.',ou=people,o=gluu';

        try {
            $this->userRepository->update($user, $request->only('display_name','email','roles','permissions'));
            $query->updateAttributes($dn, ['displayName' => [$request->display_name], 'mail' => [$request->email], 'gluuStatus' => 'active']);
            
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
