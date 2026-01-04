<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <div>
            <h2 class=" text-2xl font-bold text-slate-900">Log Aktivitas Sistem</h2>
            <p class="text-slate-500 text-sm">Riwayat tindakan pengguna (Audit Trail).</p>
        </div>
        <div>
            <a href="{{ url('/devices') }}" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-medium rounded-lg transition shadow-sm focus:outline-none">
                Kembali
            </a>
        </div>
    </div>

    <div class="bg-white shadow-sm ring-1 ring-slate-900/5 sm:rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Waktu</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Pelaku (User)</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Deskripsi</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">IP Address</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse ($logs as $log)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500">
                            {{ $log->created_at->format('d M Y H:i:s') }}
                            <div class="text-xs text-slate-400">{{ $log->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-6 w-6 rounded-full bg-blue-100 flex items-center justify-center text-xs font-bold text-blue-600 mr-2">
                                    {{ substr($log->user->name ?? '?', 0, 1) }}
                                </div>
                                <div class="text-sm font-medium text-slate-900">
                                    {{ $log->user->name ?? 'User Terhapus' }}
                                </div>
                            </div>
                            <div class="text-xs text-slate-400 ml-8">{{ $log->user->email ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $log->action == 'DELETE DEVICE' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-600">
                            {{ $log->description }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500 font-mono">
                            {{ $log->ip_address ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-slate-500 italic">Belum ada aktivitas tercatat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="bg-slate-50 px-4 py-3 border-t border-slate-200">
            {{ $logs->links() }}
        </div>
    </div>
</div>