<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pendingTodos = Todo::where('user_id', Auth::user()->id)->where('status', 'pending')->get();
        $doneTodos = Todo::where('user_id', Auth::user()->id)->where('status', 'done')->get();

        return view('dashboard', compact('pendingTodos', 'doneTodos'));
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
        $validate = Validator::make($request->all(), [
            'title' => 'required|max:100|string',
            'description' => 'required|max:250|string',
        ]);

        if ($validate->fails()) 
        {
            return redirect('dashboard')->withErrors($validate);
        }

        $todo = Todo::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'pending'
        ]);

        if (!$todo) 
        {
            return redirect('dashboard')->withErrors([
                "message" => "Error to save todo in DB."
            ]);
        }

        return redirect('dashboard')->with('success', "Todo saved successfully!");
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
    public function update(Request $request, string $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->status = "done";
        $todo->save();

        return redirect('dashboard')->with('success', "Todo updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
        
        return redirect('dashboard')->with('success', "Todo deleted successfully!");
    }
}
