<?php

namespace App\Controllers;

use App\Models\User;
use \Core\View as View;
use \Core\Controller as Controller;

class Signup extends Controller
{
    /**
     * Show the signup page
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('Signup/new.html');
    }

    /**
     * Sign up a new user
     * @return void
     */
    public function createAction()
    {
        $user = new User($_POST);
    }
}