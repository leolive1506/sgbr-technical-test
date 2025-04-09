<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Location\StoreLocationRequest;
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
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
