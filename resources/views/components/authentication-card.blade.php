<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-slate-50">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-10 py-10 bg-white shadow-xl shadow-slate-200/50 overflow-hidden sm:rounded-[2rem] border border-slate-100">
        {{ $slot }}
    </div>
    
    <p class="mt-8 text-xs text-slate-400 font-medium tracking-widest uppercase">
        &copy; {{ date('Y') }} {{ config('app.name') }}
    </p>
</div>