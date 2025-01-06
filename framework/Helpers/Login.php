<?php

namespace Framework\Helpers;

class Login {
	public static function get() {
		return $_SESSION['login'];
	}
	public static function set($login) {
		$_SESSION['login'] = $login;
	}
	public static function isLogged() {
		return isset($_SESSION['login']) && !empty($_SESSION['login']);
	}
	public static function compare($user, $userDefault) {
		return $user && password_verify($userDefault['password'], $user->password);
	}
}