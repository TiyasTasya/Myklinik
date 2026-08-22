<x-filament-panels::page>
    <div x-data="{ tab: 'provinces' }">
        <div class="flex gap-1 border-b border-gray-200 dark:border-white/10 mb-6">
            <button @click="tab = 'provinces'"
                :class="tab === 'provinces' ? 'border-primary-600 text-primary-600' :
                    'border-transparent text-gray-500 hover:text-gray-700'"
                class="px-4 py-2 border-b-2 font-medium text-sm transition">
                Provinsi
            </button>
            <button @click="tab = 'regencies'"
                :class="tab === 'regencies' ? 'border-primary-600 text-primary-600' :
                    'border-transparent text-gray-500 hover:text-gray-700'"
                class="px-4 py-2 border-b-2 font-medium text-sm transition">
                Kabupaten/Kota
            </button>
            <button @click="tab = 'districts'"
                :class="tab === 'districts' ? 'border-primary-600 text-primary-600' :
                    'border-transparent text-gray-500 hover:text-gray-700'"
                class="px-4 py-2 border-b-2 font-medium text-sm transition">
                Kecamatan
            </button>
            <button @click="tab = 'villages'"
                :class="tab === 'villages' ? 'border-primary-600 text-primary-600' :
                    'border-transparent text-gray-500 hover:text-gray-700'"
                class="px-4 py-2 border-b-2 font-medium text-sm transition">
                Desa/Kelurahan
            </button>
        </div>

        <div x-show="tab === 'provinces'">
            <livewire:wilayah.provinces-table />
        </div>

        <div x-show="tab === 'regencies'">
            <livewire:wilayah.regencies-table />
        </div>

        <div x-show="tab === 'districts'">
            <livewire:wilayah.districts-table />
        </div>

        <div x-show="tab === 'villages'">
            <livewire:wilayah.villages-table />
        </div>
    </div>
</x-filament-panels::page>
