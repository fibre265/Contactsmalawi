@extends('layouts.generalLayout')
@section('content')

<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- ======= Profile Detail Section ======= -->
    <section id="team" class="team" style="padding: 60px 0; background: #f8f9fa;">
        <div class="container" style="max-width: 800px;">
            
            <!-- Main Profile Card -->
            <div style="background: #ffffff; padding: 40px; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.06); text-align: center; margin-bottom: 30px;" data-aos="fade-up">
                
                <!-- Avatar Placeholder / Decorative Badge -->
                <div style="width: 80px; height: 80px; background: #eef2f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <i class="bi bi-phone-vibrate-fill" style="font-size: 36px; color: #3b82f6;"></i>
                </div>

                <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin-bottom: 5px;">{{ $user->name }}</h1>
                <p style="font-size: 16px; color: #6b7280; margin-bottom: 25px; font-weight: 500;">
                    📍 {{ $user->district->district }} District &bull; {{ $user->district->region->region }} Region
                </p>

                <!-- Action Communication Buttons -->
                <div class="contact-buttons" style="display: flex; gap: 15px; justify-content: center; margin-bottom: 30px;">
                    <!-- Call Button -->
                    <a href="tel:{{ $user->email }}" style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 28px; background: #2563eb; color: white; font-weight: 600; text-decoration: none; border-radius: 8px; transition: background 0.2s; min-width: 160px; box-shadow: 0 4px 12px rgba(37,99,235,0.2);">
                        📞 Call Now
                    </a>

                    @php
                        // Clean number logic
                        $cleanWhatsapp = preg_replace('/[^0-9]/', '', $user->email);
                        if (str_starts_with($cleanWhatsapp, '0')) {
                            $cleanWhatsapp = '265' . substr($cleanWhatsapp, 1);
                        }
                    @endphp

                    <!-- WhatsApp Button -->
                    <a href="https://wa.me/{{ $cleanWhatsapp }}?text=Hello%20{{ urlencode($user->name) }},%20I%20found%20your%20profile%20on%20the%20directory." 
                       target="_blank" 
                       style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 28px; background: #16a34a; color: white; font-weight: 600; text-decoration: none; border-radius: 8px; transition: background 0.2s; min-width: 160px; box-shadow: 0 4px 12px rgba(22,163,74,0.2);">
                        💬 WhatsApp
                    </a>
                </div>

                <hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 25px 0;">

                <!-- Alternate Support Text -->
                <p style="font-size: 13px; color: #9ca3af; line-height: 1.6; max-width: 500px; margin: 0 auto;">
                    If this is not the agent number you are looking for, please call <strong style="color: #4b5563;">08867...</strong> and you will be assisted as soon as possible if the number is registered with us.
                </p>
            </div>

            <!-- Directory Branding Footer Card -->
            <div style="background: #ffffff; padding: 20px 30px; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.03); display: flex; justify-content: space-between; align-items: center;" data-aos="fade-up" data-aos-delay="100">
                <div>
                    <h4 style="font-size: 16px; font-weight: 700; color: #374151; margin: 0;">Contacts Malawi</h4>
                    <span style="font-size: 13px; color: #9ca3af;">Official Verification System</span>
                </div>
                <div class="social" style="display: flex; gap: 12px; font-size: 18px;">
                    <a href="#" style="color: #6b7280; transition: color 0.2s;"><i class="bi bi-twitter"></i></a>
                    <a href="#" style="color: #6b7280; transition: color 0.2s;"><i class="bi bi-facebook"></i></a>
                    <a href="#" style="color: #6b7280; transition: color 0.2s;"><i class="bi bi-instagram"></i></a>
                    <a href="#" style="color: #6b7280; transition: color 0.2s;"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>

        </div>
    </section>
    <!-- End Team Section -->
</x-guest-layout>

@endsection