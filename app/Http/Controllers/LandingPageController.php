<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Gallery;
use App\Models\Consultant;
use App\Models\Video;
use App\Models\Post;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        foreach (['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'gclid'] as $param) {
            if ($request->filled($param)) {
                session([$param => $request->get($param)]);
            }
        }

        $cars = Car::where('is_available', true)->get();
        $galleries = Gallery::all();
        $consultant = Consultant::first();
        $video = Video::where('type', 'youtube')->where('is_active', true)->latest()->first();
        $popupVideo = Video::where('type', 'popup')->where('is_active', true)->latest()->first();
        $posts = Post::where('is_published', true)
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(8)
            ->get();
        $testimonials = \App\Models\Testimonial::where('is_active', true)->latest()->get();
        $activeEvent = \App\Models\ShowroomEvent::where('is_active', true)
            ->where('event_date', '>=', now()->startOfDay())
            ->orderBy('event_date')
            ->first();

        return view('welcome', compact('cars', 'galleries', 'consultant', 'video', 'popupVideo', 'posts', 'testimonials', 'activeEvent'));
    }

    public function show($slug)
    {
        if ($slug === 'stargazer-x') {
            return redirect()->route('car.show', ['slug' => 'stargazer-cartenz-x'], 301);
        }

        if ($slug === 'palisade-hev') {
            return redirect()->route('car.show', ['slug' => 'all-new-palisade-hybrid'], 301);
        }

        $car = Car::where('slug', $slug)->firstOrFail();
        $consultant = Consultant::first();
        return view('car-detail', compact('car', 'consultant'));
    }

    public function pricelist()
    {
        $orderedSlugs = [
            'stargazer-cartenz',
            'stargazer-cartenz-x',
            'stargazer',
            'ioniq-9',
            'the-new-creta',
            'creta-n-line',
            'palisade',
            'all-new-palisade-hybrid',
            'palisade-hev',
            'santa-fe',
            'staria',
            'ioniq-5',
            'kona-electric',
        ];

        $cars = Car::where('is_available', true)
            ->get()
            ->sortBy(function ($car) use ($orderedSlugs) {
                $pos = array_search($car->slug, $orderedSlugs);
                return $pos !== false ? $pos : 999;
            })
            ->values();

        $consultant = Consultant::first();
        return view('pricelist', compact('cars', 'consultant'));
    }

    public function postsIndex()
    {
        $posts = Post::where('is_published', true)
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->paginate(9);
        
        $consultant = Consultant::first();
        return view('posts.index', compact('posts', 'consultant'));
    }

    public function postsShow(Post $post)
    {
        if (!$post->is_published || $post->published_at > now()) {
            abort(404);
        }

        $consultant = Consultant::first();
        $relatedPosts = Post::where('is_published', true)
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(3)
            ->get();

        return view('posts.show', compact('post', 'consultant', 'relatedPosts'));
    }

    public function testDrive(Request $request)
    {
        $cars = Car::where('is_available', true)->get();

        $featuredIds = \App\Models\Setting::getJson('featured_test_drive_car_ids', []);
        if (!empty($featuredIds) && is_array($featuredIds)) {
            $featuredCars = Car::whereIn('id', $featuredIds)
                ->where('is_available', true)
                ->get()
                ->sortBy(function ($car) use ($featuredIds) {
                    return array_search($car->id, $featuredIds);
                })
                ->values();
            $testDriveCars = $featuredCars->isNotEmpty() ? $featuredCars : $cars->take(6);
        } else {
            $testDriveCars = $cars->take(6);
        }

        $selectedCarId = $request->get('car_id');
        $selectedCar = $selectedCarId ? Car::find($selectedCarId) : null;
        $consultant = Consultant::first();
        return view('test-drive', compact('cars', 'testDriveCars', 'selectedCar', 'consultant'));
    }

    public function creditSimulation(Request $request)
    {
        $cars = Car::where('is_available', true)->get();
        $selectedCarId = $request->get('car_id') ?: ($cars->first()?->id);
        $selectedCar = Car::find($selectedCarId) ?: $cars->first();
        $consultant = Consultant::first();
        return view('simulasi-kredit', compact('cars', 'selectedCar', 'consultant'));
    }

    public function promoIndex()
    {
        $cars = Car::where('is_available', true)->get();
        $consultant = Consultant::first();
        $activeEvent = \App\Models\ShowroomEvent::where('is_active', true)
            ->where('event_date', '>=', now()->startOfDay())
            ->orderBy('event_date')
            ->first();
        return view('promo', compact('cars', 'consultant', 'activeEvent'));
    }

    public function tradeInPage(Request $request)
    {
        $cars = Car::where('is_available', true)->get();
        $consultant = Consultant::first();
        return view('tukar-tambah', compact('cars', 'consultant'));
    }

    public function servicePage(Request $request)
    {
        $cars = Car::where('is_available', true)->get();
        $consultant = Consultant::first();
        return view('bengkel-service', compact('cars', 'consultant'));
    }

    public function quotation(Request $request)
    {
        $carId = $request->get('car_id');
        $car = $carId ? Car::find($carId) : Car::where('is_available', true)->first();
        if (!$car) abort(404);

        $consultant = Consultant::first();
        $dpPercent = (float) $request->get('dp_percent', 20);
        $tenor = (int) $request->get('tenor', 36);
        $insuranceType = $request->get('insurance', 'all_risk');
        $dpAmount = (float) $request->get('dp_amount', ($dpPercent / 100) * $car->price);
        
        $principal = $car->price - $dpAmount;
        $interestRate = match(true) {
            $tenor <= 12 => 0.03,
            $tenor <= 24 => 0.04,
            $tenor <= 36 => 0.05,
            $tenor <= 48 => 0.06,
            default => 0.07,
        };
        $years = $tenor / 12;
        $totalLoan = $principal + ($principal * $interestRate * $years);
        $installment = $tenor > 0 ? $totalLoan / $tenor : 0;

        return view('quotation', compact('car', 'consultant', 'dpPercent', 'tenor', 'insuranceType', 'dpAmount', 'installment'));
    }

    public function privacyPolicy()
    {
        $consultant = Consultant::first();
        return view('privacy-policy', compact('consultant'));
    }

    public function terms()
    {
        $consultant = Consultant::first();
        return view('terms', compact('consultant'));
    }

    public function sitemap()
    {
        $cars = Car::where('is_available', true)->get();
        $posts = Post::where('is_published', true)->where('published_at', '<=', now())->get();
        return response()->view('sitemap', compact('cars', 'posts'))->header('Content-Type', 'text/xml');
    }

    public function robots()
    {
        $url = url('/');
        $content = "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /admin/*\n\nSitemap: {$url}/sitemap.xml\n";
        return response($content, 200, ['Content-Type' => 'text/plain']);
    }

    public function captureLead(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'whatsapp' => 'required|string|max:25',
            'car_id' => 'nullable|exists:cars,id',
            'car_name' => 'nullable|string|max:100',
            'purchase_type' => 'nullable|string|in:cash,credit,trade_in',
            'lead_type' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500',
        ]);

        $car = !empty($validated['car_id']) ? Car::find($validated['car_id']) : null;
        $carName = $car ? $car->name : ($validated['car_name'] ?? 'Konsultasi Unit');

        $ip = $request->ip();
        $region = \App\Models\SiteLog::getRegionFromIp($ip);
        if ($region === 'Foreign') $region = 'Luar Negeri';

        $lead = \App\Models\Lead::create([
            'name' => $validated['name'],
            'whatsapp' => $validated['whatsapp'],
            'car_id' => $car?->id,
            'car_name' => $carName,
            'lead_type' => $validated['lead_type'] ?? 'consultation',
            'purchase_type' => $validated['purchase_type'] ?? 'credit',
            'notes' => $validated['notes'] ?? null,
            'status' => 'new',
            'utm_source' => $request->get('utm_source') ?: session('utm_source', 'direct'),
            'utm_medium' => $request->get('utm_medium') ?: session('utm_medium'),
            'utm_campaign' => $request->get('utm_campaign') ?: session('utm_campaign'),
            'utm_term' => $request->get('utm_term') ?: session('utm_term'),
            'gclid' => $request->get('gclid') ?: session('gclid'),
            'ip_address' => $ip,
            'region' => $region,
        ]);

        \App\Models\SiteLog::create([
            'log_type' => 'lead_captured',
            'source' => $lead->utm_source ?: 'direct',
            'car_id' => $car?->id,
            'ip_address' => $ip,
            'user_agent' => $request->userAgent(),
            'region' => $region,
            'created_at' => now(),
        ]);

        // Send instant Telegram Lead Alert
        \App\Services\TelegramNotificationService::sendAlert('Prospek Baru (Promo Form)', [
            'Nama' => $validated['name'],
            'WhatsApp' => $validated['whatsapp'],
            'Unit Pilihan' => $carName,
            'Rencana Pembelian' => strtoupper($validated['purchase_type'] ?? 'Kredit'),
            'Sumber Trafik' => $lead->utm_source ?: 'Direct',
            'Wilayah/IP' => "{$region} ({$ip})",
            'Catatan' => $validated['notes'] ?? '-',
        ]);

        $consultant = Consultant::first();
        $phone = $consultant?->formatted_phone ?? '6281330135013';
        
        $msg = "Halo Nico (Sales Hyundai Surabaya), saya *{$validated['name']}* tertarik dengan unit *{$carName}* (Rencana: " . strtoupper($validated['purchase_type'] ?? 'Kredit') . "). Mohon info promo diskon dan simulasi cicilan terbarunya. Terima kasih.";

        $waUrl = "https://api.whatsapp.com/send/?phone={$phone}&text=" . urlencode($msg);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Terima kasih! Kami akan segera menghubungi Anda.',
                'wa_url' => $waUrl,
            ]);
        }

        return redirect($waUrl);
    }

    public function captureTradeIn(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'old_car_brand' => 'required|string|max:100',
            'old_car_model' => 'required|string|max:100',
            'old_car_year' => 'required|integer',
            'old_car_transmission' => 'nullable|string',
            'expected_price' => 'nullable|numeric',
            'interested_car_id' => 'nullable|exists:cars,id',
            'notes' => 'nullable|string',
        ]);

        $tradeIn = \App\Models\TradeIn::create([
            'customer_name' => $validated['name'],
            'customer_phone' => $validated['phone'],
            'old_car_brand' => $validated['old_car_brand'],
            'old_car_model' => $validated['old_car_model'],
            'old_car_year' => $validated['old_car_year'],
            'old_car_transmission' => $validated['old_car_transmission'] ?? 'automatic',
            'expected_price' => $validated['expected_price'] ?? null,
            'interested_car_id' => $validated['interested_car_id'] ?? null,
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        // Also record as a Lead for CRM pipeline
        \App\Models\Lead::create([
            'name' => $validated['name'],
            'whatsapp' => $validated['phone'],
            'car_id' => $validated['interested_car_id'] ?? null,
            'purchase_type' => 'trade_in',
            'lead_type' => 'trade_in',
            'status' => 'new',
            'notes' => "Trade-in mobil lama: {$validated['old_car_brand']} {$validated['old_car_model']} ({$validated['old_car_year']})",
        ]);

        $targetCar = $tradeIn->interestedCar?->name ?? 'mobil baru Hyundai';

        // Send instant Telegram Trade-in Alert
        \App\Services\TelegramNotificationService::sendAlert('Pengajuan Tukar Tambah (Trade-In)', [
            'Nama Pemohon' => $validated['name'],
            'WhatsApp' => $validated['phone'],
            'Mobil Lama' => "{$validated['old_car_brand']} {$validated['old_car_model']} ({$validated['old_car_year']})",
            'Transmisi' => ucfirst($validated['old_car_transmission'] ?? 'Automatic'),
            'Ekspektasi Harga' => $validated['expected_price'] ? 'Rp ' . number_format($validated['expected_price'], 0, ',', '.') : '-',
            'Tertarik ke Unit' => $targetCar,
            'Catatan' => $validated['notes'] ?? '-',
        ]);
        $consultant = Consultant::first();
        $phone = $consultant?->formatted_phone ?? '6281330135013';
        $msg = "Halo Nico (Sales Hyundai Surabaya), saya *{$validated['name']}* ingin mengajukan program Tukar Tambah mobil lama saya *{$validated['old_car_brand']} {$validated['old_car_model']} ({$validated['old_car_year']})* ke unit *{$targetCar}*. Mohon info taksiran harga dan promo terbarunya.";

        $waUrl = "https://api.whatsapp.com/send/?phone={$phone}&text=" . urlencode($msg);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengajuan tukar tambah berhasil dikirim.',
                'wa_url' => $waUrl,
            ]);
        }

        return redirect($waUrl);
    }

    public function trackDuration(Request $request)
    {
        $visitId = $request->input('visit_id') ?: session('current_visit_id');
        $duration = (int) $request->input('duration', 0);

        if ($visitId && $duration > 0) {
            \App\Models\SiteLog::where('id', $visitId)->update([
                'duration_seconds' => min(3600, $duration),
            ]);
        }

        return response()->json(['status' => 'ok']);
    }
}
