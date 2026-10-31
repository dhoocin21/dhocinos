<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?string $navigationLabel = 'Auto Insight (Berita Hyundai)';
    protected static ?string $modelLabel = 'Auto Insight';
    protected static ?string $pluralModelLabel = 'Auto Insight (Berita Hyundai)';
    protected static ?int $navigationSort = 1;

    public static function canCreate(): bool
    {
        // Berita sepenuhnya ditarik otomatis dari hyundai.com
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Rincian Berita Resmi Hyundai')
                    ->description('Data ini ditarik otomatis langsung dari hyundai.com/id/en/hyundai-story/news')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Berita Resmi')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('source_url')
                            ->label('Tautan Sumber Asli (Hyundai Indonesia)')
                            ->url()
                            ->readOnly()
                            ->suffixIcon('heroicon-m-arrow-top-right-on-square')
                            ->columnSpan(2),

                        Forms\Components\TextInput::make('seq')
                            ->label('ID Artikel Hyundai (Seq)')
                            ->readOnly()
                            ->columnSpan(1),

                        Forms\Components\Select::make('category')
                            ->label('Kategori')
                            ->options([
                                'News' => 'News',
                                'Event' => 'Event',
                                'Promo' => 'Promo',
                                'Tips' => 'Tips',
                            ])
                            ->required(),

                        Forms\Components\Toggle::make('is_published')
                            ->label('Tampilkan di Website Showroom')
                            ->default(true),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Tanggal Rilis Resmi')
                            ->default(now()),

                        Forms\Components\RichEditor::make('content')
                            ->label('Isi Berita & Format Pratinjau')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('published_at', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl('https://www.hyundai.com/content/dam/hyundai/id/id/images/local/HYU_Logo_Vertical_Blue_RGB.png')
                    ->state(function (Post $record): ?string {
                        if (!$record->image) {
                            return null;
                        }
                        if (Str::startsWith($record->image, ['http://', 'https://'])) {
                            return $record->image;
                        }
                        return asset('storage/' . $record->image);
                    }),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Berita')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap()
                    ->description(function (Post $record): string {
                        $source = $record->source_name ?: 'Hyundai Motors Indonesia';
                        $seq = $record->seq ? " [ID: {$record->seq}]" : '';
                        return "Sumber: {$source}{$seq}";
                    }),

                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'News' => 'info',
                        'Tips' => 'success',
                        'Promo' => 'warning',
                        'Event' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Tanggal Rilis')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('is_published')
                    ->label('Tampil di Web'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'News' => 'News',
                        'Event' => 'Event',
                        'Promo' => 'Promo',
                        'Tips' => 'Tips',
                    ]),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Status Publikasi'),
            ])
            ->actions([
                Tables\Actions\Action::make('open_source')
                    ->label('Buka Sumber Asli')
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->color('info')
                    ->url(fn (Post $record) => $record->source_url ?: "https://www.hyundai.com/id/en/hyundai-story/news/detail?newsid={$record->seq}")
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make('open_web')
                    ->label('Lihat di Web Kita')
                    ->icon('heroicon-m-globe-alt')
                    ->color('gray')
                    ->url(fn (Post $record) => route('posts.show', $record->slug))
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make('promote')
                    ->label('Promosikan')
                    ->icon('heroicon-m-megaphone')
                    ->color('success')
                    ->modalHeading('Materi Promosi Instagram / WhatsApp')
                    ->modalDescription('Bagikan rilis resmi Hyundai ini ke media sosial Anda.')
                    ->form([
                        Forms\Components\Textarea::make('caption')
                            ->label('Teks Caption (Siap Salin)')
                            ->rows(8)
                            ->default(fn ($record) => "🔥 [OFFICIAL HYUNDAI NEWS] " . $record->title . "\n\nSimak informasi resmi terlengkap dan penawaran terbaik hanya di Hyundai Gowa HR Muhammad Surabaya.\n\n👉 Baca selengkapnya di web: " . route('posts.show', $record->slug) . "\n📞 Konsultasi & Test Drive: Hubungi Sales Consultant Nico via WhatsApp sekarang!\n\n#hyundai #hyundaisurabaya #hyundaiindonesia #otomotifsurabaya"),
                    ])
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),

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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
