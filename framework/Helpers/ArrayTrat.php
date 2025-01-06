<?php

namespace Framework\Helpers;

class ArrayTrat {
	public static function turnOneArrayToArrays(array $array): array {
		$keys = [];
		$values = [];

		foreach ($array as $key => $value) {
			array_push($keys, $key);
			array_push($values, $value);
		}

		return ['keys' => $keys, 'values' => $values];
	}
}
