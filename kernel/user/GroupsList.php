<?php

class Kernel_User_GroupsList extends Object
{
	private $items = array();

	public function loadGroupsByUserId($id)
	{
		$query = "SELECT `id`, `pid`, `title`, `description` FROM
			`" . Kernel_Config_Config::DB_PREFIX . "user_groups` ug
			JOIN  `" . Kernel_Config_Config::DB_PREFIX . "groups` g ON g.`id` = ug.`group_id`
			WHERE ug.`user_id` = " . $id;
		$result = dibi::query($query)->fetchAssoc('id');
        
		$this->importRecord($result);

		return $this;
	}

	private function importRecord(array $result)
	{
		foreach($result as $key => $group){
			$this->items[$key] = new Kernel_User_Group;
			$this->items[$key]->importRecord($group);
		}

		return $this;
	}

	public function getItems()
	{
		return $this->items;
	}

}