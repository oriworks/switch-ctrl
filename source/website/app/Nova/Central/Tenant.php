<?php

namespace App\Nova\Central;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Repeater;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Tenant extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Central\Tenant>
     */
    public static $model = \App\Models\Central\Tenant::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Text::make('Name', 'id')
                ->rules('required', 'max:255', 'unique:tenants,id')
                ->hideWhenUpdating(),

            URL::make('Backoffice', fn () => "https://{$this->id}.switch-ctrl.local")
                ->displayUsing(fn () => "{$this->id}.switch-ctrl.local")
                ->textAlign('left'),

            Panel::make('Database connection', [
                Text::make('Connection', 'tenancy_db_connection')
                    ->dependsOn(['id'], function (Text $field, NovaRequest $request, FormData $form) {
                        $field->setValue($form->id);
                    })
                    ->textAlign('left')
                    ->hideWhenUpdating(),
                Text::make('Driver', 'tenancy_db_driver')->default('mysql')->hideFromIndex(),
                Text::make('Host', 'tenancy_db_host')->default('172.18.0.1')->hideFromIndex(),
                Number::make('Port', 'tenancy_db_port')->default(33060)->hideFromIndex(),
                Text::make('Database', 'tenancy_db_name')
                    ->dependsOn(['id'], function (Text $field, NovaRequest $request, FormData $form) {
                        if ($form->id) {
                            $field->setValue("{$form->id}_switch_ctrl");
                        }
                    })
                    ->hideFromIndex(),
                Text::make('Username', 'tenancy_db_username')->default('root')->hideFromIndex(),
                Text::make('Password', 'tenancy_db_password')->default('root')->hideFromIndex(),
            ]),

            Panel::make('Features', [
                Boolean::make('Blog', 'features_blog')->default(false),
            ]),

            HasMany::make('Domains'),

            Repeater::make('Domains')
                ->repeatables([
                    \App\Nova\Repeater\Central\Domain::make(),
                ])
                ->asHasMany(\App\Nova\Central\Domain::class),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
