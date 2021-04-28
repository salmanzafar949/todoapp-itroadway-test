<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use Symfony\Component\HttpFoundation\Response;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): \Illuminate\Http\Response
    {
        $todos = Todo::whereUserId(auth()->id())
            ->paginate(10);

        return \response([
            'data' => $todos
        ],Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoRequest $request): \Illuminate\Http\Response
    {
        return  $request->store();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        return \response([
            'data' => $todo
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param $todo
     * @return \Illuminate\Http\Response
     */
    public function update(TodoRequest $request, $todo): \Illuminate\Http\Response
    {
        return $request->update($todo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo): \Illuminate\Http\Response
    {
        $todo->delete();

        return response([
            'data' => 'todo deleted'
        ], Response::HTTP_OK);
    }
}
