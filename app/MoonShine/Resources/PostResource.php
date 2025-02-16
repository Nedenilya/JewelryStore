<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Post>
 */
class PostResource extends ModelResource
{
    protected string $model = Post::class;

    protected string $title = 'Посты';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make(
                'Пользователь',
                'user_id',
            fn(Post $item) => User::where('id', $item->user_id)->first()->email ?? 'N/A'),
            Text::make('Заголовок', 'title'),
            Text::make('Описание', 'description'),
            Image::make('Картинка', 'image')
                ->disk('pub')
                ->dir('blog')
                ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif']),
            Image::make('Картинка(70x70)', 'image_small')
                ->disk('pub')
                ->dir('blog')
                ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif'])

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
                Text::make(
                    'Пользователь',
                    'user_id',
                    fn(Post $item) => User::where('id', $item->user_id)->first()->email ?? 'N/A'),
                Text::make('Заголовок', 'title'),
                Text::make('Описание', 'description'),
                Image::make('Картинка', 'image')
                    ->disk('pub')
                    ->dir('blog')
                    ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif']),
                Image::make('Картинка(70x70)', 'image_small')
                    ->disk('pub')
                    ->dir('blog')
                    ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif'])
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
            Text::make(
                'Пользователь',
                'user_id',
                fn(Post $item) => User::where('id', $item->user_id)->first()->email ?? 'N/A'),
            Text::make('Заголовок', 'title'),
            Text::make('Описание', 'description'),
            Image::make('Картинка', 'image')
                ->disk('pub')
                ->dir('blog')
                ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif']),
            Image::make('Картинка(70x70)', 'image_small')
                ->disk('pub')
                ->dir('blog')
                ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif'])
        ];
    }

    /**
     * @param Post $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
