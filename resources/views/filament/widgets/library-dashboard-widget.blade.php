<x-filament::section heading="Dashboard Perpustakaan">
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <x-filament::card>
            <div class="text-sm text-gray-500">Welcome</div>
            <div class="text-2xl font-bold">{{ $userName }}</div>
            <div class="mt-2 text-xs text-gray-500">Senang melihatmu kembali 👋</div>
        </x-filament::card>

        <x-filament::card>
            <div class="text-sm text-gray-500">Filament Version</div>
            <div class="text-2xl font-bold">{{ $filamentVersion }}</div>
            <div class="mt-2 text-xs text-gray-500">Laravel {{ $laravelVersion }}</div>
        </x-filament::card>
    </div>
</x-filament::section>
