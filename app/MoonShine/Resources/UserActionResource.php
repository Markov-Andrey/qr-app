<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserAction;

use MoonShine\Fields\Date;
use MoonShine\Fields\Json;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<UserAction>
 */
class UserActionResource extends ModelResource
{
    protected string $model = UserAction::class;

    protected string $title = 'UserActions';

    /**
     * @return list<MoonShineComponent|Field>
     * @throws \Throwable
     */
    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                BelongsTo::make('Пользователь', 'user', resource: new UserResource())->nullable(),
                Text::make('IP', 'ip_address')->nullable(),
                Json::make('Данные', 'processed_data')->onlyValue()->nullable()->hideOnIndex(),
                Date::make('Создано', 'created_at')->format('d.m.Y'),
                Date::make('Обновлено', 'updated_at')->format('d.m.Y'),
            ]),
        ];
    }

    /**
     * @param UserAction $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
