<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShowroomEventResource\Pages;
use App\Models\ShowroomEvent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ShowroomEventResource extends Resource
{
    protected static ?string $model = ShowroomEvent::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Marketing & Engagement';
    protected static ?string $navigationLabel = 'Event & Promo Showroom';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Acara Dealer')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Nama Event / Promo')
                            ->placeholder('Contoh: Hyundai Weekend Sales Gathering & Test Drive Party')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                        Forms\Components\TextInput::make('slug')
                            ->label('URL Slug')
                            ->required()
                            ->unique(ShowroomEvent::class, 'slug', ignoreRecord: true),

                        Forms\Components\DateTimePicker::make('event_date')
                            ->label('Tanggal Acara / Batas Promo')
                            ->required()
                            ->default(now()->addDays(7)),

                        Forms\Components\TextInput::make('start_time')
                            ->label('Jam Mulai')
                            ->default('09:00')
                            ->required(),

                        Forms\Components\TextInput::make('end_time')
                            ->label('Jam Selesai')
                            ->default('17:00')
                            ->required(),

                        Forms\Components\TextInput::make('location')
                            ->label('Lokasi Acara')
                            ->default('Dealer Resmi Hyundai Gowa HR Muhammad, Surabaya')
                            ->required(),

                        Forms\Components\TagsInput::make('promo_highlights')
                            ->label('Poin Promo / Keuntungan Pengunjung')
                            ->placeholder('Ketik promo lalu tekan enter (Contoh: Lucky Dip Emas, DP Mulai 10%, Free Voucher BBM)')
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('banner_image')
                            ->label('Banner Poster Acara')
                            ->image()
                            ->directory('events')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('description')
                            ->label('Deskripsi Lengkap Acara')
                            ->placeholder('Jelaskan detail fasilitas acara, test drive, hiburan, dan bonus khusus yang berlaku.')
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktifkan Banner & Countdown di Website Utama')
                            ->default(true)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('event_date', 'asc')
            ->columns([
                Tables\Columns\ImageColumn::make('banner_image')
                    ->label('Banner')
                    ->circular(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Nama Event')
                    ->weight('bold')
                    ->searchable(),

                Tables\Columns\TextColumn::make('event_date')
                    ->label('Waktu Pelaksanaan')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('location')
                    ->label('Lokasi')
                    ->limit(35),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status Aktif')
                    ->boolean(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShowroomEvents::route('/'),
            'create' => Pages\CreateShowroomEvent::route('/create'),
            'edit' => Pages\EditShowroomEvent::route('/{record}/edit'),
        ];
    }
}
