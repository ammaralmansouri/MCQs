<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChoicesResource\Pages;
use App\Filament\Resources\ChoicesResource\RelationManagers;
use App\Models\Choice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChoicesResource extends Resource
{
    protected static ?string $model = Choice::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3-center-left';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('choice_text')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_correct')
                    ->required(),
                Forms\Components\Select::make('question_id')
                    ->label('Question')
                    ->relationship('question', 'question_text')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('choice_text')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_correct')
                    ->boolean(),
                Tables\Columns\TextColumn::make('question_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChoices::route('/'),
            'create' => Pages\CreateChoices::route('/create'),
            'view' => Pages\ViewChoices::route('/{record}'),
            'edit' => Pages\EditChoices::route('/{record}/edit'),
        ];
    }
}
