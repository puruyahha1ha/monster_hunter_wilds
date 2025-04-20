<?php

use App\Models\Series;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.admin-app')] class extends Component {
    public Series $series;
    public bool $showDeleteModal = false;

    public function confirmDelete($seriesId)
    {
        $this->showDeleteModal = true;
        $this->seriesIdToDelete = $seriesId;
    }

    public function deleteSeries()
    {
        Series::find($this->seriesIdToDelete)->delete();
        $this->showDeleteModal = false;
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
    }
}; ?>

<div>
    <div class="rounded-lg border-gray-700 border p-8 bg-gray-850 shadow-xl">
        <h2 class="text-2xl font-bold text-white mb-6 border-b border-gray-700 pb-2">シリーズ詳細</h2>

        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="block text-gray-300 text-lg font-medium mb-2">
                        シリーズ名
                    </p>
                    <p class="w-full text-white">
                        {{ $series->name }}
                    </p>
                </div>
                <div>
                    <p class="block text-gray-300 text-lg font-medium mb-2" for="description">
                        シリーズ説明
                    </p>
                    <p class="w-full text-white">
                        {{ $series->description }}
                    </p>
                </div>
            </div>

            <div>
                <p class="block text-gray-300 text-lg font-medium mb-2">
                    発動スキル
                </p>

                <div class="grid grid-cols-2 gap-6">
                    @forelse($series->skills as $skill)
                        <div class="flex justify-between items-center">
                            <span class="text-white font-medium">
                                {{ $skill->name }}
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center">スキルなし</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="space-y-4 pt-3">
            <div class="grid grid-cols-3 gap-6">
                <a href="{{ route('admin.skills.series.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white text-center rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    シリーズ一覧へ
                </a>
                <a href="{{ route('admin.skills.series.edit', $series->id) }}"
                    class="px-4 py-2 bg-blue-500 text-white text-center rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    シリーズ編集
                </a>
                <button wire:click="confirmDelete({{ $series->id }})"
                    class="px-4 py-2 bg-red-500 text-white rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    シリーズ削除
                </button>
            </div>
        </div>
    </div>
    @if ($showDeleteModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg max-w-md w-full">
                <h3 class="text-xl font-bold text-white mb-4">削除の確認</h3>
                <p class="text-gray-300 mb-6">
                    このシリーズを削除してもよろしいですか？<br>
                    この操作は取り消せません。
                </p>
                <div class="flex justify-end space-x-3">
                    <button wire:click="cancelDelete"
                        class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                        キャンセル
                    </button>
                    <button wire:click="deleteSeries" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        削除する
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
