<?php

namespace App\Http\Controllers\Frontend\Auth;

use LdapRecord\Connection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use LdapRecord\Models\OpenLDAP\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use LdapRecord\Container;

/**
 * Class ForgotPasswordController.
 */
class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {   
        return view('frontend.auth.passwords.email');

    }
}
