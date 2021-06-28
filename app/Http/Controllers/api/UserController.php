<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index()
    {
        $data = User::orderBy('id','DESC')->get();
        return response()->json([
            'data' => $data,
        ]);
    }


    public function store()
    {
        $rules = [
            'name'=>'required|max:15|alpha|min:3',
            'lastname'=>'required|max:15|alpha|min:3',
            'nationality'=>'required|',
            'dni'=>'required|integer|unique:users,dni|',
        ];
        $validator = Validator::make(request()->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['code' => 406, 'msg' => $validator->errors()->first()]);
        }
        if (User::insert(request()->except('_token'))) {
            return response()->json([
                'code' =>200,
            ]);
        }
    }


    public function show($id)
    {
        return User::find($id);
    }


    public function update()
    {
        $rules = [
            'name'=>'required|alpha|max:15|min:3',
            'lastname'=>'required|alpha|max:15|min:3',
            'nationality'=>'required|',
            'dni'=>'required|integer',
        ];
        $validator = Validator::make(request()->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['code' => 406, 'msg' => $validator->errors()->first()]);
        }
        if (User::find(request()->id)->update(request()->all())) {
            return response()->json([
                'code' =>200,
                'data' => User::orderBy('id','DESC')->get()
            ]);
        }
    }


    public function destroy($id)
    {
        if (User::find($id)->delete()) {
            return response()->json([
                'code' =>200,
                'data' => User::orderBy('id','DESC')->get()
            ]);
        }
        
    }
    public function listar()
    {
        
    }
}
