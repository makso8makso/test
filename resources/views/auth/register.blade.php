<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="phone_number" value="{{ __('Phone number (optional)') }}" />
                <x-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number"/>
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="photo" value="{{ __('Photo') }}"/>
                <x-input id="photo" class="block mt-1 w-full" type="file" name="photo" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <x-label for="addresses" value="{{ __('Addresses') }}" class="mt-3"/>
            <div id="address">
                <div class="mt-4 duplicateAddressDiv">
                    <hr>
                    <div class="mt-4 country">
                        <x-label for="country" value="{{ __('Country') }}"/>
                        <x-input id="country" class="block mt-1 w-full" type="text" name="country[]"/>
                    </div>

                    <div class="mt-4 postal_code">
                        <x-label for="postal_code" value="{{ __('Postal code') }}"/>
                        <x-input id="postal_code" class="block mt-1 w-full" type="text" name="postal_code[]"/>
                    </div>

                    <div class="mt-4 city">
                        <x-label for="city" value="{{ __('City') }}"/>
                        <x-input id="city" class="block mt-1 w-full" type="text" name="city[]"/>
                    </div>

                    <div class="mt-4 address">
                        <x-label for="address" value="{{ __('Address') }}"/>
                        <x-input id="address" class="block mt-1 w-full" type="text" name="address[]"/>
                    </div>
                </div>
            </div>

            <div id="duplicateAddress" style="text-decoration: underline; color: blue; cursor: pointer; padding: 10px; border: lightblue;">
                Add address
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
<script>
    document.getElementById("duplicateAddress").addEventListener("click", function () {
        let duplicateAddressDiv = document.querySelector(".duplicateAddressDiv").cloneNode(true);
        document.getElementById("address").appendChild(duplicateAddressDiv);
    });
</script>
