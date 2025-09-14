<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PixelResource\Pages;
use App\Models\Pixel;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PixelResource extends Resource
{
    protected static ?string $model = Pixel::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static \UnitEnum|string|null $navigationGroup = 'Marketing';

    protected static ?int $navigationSort = 20;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('provider')
                    ->label('Provider')
                    ->options([
                        'facebook' => 'Facebook Pixel',
                        'google_tag' => 'Google Tag',
                        'tiktok' => 'TikTok Pixel',
                        'custom' => 'Custom',
                    ])
                    ->required()
                    ->native(false),
                Forms\Components\Select::make('location')
                    ->label('Location')
                    ->options([
                        'head' => 'Head',
                        'body_start' => 'Body Start',
                        'body_end' => 'Body End',
                    ])
                    ->required()
                    ->default('head')
                    ->native(false),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Active',
                        'paused' => 'Paused',
                    ])
                    ->required()
                    ->default('active')
                    ->native(false),
                Forms\Components\Textarea::make('code')
                    ->label('Pixel Code (script/snippet)')
                    ->rows(8)
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->wrap()->limit(30),
                Tables\Columns\TextColumn::make('provider')->label('Provider')->badge()->sortable(),
                Tables\Columns\TextColumn::make('location')->label('Location')->badge()->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'paused' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->since()->sortable(),
            ])
            ->filters([
                SelectFilter::make('provider')
                    ->options([
                        'facebook' => 'Facebook Pixel',
                        'google_tag' => 'Google Tag',
                        'tiktok' => 'TikTok Pixel',
                        'custom' => 'Custom',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'paused' => 'Paused',
                    ]),
            ])
            ->actions([])
            ->recordUrl(fn ($record) => static::getUrl('edit', ['record' => $record]))
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPixels::route('/'),
            'create' => Pages\CreatePixel::route('/create'),
            'edit' => Pages\EditPixel::route('/{record}/edit'),
        ];
    }
}
