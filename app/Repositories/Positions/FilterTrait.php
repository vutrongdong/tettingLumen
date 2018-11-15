<?php

namespace App\Repositories\Positions;

trait FilterTrait
{
	/**
	 * Tìm kiếm theo tên
	 * @param  [type] $query [description]
	 * @param  string $q     name
	 * @return Collection Position Model
	 */
	public function scopeQ($query, $q)
	{
		if ($q) {
			return $query->where('name', 'like', "%${q}%");
		}
		return $query;
	}

	/**
	 * Tìm kiếm theo trạng thái
	 * @param  [type] $query  [description]
	 * @param  int    $status status
	 * @return Collection Contract Model
	 */
	public function scopeStatus($query, $status)
	{
		if (is_numeric($status)) {
			return $query->where('status', $status);
		}
		return $query;
	}

	/**
	 * Tìm kiếm theo ID
	 * @param  [type] $query [description]
	 * @param  int    $id    id
	 * @return Collection Position Model
	 */
	public function scopeID($query, $id)
	{
		if ($id) {
			return $query->where('id', $id);
		}
		return $query;
	}
}
