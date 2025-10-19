<?php

use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use App\Livewire\Admin\Rooms;
use App\Livewire\Admin\Tasks;
use App\Livewire\Admin\Users\Form\Create as CreateUser;
use App\Livewire\Admin\Users\Form\Edit as EditUser;
use App\Livewire\Property\Form\Create as CreateProperty;
use App\Livewire\Property\Form\Edit as EditProperty;
use App\Livewire\Property\Room\Form\Create as CreateRoom;
use App\Livewire\Property\Room\Form\Edit as EditRoom;
use App\Livewire\Schedule\Item as ScheduleItem;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::prefix('dashboard')->name('dashboard.')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::view('/', 'dashboard')->name('index');

        Route::can('viewDashboard', User::class)
            ->group(function () {
                Route::get('/rooms', Rooms::class)
                    ->name('rooms');
                Route::get('/tasks', Tasks::class)
                    ->name('tasks');
                Route::prefix('users')
                    ->name('users.')
                    ->group(function () {
                        Route::get('/', [UserController::class, 'index'])
                            ->name('index');
                        Route::get('create', CreateUser::class)
                            ->name('create');
                        Route::get('{user}', EditUser::class)
                            ->name('edit');
                    });
            });
    });

Route::prefix('properties')
    ->name('properties.')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/', [PropertyController::class, 'index'])
            ->name('index');
        Route::get('create', CreateProperty::class)
            ->can('create', Property::class)
            ->name('create');

        Route::prefix('{property}')
            ->group(function () {
                Route::get('/', EditProperty::class)
                    ->name('edit');

                Route::prefix('rooms')
                    ->name('rooms.')
                    ->group(function () {
                        Route::get('/', [PropertyController::class, 'rooms'])
                            ->name('index');
                        Route::get('/create', CreateRoom::class)
                            ->name('create');
                        Route::get('/{room}', EditRoom::class)
                            ->name('edit');
                    });

                Route::prefix('schedule')
                    ->name('schedule.')
                    ->group(function () {
                        Route::get('/', [PropertyController::class, 'schedule'])
                            ->name('index');
                        Route::get('{schedule}', ScheduleItem::class)
                            ->name('view');
                    });
            });
    });

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

require __DIR__ . '/auth.php';
