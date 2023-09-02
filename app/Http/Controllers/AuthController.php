<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $filename = null;
        $validator = $request->validate([
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
            "image_user" => 'required ',
            'First_name'=>'required|string',
            'Last_name'=>'required|string',
            'phone_number'=>'required|numeric',
            'adress'=>'required|string',
            'city'=>'required|string',
            'country'=>'required|string',
            'id_role'=>'required|numeric',
        ]);

        if ($request->hasFile('image_user')) {
            $image = $request->file('image_user');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('users')->put($filename, file_get_contents($image));
        }

        $user = User::create(array_merge([
            'name' => $validator['name'],
            'email' =>  $validator['email'],
            'password' =>  $validator['password'],
            "image_user" =>  $filename,
            'First_name'=> $validator['First_name'],
            'Last_name'=> $validator['Last_name'],
            'phone_number'=> $validator['phone_number'],
            'adress'=> $validator['adress'],
            'city'=> $validator['city'],
            'country'=> $validator['country'],
            'id_role'=> $validator['id_role'],
        ],
            ['password' => bcrypt($request->password)]
        ));
        return response()->json($user);
    }
  
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}