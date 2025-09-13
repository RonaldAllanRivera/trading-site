<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Models\Lead;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-user-plus';

    protected static \UnitEnum|string|null $navigationGroup = 'Marketing';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->maxLength(256)
                    ->label('First name'),
                Forms\Components\TextInput::make('last_name')
                    ->maxLength(256)
                    ->label('Last name'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(256),
                Forms\Components\TextInput::make('country')
                    ->maxLength(256),
                Forms\Components\TextInput::make('phone_prefix')
                    ->label('Phone prefix')
                    ->maxLength(64),
                Forms\Components\TextInput::make('phone_number')
                    ->label('Phone number')
                    ->maxLength(64),
                Forms\Components\Select::make('status')
                    ->options([
                        'new' => 'New',
                        'contacted' => 'Contacted',
                        'converted' => 'Converted',
                    ])
                    ->required()
                    ->default('new')
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('first_name')->label('First')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('last_name')->label('Last')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('email')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('country')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone_prefix')->label('Prefix')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone_number')->label('Phone')->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'info',
                        'contacted' => 'warning',
                        'converted' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->since()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'contacted' => 'Contacted',
                        'converted' => 'Converted',
                    ]),
            ])
            ->actions([])
            ->recordUrl(fn ($record) => static::getUrl('edit', ['record' => $record]))
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'view' => Pages\ViewLead::route('/{record}'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
