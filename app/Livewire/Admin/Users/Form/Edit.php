<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Users\Form;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

final class Edit extends Component
{
    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $role = UserRole::USER->value;

    public string $password = '';

    public User $user;

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->role = $user->role->value;
    }

    public function updateUser(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user->id)],
            'phone' => ['required', 'string', 'max:255', Rule::unique(User::class)->ignore($this->user->id)],
            'role' => ['required', 'string', new Enum(UserRole::class)],
            'password' => ['nullable', 'string', Password::defaults()],
        ]);

        if (! empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $this->user->update($validated);

        $this->dispatch('user-updated');
    }

    public function render(): Factory|View
    {
        return view('livewire.admin.users.form.edit');
    }
}
