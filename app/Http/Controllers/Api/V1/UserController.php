<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Sport;
use App\Models\Activity;
use App\Models\Follower;
use App\Models\UserLocation;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;
use App\Models\ActivitySport;
use App\Models\FollowRequest;
use Illuminate\Validation\Rule;
use App\Models\ActivityLocation;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\SportResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\FollowerResource;
use App\Transformers\V1\UserTransformer;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Resources\FollowingResource;
use App\Transformers\V1\SportTransformer;
use Illuminate\Validation\Rules\Password;
use App\Http\Resources\UserSearchResource;
use App\Models\Notification;
use App\Transformers\V1\ActivityTransformer;
use App\Transformers\V1\ProfileTransformer;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Kreait\Firebase\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class UserController extends Controller
{
    protected $model;
    public function __construct(User $model)
    {
        $this->model = $model;
    }
    public function getProfile(Request $request, User $user = null)
    {
        if (is_null($user))
            $user = $request->user();
        return fractal($user, new UserTransformer())->respond();
    }

    // public function addLocation(Request $request): JsonResponse
    // {
    //     $input = $request->validate([
    //         'lat' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
    //         'lng' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
    //         'title' => ['required', 'string'],
    //         'address' => ['nullable', 'string']
    //     ]);
    //     $input['user_id'] = $request->user()->id;
    //     $address =  $request->has('address') ? $request['address'] : 'Singapore';
    //     $location = UserLocation::query()->updateOrCreate(
    //         [
    //             'user_id' => $input['user_id']
    //         ],
    //         [
    //             'lat' => $input['lat'],
    //             'lng' => $input['lng'],
    //             'title' => $input['title'],
    //             'address' => $address,

    //         ]
    //     );

    //     return response()->json([
    //         'message' => 'Updated successfully',
    //         'data' => [
    //             'location_id' => $location->id
    //         ]
    //     ]);
    // }

    public function updateProfile(Request $request): JsonResponse
    {
        $user = $request->user();
        $input = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'role' => ['required', 'string'],
            'phone' => ['sometimes', 'required'],
            'email' => ['sometimes', 'required'],
            'contact_name' => ['sometimes', 'required', 'string', 'max:255'],
            'organization_type' => ['sometimes', 'required', 'string', 'max:255'],
            'incorporation_date' => ['sometimes', 'required'],
            'alternate_phone' => ['sometimes', 'required'],
            'gst_number' => ['sometimes', 'required'],
            'sales_turnover' => ['sometimes', 'required'],
            'employees_count' => ['sometimes', 'required'],
            'referrer_id' => ['sometimes', 'required'],
        ]);
        // $rules = [
        //     'name' => ['required', 'string', 'max:255'],
        //     'role' => ['required', 'string'],
        //     'phone' => ['required'],
        //     'email' => ['required'],
        //     'contact_name' => ['required', 'string', 'max:255'],
        //     'organization_type' => ['required', 'string', 'max:255'],
        //     'incorporation_date' => ['required'],
        //     'alternate_phone' => ['required'],
        //     'gst_number' => ['required'],
        //     'sales_turnover' => ['required'],
        //     'employees_count' => ['required'],
        //     'referrer_id' => ['required'],

        //     // 'password' => ['required'],
        // ];
        if ($request->method() == 'PATCH') {
            $input = $request->validate([
                'name' => ['sometimes', 'required', 'string', 'max:255'],
                'role' => ['sometimes','required', 'string'],
                'phone' => ['sometimes', 'required'],
                'email' => ['sometimes', 'required'],
                'contact_name' => ['sometimes', 'required', 'string', 'max:255'],
                'organization_type' => ['sometimes', 'required', 'string', 'max:255'],
                'incorporation_date' => ['sometimes', 'required'],
                'alternate_phone' => ['sometimes', 'required'],
                'gst_number' => ['sometimes', 'required'],
                'sales_turnover' => ['sometimes', 'required'],
                'employees_count' => ['sometimes', 'required'],
                'referrer_id' => ['sometimes', 'required'],
            ]);
            // $rules = [
            //     'name' => ['sometimes', 'required', 'string', 'max:255'],
            //     'role' => ['sometimes','required', 'string'],
            //     'phone' => ['sometimes', 'required'],
            //     'email' => ['sometimes', 'required'],
            //     'contact_name' => ['sometimes', 'required', 'string', 'max:255'],
            //     'organization_type' => ['sometimes', 'required', 'string', 'max:255'],
            //     'incorporation_date' => ['sometimes', 'required'],
            //     'alternate_phone' => ['sometimes', 'required'],
            //     'gst_number' => ['sometimes', 'required'],
            //     'sales_turnover' => ['sometimes', 'required'],
            //     'employees_count' => ['sometimes', 'required'],
            //     'referrer_id' => ['sometimes', 'required'],

            // ];
        }

        // $this->validate($request, $rules);
        
        $user->update($input);
        
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
         
            // $updater->update($request->user(),$request->all());
            // $user->updateProfilePhoto($input['photo']); 
            // $file = $request->file('avatar');
            $user->clearMediaCollection('avatar');
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
            // $user->addMedia($file)->toMediaCollection('avatar');
        }
        return fractal($user->fresh(), new UserTransformer())->respond();
        // return response()->json(['message' => 'Updated successfully']);
    }
    public function newUpdateProfile(Request $request)
    {
        $user = $request->user();
        $rule = [
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string'],
            'phone' => ['required'],
            'email' => ['required'],
            'contact_name' => ['required', 'string', 'max:255'],
            'organization_type' => ['required', 'string', 'max:255'],
            'incorporation_date' => ['required'],
            'alternate_phone' => ['required'],
            'gst_number' => ['required'],
            'sales_turnover' => ['required'],
            'employees_count' => ['required'],
            'referrer_id' => ['required'],
            'password' => ['required'],

            // 'first_name' => ['sometimes','required', 'string', 'max:255'],
            // 'last_name' => ['sometimes','required', 'string', 'max:255'],
            // 'gender' => ['sometimes','required', Rule::in(['Male', 'Female'])],
            // 'date_of_birth' => ['sometimes','required', 'before_or_equal:' . now()->subYears(12)],
            // 'username' => ['sometimes','required', 'string', 'min:4', 'max:30', 'regex:/^([a-z0-9])+$/', Rule::unique('users', 'username')->ignore(auth()->id())],
            // 'bio' => ['sometimes','nullable', 'string'],
            // 'first_name' => ['sometimes', 'required', 'string', 'max:255'],
            // 'last_name' => ['sometimes', 'string', 'max:255'],
            // 'email' => ['sometimes', 'required', 'email:rfc,dns', 'unique:users,email,' . $user->id],
            // 'email_verified_at' => ['sometimes', 'required', 'date_format:Y-m-d H:i:s'],
            // 'phone' => ['sometimes', 'required', 'unique:users,phone,' . $user->id],
            // 'phone_verified_at' => ['sometimes', 'required', 'date_format:Y-m-d H:i:s'],
            // 'dob_updated_at' => ['sometimes', 'required', 'date_format:Y-m-d H:i:s'],
            // 'name_updated_at' => ['sometimes', 'required', 'date_format:Y-m-d H:i:s'],
            // 'username_updated_at' => ['sometimes', 'required', 'date_format:Y-m-d H:i:s'],
            // 'date_of_birth' => ['sometimes', 'required', 'before_or_equal:' . now()->subYears(12)],
            // 'username' => ['sometimes', 'required', 'string', 'min:4', 'max:30', 'regex:/^([a-z0-9])+$/', Rule::unique('users', 'username')->ignore(auth()->id())],

        ];


        $this->validate($request, $rule);
        // $request['email_verified_at']=Carbon::parse($request['email_verified_at']);
        // $request['phone_verified_at']=Carbon::parse($request['email_verified_at']);
        if ($request->has('date_of_birth'))
            $request['dob_updated_at'] = Carbon::now();
        if ($request->has('username'))
            $request['username_updated_at'] = Carbon::now();
        if ($request->has('first_name') || $request->has('last_name'))
            $request['name_updated_at'] = Carbon::now();
        $user->update($request->only([
            'email',
            'email_verified_at',
            'phone',
            'phone_verified_at',
            'dob_updated_at',
            'name_updated_at',
            'username_updated_at',
            'date_of_birth',
            'username',
            'first_name',
            'last_name'
        ]));
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            // $file = $request->file('avatar');
            $user->clearMediaCollection('avatar');
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
            // $user->addMedia($file)->toMediaCollection('avatar');
        }

        return response()->json(['message' => 'Patched successfully']);
    }
    public function updatePassword(Request $request): JsonResponse
    {
        $input = $request->validate([
            'current_password' => [
                'required', 'string', 'current_password:sanctum'
                //                function ($attribute, $value, $fail) use ($user) {
                //                    if (!Hash::check($value, $user->password)) {
                //                        $fail('Incorrect current password');
                //                    }
                //                },
            ],
            'new_password' => ['required', Password::defaults(), 'confirmed'],
        ]);
        // $input['password'] = Hash::make($input['password']);
        $request->user()->update([
            'password' => Hash::make($input['new_password'])
        ]);

        return response()->json(['message' => 'Updated successfully']);
    }


    // /**
    //  * @throws ValidationException
    //  */
    // public function linkFacebook(Request $request): JsonResponse
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
    //             'token' => ['This account is already linked']
    //         ]);
    //     }
    //     $user = $request->user();

    //     $user->update(['email' => $fb_user->email ?: $user->email, 'fb_id' => $fb_user->id]);

    //     return response()->json(['message' => 'Linked successfully']);
    // }

    // public function unlinkFacebook(Request $request): JsonResponse
    // {
    //     $request->user()->update(['fb_id' => null]);

    //     return response()->json(['message' => 'Updated successfully']);
    // }

    // /**
    //  * @throws ValidationException
    //  */
    // public function linkGoogle(Request $request): JsonResponse
    // {
    //     $input = $request->validate([
    //         'token' => ['required', 'string']
    //     ]);
    //     try {
    //         $fb_user = Socialite::driver('google')->userFromToken($input['token']);
    //     } catch (\Exception $e) {
    //         throw ValidationException::withMessages([
    //             'token' => ['Invalid token']
    //         ]);
    //     }

    //     $query = User::query()->where('google_id', $fb_user->id);
    //     if ($fb_user->email)
    //         $query->orWhere('email', $fb_user->email);
    //     $user = $query->first();
    //     if ($user) {
    //         throw ValidationException::withMessages([
    //             'token' => ['This account is already linked']
    //         ]);
    //     }
    //     $user = $request->user();

    //     $user->update(['email' => $fb_user->email ?: $user->email, 'google_id' => $fb_user->id]);

    //     return response()->json(['message' => 'Linked successfully']);
    // }

    // public function unlinkGoogle(Request $request): JsonResponse
    // {
    //     $request->user()->update(['google_id' => null]);

    //     return response()->json(['message' => 'Updated successfully']);
    // }

    // public function sendEmailVerificationNotification(Request $request): JsonResponse
    // {
    //     $request->user()->notify(new VerifyEmail);

    //     return response()->json(['message' => 'Sent successfully']);
    // }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }




    // public function getUserByLocation(Request $request)
    // {
    //     $user = $request->user();
    //     $bu = $user->blockUsers->pluck('id');
    //     $user_id = $user->id;
    //     $sportIDS = $user->sports->pluck('id');

    //     $rules = [
    //         'lat' => ['required', 'string'],
    //         'lng' => ['required', 'string'],
    //         'dis' => ['required', 'string']

    //     ];
    //     $this->validate($request, $rules);
    //     $lat = $request->lat;
    //     $lng = $request->lng;
    //     $distance = $request->dis;
    //     if (count($sportIDS) > 0) {
    //         $user_ids = UserLocation::select(DB::raw("distinct(user_locations.id),user_locations.user_id, ( 3959 * acos( cos( radians('$lat') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('$lng') ) + sin( radians('$lat') ) * sin( radians( lat ) ) ) ) AS distance"))
    //             ->join('users', 'users.id', 'user_locations.user_id')
    //             ->join('sport_user', 'sport_user.user_id', 'user_locations.user_id')
    //             ->whereIn('sport_user.sport_id', $sportIDS)
    //             ->havingRaw('distance < ' . $distance)
    //             ->whereNotIn('users.id', $bu)
    //             ->orderBy('distance')
    //             ->get()
    //             ->pluck('user_id');
    //     } else {
    //         $user_ids = UserLocation::select(DB::raw("distinct(user_locations.id),user_locations.user_id, ( 3959 * acos( cos( radians('$lat') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('$lng') ) + sin( radians('$lat') ) * sin( radians( lat ) ) ) ) AS distance"))
    //             ->join('users', 'users.id', 'user_locations.user_id')
    //             ->join('sport_user', 'sport_user.user_id', 'user_locations.user_id')
    //             // ->whereIn('sport_user.sport_id',$sportIDS)
    //             ->whereNotIn('users.id', $bu)
    //             ->havingRaw('distance < ' . $distance)
    //             ->orderBy('distance')
    //             ->get()
    //             ->pluck('user_id');
    //     }

    //     //    Activity::whereIn('id',$a)->get()
    //     // return $user_ids;
    //     $paginator = $this->model->whereIn('id', $user_ids)->where('id', '!=', $user_id)->paginate($request->get('limit', config('app.pagination_limit')));
    //     if ($request->has('limit')) {
    //         $paginator->appends('limit', $request->get('limit'));
    //     }
    //     return fractal($paginator, new UserTransformer())->respond();
    // }

}
