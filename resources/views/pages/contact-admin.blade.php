@extends('layouts.app')

@section('title', 'Bantuan')
@section('page-title', 'Pusat Bantuan')
@section('page-subtitle', 'Tanyakan apa saja kepada asisten virtual kami, atau hubungi admin langsung.')

@section('content')
    <section class="section-sm">
        <div class="container detail-layout">
            <div class="card reveal" style="padding:0;overflow:hidden">
                <div style="display:flex;align-items:center;gap:.8rem;padding:1rem 1.2rem;border-bottom:1px solid var(--border)">
                    <div class="feature" style="padding:0;border:0;background:none"><div class="ico" style="margin:0;width:44px;height:44px"><i class="fas fa-robot"></i></div></div>
                    <div>
                        <strong>Hotel Booking Assistant</strong><br>
                        <span class="small" style="color:var(--success)"><i class="fas fa-circle" style="font-size:.5rem"></i> Online</span>
                    </div>
                </div>
                <div class="chat">
                    <div class="chatbot-messages" id="chatbotMessages">
                        <div class="message bot"><div class="message-content">Halo! Saya asisten booking hotel Anda. Ada yang bisa saya bantu?</div></div>
                    </div>
                    <div class="quick-reply-group" id="quickReplyGroup"></div>
                    <div class="chatbot-input">
                        <input type="text" id="userInput" placeholder="Ketik pesan Anda..." autocomplete="off" aria-label="Input pesan">
                        <button id="typeQuestion" class="type-button" aria-label="Tulis pesan"><i class="fas fa-keyboard"></i><span class="button-label">Tulis</span></button>
                        <button id="sendMessage" class="send-button" aria-label="Kirim pesan"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
            <aside class="sticky" style="display:grid;gap:1rem">
                @foreach ([
                    ['fa-envelope', 'Email', $site['email'], 'mailto:'.$site['email']],
                    ['fa-phone', 'Telepon', $site['phone'], 'tel:'.$site['phone']],
                    ['fa-location-dot', 'Alamat', $site['address'], null],
                ] as $i => [$icon, $label, $value, $href])
                    <div class="feature reveal reveal-delay-{{ $i }}" data-tilt="8">
                        <div class="ico"><i class="fas {{ $icon }}"></i></div>
                        <h3>{{ $label }}</h3>
                        <p>@if ($href)<a href="{{ $href }}">{{ $value }}</a>@else{{ $value }}@endif</p>
                    </div>
                @endforeach
            </aside>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/chatbot.js') }}"></script>
@endpush
