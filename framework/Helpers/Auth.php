<?php

namespace Framework\Helpers;

use App\Models\UserModel;

class Auth {
    private static bool $error;

	public static function needLogin() {
        self::$error = false;

		$userModel = new UserModel;

        if (!Login::isLogged()) {
            self::$error = true;
            header('Location: /login');
        }
        else {
            $loggedUser = Login::get();
            $user = $userModel->selectByEmail($loggedUser['email']);

            if (!Login::compare($user, $loggedUser)) {
                self::$error = true;
                session_destroy();
                header('Location: /login');
            }
        }
	}

    public static function getError() {
        return self::$error;
    }
}