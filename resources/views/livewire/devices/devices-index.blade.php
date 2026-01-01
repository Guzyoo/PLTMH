<div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        
        <div class="p-4 border-b border-slate-200 bg-slate-50/50 flex gap-3">
             <div class="relative flex-1 max-w-sm">
                 <input type="text" class="block w-full pl-3 pr-3 py-2 border border-slate-300 rounded-lg sm:text-sm" placeholder="Search...">
             </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Identifier</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    
                    {{-- PERHATIKAN: $devices as $device (SINGULAR) --}}
                    @foreach ($devices as $device)
                    <tr class="hover:bg-slate-50 transition-colors">
                        
                        {{-- HAPUS typo $devies --}}
                        <td class="px-6 py-4 text-sm text-slate-500">
                            #{{ $device->id }}
                        </td>

                        <td class="px-6 py-4 text-sm font-medium text-slate-900">
                            {{ $device->user->name ?? 'No User' }}
                        </td>

                        {{-- JANGAN PAKE tanda $ setelah panah --}}
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $device->device_type }}
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-600 font-mono">
                            {{ $device->device_identifier }}
                        </td>

                        <td class="px-6 py-4 text-right">
                            <button class="text-blue-600 hover:underline">Edit</button>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        
        <div class="p-4">
            {{ $devices->links() }}
        </div>
    </div>
</div>