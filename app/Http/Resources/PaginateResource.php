<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateResource
{
    public mixed $data;
    public array $paginate;

    public function __construct(LengthAwarePaginator $data, string $className)
    {
        $this->data = $className::collection($data);
        $this->paginate = $this->makePaginate($data);
    }

    public function makePaginate(LengthAwarePaginator $data)
    {
        return [
            'total' => $data->total(),
            'perPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
            'lastPage' => $data->lastPage(),
            'nextPageUrl' => $data->nextPageUrl(),
            'prevPageUrl' => $data->previousPageUrl()
        ];
    }
}
