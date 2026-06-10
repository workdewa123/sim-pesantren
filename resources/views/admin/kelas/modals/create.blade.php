<div id="modal-create-kelas" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 w-full sm:max-w-md border border-slate-200">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Pembuatan Ruang Kelas Baru</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Buat klasifikasi kelas baru untuk pemetaan santri.</p>
                </div>
                <button type="button" onclick="closeModal('create')" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-100 transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <form action="{{ route('admin.kelas.store') }}" method="POST" class="p-6 space-y-4 text-sm">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Ruang Kelas</label>
                    <input type="text" name="nama_kelas" required class="w-full px-3.5 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all" placeholder="Contoh: Kelas 1A, Kelas 2B, Jilid 3, dll.">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Wali Kelas (Ustadz)</label>
                    <select name="ustadz_id" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all bg-white text-slate-700">
                        <option value="">-- Pilih Wali Kelas (Opsional) --</option>
                        @foreach($daftarUstadz as $ustadz)
                            <option value="{{ $ustadz->id }}">{{ $ustadz->nama_ustadz }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeModal('create')" class="px-4 py-2 border border-slate-200 text-slate-500 rounded-xl text-xs font-semibold hover:bg-slate-50 transition-colors">Batal</button>
                    <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all shadow-sm">Simpan Kelas</button>
                </div>
            </form>
        </div>
    </div>
</div>