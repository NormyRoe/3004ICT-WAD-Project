<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\FarmDetail;

class FarmComposer
{
    public function compose(View $view)
    {

        # Retrieve the Farm's Details
        $farm = FarmDetail::first();

        # Provide the Farm's name to every view
        $view->with('farmName', $farm?->name ?? 'Tree Farm');

    }

}
