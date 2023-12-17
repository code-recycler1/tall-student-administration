<nav class="container mx-auto p-4 space-x-6">
    <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">Home</x-nav-link>
    <x-nav-link href="{{ route('courses') }}" :active="request()->routeIs('courses')">Courses</x-nav-link>
</nav>
