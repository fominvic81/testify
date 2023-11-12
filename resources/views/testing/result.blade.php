<x-layouts.base class="bg-gray-100" title="Результат тестування">
    <div class="w-full h-14 bg-emerald-400 shadow-md"></div>

    <div class="w-full max-w-3xl mx-auto ">
        <div class="mt-5 p-3 bg-white rounded-md shadow-md">
            <div class="text-xl font-semibold">
                {{ $session->test->name }}
            </div>
            <hr class="my-3">
            <div class="w-max mx-auto text-lg font-semibold">Задав(ла): {{ $session->exam->user->fullname }}</div>
            <div class="w-max mx-auto text-lg font-semibold">Виконав(ла): {{ $session->student_name }}</div>
            <div class="w-max mx-auto text-lg font-semibold">Почато: {{ App\Helpers\Timezone::getDatetime($session->created_at, 'Y:m:d H:i') }}</div>
            <div class="w-max mx-auto text-lg font-semibold">Витрачено часу: {{ preg_replace('/^00:/', '', date('H:i:s', $session->ends_at->timestamp - $session->created_at->timestamp)) }}</div>
            @if ($session->settings->show_result)
                <hr class="my-3">
                <div class="mx-20 grid grid-cols-[auto_1fr] md:grid-cols-[repeat(2,auto_1fr)] items-center gap-3 my-2 text-xl whitespace-nowrap">
                    <div>Оцінка:</div>
                    <div class="bg-gray-200 max-w-sm ml-2 p-2 grow text-center rounded font-bold">{{ round($session->stats()['points']) }} / {{ $session->settings->points_max }}</div>
                    <div>Тестові Бали:</div>
                    <div class="bg-gray-200 max-w-sm ml-2 p-2 grow text-center rounded font-bold">{{ round($session->stats()['correct']) }} / {{ $session->stats()['max'] }}</div>
                </div>
                <x-session.pointsbar :stats="$session->stats()" class="mx-8"></x-session.pointsbar>
            @endif
        </div>
    </div>

    @if ($session->settings->show_result)
        @foreach ($session->test->questions as $question)
            {{-- TODO --}}
        @endforeach
    @endif

</x-layouts.base>