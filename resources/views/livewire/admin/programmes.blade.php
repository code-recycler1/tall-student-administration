<div>
    <div wire:loading
         class="fixed top-8 left-1/2 -translate-x-1/2 z-50 animate-pulse">
        <x-preloader class="bg-lime-700/60 text-white border border-lime-700 shadow-2xl">
            {{ $loading }}
        </x-preloader>
    </div>

    <x-layout.section
        x-data="{ open: false }"
        class="p-0 mb-4 flex flex-col gap-2">
        <div class="p-4 flex justify-between items-start gap-4">
            <div class="relative w-64">
                <x-input id="newProgramme" type="text" placeholder="New programme"
                         @keydown.enter="handleInputKeydown"
                         @keydown.tab="handleInputKeydown"
                         @keydown.esc="handleInputKeydown"
                         wire:model="newProgramme"
                         wire:keydown.enter="create()"
                         wire:keydown.tab="create()"
                         class="w-full shadow-md placeholder-gray-300"/>
                <x-phosphor-arrows-clockwise
                    wire:loading
                    wire:target="create"
                    class="w-5 h-5 text-gray-500 absolute top-3 right-2 animate-spin"/>
            </div>
            <x-heroicon-o-information-circle
                @click="open = !open"
                class="w-5 text-gray-400 cursor-help outline-0"/>
        </div>
        <x-input-error for="newProgramme" class="m-4 -mt-4 w-full"/>
        <div
            x-show="open"
            x-transition
            style="display: none"
            class="text-sky-900 bg-sky-50 border-t p-4">
            <x-list type="ul" class="list-outside mx-4 text-sm">
                <li>
                    <b>A new programme</b> can be added by typing in the input field and pressing <b>enter</b> or
                    <b>tab</b>. Press <b>escape</b> to undo.
                </li>
                <li>
                    <b>Edit a programme</b> by clicking the
                    <x-phosphor-pencil-line-duotone class="w-5 inline-block"/>
                    icon or by clicking on the programme name. Press <b>enter</b> to save, <b>escape</b> to undo.
                </li>
                <li>
                    Clicking the
                    <x-heroicon-o-information-circle class="w-5 inline-block"/>
                    icon will toggle this message on and off.
                </li>
            </x-list>
        </div>
    </x-layout.section>

    <x-layout.section>
        <div class="my-4">{{ $allProgrammes->links() }}</div>
        <table class="text-center w-full border border-gray-300">
            <colgroup>
                <col class="w-20">
                <col class="w-60">
                <col class="w-max">
                <col class="w-20">
            </colgroup>
            <thead>
            <tr class="bg-gray-100 text-gray-700 [&>th]:p-2 cursor-pointer">
                <th wire:click="resort('id')">
                    <span>#</span>
                    <x-heroicon-s-chevron-up
                            class="w-5 text-slate-400
                {{$orderAsc ?: 'rotate-180'}}
                {{$orderBy === 'id' ? 'inline-block' : 'hidden'}}"/>
                </th>
                <th wire:click="resort('courses_count')">
                <span>
                    Amount of courses
                </span>
                    <x-heroicon-s-chevron-up
                            class="w-5 text-slate-400
                {{$orderAsc ?: 'rotate-180'}}
                {{$orderBy === 'courses_count' ? 'inline-block' : 'hidden'}}"/>
                </th>
                <th wire:click="resort('name')" class="text-left">
                    <span>Programme</span>
                    <x-heroicon-s-chevron-up
                            class="w-5 text-slate-400
                {{$orderAsc ?: 'rotate-180'}}
                {{$orderBy === 'name' ? 'inline-block' : 'hidden'}}"/>
                </th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($allProgrammes as $programme)
                <tr wire:key="programme-{{$programme->id}}"
                    class="border-t border-gray-300 [&>td]:p-2">
                    <td>{{$programme->id}}</td>
                    <td>{{$programme->courses_count}}</td>
                    @if($editProgramme['id'] !== $programme->id)
                        <td wire:click="edit({{ $programme->id }})"
                            class="text-left cursor-pointer">
                            {{$programme->name}}
                        </td>
                    @else
                        <td>
                            <div class="relative text-left w-full">
                                <x-input id="edit_{{ $programme->id }}" type="text"
                                         x-init="$el.focus()"
                                         @keydown.enter="$el.setAttribute('disabled', true);"
                                         @keydown.tab="$el.setAttribute('disabled', true);"
                                         @keydown.esc="$el.setAttribute('disabled', true);"
                                         wire:model="editProgramme.name"
                                         wire:keydown.enter="update({{ $programme->id }})"
                                         wire:keydown.tab="update({{ $programme->id }})"
                                         wire:keydown.escape="resetValues()"
                                         class="w-full"/>
                                <x-phosphor-arrows-clockwise
                                        wire:loading
                                        wire:target="update"
                                        class="w-5 h-5 text-gray-500 absolute top-3 right-2 animate-spin"/>
                                <x-input-error for="editProgramme.name" class="mt-2"/>
                            </div>
                        </td>
                    @endif
                    <td>
                        @if($editProgramme['id'] !== $programme->id)
                            <div class="flex gap-1 justify-end [&>*]:cursor-pointer [&>*]:outline-0 [&>*]:transition">
                                <x-phosphor-pencil-line-duotone
                                        wire:click="edit({{ $programme->id }})"
                                        class="w-5 text-gray-300 hover:text-green-600"/>
                                <x-phosphor-book-duotone
                                        wire:click="newCourse({{ $programme->id }})"
                                        class="w-5 text-gray-300 hover:text-blue-600"/>
                                <x-phosphor-trash-duotone
                                        wire:click="remove({{$programme->id}}, {{$programme->courses_count}})"
                                        class="w-5 text-gray-300 hover:text-red-600"/>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="my-4">{{ $allProgrammes->links() }}</div>
    </x-layout.section>

    {{-- Modal for edit a programme --}}
    <x-modal id="programmeModal"
             wire:model.live="showModal">
        <div class="px-6 py-4 border-b text-2xl">
            <h1>{{$selectedProgramme->name ?? ''}}</h1>
        </div>
        <form wire:submit.prevent="createCourse()">
            <div class="px-6 py-4 text-sm text-gray-600">
                @if ($errors->any())
                    <x-alert type="danger">
                        <x-list>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </x-list>
                    </x-alert>
                @endif
                <div class="border-b p-4">
                    <h2 class="text-xl">Courses</h2>
                    <div class="py-4">
                        @if ($selectedProgramme && $selectedProgramme->courses->isNotEmpty())
                            @foreach($selectedProgramme->courses as $course)
                                <p data-tippy-content="{{$course->description ?? ''}}" class="text-base w-max pb-0.5">
                                    {{$course->name ?? ''}}
                                </p>
                            @endforeach
                        @else
                            <x-alert type="danger" class="w-full">
                                There are no courses in this programme...
                            </x-alert>
                        @endif
                    </div>
                </div>
                <div class="pt-2">
                    <h2 class="text-xl">Add a course to the {{$selectedProgramme->name ?? ''}} programme</h2>
                    <x-label for="name" value="Name" class="mt-4"/>
                    <x-input wire:model="form.name"
                             id="name" type="text"
                             class="mt-1 block w-full"/>
                    <x-label for="description" value="Description" class="mt-4"/>
                    <x-form.textarea wire:model="form.description"
                                     id="description" class="block mt-1 w-full" rows="2"/>
                </div>
            </div>
            <div class="flex flex-row justify-end px-6 py-4 bg-gray-100">
                <x-secondary-button @click="$wire.showModal = false">Cancel</x-secondary-button>
                <x-form.button color="dark"
                               text="xs"
                               class="inline-flex uppercase ml-2 py-2">Add new course
                </x-form.button>
            </div>
        </form>
    </x-modal>
</div>

<script>
    function handleInputKeydown(event) {
        const element = event.target;
        element.setAttribute('disabled', true);
        element.value = '';
    }
</script>
