<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Guardian;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        Log::info('login', [$request->all()]);
        $credentials = $request->only('email', 'password');

        if ($token = JWTAuth::attempt($credentials)) {
            return $this->respondWithToken($token);
        } else {
            Log::info('login_response', [$request->all()]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Login Failed',
        ], 200);
    }

    public function register(Request $request)
    {
        try {
            // Log::info('register_params', [$request->all()]);

            $validator = Validator::make($request->all(), [
                'guardian_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'student_id' => 'required',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }

            $student = Student::where('id_no', $request->get('student_id'))->first();

            if ($student) {
                $user = User::create([
                    'name' => $request->get('guardian_name'),
                    'email' => $request->get('email'),
                    'password' => Hash::make($request->get('password')),
                ]);

                $token = JWTAuth::fromUser($user);

                $guardian = Guardian::create([
                    'first_name' => $request->get('guardian_name'),
                    // 'last_name' => $request->get('guardian_name'),
                    'user_id' => $user->id,
                    'phone' => $request->get('phone'),
                ]);

                $guardian->students()->attach($student->id);

                return response()->json(['user' => $user, 'token' => $token, 'status' => true],200);
            } else {
                return response()->json(['status' => false, 'message' => 'Student not found'],200);
            }
        } catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => 'Something went wrong, please try again.'], 201);
        }
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(JWTAuth::user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'error' => false,
            'message' => 'Login Success',
            'access_token' => $token,
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}
