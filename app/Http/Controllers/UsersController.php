<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\StoreUsersRequest;
use App\Http\Requests\Users\UpdateUsersRequest;
use App\Http\Resources\UsersCollection;
use App\Http\Resources\UsersResource;
use App\Models\Users2;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = Users2::paginate(10);
        return new UsersCollection($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUsersRequest $request)
    {
        $users = Users2::create($request->validated());
        return new UsersResource($users);
    }

    /**
     * Display the specified resource.
     */
    public function show(Users2 $users)
    {
        return new UsersResource($users);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Users2 $users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUsersRequest $request, Users2 $users)
    {
        $users->update($request->validated());
        return new UsersResource($users);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Users2 $users)
    {
        $users->delete();
        return response()->noContent();
    }
}
