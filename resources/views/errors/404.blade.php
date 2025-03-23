<x-app-layout>
    <div class="container text-center text-white">
        <h1 class="text-white text-2xl font-bold">404</h1>
        <p class="text-xl font-semibold">{{ $message ?? 'The page you are looking for does not exist.' }}</p>
        <a href="{{ url('/') }}" class="btn">Go Home</a>
    </div>
</x-app-layout>
