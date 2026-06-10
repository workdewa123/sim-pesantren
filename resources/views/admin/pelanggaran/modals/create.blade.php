<div id="modal-create-pelanggaran" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="tutupModal('create')"></div>
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 w-full sm:max-w-xl border border-slate-200">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Catat Pelanggaran Santri</h3>
                    <p class="text-[10px] text-slate-500 mt-0.5 uppercase tracking-wider font-semibold">Petugas: {{ Auth::user()->name }}</p>
                </div>
                <button type="button" onclick="tutupModal('create')" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-100 transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <form action="{{ route('admin.pelanggaran.store') }}" method="POST" class="p-6 space-y-4 text-sm">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-tight">Pilih Nama Santri</label>
                    <select name="santri_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all bg-white text-slate-700 cursor-pointer">
                        <option value="" selected disabled>-- Cari & Pilih Santri --</option>
                        @foreach($daftarSantri as $snt)
                            <option value="{{ $snt->id }}">{{ $snt->nama_santri }} ({{ $snt->nama_kelas ?? 'Tanpa Kelas' }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-tight">Tanggal Kejadian</label>
                        <input type="date" name="tanggal_pelanggaran" value="{{ date('Y-m-d') }}" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-tight">Tingkat Kategori</label>
                        <select name="kategori_pelanggaran" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all bg-white text-slate-700 cursor-pointer">
                            <option value="Ringan">Ringan</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Berat">Berat</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-tight">Kronologi / Bentuk Takzir</label>
                    <textarea name="deskripsi_pelanggaran" rows="4" placeholder="Tuliskan detail kesalahan santri di sini..." required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all"></textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" onclick="tutupModal('create')" class="px-4 py-2 border border-slate-200 text-slate-500 rounded-xl text-xs font-semibold hover:bg-slate-50 transition-colors">Batal</button>
                    <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition-all shadow-md shadow-emerald-700/10">
                        <i class="fa-solid fa-save mr-1"></i> Simpan Catatan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>