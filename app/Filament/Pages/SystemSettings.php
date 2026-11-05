<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Models\Car;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

class SystemSettings extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'System Settings';
    protected static ?string $navigationGroup = 'System Control';
    protected static ?int $navigationSort = 2;
    protected static ?string $title = 'System & AI Settings';
    protected static ?string $slug = 'system-settings';
    protected static string $view = 'filament.pages.system-settings';
    
    // Menu ini muncul untuk role developer dan sales (client)
    public static function shouldRegisterNavigation(): bool
    {
        return in_array(auth()->user()?->role, ['developer', 'sales']);
    }

    public ?array $data = [];

    public function mount(): void
    {
        $encryptedKey = Setting::get('ai_api_key');
        $decryptedKey = '';
        if ($encryptedKey) {
            try {
                $decryptedKey = Crypt::decryptString($encryptedKey);
            } catch (\Exception $e) {
                $decryptedKey = '';
            }
        }

        $savedEv = Setting::getJson('ev_calculator_models', null);
        if (empty($savedEv)) {
            $savedEv = [
                [
                    'name' => 'Hyundai IONIQ 5',
                    'badge' => 'Paling Populer',
                    'range' => 'Up to 481 KM',
                    'efficiency' => 6.5,
                    'tagline' => 'The Iconic Retro-Futuristic Crossover EV',
                ],
                [
                    'name' => 'All New KONA Electric',
                    'badge' => 'Jarak Tempuh Juara',
                    'range' => 'Up to 602 KM (Terjauh)',
                    'efficiency' => 7.2,
                    'tagline' => 'Smart Urban All-Electric Compact SUV',
                ],
                [
                    'name' => 'Hyundai IONIQ 6',
                    'badge' => 'Flagship Luxury',
                    'range' => 'Up to 519 KM',
                    'efficiency' => 7.6,
                    'tagline' => 'Electrified Streamliner Ultra-Aerodynamic',
                ],
            ];
        }

        $featuredTestDriveIds = Setting::getJson('featured_test_drive_car_ids', []);

        $this->form->fill([
            'site_name' => Setting::get('site_name', 'Hyundai Showroom'),
            'site_logo' => Setting::get('site_logo'),
            'featured_test_drive_car_ids' => $featuredTestDriveIds,
            'ev_calculator_models' => $savedEv,
            'ai_provider' => Setting::get('ai_provider', 'gemini'),
            'ai_model' => Setting::get('ai_model', 'gemini-1.5-flash'),
            'ai_api_key' => $decryptedKey,
            'ai_system_prompt' => Setting::get('ai_system_prompt', 'Anda adalah Sales Consultant AI resmi dari Hyundai Gowa Surabaya (Nico - 0813-3013-5013). Berikan jawaban yang ramah, profesional, dan meyakinkan tentang spesifikasi mobil, promo OTR Surabaya, estimasi DP dan cicilan kredit, serta arahkan calon pembeli untuk Booking Test Drive atau chat WhatsApp Sales.'),
            'google_ads_id' => Setting::get('google_ads_id', ''),
            'google_tag_manager_id' => Setting::get('google_tag_manager_id', ''),
            'meta_pixel_id' => Setting::get('meta_pixel_id', ''),
            'google_site_verification' => Setting::get('google_site_verification', ''),
            'meta_title' => Setting::get('meta_title', 'Promo Hyundai Surabaya 2026 - Dealer Resmi Hyundai Gowa HR Muhammad (Nico)'),
            'meta_description' => Setting::get('meta_description', 'Promo diskon mobil baru Hyundai Surabaya, DP mulai 10%, bunga 0%, garansi baterai EV 8 tahun, dan tukar tambah semua merek mobil. Hubungi Nico 0813-3013-5013.'),
            'meta_keywords' => Setting::get('meta_keywords', 'hyundai surabaya, dealer hyundai hr muhammad, promo hyundai gowa surabaya, kredit stargazer surabaya, harga creta surabaya, palisade surabaya'),
            'dealer_address' => Setting::get('dealer_address', 'Jl. Mayjen HR. Muhammad No.35C, Sonokwijenan, Kec. Sukomanunggal, Surabaya, Jawa Timur 60189'),
            'dealer_maps_url' => Setting::get('dealer_maps_url', 'https://maps.app.goo.gl/wJk4zXpG8M8GzK2T6'),
            'geo_coordinates' => Setting::get('geo_coordinates', '-7.2847, 112.7001'),
            'lead_modal_enabled' => (bool) Setting::get('lead_modal_enabled', true),
            'telegram_notifications_enabled' => (bool) Setting::get('telegram_notifications_enabled', false),
            'telegram_bot_token' => Setting::get('telegram_bot_token', ''),
            'telegram_chat_id' => Setting::get('telegram_chat_id', ''),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Branding')
                    ->description('Atur identitas utama website di sini.')
                    ->visible(fn () => auth()->user()?->role === 'developer')
                    ->schema([
                        TextInput::make('site_name')
                            ->label('Nama Showroom / Brand')
                            ->required()
                            ->placeholder('Contoh: Hyundai Gowa Surabaya'),
                        FileUpload::make('site_logo')
                            ->label('Logo Utama')
                            ->image()
                            ->directory('settings')
                            ->helperText('Gunakan logo transparan (PNG) untuk hasil terbaik.'),
                    ])->columns(2),

                Section::make('AutoShow AI Engine & Perintah AI')
                    ->description('Hubungkan website dengan model AI (OpenRouter atau Google Gemini) dan berikan instruksi/perintah spesifik untuk asisten AI.')
                    ->schema([
                        Select::make('ai_provider')
                            ->label('Pilihan AI Provider')
                            ->options([
                                'openrouter' => 'OpenRouter (Llama 3, Qwen, DeepSeek, Mistral)',
                                'gemini' => 'Google Gemini (Gemini 1.5 Flash / Pro)',
                                'disabled' => 'Nonaktifkan AI',
                            ])
                            ->required()
                            ->reactive(),
                        TextInput::make('ai_model')
                            ->label('Model AI')
                            ->placeholder('Contoh: gemini-1.5-flash atau openrouter/free')
                            ->helperText('Untuk Gemini: gemini-1.5-flash | Untuk OpenRouter: openrouter/free atau meta-llama/llama-3-8b-instruct')
                            ->required(fn ($get) => $get('ai_provider') !== 'disabled')
                            ->visible(fn ($get) => $get('ai_provider') !== 'disabled'),
                        TextInput::make('ai_api_key')
                            ->label('API Key')
                            ->password()
                            ->placeholder('Masukkan API Key Anda')
                            ->helperText('Biarkan kosong jika ingin menggunakan API Key default dari sistem (.env)')
                            ->visible(fn ($get) => $get('ai_provider') !== 'disabled'),
                        \Filament\Forms\Components\Textarea::make('ai_system_prompt')
                            ->label('Perintah / Instruksi AI (System Prompt)')
                            ->placeholder('Tuliskan kepribadian bot, target promo, cara menyapa pelanggan, dan arahan penjualan...')
                            ->helperText('Instruksi ini akan digunakan oleh AI saat merespons pertanyaan pengunjung di website.')
                            ->rows(5)
                            ->columnSpanFull()
                            ->visible(fn ($get) => $get('ai_provider') !== 'disabled'),
                    ])->columns(3),

                Section::make('Tampilan Fitur Unggulan (Test Drive & Kalkulator EV)')
                    ->description('Pilih mobil apa saja yang ingin ditampilkan di kartu "Unit Populer Test Drive" dan "Kalkulator Hemat Listrik vs Bensin".')
                    ->schema([
                        Select::make('featured_test_drive_car_ids')
                            ->label('Pilihan Unit Populer Siap Test Drive')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->options(fn () => Car::where('is_available', true)->pluck('name', 'id'))
                            ->helperText('Pilih unit mobil yang ingin ditampilkan di halaman /test-drive pada kartu "Unit Populer Siap Test Drive". Jika dikosongkan, sistem akan otomatis menampilkan 6 unit terpopuler.')
                            ->columnSpanFull(),

                        Repeater::make('ev_calculator_models')
                            ->label('Daftar Mobil Listrik pada Kalkulator Hemat EV')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama Unit EV')
                                    ->placeholder('Contoh: Hyundai IONIQ 5 / IONIQ 9')
                                    ->required()
                                    ->columnSpan(2),
                                TextInput::make('badge')
                                    ->label('Label / Badge')
                                    ->placeholder('Contoh: Paling Populer / Flagship Luxury')
                                    ->columnSpan(2),
                                TextInput::make('range')
                                    ->label('Jarak Tempuh')
                                    ->placeholder('Contoh: Up to 500 KM')
                                    ->required()
                                    ->columnSpan(2),
                                TextInput::make('efficiency')
                                    ->label('Efisiensi (KM/kWh)')
                                    ->numeric()
                                    ->default(6.5)
                                    ->helperText('1 kWh = ... km')
                                    ->required()
                                    ->columnSpan(1),
                                TextInput::make('tagline')
                                    ->label('Tagline Singkat')
                                    ->placeholder('Contoh: The Iconic Retro-Futuristic Crossover EV')
                                    ->columnSpan(3),
                            ])
                            ->columns(5)
                            ->defaultItems(3)
                            ->createItemButtonLabel('Tambah Mobil Listrik ke Kalkulator')
                            ->reorderable()
                            ->collapsible()
                            ->columnSpanFull()
                            ->helperText('Mobil listrik di atas akan muncul sebagai pilihan di fitur "Kalkulator Hemat Listrik vs Bensin" di halaman depan.'),
                    ]),

                Section::make('Digital Marketing, Google Ads & SEO Engine')
                    ->description('Kelola ID pelacakan iklan Google Ads, GTM, Meta Pixel, serta judul dan deskripsi SEO untuk mendatangkan banyak calon pembeli.')
                    ->schema([
                        TextInput::make('google_ads_id')
                            ->label('Google Ads Tag / Conversion ID')
                            ->placeholder('Contoh: AW-123456789')
                            ->helperText('Pelacakan konversi resmi dari kampanye iklan Google Ads.'),
                        TextInput::make('google_tag_manager_id')
                            ->label('Google Tag Manager (GTM)')
                            ->placeholder('Contoh: GTM-ABC1234')
                            ->helperText('Untuk mengelola semua pixel dan event tracking terpusat.'),
                        TextInput::make('meta_pixel_id')
                            ->label('Meta Pixel ID (Facebook / Instagram)')
                            ->placeholder('Contoh: 123456789012345')
                            ->helperText('Pelacakan pengunjung dari iklan Instagram & Facebook Ads.'),
                        TextInput::make('google_site_verification')
                            ->label('Google Search Console Verification Tag')
                            ->placeholder('Contoh: google-site-verification=abc123xyz')
                            ->helperText('Untuk memverifikasi kepemilikan website di Google Search Console.'),
                        TextInput::make('meta_title')
                            ->label('Judul SEO Website (Title Tag)')
                            ->required()
                            ->columnSpanFull(),
                        \Filament\Forms\Components\Textarea::make('meta_description')
                            ->label('Deskripsi SEO (Meta Description)')
                            ->rows(2)
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('meta_keywords')
                            ->label('Target Kata Kunci (Keywords)')
                            ->placeholder('Pisahkan dengan koma')
                            ->columnSpanFull(),
                        TextInput::make('dealer_address')
                            ->label('Alamat Fisik Showroom / Dealer (Local NAP)')
                            ->placeholder('Jl. Mayjen HR. Muhammad No.35C, Sonokwijenan, Kec. Sukomanunggal, Surabaya, Jawa Timur 60189')
                            ->helperText('Pastikan persis sama dengan alamat di Google Maps profil dealer.')
                            ->columnSpanFull(),
                        TextInput::make('dealer_maps_url')
                            ->label('Tautan Google Maps Titik Showroom')
                            ->url()
                            ->placeholder('https://maps.app.goo.gl/...')
                            ->helperText('Link langsung ke Google Maps untuk navigasi dan sinyal Local SEO.')
                            ->columnSpan(1),
                        TextInput::make('geo_coordinates')
                            ->label('Koordinat Titik GPS (Latitude, Longitude)')
                            ->placeholder('-7.2847, 112.7001')
                            ->helperText('Koordinat lokasi untuk Geo Tag lokal Surabaya.')
                            ->columnSpan(1),
                        \Filament\Forms\Components\Toggle::make('lead_modal_enabled')
                            ->label('Aktifkan Pop-up Penawaran Promo & Lead Magnet Otomatis')
                            ->default(true)
                            ->helperText('Menampilkan form klaim promo diskon & simulasi cicilan khusus untuk meningkatkan konversi prospek.')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Notifikasi Instan Telegram Bot (Speed-to-Lead Alert)')
                    ->description('Dapatkan pesan bot otomatis di HP setiap kali ada calon pembeli yang booking test drive, trade-in, atau mengajukan simulasi kredit.')
                    ->schema([
                        \Filament\Forms\Components\Toggle::make('telegram_notifications_enabled')
                            ->label('Aktifkan Notifikasi Telegram')
                            ->default(false)
                            ->reactive()
                            ->columnSpanFull(),
                        TextInput::make('telegram_bot_token')
                            ->label('Bot Token Telegram')
                            ->password()
                            ->placeholder('Contoh: 123456789:ABCdefGhI...')
                            ->helperText('Buat bot dan dapatkan token dari @BotFather di aplikasi Telegram.')
                            ->visible(fn ($get) => (bool) $get('telegram_notifications_enabled')),
                        TextInput::make('telegram_chat_id')
                            ->label('Chat ID / Group ID Penerima')
                            ->placeholder('Contoh: 987654321')
                            ->helperText('Cek ID akun Telegram Anda melalui bot @userinfobot.')
                            ->visible(fn ($get) => (bool) $get('telegram_notifications_enabled')),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        if (auth()->user()?->role === 'sales') {
            // Khusus client/sales, simpan field AI dan Marketing
            $allowedKeys = [
                'ai_provider', 'ai_model', 'ai_api_key', 'ai_system_prompt',
                'google_ads_id', 'google_tag_manager_id', 'meta_pixel_id',
                'google_site_verification', 'meta_title', 'meta_description',
                'meta_keywords', 'dealer_address', 'dealer_maps_url', 'geo_coordinates', 'lead_modal_enabled',
                'telegram_notifications_enabled', 'telegram_bot_token', 'telegram_chat_id',
                'featured_test_drive_car_ids', 'ev_calculator_models'
            ];
            foreach ($allowedKeys as $key) {
                if (array_key_exists($key, $data)) {
                    $value = $data[$key];
                    if ($key === 'ai_api_key') {
                        if (empty($value)) {
                            Setting::where('key', 'ai_api_key')->delete();
                            continue;
                        } else {
                            $value = Crypt::encryptString($value);
                        }
                    } elseif (is_array($value)) {
                        $value = json_encode($value, JSON_UNESCAPED_UNICODE);
                    }
                    Setting::updateOrCreate(
                        ['key' => $key],
                        ['value' => $value]
                    );
                }
            }
        } else {
            // Untuk developer, simpan semua setelan
            foreach ($data as $key => $value) {
                if ($key === 'ai_api_key') {
                    if (empty($value)) {
                        Setting::where('key', 'ai_api_key')->delete();
                        continue;
                    } else {
                        $value = Crypt::encryptString($value);
                    }
                } elseif (is_array($value)) {
                    $value = json_encode($value, JSON_UNESCAPED_UNICODE);
                }

                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }
        }

        // Hapus cache AI insights untuk user ini agar langsung memuat ulang setelan baru
        $userId = auth()->id() ?? 'guest';
        \Illuminate\Support\Facades\Cache::forget("ai_insights_user_{$userId}");

        Notification::make()
            ->success()
            ->title('Settings saved successfully!')
            ->send();
    }
}
