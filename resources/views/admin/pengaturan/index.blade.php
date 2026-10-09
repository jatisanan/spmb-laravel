@extends('layouts.admin')

@section('title', 'Pengaturan Situs')
@section('page-title', 'Pengaturan Situs')
@section('page-subtitle', 'Edit konten landing page & upload gambar')

@section('content')

<form method="POST" action="{{ route('admin.pengaturan.update') }}" enctype="multipart/form-data">
    @csrf

    {{-- Tab Navigation --}}
    <div class="mb-5 flex flex-wrap gap-2">
        @foreach ($fields as $groupKey => $group)
            <button type="button" data-tab-btn="{{ $groupKey }}"
                    class="tab-btn inline-flex items-center gap-2 rounded-lg border border-[#d6dccf] bg-white px-4 py-2 text-sm font-semibold text-[#244535] hover:bg-[#f4f8ee] transition">
                <i data-lucide="{{ $group['icon'] }}" class="h-4 w-4"></i>
                {{ $group['label'] }}
            </button>
        @endforeach
    </div>

    {{-- Tab Content --}}
    @foreach ($fields as $groupKey => $group)
        <div data-tab-content="{{ $groupKey }}" class="tab-content hidden">
            <div class="rounded-2xl border border-[#e1e9da] bg-white p-6 shadow-sm">
                <h3 class="display-font text-lg font-bold text-[#0d4a36] mb-1">{{ $group['label'] }}</h3>
                <p class="text-xs text-[#617064] mb-5">Edit konten untuk bagian {{ strtolower($group['label']) }} pada landing page.</p>

                <div class="space-y-4">
                    @foreach ($group['fields'] as $key => $meta)
                        @php
                            $value = $settings[$key] ?? '';
                        @endphp

                        <div>
                            <label for="{{ $key }}" class="mb-1.5 block text-sm font-bold text-[#244535]">
                                {{ $meta['label'] }}
                            </label>

                            @if ($meta['type'] === 'textarea')
                                <textarea id="{{ $key }}" name="{{ $key }}" rows="3" class="field-control">{{ $value }}</textarea>

                            @elseif ($meta['type'] === 'image')
                                <div class="space-y-2">
                                    {{-- Preview gambar --}}
                                    @if ($value)
                                        @php
                                            $previewUrl = str_starts_with($value, 'http') ? $value : asset('storage/' . $value);
                                            // Fallback ke public/images kalau file belum ada di storage
                                            if (!str_starts_with($value, 'http') && !file_exists(storage_path('app/public/' . $value))) {
                                                $previewUrl = asset($value);
                                            }
                                        @endphp
                                        <div class="relative inline-block">
                                            <img src="{{ $previewUrl }}" alt="Preview"
                                                 class="h-32 w-auto rounded-lg border border-[#d6dccf] object-cover bg-[#f4f8ee]">
                                            <p class="mt-1 text-xs text-[#617064] break-all">{{ $value }}</p>
                                        </div>
                                    @else
                                        <div class="h-32 w-48 rounded-lg border-2 border-dashed border-[#d6dccf] bg-[#f4f8ee] flex items-center justify-center">
                                            <p class="text-xs text-[#617064]">Belum ada gambar</p>
                                        </div>
                                    @endif

                                    <input type="file" id="{{ $key }}" name="{{ $key }}"
                                           accept="image/*"
                                           class="block w-full text-sm text-[#244535]
                                                  file:mr-3 file:rounded-lg file:border-0
                                                  file:bg-[#0d4a36] file:px-4 file:py-2
                                                  file:text-sm file:font-bold file:text-white
                                                  hover:file:bg-[#176346]">
                                    <p class="text-xs text-[#617064]">Format: JPG, PNG, WEBP, SVG. Maks 3MB.</p>
                                </div>

                            @else
                                <input type="text" id="{{ $key }}" name="{{ $key }}" value="{{ $value }}" class="field-control">
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

    {{-- Tombol Simpan --}}
    <div class="mt-5 flex justify-end gap-3">
        <a href="{{ route('landing') }}"
           class="rounded-lg border border-[#d6dccf] px-5 py-3 text-sm font-semibold text-[#244535] hover:bg-[#f4f8ee]">
            Preview Landing
        </a>
        <button type="submit"
                class="inline-flex items-center gap-2 rounded-lg bg-[#0d4a36] px-6 py-3 text-sm font-bold text-white hover:bg-[#176346]">
            <i data-lucide="save" class="h-4 w-4"></i>
            Simpan Pengaturan
        </button>
    </div>
</form>

@endsection

@push('scripts')
<script>
(function () {
    const btns = document.querySelectorAll('[data-tab-btn]');
    const contents = document.querySelectorAll('[data-tab-content]');

    function activate(tabKey) {
        btns.forEach(b => {
            const active = b.dataset.tabBtn === tabKey;
            b.classList.toggle('bg-[#0d4a36]', active);
            b.classList.toggle('text-white', active);
            b.classList.toggle('border-[#0d4a36]', active);
            b.classList.toggle('bg-white', !active);
            b.classList.toggle('text-[#244535]', !active);
            b.classList.toggle('border-[#d6dccf]', !active);
        });

        contents.forEach(c => {
            c.classList.toggle('hidden', c.dataset.tabContent !== tabKey);
        });

        if (window.lucide) lucide.createIcons();
    }

    btns.forEach(btn => {
        btn.addEventListener('click', () => activate(btn.dataset.tabBtn));
    });

    // Aktifkan tab pertama
    if (btns.length) activate(btns[0].dataset.tabBtn);
})();
</script>
@endpush