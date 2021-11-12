<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'type' => 'nullable',
            'bio' => ['nullable', 'string'],
            'photo' => ['nullable', 'file'],
            'password' => ['required', 'string', 'max:255', 'min:8', 'confirmed']
        ]);
        $data['password'] = Hash::make($data['password']);
        if(!$request['type'])
        {
            $data['type'] = 'user';
        }
        if(!$request['photo'])
        {
            $data['photo'] = 'profile.png';
        }
        $user = User::create($data);
        return response($user, 200);
    }

    public function update(Request $request, $id)
    {
        $user=User::find($id);
        if($request['password']){
            $data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'max:255'],
                'type' => 'nullable',
                'bio' => ['nullable', 'string'],
                'photo' => ['nullable', 'file'],
                'password' => ['required', 'string', 'max:255', 'min:8', 'confirmed']
            ]);
            $data['password'] = Hash::make($data['password']);
        }
        else
        {
            $data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'max:255'],
                'type' => 'nullable',
                'bio' => ['nullable', 'string'],
                'photo' => ['nullable', 'file']
            ]);
        }
        $user = User::where('id', $id)->update($data, $id);
        return response($user, 200);
    }

    public function destroy($id)
    {
        $user=User::find($id);
        $user->delete();
        return response('user deleted', 200);
    }
}
