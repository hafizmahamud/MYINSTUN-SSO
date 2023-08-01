<?php

namespace App\Http\Controllers\Frontend\Auth;

use LdapRecord\Connection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use LdapRecord\Models\OpenLDAP\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use LdapRecord\Container;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;


/**
 * Class ForgotPasswordController.
 */
class ActivateUserController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function ActivateRequestForm()
    {   
        return view('frontend.auth.passwords.activateUsername');

    }
}
