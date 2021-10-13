<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Validator;
use Carbon\Carbon;

class AuthController extends Controller
{
    //this method adds new users
    public function createAccount(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'username' => $request->name,
            'password' => Hash::make($request->password),
            'email' => $request->email
        ]);

        return $this->success(['token' => $user->createToken('tokens')->plainTextToken,'user'=>$user]);
    }
    public function createAccountFromWP(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email
        ]);
    }

    public function updatePasswordFromWP(Request $request)
    {
        $header = $request->header('User-Agent');
        if(strpos($header, "WordPress") !== false && strpos($header, "MieleConnect") !== false)
        {
        }else{
            return response()->json("Richiesta non valida", 400);
        }
        $validator = Validator::make($request->all(),[
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'wp_token' => 'required|in:'.env("WP_TOKEN"),
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user = User::where('username',$request->username)->first();

        if($user==null)
        {
            return response()->json("Utente non trovato", 400);
        }
        $user->email_verified_at = Carbon::now();
        $user->password = Hash::make($request->password);

        $user->save();
    }

    //use this method to signin users
    public function signin(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 400);
        }

        if (!Auth::attempt($request->all())) {
            return $this->error('Credentials not match', 401);
        }
        $user = Auth::user();
        return $this->success([
            'token' => auth()->user()->createToken('tokens')->plainTextToken,
            'user' => $user,
        ]);
    }

    // this method signs out users by removing tokens
    public function signout(Request $requests)
    {
        Auth::user()->tokens()->delete();
        return [
            'message' => 'Tokens Revoked'
        ];
    }

    public function sendPasswordResetLinkEmail(Request $request) {
        $validator = Validator::make($request->all(),['email' => 'required|email']);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $status = Password::sendResetLink($request->only('email'));

        if($status === Password::RESET_LINK_SENT) {
            return $this->success(['message' => __($status)]);
        } else {
            return $this->error($status, 500);
        }
    }
    public function resetPassword(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
        if($status == Password::PASSWORD_RESET) {
            return $this->success(['message' => __($status)]);
        } else {
            return $this->error($status, 500);
        }
    }
}
