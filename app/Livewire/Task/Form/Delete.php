<?php

declare(strict_types=1);

namespace App\Livewire\Task\Form;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Delete extends Component
{
    public function submitDeleting(): void
    {
        $this->dispatch('task-deleting-confirmed');
    }

    public function render(): Factory|View
    {
        return view('livewire.task.form.delete');
    }
}
