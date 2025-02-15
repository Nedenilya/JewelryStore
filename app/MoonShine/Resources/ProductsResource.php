<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Boolean;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Preview;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use PhpParser\Node\Expr\BinaryOp\BooleanAnd;

/**
 * @extends ModelResource<Product>
 */
class ProductsResource extends ModelResource
{
    protected string $model = Product::class;

    protected string $title = 'Products';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'name'),
            Text::make('Описание', 'description'),
            Number::make('Цена', 'price'),
            Image::make('Картинка', 'image')
                ->disk('pub')
                ->dir('shop')
                ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif']),
            Image::make('Картинка(70x70)', 'image_small')
                ->disk('pub')
                ->dir('shop')
                ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif']),
            Switcher::make('Активно', 'is_active'),
            Switcher::make('Распродажа', 'is_sale'),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Название', 'name'),
                Text::make('Описание', 'description'),
                Number::make('Цена', 'price'),
                Image::make('Картинка', 'image')
                    ->disk('pub')
                    ->dir('shop')
                    ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif']),
                Image::make('Картинка(70x70)', 'image_small')
                    ->disk('pub')
                    ->dir('shop')
                    ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif']),
                Switcher::make('Активно', 'is_active'),
                Switcher::make('Распродажа', 'is_sale'),
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Название', 'name'),
            Text::make('Описание', 'description'),
            Number::make('Цена', 'price'),
            Image::make('Картинка', 'image')
                ->disk('pub')
                ->dir('shop')
                ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif']),
            Image::make('Картинка(70x70)', 'image_small')
                ->disk('pub')
                ->dir('shop')
                ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif']),
            Switcher::make('Активно', 'is_active'),
            Switcher::make('Распродажа', 'is_sale'),
        ];
    }

    /**
     * @param Product $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
