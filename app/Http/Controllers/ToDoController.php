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
        $validated = $request->validate([
            'todoItem.user_droid_id' => 'nullable|exists:user_droids, id',
            'todoItem.text' => 'required'
        ]);

        $newTodoItem = new UserToDo;
        $newTodoItem->user_id = Auth::id();
        $newTodoItem->user_droid_id = $validated['todoItem']['user_droid_id'] ?: null;
        $newTodoItem->text = $validated['todoItem']['text'];
        $newTodoItem->save();

        return response()->json($newTodoItem, 201);
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
            $existingTodoItem->update([
                'completed' => (bool)$request->completed,
                'updated_at' => Carbon::now(),
            ]);

            return response()->json($existingTodoItem, 201);
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

            return response()->json($existingTodoItem, 204);
        }

        return "Item Not Found";
    }
}
