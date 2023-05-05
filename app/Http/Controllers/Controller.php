<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function auth(Request $request)
    {
        $this->validate($request, [
            'email'       => ['required', 'email:rfc,dns'],
            'password'    => ['required', 'min:3', 'max:40'],
            'device_name' => ['required'],
        ]);

        $currentUser = User::query()
            ->where('email', '=', $request->email)
            ->first();

        if ($currentUser) {
            /** @var User $currentUser */

            $this->validate($request, [
                'password' => [function ($attribute, $value, $fail) use ($currentUser) {
                    if (!Hash::check($value, $currentUser->password)) {
                        $fail(__('content.errorPassword'));
                    }
                }]
            ]);

            return $currentUser->createToken($request->device_name)->plainTextToken;

        }
        else {
//            если электронная поча не найдена, можно создать нового пользователя..
//            $data['email'] = $request->email;
//            $data['password'] = $request->password;
//            $data['device_name'] = $request->device_name;
//            User::query()->create($data);
//            return $currentUser->createToken($request->device_name)->plainTextToken;


            throw ValidationException::withMessages([
                'email' => [__('content.errorEmailNotFound')],
            ]);
        }

    }
}
