<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserTestResource\Pages;
use App\Filament\Resources\UserTestResource\RelationManagers;
use App\Models\UserTest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserTestResource extends Resource
{
    protected static ?string $model = UserTest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('score')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('number_of_total_questions')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('number_of_answred_questions')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('number_of_correct_answers')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('taken_time_to_complete_the_test')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('test_id')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('number_of_total_questions')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('number_of_answred_questions')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('number_of_correct_answers')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('taken_time_to_complete_the_test')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('test_id')
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
            'index' => Pages\ListUserTests::route('/'),
            'create' => Pages\CreateUserTest::route('/create'),
            'view' => Pages\ViewUserTest::route('/{record}'),
            'edit' => Pages\EditUserTest::route('/{record}/edit'),
        ];
    }
}
