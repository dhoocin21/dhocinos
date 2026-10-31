<?php

namespace App\Livewire;

use App\Models\Consultant;
use App\Models\Lead;
use App\Models\Setting;
use App\Services\AiService;
use Livewire\Component;

class AiChatWidget extends Component
{
    public bool $isOpen = false;
    public string $userMessage = '';
    public array $messages = [];
    public bool $isTyping = false;

    // Customer Lead Info
    public bool $isLeadCaptured = false;
    public string $leadName = '';
    public string $leadPhone = '';
    public string $leadCity = '';

    // WhatsApp Sales Popup State
    public bool $showWhatsappPopup = false;
    public string $popupReason = '';

    public function mount(): void
    {
        // Check if customer already submitted lead in this session
        if (session()->has('customer_lead_phone')) {
            $this->leadPhone = session('customer_lead_phone');
            $this->leadName = session('customer_lead_name', '');
            $this->leadCity = session('customer_lead_city', '');
            $this->isLeadCaptured = true;
        }

        $greeting = $this->isLeadCaptured
            ? "Halo Kak " . ($this->leadName ?: '') . "! Saya Asisten AI Showroom Hyundai Surabaya. Ada yang bisa saya bantu terkait spesifikasi unit, pricelist OTR terbaru, promo diskon, atau simulasi kredit?"
            : "Halo! Selamat datang di Showroom Resmi Hyundai Gowa HR Muhammad Surabaya.\n\nSebelum saya memberikan informasi detail unit, pricelist OTR, dan promo diskon spesial, silakan lengkapi Nomor WhatsApp (Wajib), Nama, dan Domisili Anda di bawah ini agar penawaran resmi dapat tercatat langsung.";

        $this->messages = [
            [
                'role' => 'assistant',
                'text' => $greeting,
                'time' => now()->format('H:i'),
            ]
        ];
    }

    public function toggleChat(): void
    {
        $this->isOpen = !$this->isOpen;
    }

    public function closeWhatsappPopup(): void
    {
        $this->showWhatsappPopup = false;
    }

    public function openWhatsappPopup(string $reason = ''): void
    {
        $this->popupReason = $reason;
        $this->showWhatsappPopup = true;
    }

    /**
     * Submit lead from the intake form inside the chat.
     */
    public function submitLead(): void
    {
        $cleanPhone = preg_replace('/[^0-9]/', '', $this->leadPhone);

        // Nomor telepon WAJIB & valid
        if (empty($cleanPhone) || strlen($cleanPhone) < 9) {
            $this->messages[] = [
                'role' => 'assistant',
                'text' => "⚠️ Nomor telepon / WhatsApp wajib diisi dengan benar (minimal 9 digit) sebelum AI dapat menjawab pertanyaan Anda.",
                'time' => now()->format('H:i'),
            ];
            $this->openWhatsappPopup('Nomor WhatsApp wajib diisi sebelum memulai sesi konsultasi dengan AI.');
            return;
        }

        // Nama dan domisili juga harus diisi
        if (empty(trim($this->leadName)) || empty(trim($this->leadCity))) {
            $this->messages[] = [
                'role' => 'assistant',
                'text' => "⚠️ Mohon lengkapi juga Nama dan Domisili (Kota) Anda agar kami dapat menghitungkan estimasi OTR dan promo wilayah yang tepat.",
                'time' => now()->format('H:i'),
            ];
            $this->openWhatsappPopup('Nama dan Domisili wajib diisi agar data konsultasi lengkap.');
            return;
        }

        // Simpan langsung ke tabel leads
        Lead::create([
            'name' => trim($this->leadName),
            'whatsapp' => $this->leadPhone,
            'region' => trim($this->leadCity),
            'lead_type' => 'ai_chat',
            'status' => 'new',
            'notes' => 'Tanya AI Showroom: Terdaftar sebelum konsultasi unit & promo.',
            'ip_address' => request()->ip(),
        ]);

        session([
            'customer_lead_phone' => $this->leadPhone,
            'customer_lead_name' => $this->leadName,
            'customer_lead_city' => $this->leadCity,
        ]);

        $this->isLeadCaptured = true;
        $this->showWhatsappPopup = false;

        $this->messages[] = [
            'role' => 'assistant',
            'text' => "✅ Terima kasih Kak {$this->leadName} dari {$this->leadCity}! Data Anda telah terhubung langsung dengan sistem Hyundai Gowa Surabaya.\n\nSekarang silakan tanyakan unit mobil apa yang ingin Anda ketahui (contoh: Stargazer, Creta, Santa Fe, atau Ioniq 5), atau tanyakan promo DP & simulasi kredit terbaru!",
            'time' => now()->format('H:i'),
        ];
    }

    public function sendQuickPrompt(string $prompt): void
    {
        $this->userMessage = $prompt;
        $this->sendMessage();
    }

    public function sendMessage(): void
    {
        $trimmed = trim($this->userMessage);
        if (empty($trimmed)) return;

        // Add user message to conversation
        $this->messages[] = [
            'role' => 'user',
            'text' => $trimmed,
            'time' => now()->format('H:i'),
        ];

        $this->userMessage = '';

        // If lead not yet captured, check if the customer provided phone number in the message
        if (!$this->isLeadCaptured) {
            // Regex to find Indonesian phone number (08xxx or +628xxx or 628xxx)
            if (preg_match('/(\+?62|0)8[0-9]{8,12}/', $trimmed, $matches)) {
                $foundPhone = $matches[0];
                $this->leadPhone = $foundPhone;
                if (empty($this->leadName)) $this->leadName = 'Calon Customer';
                if (empty($this->leadCity)) $this->leadCity = 'Surabaya';

                // Save to leads
                Lead::create([
                    'name' => $this->leadName,
                    'whatsapp' => $this->leadPhone,
                    'region' => $this->leadCity,
                    'lead_type' => 'ai_chat',
                    'status' => 'new',
                    'notes' => 'Tanya AI Showroom: ' . $trimmed,
                    'ip_address' => request()->ip(),
                ]);

                session([
                    'customer_lead_phone' => $this->leadPhone,
                    'customer_lead_name' => $this->leadName,
                    'customer_lead_city' => $this->leadCity,
                ]);

                $this->isLeadCaptured = true;
                $this->showWhatsappPopup = false;
            } else {
                // Customer did NOT provide a phone number!
                // Per requirement: "kalau tidak dapat nomor telpon ai akan berhenti menjawab dan memberi pop up whatsapp sales"
                $this->messages[] = [
                    'role' => 'assistant',
                    'text' => "Mohon maaf, Anda wajib mencantumkan Nomor Telepon / WhatsApp (serta Nama dan Domisili) terlebih dahulu sebelum AI dapat menjawab pertanyaan Anda.\n\nSilakan lengkapi formulir di bawah atau hubungi langsung Sales Consultant kami via WhatsApp.",
                    'time' => now()->format('H:i'),
                ];

                // Stop answering and show WhatsApp Sales popup!
                $this->openWhatsappPopup('Nomor telepon wajib diberikan agar konsultasi dapat dijawab oleh AI atau dialihkan langsung ke Sales Executive.');
                return;
            }
        }

        // Lead is captured, proceed to query AI
        $this->isTyping = true;

        try {
            /** @var AiService $aiService */
            $aiService = app(AiService::class);
            $reply = $aiService->chatWithCustomer($trimmed, $this->messages);

            $this->messages[] = [
                'role' => 'assistant',
                'text' => $reply,
                'time' => now()->format('H:i'),
            ];
        } catch (\Exception $e) {
            $this->messages[] = [
                'role' => 'assistant',
                'text' => "Maaf, terjadi kendala saat menghubungkan ke asisten AI. Silakan hubungi langsung Sales Consultant kami via WhatsApp di 0813-3013-5013 untuk respon instan.",
                'time' => now()->format('H:i'),
            ];
        } finally {
            $this->isTyping = false;
        }
    }

    public function render()
    {
        $consultant = Consultant::first();
        return view('livewire.ai-chat-widget', compact('consultant'));
    }
}
