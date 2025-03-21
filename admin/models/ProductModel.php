<?php

require_once __DIR__.'/../Connection.php';

class ProductModel {
	private PDO $db_conn;
	private string $table;

	public function __construct() {
		$this->db_conn = Connection::getInstance('database');
		$this->table = 'products';
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
	public function store(string $title, string $sku, string $category, string $description) {
		$query = $this->db_conn->prepare("INSERT INTO {$this->table} ('title', 'sku', 'category', 'description') VALUES (?, ?, ?, ?)");
		return $query->execute([$title, $sku, $category, $description]);
	}
	public function updateAll(string $title, string $sku, string $category, string $description) {
		$query = $this->db_conn->prepare("");
	}
	public function destroy(string $field, string $value) {
		$query = $this->db_conn->prepare("DELETE FROM {$this->table} WHERE $field=?");
		$query->execute([$value]);
	}
}
