<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Información de Perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Actualiza la información de tu perfil y dirección de correo electrónico.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-label for="firstName" :value="__('Nombre')" />
            <x-input id="firstName" name="firstName" type="text" class="mt-1 block w-full" :value="old('firstName', $user->firstName)" required autofocus autocomplete="firstName" />
            <x-input-error class="mt-2" :messages="$errors->get('firstName')" />
        </div>

        <div>
            <x-label for="lastName" :value="__('Apellido')" />
            <x-input id="lastName" name="lastName" type="text" class="mt-1 block w-full" :value="old('lastName', $user->lastName)" required autocomplete="lastName" />
            <x-input-error class="mt-2" :messages="$errors->get('lastName')" />
        </div>

        <div>
            <x-label for="email" :value="__('Email')" />
            <x-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Tu dirección de correo electrónico no está verificada.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Haz clic aquí para reenviar el correo de verificación.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Se ha enviado un nuevo enlace de verificación a tu dirección de correo electrónico.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-label for="phoneNumber" :value="__('Teléfono')" />
            <x-input id="phoneNumber" name="phoneNumber" type="text" class="mt-1 block w-full" :value="old('phoneNumber', $user->phoneNumber)" autocomplete="phoneNumber" />
            <x-input-error class="mt-2" :messages="$errors->get('phoneNumber')" />
        </div>

        <div>
            <x-label for="MunicipalityId" :value="__('Municipio')" />
            <select id="MunicipalityId" name="MunicipalityId" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">Selecciona un municipio</option>
                @foreach($municipalities as $municipality)
                    <option value="{{ $municipality->MunId }}" {{ (old('MunicipalityId', $user->MunicipalityId) == $municipality->MunId) ? 'selected' : '' }}>
                        {{ $municipality->Name }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('MunicipalityId')" />
        </div>

        <div class="flex items-center gap-4">
            <x-button>{{ __('Guardar') }}</x-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Guardado.') }}</p>
            @endif
        </div>
    </form>
</section>
