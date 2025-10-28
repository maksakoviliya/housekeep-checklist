<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Users\Form;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

final class Create extends Component
{
    public string $name = '';
    
    public string $login = '';

    public string $email = '';

    public string $phone = '';

    public string $role = UserRole::USER->value;

    public string $password = '';

    public function createUser()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'login' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'role' => ['required', 'string', new Enum(UserRole::class)],
            'password' => ['required', 'string', Password::defaults()],
        ]);
        
        $validated['password'] = bcrypt($validated['password']);
        
        User::query()->create($validated);
        
        $this->redirectRoute('dashboard.users.index', [], navigate: true);
    }
    
    public function render(): Factory|View
    {
        return view('livewire.admin.users.form.create');
    }
}
