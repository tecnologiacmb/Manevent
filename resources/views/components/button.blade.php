<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-black border border-transparent rounded-md font-semibold text-xs text-white hover:text-black uppercase tracking-widest hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100 focus:text-black focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
