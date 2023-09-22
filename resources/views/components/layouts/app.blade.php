<x-layouts.base class="overflow-x-clip overflow-y-auto bg-gray-100">
    <div class="flex flex-col min-h-full relative">
        <x-parts.header></x-parts.header>
        <main class="flex-grow h-0">
            {{ $slot }}
            {{-- {{ auth()->user() }} --}}
        </main>
        <x-parts.footer></x-parts.footer>
    </div>
</x-layouts.base>