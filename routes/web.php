<?php

use App\Http\Controllers\PropertyController;
use App\Livewire\Property\Form\Create as CreateProperty;
use App\Livewire\Property\Form\Edit as EditProperty;
use App\Livewire\Property\Room\Form\Create as CreateRoom;
use App\Livewire\Property\Room\Form\Edit as EditRoom;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use App\Models\Property;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::prefix('dashboard')->name('dashboard.')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::view('/', 'dashboard')->name('index');
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
                Route::get('/rooms', [PropertyController::class, 'rooms'])
                    ->name('rooms.index');
                Route::get('/rooms/create', CreateRoom::class)
                    ->name('rooms.create');
                Route::get('/rooms/{room}', EditRoom::class)
                    ->name('rooms.edit');
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

require __DIR__.'/auth.php';
