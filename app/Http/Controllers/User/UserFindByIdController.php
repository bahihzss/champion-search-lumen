<?php

namespace App\Http\Controllers\User;

use App\Domain\User\UserRepository;
use App\Http\Controllers\Controller;

class UserFindByIdController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function handle(string $id)
    {
        $user = $this->userRepository->findById($id);

        if ($user === null) {
            return response()->json([
                'statusCode' => 404,
                'message' => 'Not Found',
            ], 404);
        }

        return response()->json([
            'statusCode' => 200,
            'item' => (array) $user,
        ]);
    }
}
