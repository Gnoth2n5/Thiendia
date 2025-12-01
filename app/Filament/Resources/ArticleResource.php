<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Bài viết';

    protected static ?string $modelLabel = 'Bài viết';

    protected static ?string $pluralModelLabel = 'Bài viết';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông tin bài viết')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Tiêu đề')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation !== 'create') {
                                    return;
                                }
                                $set('slug', \Illuminate\Support\Str::slug($state));
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->label('URL Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(Article::class, 'slug', ignoreRecord: true)
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\FileUpload::make('featured_image')
                            ->label('Ảnh đại diện')
                            ->image()
                            ->directory('articles/featured')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('content')
                            ->label('Nội dung')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                                'blockquote',
                            ]),
                        Forms\Components\Select::make('category')
                            ->label('Danh mục')
                            ->required()
                            ->options([
                                'tin_tuc' => 'Tin tức',
                                'su_kien' => 'Sự kiện'
                            ]),
                        Forms\Components\Select::make('status')
                            ->label('Trạng thái')
                            ->required()
                            ->options([
                                'draft' => 'Bản nháp',
                                'published' => 'Đã xuất bản',
                            ])
                            ->default('published'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Ảnh')
                    ->square()
                    ->size(60),
                Tables\Columns\TextColumn::make('title')
                    ->label('Tiêu đề')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->weight('bold'),
                Tables\Columns\BadgeColumn::make('category')
                    ->label('Danh mục')
                    ->colors([
                        'primary' => 'tin_tuc',
                        'success' => 'huong_dan',
                        'warning' => 'thong_bao',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'tin_tuc' => 'Tin tức',
                        'huong_dan' => 'Hướng dẫn',
                        'thong_bao' => 'Thông báo',
                    }),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Trạng thái')
                    ->colors([
                        'secondary' => 'draft',
                        'success' => 'published',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Bản nháp',
                        'published' => 'Đã xuất bản',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'draft' => 'Bản nháp',
                        'published' => 'Đã xuất bản',
                    ]),
                Tables\Filters\SelectFilter::make('category')
                    ->label('Danh mục')
                    ->options([
                        'tin_tuc' => 'Tin tức',
                        'huong_dan' => 'Hướng dẫn',
                        'thong_bao' => 'Thông báo',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
