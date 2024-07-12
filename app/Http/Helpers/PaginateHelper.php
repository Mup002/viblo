<?php
namespace App\Http\Helpers;

use PhpParser\Node\Stmt\Static_;

class PaginateHelper
{
    public Static function paginate($data)
    {
        return $paginationInfo = [
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total()
        ];
    }
}