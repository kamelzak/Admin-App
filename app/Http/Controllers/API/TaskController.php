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
        return Task::where('finished', false)->orderBy('end_date','ASC')->paginate(10);
    }

    public function endedTasks()
    {
        return Task::where('finished', true)->orderBy('end_date','DESC')->paginate(10);
    }

    public function endTask($task_id)
    {
        $task = Task::findOrFail($task_id);
        $task->finished = true;
        $task->save();
        return response('Task marked as ended', 200);
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

    public function assignTask($task_id, Request $request)
    {
        $task = Task::find($task_id);

        $data = $request->validate([
            'email' => ['required', 'string', 'max:255', 'exists:users,email']
        ]);

        $user = User::where('email', $data['email'])->firstOrFail();
        $task->users()->save($user);
        return response('Task assigned', 200);
    }

    public function abortTask($task_id, $user_id)
    {
        $task = Task::find($task_id);
        $user = User::find($user_id);
        $task->users()->detach($user);
        return response('Task aborted', 200);
    }

    public function showUsersAssigned($task_id) 
    {
        $task = Task::find($task_id);
        $users = $task->users;
        return $users;
    }

    public function showMyTasks() 
    {
        return auth('api')->user()->tasks->where('finished', false)->sortBy('end_date');
    }
}
