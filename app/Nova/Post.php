<?php

namespace App\Nova;

use App\Nova\Actions\RowFieldAction;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;

// nova-field Fields
use R64\NovaFields\BelongsTo;
use R64\NovaFields\Text;
use R64\NovaFields\JSON;
use R64\NovaFields\Autocomplete;
use R64\NovaFields\Number;
use R64\NovaFields\Row;

class Post extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Post';

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
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Title'),

            BelongsTo::make('Category')->quickCreate(),

            Row::make('Products', [
                Text::make('Name'),
                Number::make('Quantity'),
                Number::make('Price'),
            ])->fillUsing(function ($request, $model) {
                $model->products = json_encode($request->products);
            }),

            // Json::make('Testing', [
            //     Autocomplete::make('Variable Type')
            //         ->options([
            //             'user' => 'User',
            //             'admin' => 'Admin'
            //         ])
            //         ->displayUsingLabels()
            //         ->onlyOnForms(),

            //     Autocomplete::make('Variable Id')
            //         ->options([])
            //         ->displayUsingLabels()
            //         ->computeOptionsUsing(function ($fields) {
            //             return ['pepe' => 'Pepe', 'antonio' => 'Antonio'];
            //         }),
            // ])
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [new RowFieldAction];
    }
}
