<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuotationResource\Pages;
use App\Models\Car;
use App\Models\Consultant;
use App\Models\Quotation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QuotationResource extends Resource
{
    protected static ?string $model = Quotation::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Inventory & Sales';
    protected static ?string $navigationLabel = 'Surat Penawaran (SPH)';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Calon Pembeli & Nomor SPH')
                    ->schema([
                        Forms\Components\TextInput::make('quotation_number')
                            ->label('Nomor Penawaran')
                            ->default(fn () => 'SPH-HYU-' . date('Ymd') . '-' . rand(100, 999))
                            ->required()
                            ->readOnly(),
                        Forms\Components\TextInput::make('customer_name')
                            ->label('Nama Calon Pembeli')
                            ->placeholder('Contoh: Bapak Hendra Kusuma')
                            ->required(),
                        Forms\Components\TextInput::make('customer_phone')
                            ->label('Nomor WhatsApp')
                            ->placeholder('08123456789')
                            ->tel()
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Rincian Kendaraan & Kalkulasi Kredit')
                    ->schema([
                        Forms\Components\Select::make('car_id')
                            ->label('Pilih Unit Mobil')
                            ->relationship('car', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                if ($state) {
                                    $car = Car::find($state);
                                    if ($car) {
                                        $set('otr_price', $car->price);
                                        self::calculateCredit($set, $get, $car->price);
                                    }
                                }
                            }),

                        Forms\Components\TextInput::make('variant_name')
                            ->label('Varian / Tipe')
                            ->placeholder('Contoh: Prime IVT / Signature HEV')
                            ->nullable(),

                        Forms\Components\TextInput::make('otr_price')
                            ->label('Harga OTR (Rp)')
                            ->numeric()
                            ->prefix('Rp')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, Set $set, Get $get) => self::calculateCredit($set, $get, $state)),

                        Forms\Components\TextInput::make('discount')
                            ->label('Diskon / Cashback Promo (Rp)')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, Set $set, Get $get) => self::calculateCredit($set, $get, null, $state)),

                        Forms\Components\Select::make('dp_percent')
                            ->label('Uang Muka (DP %)')
                            ->options([
                                10 => '10% (DP Promo Spesial)',
                                15 => '15%',
                                20 => '20% (Standar Leasing)',
                                25 => '25%',
                                30 => '30%',
                                40 => '40%',
                                50 => '50%',
                            ])
                            ->default(20)
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn ($state, Set $set, Get $get) => self::calculateCredit($set, $get)),

                        Forms\Components\TextInput::make('dp_amount')
                            ->label('Total DP Dibayar (TDP)')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),

                        Forms\Components\Select::make('tenor_months')
                            ->label('Jangka Waktu (Tenor)')
                            ->options([
                                12 => '1 Tahun (12 Bulan) - Bunga 2.99%',
                                24 => '2 Tahun (24 Bulan) - Bunga 3.25%',
                                36 => '3 Tahun (36 Bulan) - Bunga 3.50%',
                                48 => '4 Tahun (48 Bulan) - Bunga 3.99%',
                                60 => '5 Tahun (60 Bulan) - Bunga 4.50%',
                                72 => '6 Tahun (72 Bulan) - Bunga 5.25%',
                                84 => '7 Tahun (84 Bulan) - Bunga 5.75%',
                            ])
                            ->default(36)
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn ($state, Set $set, Get $get) => self::calculateCredit($set, $get)),

                        Forms\Components\TextInput::make('monthly_installment')
                            ->label('Estimasi Angsuran per Bulan')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),

                        Forms\Components\Select::make('insurance_type')
                            ->label('Jenis Asuransi')
                            ->options([
                                'all_risk' => 'All Risk Full Tenor',
                                'combination' => 'Kombinasi (1 Th All Risk, Sisa TLO)',
                                'tlo' => 'Total Loss Only (TLO)',
                            ])
                            ->default('all_risk')
                            ->required(),

                        Forms\Components\Textarea::make('notes')
                            ->label('Bonus & Catatan Tambahan Penawaran')
                            ->placeholder('Contoh: Free Kaca Film Smith, Free Karpet Original, Free Service & Sparepart 4 Th, Souvenir Spesial')
                            ->columnSpanFull(),
                    ])->columns(3),
            ]);
    }

    protected static function calculateCredit(Set $set, Get $get, $customOtr = null, $customDisc = null): void
    {
        $otr = (float) ($customOtr ?? $get('otr_price') ?? 0);
        $discount = (float) ($customDisc ?? $get('discount') ?? 0);
        $dpPercent = (int) ($get('dp_percent') ?? 20);
        $tenor = (int) ($get('tenor_months') ?? 36);

        $netPrice = max(0, $otr - $discount);
        $dpAmount = ($dpPercent / 100) * $netPrice;
        $set('dp_amount', round($dpAmount));

        $principal = $netPrice - $dpAmount;
        $annualRate = match(true) {
            $tenor <= 12 => 0.0299,
            $tenor <= 24 => 0.0325,
            $tenor <= 36 => 0.0350,
            $tenor <= 48 => 0.0399,
            $tenor <= 60 => 0.0450,
            default => 0.0525,
        };

        $years = $tenor / 12;
        $totalInterest = $principal * $annualRate * $years;
        $monthly = $tenor > 0 ? ($principal + $totalInterest) / $tenor : 0;

        $set('monthly_installment', round($monthly));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('quotation_number')
                    ->label('No. SPH')
                    ->searchable()
                    ->weight('bold')
                    ->copyable(),

                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Nama Customer')
                    ->searchable(),

                Tables\Columns\TextColumn::make('customer_phone')
                    ->label('WhatsApp')
                    ->copyable()
                    ->icon('heroicon-m-phone'),

                Tables\Columns\TextColumn::make('car.name')
                    ->label('Unit Kendaraan')
                    ->badge()
                    ->color('info')
                    ->searchable(),

                Tables\Columns\TextColumn::make('otr_price')
                    ->label('Harga OTR')
                    ->money('IDR', locale: 'id'),

                Tables\Columns\TextColumn::make('dp_amount')
                    ->label('Total DP')
                    ->money('IDR', locale: 'id'),

                Tables\Columns\TextColumn::make('monthly_installment')
                    ->label('Angsuran/Bln')
                    ->money('IDR', locale: 'id')
                    ->weight('bold')
                    ->color('success'),

                Tables\Columns\TextColumn::make('tenor_months')
                    ->label('Tenor')
                    ->formatStateUsing(fn ($state) => ($state / 12) . ' Tahun (' . $state . ' Bln)'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Buat')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->actions([
                // Buka / Print PDF SPH
                Tables\Actions\Action::make('print_sph')
                    ->label('Cetak / PDF')
                    ->icon('heroicon-o-printer')
                    ->color('primary')
                    ->url(fn (Quotation $record) => route('quotation', [
                        'car_id' => $record->car_id,
                        'customer_name' => $record->customer_name,
                        'dp_percent' => $record->dp_percent,
                        'tenor' => $record->tenor_months,
                        'insurance' => $record->insurance_type,
                        'discount' => $record->discount,
                    ]))
                    ->openUrlInNewTab(),

                // Kirim SPH via WhatsApp
                Tables\Actions\Action::make('send_wa')
                    ->label('Kirim WA')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->color('success')
                    ->url(function (Quotation $record) {
                        $phone = $record->clean_phone;
                        $sphUrl = route('quotation', [
                            'car_id' => $record->car_id,
                            'customer_name' => $record->customer_name,
                            'dp_percent' => $record->dp_percent,
                            'tenor' => $record->tenor_months,
                            'insurance' => $record->insurance_type,
                            'discount' => $record->discount,
                        ]);
                        $text = "Halo Bapak/Ibu {$record->customer_name}, perkenalkan saya Nico dari Dealer Resmi Hyundai Gowa HR Muhammad Surabaya.\n\nBerikut terlampir Surat Penawaran Harga (SPH) resmi untuk unit *{$record->car?->name}*:\n\n• Harga OTR: Rp " . number_format($record->otr_price, 0, ',', '.') . "\n• Total DP: Rp " . number_format($record->dp_amount, 0, ',', '.') . " (" . $record->dp_percent . "%)\n• Angsuran: Rp " . number_format($record->monthly_installment, 0, ',', '.') . "/bln (" . ($record->tenor_months / 12) . " Tahun)\n\nAnda dapat melihat & mengunduh dokumen penawaran resminya di tautan berikut:\n{$sphUrl}\n\nMohon kabari jika ada yang perlu disesuaikan ya Pak/Bu. Terima kasih!";
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
            'index' => Pages\ListQuotations::route('/'),
            'create' => Pages\CreateQuotation::route('/create'),
            'edit' => Pages\EditQuotation::route('/{record}/edit'),
        ];
    }
}
