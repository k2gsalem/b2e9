<?php

use App\Utils\Easebuzz\Easebuzz;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Laravel\Jetstream\Jetstream;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/tmp', function () {
    return new \App\Mail\NewsLetter('Helloo', 'http://via.placeholder.com/300');
});
Route::prefix('/artisan')->group(function () {
    Route::get('/storage/link', function () {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
    });
    Route::get('/optimize/clear', function () {
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    });
    Route::get('/migrate', function () {
        \Illuminate\Support\Facades\Artisan::call('migrate');
    });
    Route::get('/db/seed', function () {
        \Illuminate\Support\Facades\Artisan::call('db:seed');
    });
});

Route::prefix('/admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/forgot-password', \App\Http\Livewire\Admin\Auth\ForgotPassword::class)
        ->name('forgot-password')->withoutMiddleware(['auth:admin']);
    Route::get('/login', \App\Http\Livewire\Admin\Auth\Login::class)
        ->name('login')->withoutMiddleware(['auth:admin']);
    Route::get('/logout', function () {
        auth('admin')->logout();
        return redirect()->route('admin.login');
    })->name('logout')->withoutMiddleware(['auth:admin']);;

    Route::get('/', \App\Http\Livewire\Admin\Dashboard::class)->name('dashboard');
    Route::prefix('/admins')->name('admins.')->group(function () {
        Route::get('/', \App\Http\Livewire\Admin\Admins\Index::class)->name('index');
    });
    Route::prefix('/users')->name('users.')->group(function () {
        Route::get('/', \App\Http\Livewire\Admin\Users\Index::class)->name('index');
    });
    Route::prefix('/projects')->name('projects.')->group(function () {
        Route::get('/', \App\Http\Livewire\Admin\Projects\Index::class)->name('index');
    });
    Route::prefix('/materials')->name('materials.')->group(function () {
        Route::get('/', \App\Http\Livewire\Admin\Materials\Index::class)->name('index');
    });
    Route::prefix('/processes')->name('processes.')->group(function () {
        Route::get('/', \App\Http\Livewire\Admin\Processes\Index::class)->name('index');
    });
    Route::prefix('/posts')->name('posts.')->group(function () {
        Route::get('/', \App\Http\Livewire\Admin\Posts\Index::class)->name('index');
    });
    Route::prefix('/plans')->name('plans.')->group(function () {
        Route::get('/', \App\Http\Livewire\Admin\Plans\Index::class)->name('index');
    });
    Route::prefix('/packages')->name('packages.')->group(function () {
        Route::get('/', \App\Http\Livewire\Admin\Packages\Index::class)->name('index');
    });
    Route::prefix('/locations')->name('locations.')->group(function () {
        Route::get('/', \App\Http\Livewire\Admin\Pincode\Index::class)->name('index');
    });
    Route::prefix('/website-settings')->name('website_settings.')->group(function () {
        Route::get('/', \App\Http\Livewire\Admin\WebsiteSettings\Index::class)->name('index');
    });
    Route::get('/newsletter', \App\Http\Livewire\Admin\Newsletter::class)->name('newsletter');
    Route::prefix('/reports')->name('reports.')->group(function () {
        Route::get('/project-transactions', \App\Http\Livewire\Admin\Reports\ProjectTransactions::class)
            ->name('project-transactions');
        Route::get('/subscriptions', \App\Http\Livewire\Admin\Reports\Subscriptions::class)
            ->name('subscriptions');
    });
    Route::prefix('/support')->name('support.')->group(function () {
        Route::get('/', \App\Http\Livewire\Admin\Support\Index::class)->name('index');
    });

    Route::prefix('/notification')->group(function () {
        Route::get('/user-account-created/{user}', function (\App\Models\User $user) {
            return (new \App\Notifications\UserAccountCreated())
                ->toMail($user);
        });
        Route::get('/user-account-updated/{user}', function (\App\Models\User $user) {
            return (new \App\Notifications\UserAccountUpdated())
                ->toMail($user);
        });
    });
});

/*Route::get('/', function () {
    return redirect()->route('dashboard');
//    return view('welcome');
})->name('home');*/

Route::get('/', \App\Http\Livewire\Home::class)->name('home');
Route::get('/blog', \App\Http\Livewire\Posts::class)->name('blog');
Route::get('/blog/{post}', \App\Http\Livewire\Post::class)->name('post');
Route::view('/faq', 'faq')->name('faq');
Route::get('nda', function () {
    $termsFile = Jetstream::localizedMarkdownPath('nda.md');

    return view('nda', [
        'nda' => Str::markdown(file_get_contents($termsFile)),
    ]);
})->name('nda');

Route::get('/forgot-password', \App\Http\Livewire\Auth\ForgotPassword::class)
    ->name('forgot-password');

Route::middleware(['auth:sanctum', 'verified', 'verified.phone'])->group(function () {
    Route::get('/verify/phone', \App\Http\Livewire\Auth\PhoneVerification::class)
        ->withoutMiddleware('verified.phone')
        ->name('phone-verification');

    Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
        switch ($request->user()->role) {
            case 'customer':
                return redirect()->route('customer.dashboard');
            case 'supplier':
                return redirect()->route('supplier.dashboard');
            case 'both':
                return view('dashboard');
            default:
                \Illuminate\Support\Facades\Auth::guard('web')->logout();
                return redirect()->route('login');
        }
    })->name('dashboard');

    Route::get('/invite', \App\Http\Livewire\Invite::class)->name('invite');

    Route::prefix('/customer')->name('customer.')->middleware(['customer'])->group(function () {
        Route::get('/dashboard', \App\Http\Livewire\Customer\Dashboard::class)->name('dashboard');

        Route::prefix('/projects')->name('projects.')->group(function () {
            Route::get('/create', \App\Http\Livewire\Customer\Projects\Create::class)->name('create');
            Route::get('/{project}/details', \App\Http\Livewire\Customer\Projects\Details::class)->name('details');
            Route::get('/{project}/invoice', \App\Http\Livewire\Customer\Projects\Invoice::class)->name('invoice');
            Route::get('/pay/{project_transaction}', function (\Illuminate\Http\Request $request, \App\Models\ProjectTransaction $project_transaction) {
                if (is_null($project_transaction->paid_at)) {
                    $postData = array (
                        "txnid" => $project_transaction->uuid,
                        "amount" => (float) number_format((float) $project_transaction->final_amount, 2, ".", ""),
                        "firstname" => $request->user()->contact_name,
                        "email" => $request->user()->email,
                        "phone" => $request->user()->phone,
                        "productinfo" => $project_transaction->project->title,
                        "surl" => route('easebuzz.webhook.pt', ['project_transaction' => $project_transaction->id]),
                        "furl" => route('easebuzz.webhook.pt', ['project_transaction' => $project_transaction->id]),
                        "udf1" => "aaaa",
                        "udf2" => "aaaa",
                        "udf3" => "aaaa",
                        "udf4" => "aaaa",
                        "udf5" => "aaaa",
                        "udf6" => "aaaa",
                        "udf7" => "aaaa",
                        "address1" => 'Address 1',
                        "address2" => 'Address 2',
                        "city" => "aaaa",
                        "state" => "aaaa",
                        "country" => "India",
                        "zipcode" => '123456',
                    );
                    $easebuzzObj = new Easebuzz(config('easebuzz.key'), config('easebuzz.salt'), config('easebuzz.env'));
                    $easebuzzObj->initiatePaymentAPI($postData);
                }
                else
                    die("Link expired");
            })->name('pay');
        });
    });

    Route::prefix('/supplier')->name('supplier.')->middleware(['supplier'])->group(function () {
        Route::get('/dashboard', \App\Http\Livewire\Supplier\Dashboard::class)->name('dashboard');

        Route::prefix('/projects')->name('projects.')->group(function () {
            Route::get('/{project}/details', \App\Http\Livewire\Supplier\Projects\Details::class)->name('details');
        });

        Route::prefix('/plans')->name('plans.')->group(function () {
            Route::get('/', \App\Http\Livewire\Supplier\Plans\Index::class)->name('index');
            Route::get('/{subscription}/invoice', \App\Http\Livewire\Supplier\Plans\Invoice::class)->name('invoice');
            Route::get('/buy/{plan_transaction}', function (\Illuminate\Http\Request $request, \App\Models\PlanTransaction $plan_transaction) {
                if (is_null($plan_transaction->paid_at)) {
                    $postData = array (
                        "txnid" => $plan_transaction->uuid,
                        "amount" => (float) number_format((float) $plan_transaction->final_amount, 2, ".", ""),
                        "firstname" => $request->user()->contact_name,
                        "email" => $request->user()->email,
                        "phone" => $request->user()->phone,
                        "productinfo" => $plan_transaction->plan->title,
                        "surl" => route('easebuzz.webhook.plan.activate', ['plan_transaction' => $plan_transaction->id]),
                        "furl" => route('easebuzz.webhook.plan.activate', ['plan_transaction' => $plan_transaction->id]),
                        "udf1" => "aaaa",
                        "udf2" => "aaaa",
                        "udf3" => "aaaa",
                        "udf4" => "aaaa",
                        "udf5" => "aaaa",
                        "udf6" => "aaaa",
                        "udf7" => "aaaa",
                        "address1" => 'Address 1',
                        "address2" => 'Address 2',
                        "city" => "aaaa",
                        "state" => "aaaa",
                        "country" => "India",
                        "zipcode" => '123456',
                    );
                    $easebuzzObj = new Easebuzz(config('easebuzz.key'), config('easebuzz.salt'), config('easebuzz.env'));
                    $easebuzzObj->initiatePaymentAPI($postData);
                }
                else
                    die("Link expired");
            })->name('buy');
        });
    });
});

Route::prefix('/easebuzz/webhook')->name('easebuzz.webhook.')->group(function () {
    Route::post('/pt/{project_transaction}', function (\Illuminate\Http\Request $request, \App\Models\ProjectTransaction $project_transaction) {
        $easebuzzObj = new \App\Utils\Easebuzz\Easebuzz(null, config('easebuzz.salt'), null);
        $result = $easebuzzObj->easebuzzResponse($request->all());
        $res = json_decode($result);
        $status = $res->status;
        if ($status == 1){
            $data = $res->data;
            $orderId = $data->txnid;
            $status = $data->status;
            if ($status == 'success' && is_null($project_transaction->paid_at)) {
                $project_transaction->paid_at = now();
                $project_transaction->save();
                return redirect()->route('customer.projects.details', ['project' => $project_transaction->project_id]);
            } else {
                return redirect()->route('customer.projects.details', ['project' => $project_transaction->project_id]);
            }
        }
        return 'Invalid data';
    })
        ->name('pt');

    Route::post('/plan/{plan_transaction}', function (\Illuminate\Http\Request $request, \App\Models\PlanTransaction $plan_transaction) {
        $easebuzzObj = new \App\Utils\Easebuzz\Easebuzz(null, config('easebuzz.salt'), null);
        $result = $easebuzzObj->easebuzzResponse($request->all());
        $res = json_decode($result);
        $status = $res->status;
        if ($status == 1){
            $data = $res->data;
            $orderId = $data->txnid;
            $status = $data->status;
            if ($status == 'success' && is_null($plan_transaction->paid_at)) {
                $plan_transaction->paid_at = now();
                $plan_transaction->save();

                $subscription = \App\Models\Subscription::query()->create([
                    'user_id' => $plan_transaction->user_id,
                    'plan_id' => $plan_transaction->plan_id,
                    'amount' => $plan_transaction->final_amount
                ]);

                $plan_transaction->subscription_id = $subscription->id;
                $plan_transaction->save();
            }
            return redirect()->intended(route('supplier.dashboard'));
        }
        return 'Invalid data';
    })
        ->name('plan.activate');
});
