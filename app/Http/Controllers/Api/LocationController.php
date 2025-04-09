<?php

namespace App\Http\Controllers\Api;

use App\Constants\MessagesResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Location\IndexLocationRequest;
use App\Http\Requests\Location\StoreLocationRequest;
use App\Http\Requests\Location\UpdateLocationRequest;
use App\Http\Resources\Location\LocationResource;
use App\Http\Resources\PaginateResource;
use App\Models\Location;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    public function index(IndexLocationRequest $request)
    {
        $location = Location::query()
            ->select([
                'id',
                'name',
                'state',
                'city',
                'slug'
            ])
            ->filters($request->validated())
            ->paginate();

        return $this->success(
            content: new PaginateResource($location, LocationResource::class)
        );
    }

    public function store(StoreLocationRequest $request)
    {
        $data = $request->validated();

        $location = Location::create([
            ...$data,
            'slug' => Str::slug($data['name'])
        ]);

        return $this->success(
            content: LocationResource::make($location),
            message: MessagesResponse::CREATED,
            status: Response::HTTP_CREATED
        );
    }

    public function show(string $id)
    {
        $location = Location::query()->select([
            'id',
            'name',
            'state',
            'city',
            'slug'
        ])->findOrFail($id);

        return $this->success(
            content: LocationResource::make($location),
        );
    }


    public function update(UpdateLocationRequest $request, string $id)
    {
        $location = Location::select('id')->findOrFail($id);

        $newData = $request->validated();

        if ($name = data_get($newData, 'name')) {
            $newData['slug'] = Str::slug($name);
        }

        $location->update($newData);

        return $this->success(
            content: LocationResource::make($location->refresh()),
            message: MessagesResponse::UPDATED
        );
    }


    public function destroy(string $id)
    {
        $deleted  = Location::query()->where('id', $id)->delete();

        if (!$deleted) {
            return $this->error(
                MessagesResponse::FAILED_DELETE,
                Response::HTTP_NOT_FOUND,
            );
        }

        return $this->success(
            message: MessagesResponse::DELETED
        );
    }
}
