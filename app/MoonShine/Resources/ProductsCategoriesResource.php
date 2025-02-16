<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductsCategories;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Preview;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<ProductCategory>
 */
class ProductsCategoriesResource extends ModelResource
{
    protected string $model = ProductCategory::class;

    protected string $title = 'Категории товаров';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'name'),
            Text::make(
                'Ссылка',
                'link',
                fn(ProductCategory $item) => '/'.$item->link
            ),
            Switcher::make('Активно', 'is_active'),
            Date::make('Дата создания', 'created_at')->readonly(),
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
                Text::make(
                    'Ссылка',
                    'link',
                    fn(ProductCategory $item) => '/'.$item->link
                ),
                Switcher::make('Активно', 'is_active'),
                Date::make('Дата создания', 'created_at')->readonly(),
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
            Text::make(
                'Ссылка',
                'link',
                fn(ProductCategory $item) => '/'.$item->link
            ),
            Switcher::make('Активно', 'is_active'),
            Date::make('Дата создания', 'created_at')->readonly(),
        ];
    }

    /**
     * @param ProductCategory $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
