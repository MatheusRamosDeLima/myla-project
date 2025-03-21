<?php

require_once __DIR__.'/../Connection.php';

class ImageModel {
	private PDO $db_conn;
	private string $table;

	public function __construct() {
		$this->db_conn = Connection::getInstance('database');
		$this->table = 'images';
	}

	public function findAll() {
		$query = $this->db_conn->query("SELECT * from {$this->table}");
		return $query->fetchAll();
	}
	public function findByField(string $field, string $value) {
		$query = $this->db_conn->prepare("SELECT * from {$this->table} WHERE $field=?");
		$query->execute([$value]);
		return $query;
	}
	public function store(string $addr, string $product_id) {
		$query = $this->db_conn->prepare("INSERT INTO {$this->table} ('addr', 'product_id') VALUES (?, ?)");
		return $query->execute([$addr, $product_id]);
	}
	public function updateAll(string $addr, string $product_id) {
		$query = $this->db_conn->prepare("");
	}
	public function destroy(string $field, string $value) {
		$query = $this->db_conn->prepare("DELETE FROM {$this->table} WHERE $field=?");
		$query->execute([$value]);
	}
}
