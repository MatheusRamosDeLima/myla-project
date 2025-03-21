<?php

class NormalizeString {
	public static function get(string $target): string {
		$normalized = Normalizer::normalize($target, Normalizer::NFD);
		$result = preg_replace('/[\x{0300}-\x{036F}]/u', '', $normalized);
		$result = preg_replace('/[ -]+/' , '-' , $result);
		$result = strtolower($result);
		return $result;
	}
}
