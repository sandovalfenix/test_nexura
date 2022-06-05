<?php

namespace Entity;

use Entity\Connect;
use Config\Config;

class Areas extends Connect
{
	const TABLA = "Areas";

	public function __construct()
	{
		parent::__construct();
	}

	private function data_complemet($data, $type = "WHERE")
	{
		$complement = " " . $type . " ";
		$i = 0;
		foreach ($data as $name => $value) {
			$complement .=  (($i == 0) ? "" : ", ") . $name . " = :" . $name;
			$i++;
		}
		return $complement;
	}

	//metodos para CRUD database
	public function create($data)
	{
		$Query = $this->prepare("INSERT INTO " . self::TABLA . $this->data_complemet($data, "SET"));

		$Query->execute($data);

		return $this->lastInsertId();
	}

	public function read($col = '*', $data = array(), $row = false)
	{
		$query = "SELECT " . $col . " FROM " . self::TABLA . ((sizeof($data) > 0) ? $this->data_complemet($data) : "");

		$Query = $this->prepare($query);

		$Query->execute($data);

		return ($row) ? $Query->fetch($this::FETCH_ASSOC) : $Query->fetchAll($this::FETCH_ASSOC);;
	}

	public function update($data)
	{
		$Query = $this->prepare("UPDATE " . self::TABLA . $this->data_complemet($data, "SET") . " WHERE id = :id");

		return $Query->execute($data);
	}

	public function delete($id)
	{
		$Query = $this->prepare("DELETE FROM " . self::TABLA . " WHERE id = :id");

		$Query->bindParam(":id", $id);

		return $Query->execute();
	}
}
