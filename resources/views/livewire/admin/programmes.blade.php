<div>
    <x-layout.section
        x-data="{ open: false }"
        class="p-0 mb-4 flex flex-col gap-2">
        <div class="p-4 flex justify-between items-start gap-4">
            <div class="relative w-64">
                <x-input id="newProgramme" type="text" placeholder="New programme"
                         @keydown.enter="$el.setAttribute('disabled', true); $el.value = '';"
                         @keydown.tab="$el.setAttribute('disabled', true); $el.value = '';"
                         @keydown.esc="$el.setAttribute('disabled', true); $el.value = '';"
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
                    <td class="text-left cursor-pointer">
                        {{$programme->name}}
                    </td>
                    <td>
                        <div class="flex gap-1 justify-end [&>*]:cursor-pointer [&>*]:outline-0 [&>*]:transition">
                            <x-phosphor-pencil-line-duotone
                                class="w-5 text-gray-300 hover:text-green-600"/>
                            <x-phosphor-trash-duotone
                                class="w-5 text-gray-300 hover:text-red-600"/>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </x-layout.section>
</div>
