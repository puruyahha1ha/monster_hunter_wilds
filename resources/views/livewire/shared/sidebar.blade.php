<div class="md:col-span-4">
    {{-- クイックリンクセクション --}}
    <livewire:home.quick-links-section />

    {{-- 人気装備セクション - 遅延ロード適用 --}}
    <livewire:home.popular-builds-section :lazy="true" />
</div>