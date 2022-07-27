<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Models\NotificationSetting;
use App\Models\PhoneToken;
use App\Models\User;
use App\Rules\Notcontain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
// use \Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Propaganistas\LaravelPhone\PhoneNumber;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;


class AuthController extends Controller
{
    /**
     * @throws ValidationException|TwilioException
     */
    // public function sendPhoneOtp(Client $twilio, Request $request): \Illuminate\Http\JsonResponse
    // {
    //     $request->validate([
    //         'phone' => ['required', 'phone:AUTO,SG,MY,IN']
    //     ]);
    //     $phone = PhoneNumber::make($request->phone, ['AUTO','SG','MY','IN'])->formatE164();

    //     try {
    //         $verification = $twilio->verify->v2->services(getenv("TWILIO_VERIFY_SID"))
    //             ->verifications
    //             ->create($phone, "sms");
    //     } catch (TwilioException $e) {
    //         throw ValidationException::withMessages([
    //             'phone' => ['Failed to send']
    //         ]);
    //     }

    //     return response()->json([
    //         'message' => 'OK',
    //         'data' => [
    //             'phone' => $verification->to,
    //             'otp_token' => $verification->sid
    //         ]
    //     ]);
    // }

    /**
     * @throws ValidationException
     */
    // public function verifyPhoneOtp(Client $twilio, Request $request): \Illuminate\Http\JsonResponse
    // {
    //     $request->validate([
    //         'token' => ['required', 'string'],
    //         'code' => ['required']
    //     ]);
    //     try {
    //         $verification = $twilio->verify->v2
    //             ->services(getenv("TWILIO_VERIFY_SID"))
    //             ->verificationChecks
    //             ->create($request->code, ["verificationSid" => $request->token]);
    //     } catch (TwilioException $e) {
    //         throw ValidationException::withMessages([
    //             'code' => ['Invalid / expired code']
    //         ]);
    //     }
    //     if (!$verification->valid) {
    //         throw ValidationException::withMessages([
    //             'code' => ['Incorrect code']
    //         ]);
    //     }

    //     $phone_token = Str::random(40);
    //     $phone_token = PhoneToken::query()->create([
    //         'phone' => $verification->to,
    //         'token' => $phone_token
    //     ]);

    //     return response()->json([
    //         'message' => 'OK',
    //         'data' => [
    //             'phone' => $phone_token->phone,
    //             'phone_token' => $phone_token->token
    //         ]
    //     ]);
    // }

    // public function checkPhoneAvailability(Request $request): \Illuminate\Http\JsonResponse
    // {
    //     $request->validate([
    //         'phone' => ['required', 'phone:AUTO,SG,MY,IN', 'unique:users']
    //     ]);
    //     // $request->validate([
    //     //     'phone' => ['required', 'unique:users']
    //     // ]);

    //     return response()->json(['message' => 'OK']);
    // }

    // public function checkEmailAvailability(Request $request): \Illuminate\Http\JsonResponse
    // {
    //     $request->validate([
    //         'email' => ['required', 'email', 'unique:users']
    //     ]);

    //     return response()->json(['message' => 'OK']);
    // }

    // public function checkUsernameAvailability(Request $request): \Illuminate\Http\JsonResponse
    // {
    //     $request->validate([
    //         'username' => ['required', 'string', 'min:4', 'max:30', 'regex:/^([a-z0-9])+$/', 'unique:users', new Notcontain],

    //     ], ['regex' => 'The special characters not accepted']);

    //     return response()->json(['message' => 'OK']);
    // }

    // /**
    //  * @throws ValidationException
    //  */
    // public function checkFacebookAvailability(Request $request): \Illuminate\Http\JsonResponse
    // {
    //     $input = $request->validate([
    //         'token' => ['required', 'string']
    //     ]);
    //     try {
    //         $fb_user = Socialite::driver('facebook')->userFromToken($input['token']);
    //     } catch (\Exception $e) {
    //         throw ValidationException::withMessages([
    //             'token' => ['Invalid token']
    //         ]);
    //     }

    //     $query = User::query()->where('fb_id', $fb_user->id);
    //     if ($fb_user->email)
    //         $query->orWhere('email', $fb_user->email);
    //     $user = $query->first();
    //     if ($user) {
    //         throw ValidationException::withMessages([
    //             'token' => ['User already registered']
    //         ]);
    //     }

    //     return response()->json(['message' => 'OK']);
    // }

    // /**
    //  * @throws ValidationException
    //  */
    // public function checkGoogleAvailability(Request $request): \Illuminate\Http\JsonResponse
    // {
    //     $input = $request->validate([
    //         'token' => ['required', 'string']
    //     ]);
    //     try {
    //         $google_user = Socialite::driver('google')->userFromToken($input['token']);
    //     } catch (\Exception $e) {
    //         throw ValidationException::withMessages([
    //             'token' => ['Invalid token']
    //         ]);
    //     }

    //     $query = User::query()->where('google_id', $google_user->id);
    //     if ($google_user->email)
    //         $query->orWhere('email', $google_user->email);
    //     $user = $query->first();
    //     if ($user) {
    //         throw ValidationException::withMessages([
    //             'token' => ['User already registered']
    //         ]);
    //     }

    //     return response()->json(['message' => 'OK']);
    // }
    // public function checkAppleAvailability(Request $request): \Illuminate\Http\JsonResponse
    // {
    //     $input = $request->validate([
    //         'token' => ['required', 'string']
    //     ]);
    //     try {
    //         $apple_user = Socialite::driver('apple')->userFromToken($input['token']);
    //     } catch (\Exception $e) {
    //         throw ValidationException::withMessages([
    //             'token' => ['Invalid token']
    //         ]);
    //     }

    //     $query = User::query()->where('apple_id', $apple_user->id);
    //     if ($apple_user->email)
    //         $query->orWhere('email', $apple_user->email);
    //     $user = $query->first();
    //     if ($user) {
    //         throw ValidationException::withMessages([
    //             'token' => ['User already registered']
    //         ]);
    //     }

    //     return response()->json(['message' => 'OK']);
    // }

    /**
     * @throws ValidationException
     */
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        
        $input = $request->validate([
            'mode' => ['required', Rule::in(['phone', 'email_password', 'facebook', 'google','apple'])],
            'name'=>['required' ,'string', 'max:255'],
            'role'=>['required','string'],
            'phone'=>['required'],
            'email'=>['required'],
            'contact_name'=>['required','string', 'max:255'],
            'organization_type'=>['required','string', 'max:255'],
            'incorporation_date'=>['required'],
            'alternate_phone'=>['required'],
            'gst_number'=>['required'],
            'sales_turnover'=>['required'],
            'employees_count'=>['required'],
            'referrer_id'=>['required'],
            'password'=>['required'],

            // 'mode' => ['required', Rule::in(['phone', 'email_password', 'facebook', 'google','apple'])],
            // 'first_name' => ['required', 'string', 'max:255'],
            // 'last_name' => ['required', 'string', 'max:255'],
            // 'gender' => ['required', Rule::in(['Male', 'Female'])],
            // 'date_of_birth' => ['required', 'before_or_equal:' . now()->subYears(12)],
            // 'username' => ['required', 'string', 'min:4', 'max:30', 'regex:/^([a-z0-9])+$/', 'unique:users'],
            // 'email' => ['required_if:mode,email_password', 'email', 'unique:users'],
            // 'password' => ['required_if:mode,email_password', Password::defaults()],
            // 'phone' => ['required_if:mode,phone', 'phone:AUTO,SG,MY,IN', 'unique:users'],
            // 'phone_token' => [
            //     'required_if:mode,phone', 'string',
            //     function ($attribute, $value, $fail) use ($request) {
            //         $phone_token = PhoneToken::query()->firstWhere('token', $value);
            //         if (empty($phone_token) || $phone_token->phone !== $request->phone) {
            //             $fail('The ' . $attribute . ' is invalid.');
            //         }
            //     },
            // ],
            // 'fb_token' => ['required_if:mode,facebook', 'string'],
            // 'google_token' => ['required_if:mode,google', 'string'],
            // 'apple_token' => ['required_if:mode,apple', 'string'],
            'device_name' => ['required', 'string', 'max:255'],
        ]);
        if ($input['mode'] == 'email_password') {
            $input['password'] = Hash::make($input['password']);
        }

        // if (!empty($input['fb_token'])) {
        //     try {
        //         $fb_user = Socialite::driver('facebook')->userFromToken($input['fb_token']);
        //     } catch (\Exception $e) {
        //         throw ValidationException::withMessages([
        //             'fb_token' => ['Failed to fetch details']
        //         ]);
        //     }

        //     $query = User::query()->where('fb_id', $fb_user->id);
        //     if ($fb_user->email)
        //         $query->orWhere('email', $fb_user->email);
        //     $user = $query->first();
        //     if ($user) {
        //         throw ValidationException::withMessages([
        //             'fb_token' => ['Account already registered']
        //         ]);
        //     }
        //     $input['fb_id'] = $fb_user->id;
        // }
        // if (!empty($input['google_token'])) {
        //     try {
        //         $google_user = Socialite::driver('google')->userFromToken($input['google_token']);
        //     } catch (\Exception $e) {
        //         throw ValidationException::withMessages([
        //             'google_token' => ['Failed to fetch details']
        //         ]);
        //     }

        //     $query = User::query()->where('google_id', $google_user->id);
        //     if ($google_user->email)
        //         $query->orWhere('email', $google_user->email);
        //     $user = $query->first();
        //     if ($user) {
        //         throw ValidationException::withMessages([
        //             'google_token' => ['Account already registered']
        //         ]);
        //     }
        //     $input['google_id'] = $google_user->id;
        // }
        // if (!empty($input['apple_token'])) {
        //     try {
        //         $apple_user = Socialite::driver('apple')->userFromToken($input['apple_token']);
        //     } catch (\Exception $e) {
        //         throw ValidationException::withMessages([
        //             'apple_token' => ['Failed to fetch details']
        //         ]);
        //     }
        //     // $query = User::query();
        //     $query = User::query()->where('apple_id', $apple_user->id);
        //     if ($apple_user->email)
        //         $query->orWhere('email', $apple_user->email);
        //     $user = $query->first();
        //     if ($user) {
        //         throw ValidationException::withMessages([
        //             'apple_token' => ['Account already registered']
        //         ]);
        //     }
        //     $input['apple_id'] = $apple_user->id;
        //     $input['email'] = $apple_user->email;
            

        // }
        $user = User::query()->create($input);
        // $userNS = User::with('notificationSetting')->find($user->id);
        // if($userNS){
        //     if ($userNS->notificationSetting->user_id === null) {
        //         $ns = new NotificationSetting(['following' => 1]);
        //         $user->notificationSetting()->save($ns);
        //     } 
        // }
        
        // if (!empty($input['phone_token'])) {
        //     $user->phone_verified_at = now();
        //     $user->save();
        //     PhoneToken::query()->where('token', $input['phone_token'])->delete();
        // }
      
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $user->clearMediaCollection('avatar');
            

            $user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
            // $user->addMedia($file)->toMediaCollection('avatar');
        }
        return response()->json([
            'message' => 'OK',
            'data' => [
                'auth_token' => $user->createToken($input['device_name'])->plainTextToken
            ]
        ]);
    }
    public function emailRegister(Request $request, CreateNewUser $creator)
    {
        // Validator::make($input, [
        //     // 'name' => ['required', 'string', 'max:255'],


        //     'first_name' => ['required', 'string', 'max:255'],
        //     'last_name' => ['required', 'string', 'max:255'],
        //     'gender' => ['required', Rule::in(['Male', 'Female'])],
        //     'date_of_birth' => ['required', 'before_or_equal:'.now()->subYears(12)],
        //     'username' => ['required', 'string', 'min:4', 'max:30', 'regex:/^([a-z0-9])+$/', 'unique:users'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'password' => $this->passwordRules(),

        //     'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        // ])->validate();
        // RegisterUserRequest

        $input = $request->validate([
            'mode' => ['required', Rule::in(['email_password'])],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', Rule::in(['Male', 'Female'])],
            'date_of_birth' => ['required', 'before_or_equal:' . now()->subYears(12)],
            'username' => ['required', 'string', 'min:4', 'max:30', 'regex:/^([a-z0-9])+$/', 'unique:users'],
            'email' => ['required_if:mode,email_password', 'email', 'unique:users'],
            'password' => ['required_if:mode,email_password', Password::defaults()],
            'device_name' => ['required', 'string', 'max:255'],
        ]);
        $input['password_confirmation'] = $input['password'];
        // $user = User::query()->create($input);
        $user = $creator->create($input);
        $user->sendEmailVerificationNotification();
        // return response()->json([
        //     'message' => 'OK',
        //     'data' => [
        //         'auth_token' => $user
        //     ]
        // ]);

    }
    /**
     * @throws ValidationException
     */
    public function login(Request $request, $mode = 'email-password'): \Illuminate\Http\JsonResponse
    {
        if ($mode == 'email-password') {
            $input = $request->validate([
                'email' => ['required', 'email', 'exists:users'],
                'password' => ['required', 'string'],
                'device_name' => ['required', 'string', 'max:255'],
            ]);
            $user = User::query()
                ->where('email', $input['email'])
                ->where('active', true)
                ->first();
            if (empty($user)) {
                throw ValidationException::withMessages([
                    'email' => ['Account not registered / banned']
                ]);
            }
            // if (!(Hash::check($input['password'], $user->password))) {
            //     throw ValidationException::withMessages([
            //         'password' => ['Incorrect password']
            //     ]);
            // }
        } elseif ($mode == 'phone') {
            $input = $request->validate([
                'phone' => ['required', 'phone:AUTO,SG,MY,IN', 'exists:users'],
                'phone_token' => [
                    'required', 'string',
                    function ($attribute, $value, $fail) use ($request) {
                        $phone_token = PhoneToken::query()->firstWhere('token', $value);
                        if (empty($phone_token) || $phone_token->phone !== $request->phone) {
                            $fail('The ' . $attribute . ' is invalid.');
                        }
                    },
                ],
                'device_name' => ['required', 'string', 'max:255'],
            ]);
            $user = User::query()
                ->where('phone', $input['phone'])
                ->where('active', true)
                ->first();
            if (empty($user)) {
                throw ValidationException::withMessages([
                    'phone' => ['Account not registered / banned']
                ]);
            }
            PhoneToken::query()->where('token', $input['phone_token'])->delete();
        } elseif ($mode == 'facebook') { 

            $input = $request->validate([
                'fb_token' => ['required', 'string'],
                'device_name' => ['required', 'string', 'max:255'],
            ]);
            try {
                $fb_user = Socialite::driver('facebook')->userFromToken($input['fb_token']);
            } catch (\Exception $e) {
                throw ValidationException::withMessages([
                    'fb_token' => ['Failed to fetch details']
                ]);
            }

            $query = User::query()->where('fb_id', $fb_user->id)
                ->where('active', true);
            if ($fb_user->email)
                $query->orWhere('email', $fb_user->email);
            $user = $query->first();

            if (empty($user)) {
                throw ValidationException::withMessages([
                    'fb_token' => ['Account not registered / banned']
                ]);
            }
            $user->update(['email' => $fb_user->email ?: $user->email, 'fb_id' => $fb_user->id]);
        } elseif ($mode == 'google') {
            $input = $request->validate([
                'google_token' => ['required', 'string'],
                'device_name' => ['required', 'string', 'max:255'],
            ]);
            try {
                $google_user = Socialite::driver('google')->userFromToken($input['google_token']);
            } catch (\Exception $e) {
                throw ValidationException::withMessages([
                    'google_token' => ['Failed to fetch details']
                ]);
            }

            $query = User::query()->where('google_id', $google_user->id)
                ->where('active', true);
            if ($google_user->email)
                $query->orWhere('email', $google_user->email);
            $user = $query->first();

            if (empty($user)) {
                throw ValidationException::withMessages([
                    'google_token' => ['Account not registered / banned']
                ]);
            }
            $user->update(['email' => $google_user->email ?: $user->email, 'google_id' => $google_user->id]);
        } 
        elseif ($mode == 'apple') {
            $input = $request->validate([
                'apple_token' => ['required', 'string'],
                'device_name' => ['required', 'string', 'max:255'],
            ]);
            try {
                $apple_user = Socialite::driver('apple')->userFromToken($input['apple_token']);
            } catch (\Exception $e) {
                throw ValidationException::withMessages([
                    'apple_token' => ['Failed to fetch details']
                ]);
            }

            $query = User::query()->where('apple_id', $apple_user->id)
                ->where('active', true);
            if ($apple_user->email)
                $query->orWhere('email', $apple_user->email);
            $user = $query->first();

            if (empty($user)) {
                throw ValidationException::withMessages([
                    'google_token' => ['Account not registered / banned']
                ]);
            }
            $user->update(['email' => $apple_user->email ?: $user->email, 'apple_id' => $apple_user->id]);
        }else {
            return response()->json(['message' => 'Not found'], 404);
        }

        $user->tokens()->delete();
        // $userNS = User::with('notificationSetting')->find($user->id);
        // if($userNS!==null){
        //     if ($userNS->notificationSetting->user_id === null) {
        //         $ns = new NotificationSetting(['following' => 1]);
        //         $user->notificationSetting()->save($ns);
        //     } 
        // }
        

        return response()->json([
            'message' => 'OK',
            'data' => [
                'auth_token' => $user->createToken($input['device_name'])->plainTextToken
            ]
        ]);
    }
}
