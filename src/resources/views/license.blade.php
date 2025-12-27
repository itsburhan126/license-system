<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>License Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-indigo-500 mb-2">License Verification</h1>
            <p class="text-gray-400">Please activate your product to continue.</p>
        </div>

        <div class="bg-gray-800 rounded-2xl shadow-xl p-8 border border-gray-700">
            @if(session('success'))
                <div class="bg-green-500/10 border border-green-500/20 rounded-lg p-4 mb-6 flex items-center">
                    <i class="fas fa-check-circle text-green-400 mr-3 text-xl"></i>
                    <p class="text-green-400 text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-500/10 border border-red-500/20 rounded-lg p-4 mb-6">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-circle text-red-400 mr-2"></i>
                        <h3 class="text-red-400 font-medium">Verification Failed</h3>
                    </div>
                    <ul class="list-disc list-inside text-red-300 text-sm pl-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('license.verify') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-gray-400 text-sm font-bold mb-2" for="license_key">
                        License Key
                    </label>
                    <input class="w-full bg-gray-700 text-white border border-gray-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-gray-600 focus:border-indigo-500 transition-colors" 
                           id="license_key" type="text" name="license_key" placeholder="LIC-XXXXXXXXXXXXXXXX" required>
                </div>
                
                <button class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-3 px-4 rounded focus:outline-none focus:shadow-outline transition-all transform hover:scale-[1.02]" type="submit">
                    Verify License
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-400 text-sm">Don't have a license?</p>
                <a href="{{ $serverUrl ?? '#' }}" target="_blank" class="text-indigo-400 hover:text-indigo-300 font-semibold text-sm flex items-center justify-center gap-2 mt-2">
                    Get License from OwnerPanel <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
