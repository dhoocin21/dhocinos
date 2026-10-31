<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TradeInResource\Pages;
use App\Models\Car;
use App\Models\TradeIn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TradeInResource extends Resource
{
    protected static ?string $model = TradeIn::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';
    protected static ?string $navigationGroup = 'Inventory & Sales';
    protected static ?string $navigationLabel = 'Tukar Tambah (Trade-In)';
    protected static ?int $navigationSort = 4;

    public static function getNavigationBadge(): ?string
    {
        $count = TradeIn::where('status', 'pending')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pemilik Mobil Lama')
                    ->schema([
                        Forms\Components\TextInput::make('customer_name')
                            ->label('Nama Customer')
                            ->placeholder('Nama Lengkap')
                            ->required(),
                        Forms\Components\TextInput::make('customer_phone')
                            ->label('Nomor WhatsApp')
                            ->placeholder('08xxxxxxxx')
                            ->tel()
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Spesifikasi Mobil Lama Customer')
                    ->schema([
                        Forms\Components\TextInput::make('old_car_brand')
                            ->label('Merk Mobil')
                            ->placeholder('Toyota / Honda / Daihatsu / dll')
                            ->required(),
                        Forms\Components\TextInput::make('old_car_model')
                            ->label('Tipe / Model Mobil')
                            ->placeholder('Innova Reborn 2.4 V / Brio RS / dll')
                            ->required(),
                        Forms\Components\TextInput::make('old_car_year')
                            ->label('Tahun Pembuatan')
                            ->numeric()
                            ->placeholder('2019')
                            ->required(),
                        Forms\Components\Select::make('old_car_transmission')
                            ->label('Transmisi')
                            ->options([
                                'automatic' => 'Automatic (A/T / CVT)',
                                'manual' => 'Manual (M/T)',
                            ])
                            ->default('automatic')
                            ->required(),
                        Forms\Components\TextInput::make('old_car_mileage')
                            ->label('Kilometer (Odometer)')
                            ->numeric()
                            ->suffix('KM')
                            ->nullable(),
                        Forms\Components\TextInput::make('expected_price')
                            ->label('Ekspektasi Harga Customer (Rp)')
                            ->numeric()
                            ->prefix('Rp')
                            ->nullable(),
                        Forms\Components\TextInput::make('appraisal_price')
                            ->label('Harga Penawaran Appraisal Showroom (Rp)')
                            ->numeric()
                            ->prefix('Rp')
                            ->nullable(),
                    ])->columns(3),

                Forms\Components\Section::make('Target Unit Hyundai & Status Appraisal')
                    ->schema([
                        Forms\Components\Select::make('interested_car_id')
                            ->label('Unit Hyundai Pengganti')
                            ->relationship('interestedCar', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Forms\Components\Select::make('status')
                            ->label('Status Tukar Tambah')
                            ->options([
                                'pending' => '🟡 Menunggu Penilaian / Inspeksi',
                                'inspected' => '🔵 Sudah Inspeksi Fisik',
                                'negotiation' => '🟣 Negosiasi Harga Taksiran',
                                'deal' => '🟢 Deal / SPK Tukar Tambah',
                                'cancelled' => '⚪ Batal',
                            ])
                            ->default('pending')
                            ->required(),
                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan Kondisi Mobil')
                            ->placeholder('Kondisi bodi, mesin, buku service, masa berlaku pajak, dll.')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Nama Customer')
                    ->weight('bold')
                    ->searchable(),

                Tables\Columns\TextColumn::make('customer_phone')
                    ->label('WhatsApp')
                    ->copyable()
                    ->icon('heroicon-m-phone'),

                Tables\Columns\TextColumn::make('old_car')
                    ->label('Mobil Lama')
                    ->state(fn (TradeIn $record) => "{$record->old_car_brand} {$record->old_car_model} ({$record->old_car_year})")
                    ->searchable(query: function ($query, string $search) {
                        return $query->where('old_car_brand', 'like', "%{$search}%")
                            ->orWhere('old_car_model', 'like', "%{$search}%");
                    }),

                Tables\Columns\TextColumn::make('expected_price')
                    ->label('Harapan Customer')
                    ->money('IDR', locale: 'id')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('appraisal_price')
                    ->label('Taksiran Dealer')
                    ->money('IDR', locale: 'id')
                    ->color('primary')
                    ->weight('bold')
                    ->default('Belum Ditaksir'),

                Tables\Columns\TextColumn::make('interestedCar.name')
                    ->label('Target Hyundai')
                    ->badge()
                    ->color('info')
                    ->default('Konsultasi'),

                Tables\Columns\SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => '🟡 Menunggu',
                        'inspected' => '🔵 Inspeksi',
                        'negotiation' => '🟣 Negosiasi',
                        'deal' => '🟢 Deal SPK',
                        'cancelled' => '⚪ Batal',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Masuk')
                    ->since()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('chat_appraisal')
                    ->label('WA Penawaran')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->color('success')
                    ->url(function (TradeIn $record) {
                        $phone = $record->clean_phone;
                        $oldCar = "{$record->old_car_brand} {$record->old_car_model} ({$record->old_car_year})";
                        $target = $record->interestedCar?->name ?? 'mobil baru Hyundai';
                        $taksiran = $record->appraisal_price ? "Rp " . number_format($record->appraisal_price, 0, ',', '.') : "harga terbaik";
                        $text = "Halo Bapak/Ibu {$record->customer_name}, perkenalkan saya Nico dari Dealer Resmi Hyundai Gowa HR Muhammad Surabaya.\n\nTerkait program Tukar Tambah untuk unit mobil lama Anda *{$oldCar}* ke unit baru *{$target}*, kami siap memberikan penawaran taksiran appraisal {$taksiran}.\n\nKira-kira kapan ada waktu luang untuk kami jadwalkan cek fisik / test drive mobil barunya ya Pak/Bu?";
                        return "https://wa.me/{$phone}?text=" . urlencode($text);
                    })
                    ->openUrlInNewTab(),

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
            'index' => Pages\ListTradeIns::route('/'),
            'create' => Pages\CreateTradeIn::route('/create'),
            'edit' => Pages\EditTradeIn::route('/{record}/edit'),
        ];
    }
}
