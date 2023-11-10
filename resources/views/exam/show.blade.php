<x-layouts.feed :title="$exam->label">
    <h1 class="text-3xl font-bold text-center">Домашнє завдання</h1>
    <div class="p-3 text-lg shadow rounded-md mt-5 bg-white">
        <h1 class="text-2xl font-bold text-center">{{ $exam->label }}</h1>
        <div class="grid grid-cols-[1fr_auto]">
            <div>
                <div>Початок: {{ App\Helpers\Timezone::getDatetime($exam->begin_at, 'H:i m.d') }}</div>
                <div>Кінець: {{ App\Helpers\Timezone::getDatetime($exam->end_at, 'H:i m.d') }}</div>
                <div>Час на виконання: {{ date('H:i', strtotime($exam->settings->time)) }}</div>
                <div>
                    Тест: <a href="{{ route('test.show', $exam->test->id) }}" class="text-blue-600 hover:text-blue-400">{{ $exam->test->name }}</a>
                </div>
            </div>
            <div>
                @if ($exam->isActive())
                    <a href="{{ route('exam.edit', $exam->id) }}" class="block w-10 h-10 rounded-md border-2 hover:bg-gray-200">
                        <x-svg path="common/edit.svg"></x-svg>
                    </a>
                @endif
            </div>
        </div>
    </div>
    <div class="p-3 text-lg shadow rounded-md mt-5 bg-white grid grid-cols-[1fr_150px]">
        @if ($exam->isActive())
            <h1 class="text-2xl font-bold text-center col-span-2">Щоб пройти тест</h1>
            <div x-data="{ copied: false }">
                <div class="w-full fixed top-0 left-0 pointer-events-none">
                    <div
                        x-cloak
                        x-bind:class="copied ? 'translate-y-4' : '-translate-y-full'"
                        class="w-max mx-auto p-3 bg-yellow-300 rounded-md transition-transform font-semibold"
                    >Скопійовано!</div>
                </div>
                <div>
                    Введіть код:
                    <span
                        x-on:click="await navigator.clipboard.writeText('{{ $exam->code }}'); clearTimeout(copied); copied = setTimeout(() => copied = 0, 1000)"
                        class="text-2xl font-semibold text-emerald-600 cursor-pointer"
                    >{{ $exam->code }}</span>
                    за посиланням
                    <span
                        x-on:click="await navigator.clipboard.writeText('{{ route('exam.join') }}'); clearTimeout(copied); copied = setTimeout(() => copied = 0, 1000)"
                        class="text-2xl font-semibold text-emerald-600 cursor-pointer"
                    >{{ route('exam.join') }}</span>
                </div>
                <div class="mt-3">
                    Або перейдіть за посиланням:
                    <span
                        class="text-2xl font-semibold text-emerald-600 cursor-pointer"
                        x-on:click="await navigator.clipboard.writeText('{{ route('exam.join', [ 'code' => $exam->code ]) }}'); clearTimeout(copied); copied = setTimeout(() => copied = 0, 1000)"
                    >{{ route('exam.join', [ 'code' => $exam->code ]) }}</span>
                </div>
            </div>
            {{-- <div class="w-full aspect-square bg-gray-100"></div> --}}
        @else
            <h1 class="text-2xl font-bold text-center col-span-2">Завершено</h1>
        @endif
    </div>
    <div class="p-3 text-lg shadow rounded-md mt-5 bg-white grid gap-2">
        <h1 class="text-2xl font-bold text-center">Результати</h1>
        @if ($exam->sessions->count() === 0)
            <div class="flex justify-center text-xl font-semibold">Результатів ще немає</div>
        @endif
        @foreach ($exam->sessions as $session)
            <div class="grid md:grid-cols-[1fr_70px_2fr] justify-stretch items-center gap-2 border-2 p-0.5 rounded">
                <div class="indent-2 font-semibold">{{ $session->student_name }}</div>
                <div class="bg-gray-200 font-bold text-center rounded border-2 border-gray-400">{{ round($session->stats()['points']) }}/{{ $session->settings->points_max }}</div>
                <x-session.pointsbar :stats="$session->stats()"></x-session.pointsbar>
            </div>
        @endforeach
    </div>
</x-layouts.feed>