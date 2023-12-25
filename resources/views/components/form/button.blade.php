@props([
    'color' => 'dark',
    'disabled' => false,
    'text'=> 'xs',
])

@php
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $options = [
        'dark' => 'bg-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:border-gray-900 focus:ring-gray-300',
        'success' => 'bg-emerald-800 hover:bg-emerald-700 active:bg-emerald-900 focus:border-emerald-900 focus:ring-emerald-300',
        'danger' => 'bg-red-800 hover:bg-red-700 active:bg-red-900 focus:border-red-900 focus:ring-red-300',
        'info' => 'bg-sky-800 hover:bg-sky-700 active:bg-sky-900 focus:border-sky-900 focus:ring-sky-300',
        'primary' => 'bg-blue-500 hover:bg-blue-700 active:bg-blue-900 focus:border-blue-900 focus:ring-blue-300',
    ];
    $style = $options[$color] ?? $options['dark'];
    if($disabled) {
        $style .= ' cursor-not-allowed disabled:opacity-25 ';
    }
@endphp

<button
        {{ $attributes->merge([
               'type' => 'submit',
               'class' => "
                   $style
                   items-center px-4 py-4 border border-transparent rounded-md text-$text text-white
                   tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out
                   duration-150"
        ])}}
        {{ $disabled ? 'disabled' : '' }}>
    {{ $slot }}
</button>
