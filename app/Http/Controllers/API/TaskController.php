<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Task; 

class TaskController extends Controller
{
    public function index()
    {
        return Task::orderBy('end_date','ASC')->paginate(10);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date']
        ]);
        $task = Task::create($data);
        return response($task, 200);
    }

    public function update(Request $request, $id)
    {
        $task=TasK::findOrFail($id);
        
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date']
        ]);
        $task = Task::where('id', $id)->update($data, $id);
        return response($task, 200);
    }

    public function destroy($id)
    {
        //$this->authorize('isAdmin');
        $task=Task::find($id);
        $task->delete();
        return response('task deleted', 200);
    }
}
