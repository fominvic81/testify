<x-layouts.feed title="Профіль {{ $user->fullname }}">
    {{-- {{ $user->fullname }} --}}
    <div class="grid sm:grid-cols-[auto_1fr_auto] items-center gap-3 p-3 bg-white rounded-md shadow">
        <div class="w-20 aspect-square rounded-full border-2 border-gray-400 overflow-clip">
            <img class="w-full h-full" src="{{ App\Helpers\ImageHelper::url($user->image, URL::to('/images/profile.png')) }}" alt="">
        </div>
        <div>
            <div class="text-2xl font-semibold">{{ $user->fullname }}</div>
        </div>
        <div>
            @can('update', $user)
                <x-button.edit :href="route('user.edit', $user->id)"></x-button.edit>
            @endcan
        </div>
        <div class="col-span-full text-lg indent-2">{{ $user->about }}</div>
    </div>
    <div class="flex gap-3 mt-3">
        <a
            href="{{ route('user.show', ['user' => $user->id, 'tab' => 'tests']) }}"
            @class([
                'text-2xl border-2 border-gray-300 text-gray-600 font-bold p-2 rounded hover:bg-gray-300',
                'bg-gray-200' => (Request::query('tab') ?? 'tests') === 'tests'
            ])
        >Тести</a>
        <a
            href="{{ route('user.show', ['user' => $user->id, 'tab' => 'courses']) }}"
            @class([
                'text-2xl border-2 border-gray-300 text-gray-600 font-bold p-2 rounded hover:bg-gray-300',
                'bg-gray-200' => Request::query('tab') === 'courses'
            ])
        >Курси</a>
    </div>
    <div class="grid gap-5 my-4">
        @if ((Request::query('tab') ?? 'tests') === 'tests')
            @foreach ($tests as $test)
                <x-test.card :test="$test"></x-test.card>
            @endforeach
            {{ $tests->links() }}
        @elseif (Request::query('tab') === 'courses')
            @foreach ($courses as $course)
                <x-course.card :course="$course"></x-course.card>
            @endforeach
            {{ $courses->links() }}
        @endif
    </div>
</x-layouts.feed>