<?php

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

new #[Layout('components.layouts.admin-app')] class extends Component {
    public string $search = '';
    public int $perPage = 10;
    public string $sortField = 'id';
    public string $sortDirection = 'asc';
    public bool $showDeleteModal = false;
    public ?int $deleteUserId = null;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function users()
    {
        return User::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function confirmDelete(int $userId): void
    {
        $this->deleteUserId = $userId;
        $this->showDeleteModal = true;
    }

    public function cancelDelete(): void
    {
        $this->deleteUserId = null;
        $this->showDeleteModal = false;
    }

    public function deleteUser(): void
    {
        if ($this->deleteUserId) {
            try {
                User::findOrFail($this->deleteUserId)->delete();
                session()->flash('message', 'ユーザーが削除されました。');
            } catch (\Exception $e) {
                session()->flash('error', 'ユーザーの削除に失敗しました。');
            } finally {
                $this->cancelDelete();
            }
        }
    }
}; ?>

<div class="text-white">
    <div class="rounded-lg border-gray-700 border p-8 bg-gray-850 shadow-xl">
        <h2 class="text-2xl font-bold text-white mb-6 border-b border-gray-700 pb-2">ユーザー一覧</h2>

        <div class="mb-4">
            <input type="text" wire:model="search" placeholder="ユーザー名またはメールアドレスで検索"
                class="w-full p-2 rounded-md bg-gray-800 text-white">
        </div>

        <table class="min-w-full divide-y divide-gray-700">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">操作</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">名前</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">メールアドレス
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-800 divide-y divide-gray-700">
                @forelse ($this->users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button wire:click="confirmDelete({{ $user->id }})"
                                class="text-red-500 hover:text-red-700">削除</button>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-400">
                            ユーザーが見つかりませんでした
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $this->users->links() }}

        @if ($showDeleteModal)
            <div class="fixed inset-0 flex items-center justify-center z-[100] bg-black bg-opacity-50">
                <div class="bg-white rounded-lg p-8 shadow-lg">
                    <h3 class="text-lg font-bold mb-4">ユーザー削除
                        確認</h3>
                    <p class="mb-4">このユーザーを削除してもよろしいですか？</p>
                    <div class="flex justify-end">
                        <button wire:click="cancelDelete"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md mr-2">キャンセル</button>
                        <button wire:click="deleteUser" class="px-4 py-2 bg-red-500 text-white rounded-md">削除</button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
