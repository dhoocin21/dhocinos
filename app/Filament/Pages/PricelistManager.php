<?php

namespace App\Filament\Pages;

use App\Models\Car;
use App\Services\AiService;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class PricelistManager extends Page
{
    use WithFileUploads;

    protected static ?string $navigationIcon = 'heroicon-o-cloud-arrow-up';
    protected static ?string $navigationGroup = 'Inventory & Sales';
    protected static ?string $navigationLabel = 'Update Pricelist Otomatis';
    protected static ?int $navigationSort = 1;
    protected static ?string $title = 'Update Pricelist Otomatis (1-Click AI)';
    protected static ?string $slug = 'update-pricelist';
    protected static string $view = 'filament.pages.pricelist-manager';

    public $pricelistFile;
    public bool $isExtracting = false;
    public array $pendingAdjustments = [];
    public ?string $uploadedFileName = null;
    public ?string $analysisSummary = null;
    public array $currentCars = [];

    public function mount(): void
    {
        $this->loadCurrentCars();
    }

    public function loadCurrentCars(): void
    {
        $this->currentCars = Car::orderBy('name')
            ->get(['id', 'name', 'category', 'price', 'image', 'variants', 'updated_at'])
            ->toArray();
    }

    /**
     * Analyze uploaded flyer image or PDF with AI Vision
     */
    public function analyzeUploadedPricelist(): void
    {
        $this->validate([
            'pricelistFile' => 'required|file|mimes:jpg,jpeg,png,webp,pdf|max:12288',
        ]);

        $this->isExtracting = true;

        try {
            $path = $this->pricelistFile->getRealPath();
            $mime = $this->pricelistFile->getMimeType();
            $this->uploadedFileName = $this->pricelistFile->getClientOriginalName();

            // Store permanent archival copy
            $storedName = 'pricelist_' . date('Ymd_His') . '.' . $this->pricelistFile->getClientOriginalExtension();
            $this->pricelistFile->storeAs('public/pricelists', $storedName);

            /** @var AiService $aiService */
            $aiService = app(AiService::class);
            $extractedUnits = $aiService->extractPricelistFromImage($path, $mime);

            if (empty($extractedUnits)) {
                throw new \Exception('AI tidak dapat membaca data unit dari gambar/dokumen ini. Pastikan gambar jelas dan teks terbaca.');
            }

            $this->buildPendingAdjustments($extractedUnits);

            Notification::make()
                ->title('Analisis Brosur Selesai!')
                ->body('Ditemukan ' . count($this->pendingAdjustments) . ' unit kendaraan. Silakan periksa perbandingan harga di bawah, lalu klik "Konfirmasi & Terapkan".')
                ->success()
                ->send();

        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal Menganalisis Brosur')
                ->body($e->getMessage())
                ->danger()
                ->send();
        } finally {
            $this->isExtracting = false;
        }
    }

    /**
     * Load official Hyundai Gowa Surabaya brochure data directly into preview
     */
    public function loadOfficialBrochureData(): void
    {
        $officialData = [
            ['name' => 'STARGAZER Cartenz', 'category' => 'MPV', 'price' => 245800000, 'variants' => [
                ['name' => 'Trend MT', 'price' => 245800000],
                ['name' => 'Trend IVT', 'price' => 260800000],
                ['name' => 'Style IVT', 'price' => 275550000],
                ['name' => 'Smart Non HSS IVT', 'price' => 289350000],
                ['name' => 'Smart HSS IVT', 'price' => 299350000],
                ['name' => 'Prime Non HSS IVT', 'price' => 312350000],
                ['name' => 'Prime HSS IVT', 'price' => 322350000],
            ]],
            ['name' => 'STARGAZER Cartenz X', 'category' => 'MPV', 'price' => 354400000, 'variants' => [
                ['name' => 'Style IVT', 'price' => 354400000],
                ['name' => 'Prime Package IVT', 'price' => 389400000],
            ]],
            ['name' => 'STARGAZER', 'category' => 'MPV', 'price' => 260450000, 'variants' => [
                ['name' => 'Active+ MT Steel Wheel', 'price' => 260450000],
                ['name' => 'Active+ MT', 'price' => 262950000],
                ['name' => 'Active+ IVT Steel Wheel', 'price' => 273800000],
                ['name' => 'Active+ IVT', 'price' => 276300000],
                ['name' => 'Essential MT', 'price' => 275050000],
                ['name' => 'Essential IVT', 'price' => 286750000],
            ]],
            ['name' => 'CRETA', 'category' => 'SUV', 'price' => 312650000, 'variants' => [
                ['name' => 'Active 1.5 MT', 'price' => 312650000],
                ['name' => 'Trend 1.5 MT', 'price' => 345450000],
                ['name' => 'Trend 1.5 IVT', 'price' => 366500000],
                ['name' => 'Style 1.5 IVT', 'price' => 412200000],
                ['name' => 'Prime 1.5 IVT 1 Tone', 'price' => 443350000],
                ['name' => 'Alpha', 'price' => 459850000],
            ]],
            ['name' => 'CRETA N Line', 'category' => 'SUV', 'price' => 477850000, 'variants' => [
                ['name' => 'N Line', 'price' => 477850000],
                ['name' => 'Turbo', 'price' => 525850000],
            ]],
            ['name' => 'PALISADE', 'category' => 'SUV', 'price' => 952800000, 'variants' => [
                ['name' => 'Prime', 'price' => 952800000],
                ['name' => 'Signature', 'price' => 1098700000],
                ['name' => 'Signature XRT', 'price' => 1127600000],
                ['name' => 'Signature 4WD XRT', 'price' => 1268500000],
            ]],
            ['name' => 'The all-new PALISADE Hybrid', 'category' => 'HEV', 'price' => 1136600000, 'variants' => [
                ['name' => 'Signature', 'price' => 1136600000],
                ['name' => 'Calligraphy', 'price' => 1309400000],
                ['name' => 'Calligraphy AWD', 'price' => 1396500000],
            ]],
            ['name' => 'SANTA FE HEV', 'category' => 'HEV', 'price' => 740500000, 'variants' => [
                ['name' => 'G 2.5 6AT Prime', 'price' => 740500000],
                ['name' => 'G 2.5 6AT Calligraphy', 'price' => 830000000],
                ['name' => 'HEV Prime', 'price' => 832100000],
                ['name' => 'HEV Calligraphy', 'price' => 919400000],
                ['name' => 'HEV XRT', 'price' => 937100000],
            ]],
            ['name' => 'STARIA', 'category' => 'Luxury MPV', 'price' => 966700000, 'variants' => [
                ['name' => '9 Seaters Signature', 'price' => 966700000],
                ['name' => '7 Seaters Signature', 'price' => 1107500000],
            ]],
            ['name' => 'IONIQ 5', 'category' => 'EV', 'price' => 813500000, 'variants' => [
                ['name' => 'Prime Standard Range', 'price' => 813500000],
                ['name' => 'Prime Long Range', 'price' => 856500000],
                ['name' => 'Signature Standard Range', 'price' => 878900000],
                ['name' => 'Signature Long Range', 'price' => 930600000],
            ]],
            ['name' => 'KONA Electric', 'category' => 'EV', 'price' => 570250000, 'variants' => [
                ['name' => 'Style', 'price' => 570250000],
                ['name' => 'Prime Standard Range', 'price' => 588500000],
                ['name' => 'Prime Long Range', 'price' => 639500000],
                ['name' => 'Signature Standard Range', 'price' => 656650000],
                ['name' => 'Signature Long Range', 'price' => 673550000],
                ['name' => 'N Line', 'price' => 694550000],
            ]],
            ['name' => 'IONIQ 9', 'category' => 'EV', 'price' => 1547000000, 'variants' => [
                ['name' => 'Calligraphy AWD 6P Swivel Seat', 'price' => 1547000000],
                ['name' => 'Calligraphy AWD 6P Power Seat', 'price' => 1557000000],
            ]],
        ];

        $this->uploadedFileName = 'Brosur_Resmi_Hyundai_Gowa_Surabaya.jpg';
        $this->buildPendingAdjustments($officialData);

        Notification::make()
            ->title('Data Brosur Resmi Siap Ditinjau')
            ->body('Data brosur resmi Hyundai Gowa Surabaya telah dimuat ke tabel perbandingan. Silakan periksa lalu tekan tombol Konfirmasi.')
            ->info()
            ->send();
    }

    /**
     * Map extracted units against database cars to generate diff
     */
    protected function buildPendingAdjustments(array $extractedUnits): void
    {
        $adjustments = [];

        foreach ($extractedUnits as $item) {
            if (empty($item['name'])) continue;

            $itemName = trim($item['name']);
            $newPrice = (float) ($item['price'] ?? 0);
            $variants = is_array($item['variants'] ?? null) ? $item['variants'] : [];

            // Find matching car in DB with high precision
            $car = $this->findMatchingCar($itemName);

            $oldPrice = $car ? (float) $car->price : 0;
            $diff = $newPrice - $oldPrice;

            if (!$car) {
                $status = 'new';
            } elseif ($diff > 0) {
                $status = 'up';
            } elseif ($diff < 0) {
                $status = 'down';
            } else {
                $status = 'same';
            }

            $adjustments[] = [
                'name' => $car ? $car->name : $itemName,
                'detected_name' => $itemName,
                'car_id' => $car ? $car->id : null,
                'category' => $car ? $car->category : ($item['category'] ?? 'SUV'),
                'image' => $car ? $car->image : null,
                'old_price' => $oldPrice,
                'new_price' => $newPrice,
                'diff' => $diff,
                'status' => $status,
                'variants' => $variants,
                'variants_count' => count($variants),
            ];
        }

        $this->pendingAdjustments = $adjustments;
    }

    /**
     * Precisely match extracted car names without cross-contamination.
     */
    protected function findMatchingCar(string $itemName): ?Car
    {
        $name = trim($itemName);

        // 1. Exact match
        $car = Car::where('name', $name)->first();
        if ($car) return $car;

        // 2. Exact slug match
        $car = Car::where('slug', Str::slug($name))->first();
        if ($car) return $car;

        // 3. Distinct Stargazer series matching
        if (stripos($name, 'Cartenz X') !== false || stripos($name, 'Cartenz-X') !== false) {
            return Car::where('name', 'LIKE', '%Cartenz X%')
                ->orWhere('name', 'LIKE', '%Cartenz-X%')
                ->orWhere('slug', 'LIKE', '%cartenz-x%')
                ->first();
        }

        if (stripos($name, 'Cartenz') !== false) {
            return Car::where(function($q) {
                    $q->where('name', 'LIKE', '%Cartenz%')
                      ->orWhere('slug', 'LIKE', '%cartenz%');
                })
                ->where('name', 'NOT LIKE', '%Cartenz X%')
                ->where('slug', 'NOT LIKE', '%cartenz-x%')
                ->first();
        }

        if (strcasecmp($name, 'STARGAZER') === 0 || stripos($name, 'STARGAZER') !== false) {
            $pureStargazer = Car::where('name', 'LIKE', '%STARGAZER%')
                ->where('name', 'NOT LIKE', '%Cartenz%')
                ->where('slug', 'NOT LIKE', '%cartenz%')
                ->first();
            if ($pureStargazer) return $pureStargazer;
        }

        // 4. Distinct Creta series matching
        if (stripos($name, 'N Line') !== false || stripos($name, 'N-Line') !== false) {
            return Car::where('name', 'LIKE', '%N Line%')
                ->orWhere('name', 'LIKE', '%N-Line%')
                ->orWhere('slug', 'LIKE', '%n-line%')
                ->first();
        }

        if (stripos($name, 'CRETA') !== false) {
            $pureCreta = Car::where('name', 'LIKE', '%CRETA%')
                ->where('name', 'NOT LIKE', '%N Line%')
                ->where('slug', 'NOT LIKE', '%n-line%')
                ->first();
            if ($pureCreta) return $pureCreta;
        }

        // 5. Distinct Palisade series matching
        if (stripos($name, 'Palisade HEV') !== false || stripos($name, 'Palisade Hybrid') !== false || stripos($name, 'all-new-palisade-hybrid') !== false) {
            return Car::where('name', 'LIKE', '%PALISADE HEV%')
                ->orWhere('name', 'LIKE', '%PALISADE Hybrid%')
                ->orWhere('name', 'LIKE', '%The all-new PALISADE%')
                ->orWhere('slug', 'LIKE', '%palisade-hev%')
                ->orWhere('slug', 'LIKE', '%all-new-palisade-hybrid%')
                ->first();
        }

        if (stripos($name, 'PALISADE') !== false) {
            $purePalisade = Car::where('name', 'LIKE', '%PALISADE%')
                ->where('name', 'NOT LIKE', '%HEV%')
                ->where('slug', 'NOT LIKE', '%hev%')
                ->first();
            if ($purePalisade) return $purePalisade;
        }

        // 6. Santa Fe
        if (stripos($name, 'Santa Fe') !== false) {
            return Car::where('name', 'LIKE', '%Santa Fe%')->first();
        }

        // 7. General fallback
        return Car::where('name', 'LIKE', '%' . $name . '%')->first();
    }

    /**
     * Confirmed by user: Write all adjustments to DB and update website
     */
    public function confirmAndApply(): void
    {
        if (empty($this->pendingAdjustments)) {
            Notification::make()
                ->title('Tidak Ada Perubahan')
                ->body('Silakan upload atau muat data brosur terlebih dahulu.')
                ->warning()
                ->send();
            return;
        }

        DB::beginTransaction();
        try {
            $updatedUnits = 0;
            $totalVariants = 0;

            foreach ($this->pendingAdjustments as $adj) {
                $newPrice = (float) $adj['new_price'];
                $variants = $adj['variants'];

                if (!empty($adj['car_id'])) {
                    $car = Car::find($adj['car_id']);
                    if ($car) {
                        $updateData = ['price' => $newPrice];
                        if (!empty($variants)) {
                            $updateData['variants'] = $variants;
                        }
                        $car->update($updateData);
                        $updatedUnits++;
                        $totalVariants += count($variants);
                    }
                } else {
                    // Create newly detected car
                    $carName = $adj['name'] ?: $adj['detected_name'];
                    Car::create([
                        'name' => $carName,
                        'slug' => Str::slug($carName),
                        'category' => $adj['category'] ?? 'SUV',
                        'price' => $newPrice,
                        'variants' => $variants,
                        'is_available' => true,
                    ]);
                    $updatedUnits++;
                    $totalVariants += count($variants);
                }
            }

            DB::commit();

            // Clear cache to immediately reflect updates on frontend
            try {
                Cache::flush();
                Artisan::call('cache:clear');
            } catch (\Exception $e) {
                // Ignore cache clearing errors if any
            }

            // Clear state and refresh list
            $this->pendingAdjustments = [];
            $this->pricelistFile = null;
            $this->uploadedFileName = null;
            $this->loadCurrentCars();

            Notification::make()
                ->title('Semua Harga Berhasil Disesuaikan & Diterapkan!')
                ->body("{$updatedUnits} unit kendaraan dan {$totalVariants} varian telah berhasil disinkronkan ke seluruh katalog, simulasi cicilan, kalkulator trade-in, dan e-quotation.")
                ->success()
                ->duration(8000)
                ->send();

        } catch (\Exception $e) {
            DB::rollBack();
            Notification::make()
                ->title('Gagal Menerapkan Perubahan')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    /**
     * Cancel pending changes
     */
    public function cancelPending(): void
    {
        $this->pendingAdjustments = [];
        $this->pricelistFile = null;
        $this->uploadedFileName = null;

        Notification::make()
            ->title('Perubahan Dibatalkan')
            ->body('Penyesuaian harga belum diterapkan ke database.')
            ->info()
            ->send();
    }
}
