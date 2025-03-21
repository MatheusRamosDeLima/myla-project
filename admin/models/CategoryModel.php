<?php

require_once __DIR__.'/../Connection.php';

class CategoryModel {
	private PDO $db_conn;
	private string $table;

	public function __construct() {
		$this->db_conn = Connection::getInstance('database');
		$this->table = 'categories';
	}

	public function findAll() {
		$query = $this->db_conn->query("SELECT * from {$this->table}");
		return $query->fetchAll();
	}

	public function findByField(string $field, string $value) {
		$query = $this->db_conn->prepare("SELECT * from {$this->table} WHERE $field=?");
		$query->execute([$value]);
		return $query->fetchObject();
	}

	public function store(string $name, string $addr) {
		$query = $this->db_conn->prepare("INSERT INTO {$this->table} ('name', 'addr') VALUES (?, ?)");
		return $query->execute([$name, $addr]);
	}
	
	public function destroy(string $field, string $value) {
		$query = $this->db_conn->prepare("DELETE FROM {$this->table} WHERE $field=?");
		$query->execute([$value]);
	}
}
