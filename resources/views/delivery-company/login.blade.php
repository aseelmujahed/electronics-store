<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-tr from-blue-50 via-purple-50 to-blue-100">
        <div class="max-w-md w-full p-8 bg-white rounded-2xl shadow-xl border border-blue-100 flex flex-col items-center">
            <h2 class="text-2xl font-bold mb-2 text-blue-700 text-center">
                {{ __('Delivery Company Login') }}
            </h2>
            <p class="text-gray-500 mb-6 text-center text-sm">
                {{ __('Enter your credentials to access the delivery company dashboard.') }}
            </p>
            <form method="POST" action="{{ url('/delivery-company/login') }}" class="w-full">
                @csrf
                @if($errors->any())
                    <div class="text-red-600 mb-4 text-center text-sm rounded bg-red-50 border border-red-100 p-2">
                        {{ $errors->first() }}
                    </div>
                @endif
                <div class="mb-4">
                    <input type="email" name="email" placeholder="{{ __('Email') }}"
                        class="w-full px-4 py-2 border rounded-xl bg-blue-50 focus:bg-white focus:border-blue-400 outline-none"
                        required>
                </div>
                <div class="mb-6">
                    <input type="password" name="password" placeholder="{{ __('Password') }}"
                        class="w-full px-4 py-2 border rounded-xl bg-blue-50 focus:bg-white focus:border-blue-400 outline-none"
                        required>
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-xl shadow transition">
                    {{ __('Login') }}
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
