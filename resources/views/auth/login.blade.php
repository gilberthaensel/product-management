<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-900">

    <div class="w-full max-w-md p-8 space-y-4 bg-gray-800 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-center text-white">Login</h2>
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div class='flex flex-col gap-2'>
                <label for="email" class="block text-sm text-white">Email</label>
                <input type="email" name="email" id="email"
                    class="w-full bg-transparent placeholder:text-gray-400 text-white text-sm border border-slate-300 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow"
                    placeholder="Enter your email" required>
            </div>

            <div class='flex flex-col gap-2'>
                <label for="password" class="block text-sm text-white">Password</label>
                <input type="password" name="password" id="password"
                    class="w-full bg-transparent placeholder:text-gray-400 text-white text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow"
                    placeholder="Enter your password" required>
            </div>

            @if ($errors->any())
                <p class="p-2 text-sm text-red-600 bg-red-100 border border-red-400 rounded">
                    {{ $errors->first('login') }}
                </p>
            @endif
            <button type="submit" class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 transform active:scale-95 transition-transform duration-75">
                Login
            </button>
        </form>
    </div>

</body>

</html>
