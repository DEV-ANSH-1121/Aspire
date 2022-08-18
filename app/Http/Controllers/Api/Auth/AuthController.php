<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\StoreAuthRequest;
use App\Http\Requests\Auth\LoginAuthRequest;

class AuthController extends Controller
{
    /**
     * AuthService constructor.
     *
     * @param    User  $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @param    array  $data
     *
     * @return  mixed
     * @throws  GeneralException
     */
    public function register(StoreAuthRequest $request)
    {
        \DB::beginTransaction();

        try {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);
            $auth = $this->createUser($data);
            $token = $auth->createToken('token')->plainTextToken;
            $user = $this->model::find($auth->uuid);
            //event(new UserCreated($user));

        } catch (\Throwable $th) {
            \DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

        \DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
            'user' => $user,
            '_token' => $token
        ], 200);
    }

    /**
     * @param    array  $data
     *
     * @return  mixed
     * @throws  GeneralException
     */
    public function login(LoginAuthRequest $request)
    {
        try {
            $data = $request->validated();
            
            $user = \Auth::attempt(['email' => $data['email'], 'password' => $data['password']]);

            if(!$user){
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 403);
            }
            
            $token = \Auth::user()->createToken('token')->plainTextToken;
            //event(new UserLoggedIn(\Auth::user()));
            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "test"//$th->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => true,
            'message' => 'User Logged-In Successfully',
            'user' => \Auth::user(),
            '_token' => $token
        ], 200);
    }

    /**
     * @param    array  $data
     *
     * @return  Auth
     */
    public function logout(array $data = [])
    {
        auth()->user()->tokens()->delete();

        return $this->successResponse([], "User Logged-out Successfully");
    }

    /**
     * @param    array  $data
     *
     * @return  Auth
     */
    protected function createUser(array $data = []): User
    {
        return $this->model::create($data);
    }
}
