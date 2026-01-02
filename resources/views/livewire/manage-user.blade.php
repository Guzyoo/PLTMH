<div class="w-full"> {{-- Tambahan w-full agar container responsive --}}

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold text-slate-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Daftar Pengguna
            </h2>
            <p class="mt-1 text-sm text-slate-500">Kelola akses dan data pengguna sistem.</p>
        </div>
        <div>
            <a href="{{ url('/devices') }}" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-medium rounded-lg transition shadow-sm focus:outline-none">
                Kembali
            </a>
        </div>
    </div>

    {{-- Flash Message dengan Animasi Fade In/Out (AlpineJS) --}}
    @if (session()->has('message'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition.duration.500ms
        class="mb-4 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-md shadow-sm">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700">{{ session('message') }}</p>
            </div>
        </div>
    </div>
    @endif

    @if (session()->has('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition.duration.500ms
        class="mb-4 bg-red-50 border-l-4 border-red-400 p-4 text-red-700 text-sm rounded-r-md shadow-sm">
        {{ session('error') }}
    </div>
    @endif

    {{-- Tabel User Responsive --}}
    {{-- FIX: overflow-hidden di parent luar, overflow-x-auto di parent dalam --}}
    <div class="bg-white shadow-sm ring-1 ring-slate-900/5 sm:rounded-xl overflow-hidden">
        <div class="w-full overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-900 sm:pl-6 whitespace-nowrap">Nama Pengguna</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900 whitespace-nowrap">Email</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900 whitespace-nowrap">Role</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900 whitespace-nowrap">Aktivitas Terakhir</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 whitespace-nowrap">
                            <span class="sr-only">Aksi</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse ($users as $user)
                    {{-- Tambahkan wire:key agar render ulang livewire efisien --}}
                    <tr wire:key="{{ $user->id }}" class="hover:bg-slate-50 transition duration-150 ease-in-out">
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-900 sm:pl-6">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold mr-3 border border-blue-200">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                {{ $user->name }}
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $user->email }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                {{ $user->role ?? 'User' }}
                            </span>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">
                            @if($user->last_activity)
                            <span class="text-green-600 flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>
                                {{ \Carbon\Carbon::parse($user->last_activity)->diffForHumans() }}
                            </span>
                            @else
                            <span class="text-slate-400 italic text-xs">Offline</span>
                            @endif
                        </td>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <button wire:click="edit({{ $user->id }})" class="text-blue-600 hover:text-blue-900 mr-4 font-semibold">Edit</button>

                            {{-- Ganti tombol hapus untuk memanggil confirmDelete --}}
                            <button wire:click="confirmDelete({{ $user->id }})"
                                class="text-red-600 hover:text-red-900 font-semibold">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-slate-500 italic">
                            Belum ada data user.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="bg-slate-50 px-4 py-3 border-t border-slate-200 sm:px-6">
            {{ $users->links() }}
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- MODAL EDIT USER --}}
    {{-- ========================================== --}}
    @if($isEditing)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"></div> {{-- Backdrop blur --}}

        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-semibold leading-6 text-slate-900 mb-4">Edit User</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium leading-6 text-slate-900">Nama Lengkap</label>
                            <div class="mt-2">
                                <input type="text" wire:model="name" class="block w-full rounded-md border-0 py-2 px-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium leading-6 text-slate-900">Email</label>
                            <div class="mt-2">
                                <input type="email" wire:model="email" disabled class="block w-full rounded-md border-0 py-2 px-3 text-slate-500 bg-slate-100 shadow-sm ring-1 ring-inset ring-slate-300 sm:text-sm sm:leading-6 cursor-not-allowed">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" wire:click="update" wire:loading.attr="disabled" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:ml-3 sm:w-auto transition">
                        <span wire:loading.remove wire:target="update">Simpan</span>
                        <span wire:loading wire:target="update">Menyimpan...</span>
                    </button>
                    <button type="button" wire:click="cancel" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto transition">Batal</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ========================================== --}}
    {{-- MODAL HAPUS USER (DELETE CONFIRMATION) --}}
    {{-- ========================================== --}}
    @if($isDeleting)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        {{-- Backdrop dengan animasi fade-in sederhana --}}
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"></div>

        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            {{-- Modal Content dengan animasi scale --}}
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-red-100">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        {{-- Icon Warning Merah --}}
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-lg font-semibold leading-6 text-slate-900" id="modal-title">Hapus Pengguna?</h3>
                            <div class="mt-2">
                                <p class="text-sm text-slate-500">
                                    Apakah Anda yakin ingin menghapus data pengguna ini? Tindakan ini tidak dapat dibatalkan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    {{-- Tombol Hapus Merah --}}
                    <button type="button" wire:click="delete" wire:loading.attr="disabled" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto transition">
                        <span wire:loading.remove wire:target="delete">Ya, Hapus</span>
                        <span wire:loading wire:target="delete">Menghapus...</span>
                    </button>
                    {{-- Tombol Batal --}}
                    <button type="button" wire:click="cancel" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto transition">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>