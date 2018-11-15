<?php

namespace App\Repositories\Positions;

use App\Repositories\BaseRepository;

class PositionRepository extends BaseRepository
{
    /**
     * Position model.
     * @var Model
     */
    protected $model;

    /**
     * PositionRepository constructor.
     * @param Position $position
     */
    public function __construct(Position $position)
    {
        $this->model = $position;
    }

    /**
     * Lấy tất cả giá trị hợp lệ của trạng thái
     * @return string
     */
    public function getAllStatus()
    {
        return implode(',', Position::ALL_STATUS);
    }

    /**
     * Thay đổi trạng thái
     * @param  integer $id ID
     * @return [type]      [description]
     */
    public function changeStatus($id)
    {
        $position = parent::getById($id);
        if ($position->status == Position::ENABLE) {
            return parent::update($id, ['status' => Position::DISABLE]);
        } else {
            return parent::update($id, ['status' => Position::ENABLE]);
        }
    }
}
