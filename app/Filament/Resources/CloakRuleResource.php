<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CloakRuleResource\Pages;
use App\Models\CloakRule;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class CloakRuleResource extends Resource
{
    protected static ?string $model = CloakRule::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-shield-check';

    protected static \UnitEnum|string|null $navigationGroup = 'Marketing';

    protected static ?int $navigationSort = 30;

    protected static ?string $navigationLabel = 'Cloaker';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Active',
                        'paused' => 'Paused',
                    ])
                    ->required()
                    ->default('active')
                    ->native(false),

                Forms\Components\Select::make('mode')
                    ->label('Mode')
                    ->options([
                        'whitelist' => 'Whitelist',
                        'blacklist' => 'Blacklist',
                    ])
                    ->required()
                    ->default('whitelist')
                    ->native(false),

                Forms\Components\Select::make('match_type')
                    ->label('Match Type')
                    ->options([
                        'ip' => 'IP Address',
                        'country' => 'Country (ISO code)',
                        'ua' => 'User Agent contains',
                        'referrer' => 'Referrer contains',
                        'param' => 'Query Param contains',
                    ])
                    ->required()
                    ->default('ip')
                    ->native(false),

                Forms\Components\Textarea::make('pattern')
                    ->label('Patterns')
                    ->rows(5)
                    ->helperText('Enter one pattern per line (e.g., IPs, country codes, UA/referrer fragments, or param=value).')
                    ->required(),

                Forms\Components\TextInput::make('safe_url')
                    ->label('Safe URL')
                    ->placeholder(url('/safe'))
                    ->maxLength(1024),

                Forms\Components\TextInput::make('offer_url')
                    ->label('Offer URL')
                    ->placeholder(url('/'))
                    ->maxLength(1024),

                Forms\Components\Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3),

                Forms\Components\Placeholder::make('metrics')
                    ->label('Metrics')
                    ->content(fn ($record) => $record ? "Safe hits: {$record->hits_safe} • Offer hits: {$record->hits_offer}" : '–')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->wrap()->limit(30),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'paused' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('mode')->badge()->sortable(),
                Tables\Columns\TextColumn::make('match_type')->label('Match')->badge()->sortable(),
                Tables\Columns\TextColumn::make('hits_safe')->label('Safe Hits')->sortable(),
                Tables\Columns\TextColumn::make('hits_offer')->label('Offer Hits')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->since()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(['active' => 'Active', 'paused' => 'Paused']),
                SelectFilter::make('mode')->options(['whitelist' => 'Whitelist', 'blacklist' => 'Blacklist']),
                SelectFilter::make('match_type')->options([
                    'ip' => 'IP Address',
                    'country' => 'Country',
                    'ua' => 'User Agent',
                    'referrer' => 'Referrer',
                    'param' => 'Param',
                ]),
            ])
            ->actions([])
            ->recordUrl(fn ($record) => static::getUrl('edit', ['record' => $record]))
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCloakRules::route('/'),
            'create' => Pages\CreateCloakRule::route('/create'),
            'edit' => Pages\EditCloakRule::route('/{record}/edit'),
        ];
    }
}
