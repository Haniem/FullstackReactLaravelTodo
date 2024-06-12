<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserData(Request $request) {
        $validator = Validator::make($request->all, [
            'id_user' => 'required|alpha'
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'Неправильно введены данные',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('id', $request->id_user)->first();

        if($user){
            return response()->json([
                'message' => 'Информация о пользователе успешно получена.',
                'user' => $user
            ], 200);
        } else {
            return response()->json([
                'message' => 'Пользователь не найден.',
            ], 422);
        }
    }

    public function updateUserData(Request $request) {
        $validator = Validator::make($request->all, [
            'name' => 'required|min:2|max:100',
            'username' => 'required|alpha:ascii|unique:users',
            'email' => 'required|unique:users|email',
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'Неправильно введены данные',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('id', $request->user()->id)->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email
        ]);

        return response()->json([
            'message' => 'Данные пользователя успешно обновлены',
            'user' => $user
        ], 200);
        
    }

    public function deleteUserData(Request $request) {
        $user = User::where('id', $request->user()->id)->delete();

        return response()->json([
            'message' => 'Пользователь успешно удален'
        ], 200);
    }

    public function updateUserPassword(Request $request){
         $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password'=>'required',
            'password_confirmation'=>'required|same:password'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Неправильно введены данные',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::find($request->user()->id);
        if (Hash::check($request->old_password, $user->password)) {
            if (!$request->old_password == $request->password){
                $user->update([
                    'password' => Hash::make($request->password)
                ]);
                return response()->json([
                    'message' => 'Пароль был успешно изменен',
                    'data' => $user
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Старый пароль совпадает с новым'
                ], 422);
            }
        } else {
            return response()->json([
                'message' => 'Неправильно введет старый пароль'
            ], 422);
        }
    }
}
