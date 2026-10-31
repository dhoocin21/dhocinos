<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Models\Car;
use App\Models\Consultant;
use App\Models\Lead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Inventory & Sales';
    protected static ?string $navigationLabel = 'Manajemen Leads & Prospek';
    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        $count = Lead::where('status', 'new')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Prospek')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Calon Pembeli')
                            ->required(),
                        Forms\Components\TextInput::make('whatsapp')
                            ->label('Nomor WhatsApp')
                            ->tel()
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email(),
                        Forms\Components\Select::make('car_id')
                            ->label('Unit Minat')
                            ->relationship('car', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('purchase_type')
                            ->label('Rencana Pembelian')
                            ->options([
                                'credit' => 'Kredit (Cicilan / DP Ringan)',
                                'cash' => 'Cash / Tunai',
                                'trade_in' => 'Tukar Tambah (Trade-In)',
                            ]),
                        Forms\Components\Select::make('lead_type')
                            ->label('Kategori Pengajuan')
                            ->options([
                                'consultation' => 'Konsultasi Promo / Web',
                                'credit' => 'Kalkulator Kredit',
                                'trade_in' => 'Kalkulator Trade-In',
                                'quotation' => 'Unduh E-Quotation PDF',
                                'test_drive' => 'Pengajuan Test Drive',
                                'promo' => 'Klaim Voucher Promo',
                            ]),
                        Forms\Components\Select::make('status')
                            ->label('Status Follow-Up')
                            ->options([
                                'new' => 'Baru (Belum Dihubungi)',
                                'contacted' => 'Sudah Dihubungi',
                                'prospect' => 'Prospek Serius',
                                'test_drive' => 'Jadwal Test Drive',
                                'spk' => 'SPK / Closing Deal',
                                'lost' => 'Batal / Tidak Berminat',
                            ])
                            ->default('new')
                            ->required(),
                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan Khusus Sales')
                            ->placeholder('Contoh: Mau test drive hari Sabtu di rumah, budget DP 50jt')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Data Pelacakan Digital & Iklan (Google / Meta Ads)')
                    ->collapsed()
                    ->schema([
                        Forms\Components\TextInput::make('utm_source')
                            ->label('Sumber Traffic / Ads')
                            ->disabled(),
                        Forms\Components\TextInput::make('utm_medium')
                            ->label('Medium Iklan')
                            ->disabled(),
                        Forms\Components\TextInput::make('utm_campaign')
                            ->label('Nama Kampanye Iklan')
                            ->disabled(),
                        Forms\Components\TextInput::make('gclid')
                            ->label('Google Click ID (GCLID)')
                            ->disabled(),
                        Forms\Components\TextInput::make('ip_address')
                            ->label('IP Pengunjung')
                            ->disabled(),
                        Forms\Components\TextInput::make('region')
                            ->label('Wilayah Asal')
                            ->disabled(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Prospek')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('whatsapp')
                    ->label('WhatsApp')
                    ->copyable()
                    ->searchable()
                    ->icon('heroicon-m-phone'),

                Tables\Columns\TextColumn::make('car_name')
                    ->label('Unit Minat')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->default(fn ($record) => $record->car?->name ?? 'Konsultasi'),

                Tables\Columns\TextColumn::make('purchase_type')
                    ->label('Rencana')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match($state) {
                        'credit' => 'Kredit',
                        'cash' => 'Cash',
                        'trade_in' => 'Tukar Tambah',
                        default => $state ?? 'Kredit'
                    })
                    ->color(fn ($state) => match($state) {
                        'credit' => 'primary',
                        'cash' => 'success',
                        'trade_in' => 'warning',
                        default => 'gray'
                    }),

                Tables\Columns\SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'new' => '🔴 Baru',
                        'contacted' => '🔵 Dihubungi',
                        'prospect' => '🟡 Prospek Serius',
                        'test_drive' => '🟣 Test Drive',
                        'spk' => '🟢 SPK / Closing',
                        'lost' => '⚪ Batal',
                    ]),

                Tables\Columns\TextColumn::make('utm_source')
                    ->label('Sumber Ads')
                    ->badge()
                    ->color(fn ($state) => match(strtolower($state ?? '')) {
                        'google' => 'danger',
                        'facebook', 'meta', 'instagram' => 'primary',
                        'tiktok' => 'gray',
                        default => 'info'
                    })
                    ->default('Direct / Web'),

                Tables\Columns\TextColumn::make('region')
                    ->label('Wilayah')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Masuk')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'new' => 'Baru (Belum Dihubungi)',
                        'contacted' => 'Sudah Dihubungi',
                        'prospect' => 'Prospek Serius',
                        'test_drive' => 'Jadwal Test Drive',
                        'spk' => 'SPK / Closing Deal',
                        'lost' => 'Batal',
                    ]),
                Tables\Filters\SelectFilter::make('purchase_type')
                    ->label('Filter Rencana Beli')
                    ->options([
                        'credit' => 'Kredit',
                        'cash' => 'Cash',
                        'trade_in' => 'Tukar Tambah',
                    ]),
                Tables\Filters\SelectFilter::make('utm_source')
                    ->label('Filter Sumber Iklan')
                    ->options([
                        'google' => 'Google Ads / Search',
                        'facebook' => 'Facebook Ads',
                        'instagram' => 'Instagram Ads',
                        'tiktok' => 'TikTok',
                        'direct' => 'Langsung (Direct)',
                    ]),
            ])
            ->actions([
                // 1-Click WhatsApp Follow-up Modal with 4 smart sales templates
                Tables\Actions\Action::make('chat_wa')
                    ->label('Follow-Up WA')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->color('success')
                    ->modalHeading(fn (Lead $record) => "Kirim WhatsApp Follow-Up: {$record->name}")
                    ->modalDescription('Pilih template pesan resmi Hyundai atau sesuaikan teks sebelum dikirim.')
                    ->modalSubmitActionLabel('Kirim via WhatsApp')
                    ->form([
                        Forms\Components\Select::make('template')
                            ->label('Pilih Template Follow-Up')
                            ->options([
                                'greeting' => '1. Sapaan Awal & Ketersediaan Unit',
                                'promo' => '2. Penawaran Promo & Simulasi DP Ringan',
                                'test_drive' => '3. Undangan Test Drive (Rumah / Showroom)',
                                'spk' => '4. Follow-Up Penutupan SPK & Bonus Spesial',
                            ])
                            ->default('greeting')
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set, $record) {
                                $unit = $record->car_name ?: ($record->car?->name ?? 'mobil Hyundai');
                                $message = match($state) {
                                    'promo' => "Halo Bapak/Ibu {$record->name}, saya Nico dari Hyundai Gowa HR Muhammad Surabaya.\n\nKebetulan minggu ini kami sedang ada *Program Promo Spesial* untuk unit *{$unit}* dengan subsidi DP ringan, bunga 0%, dan free asuransi.\n\nBoleh saya buatkan rincian simulasi kredit terbaiknya untuk Anda?",
                                    'test_drive' => "Halo Bapak/Ibu {$record->name}, saya Nico dari Hyundai HR Muhammad Surabaya.\n\nApakah Bapak/Ibu ada waktu luang akhir pekan ini untuk mencoba langsung kenyamanan berkendara unit *{$unit}*? Mobil test drive bisa kami bawakan langsung ke rumah/kantor Anda secara gratis.",
                                    'spk' => "Halo Bapak/Ibu {$record->name}, salam hangat dari Nico Hyundai Gowa HR Muhammad.\n\nMengingat alokasi unit *{$unit}* promo bulan ini tinggal sedikit, jika berkenan kami siap bantu proses pemesanan (SPK) dengan tambahan bonus aksesoris eksklusif khusus untuk Anda hari ini.",
                                    default => "Halo Bapak/Ibu {$record->name}, terima kasih telah menghubungi Hyundai Gowa Surabaya.\n\nTerkait minat Anda pada unit *{$unit}*, perkenalkan saya Nico siap membantu konsultasi spesifikasi, ketersediaan warna unit, dan penawaran diskon terbaiknya.\n\nApakah ada hal khusus yang ingin ditanyakan terkait unit {$unit}?",
                                };
                                $set('message_text', $message);
                            }),

                        Forms\Components\Textarea::make('message_text')
                            ->label('Isi Pesan WhatsApp (Dapat Diedit Bebas)')
                            ->rows(6)
                            ->default(function ($record) {
                                $unit = $record->car_name ?: ($record->car?->name ?? 'mobil Hyundai');
                                return "Halo Bapak/Ibu {$record->name}, terima kasih telah menghubungi Hyundai Gowa Surabaya.\n\nTerkait minat Anda pada unit *{$unit}*, perkenalkan saya Nico siap membantu konsultasi spesifikasi, ketersediaan warna unit, dan penawaran diskon terbaiknya.\n\nApakah ada hal khusus yang ingin ditanyakan terkait unit {$unit}?";
                            })
                            ->required(),
                    ])
                    ->action(function (Lead $record, array $data) {
                        $phone = $record->clean_whatsapp;
                        $text = urlencode($data['message_text']);
                        if ($record->status === 'new') {
                            $record->update(['status' => 'contacted']);
                        }
                        return redirect()->away("https://wa.me/{$phone}?text={$text}");
                    }),

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
            'index' => Pages\ListLeads::route('/'),
        ];
    }
}
