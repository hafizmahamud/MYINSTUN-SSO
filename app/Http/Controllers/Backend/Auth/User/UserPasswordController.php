<?php

namespace App\Http\Controllers\Backend\Auth\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\User\ManageUserRequest;
use App\Http\Requests\Backend\Auth\User\UpdateUserPasswordRequest;
use App\Models\Auth\User;
use App\Repositories\Backend\Auth\UserRepository;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use LdapRecord\Container;

/**
 * Class UserPasswordController.
 */
class UserPasswordController extends Controller
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
     * @param ManageUserRequest $request
     * @param User              $user
     *
     * @return mixed
     */
    public function edit(ManageUserRequest $request, User $user)
    {
       //$inum = $user->username;
       //dd($inum);
        return view('backend.auth.user.change-password')
            ->withUser($user);
    }

    /**
     * @param UpdateUserPasswordRequest $request
     * @param User                      $user
     *
     * @throws \App\Exceptions\GeneralException
     * @return mixed
     */
    public function update(UpdateUserPasswordRequest $request, User $user)
    {
        $inum = $user->username;
       // $connection = Container::getConnection('default');
	$connection = Container::getDefaultConnection();
        $query = $connection->query();
        $dn = 'inum='.$inum.',ou=people,o=gluu';

        try{
        //$this->userRepository->updatePassword($user, $request->only('password'));
        $password = $request->password;

        $query->updateAttributes($dn, ['userPassword' => [$password]]);
        $user->password = $password;
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

        return redirect()->route('admin.auth.user.index')->withFlashSuccess(__('alerts.backend.users.updated_password'));
    }
}
