<?php

namespace App\Nova\Repeater\Central;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Repeater\Repeatable;
use Laravel\Nova\Http\Requests\NovaRequest;

class Domain extends Repeatable
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Central\Domain>
     */
    public static $model = \App\Models\Central\Domain::class;

    /**
     * Get the fields displayed by the repeatable.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make(),

            Text::make('Domain', 'domain')
                ->rules('required', 'max:255')
                ->creationRules('unique:domains,domain')
                ->updateRules('unique:domains,domain,{{resourceId}}'),
        ];
    }
}
