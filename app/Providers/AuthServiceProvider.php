<?php

namespace App\Providers;
use App\Role;
use App\User;
use App\permession;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        view()->composer('*', function ($view) 
        {
            permession::get()->map(function($permession){
                Gate::define($permession->Name, function ($name)  use ($permession){
                    $user = User::find(Auth::user()->id)->where('id',Auth::user()->id)->first();
                    $array[]=[];
                    foreach ($user->roles as $cc) {
                            $array = json_decode ($cc->permessions);
                            $array = array_values( array_unique( $array, SORT_REGULAR ) );
                        } 
                    if(in_array ($permession->Name,$array)){
                                return true;
                            }else{
                                return false;
                            } 
                            // $view->with('array', $array);
                    });
            });

        });
    }
}
