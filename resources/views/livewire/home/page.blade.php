<div>
    {{-- ヒーローセクション --}}
    <livewire:home.hero-section />

    {{-- クイックリンクセクション --}}
    <livewire:home.quick-links-section />

    <div class="mx-auto max-w-7xl px-2 py-8 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
            <!-- メインコンテンツ -->
            <div class="md:col-span-8">
                {{-- 新着装備セクション - 遅延ロード適用 --}}
                <livewire:home.latest-builds-section :lazy="true" />

                {{-- 人気装備セクション - 遅延ロード適用 --}}
                <livewire:home.popular-builds-section :lazy="true" />

                {{-- 最新ニュースセクション - 遅延ロード適用 --}}
                {{-- <livewire:home.news-section :lazy="true" /> --}}
            </div>
        </div>
    </div>
</div>
