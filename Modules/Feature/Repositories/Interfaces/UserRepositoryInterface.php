<?php
namespace Modules\Feature\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function storeData($data);
    public function getAllData();

    public function getDataById($data);
    public function updateData($id, $data);
    public function deleteData($id);
}
