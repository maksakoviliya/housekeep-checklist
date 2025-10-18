<?php

declare(strict_types=1);

namespace App\Livewire\Property\Form;

use App\Models\Property;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Delete extends Component
{
    public Property $property;

    public function mount(Property $property): void
    {
        $this->property = $property;
    }

    public function deleteProperty(): void
    {
        $this->property->delete();

        $this->redirect(route('properties.index'));
    }

    public function render(): Factory|View
    {
        return view('livewire.property.form.delete');
    }
}
