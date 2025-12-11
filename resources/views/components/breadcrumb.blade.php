<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    /**
     * Les liens du fil d'Ariane
     */
    public $links;

    /**
     * Créer une nouvelle instance du composant
     */
    public function __construct($links = [])
    {
        $this->links = $links;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.breadcrumb');
    }
}