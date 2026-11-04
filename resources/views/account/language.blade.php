@extends('layouts.account')

@section('title', __('ui.title'))
@section('page-title', __('ui.title'))

@section('account')
    <div class="card">
        <div class="card-title">{{ __('ui.main_language') }}</div>
        <div class="choice-grid">
            @foreach (\App\Http\Middleware\SetLocale::SUPPORTED as $lang)
                <a href="{{ route('language', ['lang' => $lang]) }}" class="choice" style="color:inherit">
                    <input type="radio" name="lang" @checked($current === $lang) tabindex="-1" aria-hidden="true">
                    <span class="box">
                        <span style="font-size:1.6rem">{{ ['id' => '🇮🇩', 'en' => '🇬🇧', 'ja' => '🇯🇵', 'zh' => '🇨🇳'][$lang] }}</span>
                        <span><strong>{{ __('ui.'.$lang) }}</strong><small>{{ strtoupper($lang) }}</small></span>
                        @if ($current === $lang)<i class="fas fa-circle-check" style="margin-left:auto;color:var(--brand)"></i>@endif
                    </span>
                </a>
            @endforeach
        </div>
        <a href="{{ route('language', ['reset' => 1]) }}" class="btn btn-outline" style="margin-top:1.2rem"><i class="fas fa-rotate-left"></i> {{ __('ui.reset_language') }}</a>
    </div>
@endsection
