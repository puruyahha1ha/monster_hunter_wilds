<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'モンスターハンターワイルズ 情報サイト' }}</title>

    {{-- メタデータ --}}
    <meta name="description" content="{{ $metaDescription ?? 'モンスターハンターワイルドの総合情報サイト。モンスター、武器、防具、装備セットの情報を提供します。' }}">
    <meta name="keywords" content="モンスターハンターワイルド,MHW,モンハン,装備,攻略">
    <meta name="author" content="モンスターハンターワイルズ 情報サイト">

    {{-- OGP設定 --}}
    <meta property="og:title" content="{{ $title ?? 'モンスターハンターワイルズ 情報サイト' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/ogp.png') }}">
    <meta property="og:description"
        content="{{ $metaDescription ?? 'モンスターハンターワイルドの総合情報サイト。モンスター、武器、防具、装備セットの情報を提供します。' }}">
    <meta property="og:site_name" content="モンスターハンターワイルズ 情報サイト">
    <meta property="og:locale" content="ja_JP">

    {{-- Twitterカード設定 --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@monhan_wilds">
    <meta name="twitter:creator" content="@monhan_wilds">
    <meta name="twitter:title" content="{{ $title ?? 'モンスターハンターワイルズ 情報サイト' }}">
    <meta name="twitter:description"
        content="{{ $metaDescription ?? 'モンスターハンターワイルドの総合情報サイト。モンスター、武器、防具、装備セットの情報を提供します。' }}">
    <meta name="twitter:image" content="{{ asset('images/ogp.png') }}">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">

    {{-- CSS --}}
    @vite('resources/css/app.css')

    {{-- Livewire Styles --}}
    @livewireStyles

    {{-- 追加のCSS --}}
    @stack('styles')

    {{-- 初期データのプリロード --}}
    @if (isset($initialData))
        <script>
            window.initialData = @json($initialData);
        </script>
    @endif
</head>

<body class="min-h-screen bg-gray-900">
    {{-- ヘッダー --}}
    <livewire:shared.header />
    
    {{-- メインコンテンツ --}}
    <main>
        {{ $slot }}
    </main>

    {{-- フッター --}}
    <livewire:shared.footer />

    {{-- Livewire Scripts --}}
    @livewireScripts

    {{-- Alpine.js (Livewireのdefault-webpackエントリーポイントに含まれている) --}}
    @vite('resources/js/app.js')

    {{-- 追加のスクリプト --}}
    @stack('scripts')
</body>

</html>
