<?php

namespace App\Http\Controllers;

use App\Models\UserToDo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToDoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userTodo = UserToDo::where('user_id', auth()->user()->id)
            ->where('completed', '0')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->with(['userDroid', 'userDroid.mainframeDroid'])
            ->get();

        return response()->json($userTodo);
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
    public function store(Request $request)
    {
//        dd($request);

        $newTodoItem = new UserToDo;
        $newTodoItem->user_id = Auth::id();
        $newTodoItem->user_droid_id = $request->todoItem['user_droid_id'] ?: null;
        $newTodoItem->text = $request->todoItem['text'];
        $newTodoItem->save();

        return $newTodoItem;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $todItemId)
    {
        $existingTodoItem = UserToDo::find($todItemId);

        if ($existingTodoItem) {
            $existingTodoItem->completed = (bool)$request->item['completed'];
            $existingTodoItem->updated_at = Carbon::now();
            $existingTodoItem->save();

            return $existingTodoItem;
        }

        return "Item not found";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $todItemId)
    {
        $existingTodoItem = UserToDo::find($todItemId);
        if ($existingTodoItem) {
            $existingTodoItem->delete();
            return 'Item Deleted';
        }

        return "Item Not Found";
    }
}
