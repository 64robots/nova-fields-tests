<?php

namespace App\Nova;

use App\Nova\Actions\RowFieldAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
// nova-field Fields
use R64\NovaFields\BelongsTo;
use R64\NovaFields\Text;
use R64\NovaFields\JSON;
use R64\NovaFields\Autocomplete;
// use R64\NovaFields\Number;
use R64\NovaFields\Row;
use R64\NovaFields\File;

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

            File::make('File')
                      ->draggable()
                      ->disk('public')
                      ->previewBeforeUpload()
                      ->addFieldClasses('w-full'),

            Row::make('Products', [
                Text::make('Name'),
                Number::make('Quantity Readonly')->readonly(),
                Number::make('Price')->hideWhenCreating()->readonly(),
                Number::make('Price Readonly')->readonly(),
            ])->fillUsing(function ($request, $model) {
                $model->products = json_encode($request->products);
            })->sum('price'),

            JSON::make('Extras', [
                new Panel('This should be first', [
                    Text::make('should be first')
                ]),
                Text::make('should be second'),
            ]),

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
