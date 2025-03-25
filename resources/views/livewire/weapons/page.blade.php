<div>
    {{-- ヘッダーセクション --}}
    <livewire:weapons.header-section />

    <div class="mx-auto max-w-7xl px-2 py-8 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
            {{-- メインコンテンツ --}}
            <div class="md:col-span-9 space-y-8">
                {{-- 武器一覧セクション - 遅延ロード適用 --}}
                <livewire:weapons.weapon-list-section :lazy="true" />
            </div>

            {{-- サイドバー --}}
            <div class="md:col-span-3">
                {{-- フィルターセクション --}}
                {{-- <livewire:weapons.filter-section /> --}}

                {{-- サイドバー共通コンポーネント --}}
                <livewire:shared.sidebar />
            </div>
        </div>
    </div>
</div>
