<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <div class="fi-form-actions flex flex-wrap items-center gap-3" style="margin-top: 2.5rem; padding-top: 0.5rem;">
            <x-filament::button type="submit" size="md" icon="heroicon-o-folder-arrow-down">
                Simpan Pengaturan
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>

