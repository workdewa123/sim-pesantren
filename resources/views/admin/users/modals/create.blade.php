<div id="modalCreate" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 transition-all duration-300">
    <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl border border-slate-100 overflow-hidden transform transition-all">
        
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-start relative">
            <div class="flex gap-4">
                <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-700 shrink-0 border border-emerald-100/50">
                    <i class="fa-solid fa-user-plus text-base"></i>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-slate-800 tracking-tight">Tambah Pengguna Baru</h3>
                    <p class="text-slate-400 text-[11px] mt-0.5 font-medium">Daun akun login akses manajemen sistem baru.</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modalCreate')" class="text-slate-400 hover:text-slate-600 transition-colors p-1.5 rounded-lg hover:bg-slate-50 cursor-pointer">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" class="text-xs">
            @csrf
            <div class="px-6 py-4 space-y-4">
                <div class="pb-3 border-b border-slate-50">
                    <label class="block font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="Masukkan nama staf / pengurus" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600 focus:ring-4 focus:ring-emerald-600/5 bg-slate-50 focus:bg-white transition-all placeholder:text-slate-400">
                </div>
                
                <div class="pb-3 border-b border-slate-50">
                    <label class="block font-semibold text-slate-700 mb-1.5">Alamat Email Resmi</label>
                    <input type="email" name="email" required placeholder="contoh@pesantren.com" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600 focus:ring-4 focus:ring-emerald-600/5 bg-slate-50 focus:bg-white transition-all placeholder:text-slate-400">
                </div>
                
                <div class="pb-2">
                    <label class="block font-semibold text-slate-700 mb-1.5">Kata Sandi Akses</label>
                    <input type="password" name="password" required placeholder="Minimal 6 karakter kombinasi" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600 focus:ring-4 focus:ring-emerald-600/5 bg-slate-50 focus:bg-white transition-all placeholder:text-slate-400">
                </div>
            </div>

            <div class="px-6 py-4 bg-slate-50/60 border-t border-slate-100 flex justify-end gap-2">
                <button type="button" onclick="closeModal('modalCreate')" class="px-4 py-2.5 bg-white hover:bg-slate-100 text-slate-600 border border-slate-200 rounded-xl font-bold transition-all cursor-pointer">Batal</button>
                <button type="submit" class="px-4 py-2.5 bg-emerald-800 hover:bg-emerald-900 text-white rounded-xl font-bold shadow-sm shadow-emerald-800/10 transition-all cursor-pointer">Simpan Akun</button>
            </div>
        </form>
    </div>
</div>