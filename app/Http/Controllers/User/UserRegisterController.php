<?php

namespace App\Http\Controllers\User;

use App\Domain\User\Entities\User;
use App\Domain\User\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserRegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function handle(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
        ]);

        $user = User::create(
            name: $request->get('name'),
            email: $request->get('email'),
        );

        $this->userRepository->save($user);

        return response()->json([
            'statusCode' => 201,
            'item' => (array) $user,
        ], 201);
    }
}
