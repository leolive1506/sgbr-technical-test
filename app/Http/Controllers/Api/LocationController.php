<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Location\StoreLocationRequest;
use App\Http\Requests\Location\UpdateLocationRequest;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    public function index()
    {
        //
    }

    public function store(StoreLocationRequest $request)
    {
        $data = $request->validated();

        $location = Location::create([
            ...$data,
            'slug' => Str::slug($data['name'])
        ]);

        return $this->success(
            content: $location,
            status: Response::HTTP_CREATED
        );
    }

    public function show(string $id)
    {

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
            content: $location->refresh()
        );
    }


    public function destroy(string $id)
    {
        //
    }
}
