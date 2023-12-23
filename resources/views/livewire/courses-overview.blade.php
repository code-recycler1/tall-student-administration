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
            <x-form.select id="programme" class="block mt-1 w-full">
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
            <x-form.select id="perPage" class="block mt-1 w-full">
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
            <div wire:key="course-{{$course->id}}"
                 class="flex flex-col bg-white border border-gray-300 shadow-md rounded-lg overflow-hidden">
                <div class="border-b-2 border-neutral-100 px-6 py-3 text-center text-sm font-bold">
                    {{$course->programme->name}}
                </div>
                <div class="px-6">
                    <p class="text-md font-bold my-4">{{$course->name}}</p>
                    <p class="text-sm my-6">{{$course->description}}</p>
                </div>
                <div class="mt-auto border-t-2 border-neutral-100 px-6 py-3 text-center">
                    <x-form.button
                        wire:click="showCourseDetails({{$course->id}})"
                        disabled="{{$course->student_courses_count === 0}}" type="button" color="primary" text="sm">
                        Manage students
                    </x-form.button>
                </div>
            </div>
        @endforeach
    </div>
    <div class="my-4">{{ $allCourses->links() }}</div>

    {{-- Modal for selected course details --}}
    <x-modal wire:model="showCourseDetailsModal">
        <div class="p-8">
            <div class="pb-4">
                <h1 class="font-bold text-xl">{{ $selectedCourse->name ?? '' }}</h1>
            </div>
            <div class="mb-4">
                <p class="text-sm">{{ $selectedCourse->description ?? '' }}</p>
            </div>
            <div class="pt-4 border-t-2">
                @foreach($selectedCourse->studentCourses ?? [] as $studentCourse)
                    <p class="text-sm">
                        {{$studentCourse->student->first_name}} {{$studentCourse->student->last_name}}
                        (semester {{$studentCourse->semester}})
                    </p>
                @endforeach
            </div>
        </div>
    </x-modal>
</div>
