<div>

    <div class="fixed top-8 left-1/2 -translate-x-1/2 z-50 animate-pulse"
         wire:loading>
        <x-preloader class="bg-lime-700/60 text-white border border-lime-700 shadow-2xl">
            {{ $loading }}
        </x-preloader>
    </div>

    <div class="grid grid-cols-3 gap-4">
        <div>
            <x-label for="nameOrDescription" value="Filter"/>
            <x-input id="nameOrDescription" type="text"
                     class="block mt-1 w-full"
                     placeholder="Filter on course name or description"/>
        </div>
        <div>
            <x-label for="programme" value="Programme"/>
            <x-form.select id="programme"
                           class="block mt-1 w-full">
                <option value="%">All Programmes</option>
                @foreach($allProgrammes as $p)
                    <option value="{{ $p->id }}">
                        {{ $p->name }}
                    </option>
                @endforeach
            </x-form.select>
        </div>
        <div>
            <x-label for="perPage" value="Courses per page"/>
            <x-form.select id="perPage"
                           class="block mt-1 w-full">
                @foreach ([6,9,12,15,18,24] as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </x-form.select>
        </div>
    </div>

    {{-- master section: cards with paginationlinks --}}
    <div class="my-4">{{ $allCourses->links() }}</div>
    <div class="grid grid-cols-3 gap-6 mt-8">
        @foreach($allCourses as $course)
            <div class="flex flex-col bg-white border border-gray-300 shadow-md rounded-lg overflow-hidden">
                <div class="border-b-2 border-neutral-100 px-6 py-3 text-center text-sm font-bold">
                    {{$course->programme->name}}
                </div>
                <div class="px-6">
                    <p class="text-md font-bold my-4">{{$course->name}}</p>
                    <p class="text-sm my-6">{{$course->description}}</p>
                </div>
                <div class="mt-auto border-t-2 border-neutral-100 px-6 py-3 text-center">
                    <button type="button" class="block rounded w-full px-6 pb-2 pt-2.5 text-white bg-blue-500 text-sm">Manage students</button>
                </div>
            </div>
        @endforeach
    </div>
    <div class="my-4">{{ $allCourses->links() }}</div>
</div>
