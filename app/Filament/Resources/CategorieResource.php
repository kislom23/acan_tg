<?php

namespace App\Filament\Resources;

use App\Filament\Formator\Resources\CategorieResource\RelationManagers\FormationsRelationManager;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Categorie;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\CategorieResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CategorieResource\RelationManagers;
use App\Filament\Resources\CategorieResource\RelationManagers\ArticlesRelationManager;

class CategorieResource extends Resource
{
    protected static ?string $model = Categorie::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Catégories';

    protected static ?string $navigationGroup = 'Blog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('libelle')
                    ->label('Libellé')
                    ->required()
                    ->unique(ignoreRecord:true),

                TextInput::make('description')
                    ->label('Description'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('libelle')
                    ->label('Libellé')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('description')
                    ->label('Description')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Création')
                    ->since()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            ArticlesRelationManager::class,
            FormationsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategorie::route('/create'),
            'edit' => Pages\EditCategorie::route('/{record}/edit'),
        ];
    }
}
