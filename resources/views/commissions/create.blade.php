<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Commission Order - Creative Portfolio</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&family=Anton&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <span class="font-['Dancing_Script'] text-2xl text-[#0d328f]">Creative</span>
                    <span class="font-['Anton'] text-xl text-[#0d328f]">Portfolio</span>
                </a>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-[#0d328f] transition">Home</a>
                    @auth
                        <a href="{{ route('commissions.status') }}" class="text-gray-600 hover:text-[#0d328f] transition">My Commissions</a>
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="bg-[#0d328f] text-white px-4 py-2 rounded-lg hover:bg-[#0a256b] transition">Admin</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-[#0d328f] transition">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-[#0d328f] transition">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-[#0d328f] to-blue-900 text-white py-16">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h1 class="font-['Dancing_Script'] text-6xl mb-4">Commission Order</h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                Ready to bring your character ideas to life? Fill out the form below and let's create something amazing together!
            </p>
        </div>
    </section>

    <!-- Order Form -->
    <section class="py-12 px-4">
        <div class="max-w-3xl mx-auto">
            @if (session('success'))
                <div class="mb-8 p-6 bg-green-50 border border-green-200 rounded-xl">
                    <p class="text-green-600 text-center">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <form action="{{ route('commissions.store') }}" method="POST" enctype="multipart/form-data" id="commissionForm">
                    @csrf

                    <!-- Contact Information -->
                    <div class="mb-8">
                        <h2 class="font-['Anton'] text-xl uppercase tracking-wider text-[#0d328f] mb-4">Contact Information</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="client_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Your Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="client_name" 
                                       name="client_name" 
                                       value="{{ old('client_name') }}"
                                       required
                                       maxlength="255"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0d328f] focus:border-transparent outline-none transition @error('client_name') border-red-500 @enderror"
                                       placeholder="Your full name">
                                @error('client_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="client_email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       id="client_email" 
                                       name="client_email" 
                                       value="{{ old('client_email') }}"
                                       required
                                       maxlength="255"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0d328f] focus:border-transparent outline-none transition @error('client_email') border-red-500 @enderror"
                                       placeholder="your@email.com">
                                @error('client_email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="client_discord" class="block text-sm font-medium text-gray-700 mb-2">
                                    Discord Username (Optional)
                                </label>
                                <input type="text" 
                                       id="client_discord" 
                                       name="client_discord" 
                                       value="{{ old('client_discord') }}"
                                       maxlength="100"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0d328f] focus:border-transparent outline-none transition @error('client_discord') border-red-500 @enderror"
                                       placeholder="username#1234">
                                @error('client_discord')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Commission Details -->
                    <div class="mb-8">
                        <h2 class="font-['Anton'] text-xl uppercase tracking-wider text-[#0d328f] mb-4">Commission Details</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Project Description <span class="text-red-500">*</span>
                                </label>
                                <textarea id="description" 
                                          name="description" 
                                          rows="6"
                                          required
                                          minlength="50"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0d328f] focus:border-transparent outline-none transition @error('description') border-red-500 @enderror"
                                          placeholder="Describe your character(s) in detail. Include personality, backstory, preferred colors, clothing style, pose preferences, and any other important details...">{{ old('description') }}</textarea>
                                <p class="mt-1 text-sm text-gray-500">Minimum 50 characters. Be as detailed as possible!</p>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="character_type" class="block text-sm font-medium text-gray-700 mb-2">
                                        Art Style
                                    </label>
                                    <select id="character_type" 
                                            name="character_type"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0d328f] focus:border-transparent outline-none transition @error('character_type') border-red-500 @enderror">
                                        <option value="">Select style...</option>
                                        <option value="Anime" {{ old('character_type') == 'Anime' ? 'selected' : '' }}>Anime</option>
                                        <option value="Manga" {{ old('character_type') == 'Manga' ? 'selected' : '' }}>Manga</option>
                                        <option value="Realistic" {{ old('character_type') == 'Realistic' ? 'selected' : '' }}>Realistic</option>
                                        <option value="Semi-Realistic" {{ old('character_type') == 'Semi-Realistic' ? 'selected' : '' }}>Semi-Realistic</option>
                                        <option value="Chibi" {{ old('character_type') == 'Chibi' ? 'selected' : '' }}>Chibi</option>
                                        <option value="Cartoon" {{ old('character_type') == 'Cartoon' ? 'selected' : '' }}>Cartoon</option>
                                        <option value="Fantasy" {{ old('character_type') == 'Fantasy' ? 'selected' : '' }}>Fantasy</option>
                                        <option value="Other" {{ old('character_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('character_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="character_count" class="block text-sm font-medium text-gray-700 mb-2">
                                        Number of Characters <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           id="character_count" 
                                           name="character_count" 
                                           value="{{ old('character_count', 1) }}"
                                           required
                                           min="1"
                                           max="10"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0d328f] focus:border-transparent outline-none transition @error('character_count') border-red-500 @enderror">
                                    @error('character_count')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="budget" class="block text-sm font-medium text-gray-700 mb-2">
                                        Budget (USD)
                                    </label>
                                    <input type="number" 
                                           id="budget" 
                                           name="budget" 
                                           value="{{ old('budget') }}"
                                           min="0"
                                           step="0.01"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0d328f] focus:border-transparent outline-none transition @error('budget') border-red-500 @enderror"
                                           placeholder="50.00">
                                    @error('budget')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="deadline" class="block text-sm font-medium text-gray-700 mb-2">
                                        Desired Deadline
                                    </label>
                                    <input type="date" 
                                           id="deadline" 
                                           name="deadline" 
                                           value="{{ old('deadline') }}"
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0d328f] focus:border-transparent outline-none transition @error('deadline') border-red-500 @enderror">
                                    @error('deadline')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reference Images -->
                    <div class="mb-8">
                        <h2 class="font-['Anton'] text-xl uppercase tracking-wider text-[#0d328f] mb-4">Reference Images</h2>
                        <div>
                            <label for="reference_images" class="block text-sm font-medium text-gray-700 mb-2">
                                Upload References (Optional)
                            </label>
                            <input type="file" 
                                   id="reference_images" 
                                   name="reference_images[]" 
                                   accept="image/*"
                                   multiple
                                   onchange="previewImages(this)"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0d328f] focus:border-transparent outline-none transition @error('reference_images.*') border-red-500 @enderror">
                            <p class="mt-1 text-sm text-gray-500">Upload up to 5 images. Max 5MB each.</p>
                            @error('reference_images.*')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <div id="imagePreviews" class="grid grid-cols-4 gap-3 mt-4"></div>
                        </div>
                    </div>

                    <!-- Terms -->
                    <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                        <h3 class="font-medium text-gray-800 mb-2">Before submitting, please note:</h3>
                        <ul class="text-sm text-gray-600 space-y-1 list-disc list-inside">
                            <li>You will receive a confirmation email once your order is reviewed</li>
                            <li>Response time is typically within 2-3 business days</li>
                            <li>50% payment is required upfront to begin work</li>
                            <li>Revisions are included (up to 3 minor changes)</li>
                            <li>Commercial use requires additional licensing</li>
                        </ul>
                    </div>

                    <!-- Submit -->
                    <div class="flex items-center justify-between">
                        <a href="{{ route('home') }}" class="text-gray-600 hover:text-[#0d328f] transition">
                            ← Back to Home
                        </a>
                        <button type="submit" 
                                class="bg-[#0d328f] text-white px-10 py-4 rounded-full font-['Anton'] tracking-wider uppercase hover:bg-[#0a256b] transition duration-300 shadow-lg hover:shadow-xl">
                            Submit Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="font-['Dancing_Script'] text-2xl mb-2">Creative Portfolio</p>
            <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} All rights reserved.</p>
        </div>
    </footer>

    @push('scripts')
    <script>
    function previewImages(input) {
        const previewContainer = document.getElementById('imagePreviews');
        previewContainer.innerHTML = '';
        
        if (input.files) {
            const maxFiles = Math.min(input.files.length, 5);
            
            for (let i = 0; i < maxFiles; i++) {
                const file = input.files[i];
                
                // Validate file size
                if (file.size > 5 * 1024 * 1024) {
                    alert('File ' + file.name + ' is too large. Maximum size is 5MB.');
                    continue;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg">
                    `;
                    previewContainer.appendChild(div);
                }
                reader.readAsDataURL(file);
            }
        }
    }

    // Form validation
    document.getElementById('commissionForm').addEventListener('submit', function(e) {
        const name = document.getElementById('client_name').value.trim();
        const email = document.getElementById('client_email').value.trim();
        const description = document.getElementById('description').value.trim();
        const characterCount = document.getElementById('character_count').value;
        
        if (!name) {
            e.preventDefault();
            alert('Please enter your name.');
            document.getElementById('client_name').focus();
            return false;
        }
        
        if (!email) {
            e.preventDefault();
            alert('Please enter your email address.');
            document.getElementById('client_email').focus();
            return false;
        }
        
        if (!description || description.length < 50) {
            e.preventDefault();
            alert('Please provide a detailed description (at least 50 characters).');
            document.getElementById('description').focus();
            return false;
        }
        
        if (characterCount < 1 || characterCount > 10) {
            e.preventDefault();
            alert('Character count must be between 1 and 10.');
            document.getElementById('character_count').focus();
            return false;
        }
    });
    </script>
    @endpush
</body>
</html>
