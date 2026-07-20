<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('About Us') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                <div class="text-center py-8 border-b border-gray-100 mb-10">
                    <span class="px-3 py-1 text-xs font-semibold text-blue-600 bg-blue-100 rounded-full uppercase tracking-wider">
                        Our Platform
                    </span>
                    <h1 class="mt-3 text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">
                        Connecting Malawi
                    </h1>
                    
                    <p class="max-w-2xl mx-auto mt-4 text-xl text-gray-500">
                        {{ $settings['hero_description'] ?? 'The unified directory platform bridging communities, professional networks, and local services across all townships and districts.' }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                    <div class="p-6 bg-blue-50 rounded-xl text-center">
                        <span class="text-4xl font-extrabold text-blue-600">
                            {{ number_format($totalContacts) }}
                        </span>
                        <h4 class="text-sm font-bold text-gray-700 mt-2">Verified Registered Contacts</h4>
                    </div>

                    <div class="p-6 bg-purple-50 rounded-xl text-center">
                        <span class="text-4xl font-extrabold text-purple-600">
                            {{ number_format($totalSubscribers) }}
                        </span>
                        <h4 class="text-sm font-bold text-gray-700 mt-2">Active Newsletter Subscribers</h4>
                    </div>
                </div>

                
            <a href="stories">
                    <div class="p-6 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="w-12 h-12 bg-purple-500 text-white flex items-center justify-center rounded-lg mb-4 shadow">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Community Stories</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Discover localized stories and contextual news narratives emerging from communities across Malawi.
                        </p>
                    </div>
                </div>
                </a>

                <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-r-xl mb-12">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-bold text-blue-900">Our Mission</h4>
                            
                            <p class="mt-1 text-blue-800 text-sm leading-relaxed">
                                {{ $settings['mission_statement'] ?? 'We believe in community visibility. By structuring databases with regional specificity, our goal is to empower small township businesses, promote public transparency, and ensure finding critical support contacts is effortless.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <hr class="my-10 border-gray-200">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Want to list your details?</h3>
                        <p class="text-gray-600 mb-6 text-sm leading-relaxed">
                            Join our directory ecosystem today. Creating a profile lets thousands of users search, find, and connect with your services.
                        </p>
                        <div class="flex gap-4">
                            <a href="/register" class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-semibold rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition shadow">
                                Create a Free Profile
                            </a>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-100">
                        <h4 class="text-lg font-bold text-gray-900 mb-2">Subscribe to our newsletter</h4>
                        <p class="text-xs text-gray-500 mb-4">Stay updated with monthly regional updates and newly registered services.</p>
                        
                        @if(session('success'))
                            <div class="mb-4 p-3 bg-emerald-100 text-emerald-800 text-xs rounded-lg font-semibold">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('newsletter.subscribe') }}" method="POST">
                            @csrf
                            <div class="flex gap-2">
                                <input type="email" name="email" required placeholder="Enter your email address" 
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-lg text-white bg-gray-900 hover:bg-black focus:outline-none transition">
                                    Subscribe
                                </button>
                            </div>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>