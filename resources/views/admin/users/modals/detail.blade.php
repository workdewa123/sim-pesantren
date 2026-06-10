<div id="modalDetail" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 transition-all duration-300">
    <div class="bg-white rounded-2xl w-full max-w-sm shadow-2xl border border-slate-100 overflow-hidden transform transition-all">
        
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-start relative">
            <div class="flex gap-4">
                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-700 shrink-0 border border-blue-100/50">
                    <i class="fa-solid fa-circle-user text-base"></i>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-slate-800 tracking-tight">Profil Pengguna</h3>
                    <p class="text-slate-400 text-[11px] mt-0.5 font-medium">Informasi data pokok pengguna sistem.</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modalDetail')" class="text-slate-400 hover:text-slate-600 transition-colors p-1.5 rounded-lg hover:bg-slate-50 cursor-pointer">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <div class="p-6 text-xs space-y-4">
            <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                <div class="w-12 h-12 bg-slate-50 border border-slate-200 rounded-full flex items-center justify-center text-slate-400 text-lg">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div>
                    <h4 id="detail_name" class="font-bold text-sm text-slate-800">-</h4>
                    <p id="detail_email" class="text-slate-400 font-medium"></p>
                </div>
            </div>

            <div class="space-y-3 pt-1">
                <div class="flex justify-between items-center py-2 border-b border-slate-50">
                    <span class="text-slate-400 font-medium">ID Pengguna</span>
                    <span id="detail_id" class="font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded-md text-[10px]">-</span>
                </div>
                
                <div class="flex justify-between items-center py-2 border-b border-slate-50">
                    <span class="text-slate-400 font-medium">Status Akun</span>
                    <span class="font-bold text-emerald-700 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-md text-[10px]">Aktif</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-slate-400 font-medium">Tanggal Registrasi</span>
                    <span id="detail_created" class="font-semibold text-slate-700">-</span>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-slate-50/60 border-t border-slate-100 flex justify-end">
            <button type="button" onclick="closeModal('modalDetail')" class="w-full py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl font-bold shadow-sm transition-all text-center cursor-pointer">Tutup Jendela</button>
        </div>
    </div>
</div>