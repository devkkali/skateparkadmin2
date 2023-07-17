<?php

namespace App\Providers;

use App\Models\MembershipUser;
use App\Models\NormalCard;
use App\Models\PackageUser;
use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Validator::extend('unique_normal_cards', function ($attribute, $value, $parameters, $validator) {
            if(NormalCard::where('card_id', $value)->count() > 0)
                return false;
            return true;
        });

        Validator::extend('unique_membership_user_card', function ($attribute, $value, $parameters, $validator) {
            if(MembershipUser::where('card_id', $value)->count() > 0)
                return false;
            return true;
        });

        Validator::extend('unique_package_user_card', function ($attribute, $value, $parameters, $validator) {
            if(PackageUser::where('card_id', $value)->count() > 0)
                return false;
            return true;
        });
        // Validator::extend('unique_table_2', function ($attribute, $value, $parameters, $validator) {
        //     if(ModelSecondTable::where('email', $value)->count() > 0)
        //         return false;
        //     return true;
        // });
    }
}
