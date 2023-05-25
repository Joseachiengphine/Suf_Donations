<div class="mt-8">
    <h2 class="text-2xl font-semibold mb-4">
        {{ __('filament-breezy::default.profile.personal_info.heading') }}
    </h2>

    <p class="text-gray-600 mb-4">
        {{ __('filament-breezy::default.profile.personal_info.subheading') }}
    </p>

    <form wire:submit.prevent="updateProfile" class="max-w-xl mx-auto">
        <div class="bg-primary-800 shadow-accent-500 rounded-lg p-4">
            <div class="bg-white rounded-lg p-6">
                {{ $this->updateProfileForm }}
            </div>
        </div>

        <div class="mt-4 text-right">
            <button type="submit" class="bg-primary-800 text-white px-4 py-2 rounded">
                {{ __('filament-breezy::default.profile.personal_info.submit.label') }}
            </button>
        </div>
    </form>
</div>
