<div>
    @if($submission && $submission->noteFor($field))
    <div class="bg-yellow-50 border border-yellow-300 text-yellow-800 rounded-lg px-3 py-2 mb-2 text-sm flex items-start">
        <svg class="w-4 h-4 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
        <span><strong>Catatan admin:</strong> {{ $submission->noteFor($field) }}</span>
    </div>
    @endif
    <div class="flex items-center justify-between mb-1">
        <label class="block text-sm font-medium text-gray-700">{{ $d['label'] }}</label>
        <div class="flex items-center text-xs bg-gray-100 rounded-full p-1">
            <button type="button" @click="mode.{{ $field }} = 'file'"
                :class="mode.{{ $field }} === 'file' ? 'bg-white shadow text-primary-700' : 'text-gray-500'"
                class="px-3 py-1 rounded-full font-medium transition-colors duration-150">Upload File</button>
            <button type="button" @click="mode.{{ $field }} = 'link'"
                :class="mode.{{ $field }} === 'link' ? 'bg-white shadow text-primary-700' : 'text-gray-500'"
                class="px-3 py-1 rounded-full font-medium transition-colors duration-150">Tautan</button>
        </div>
    </div>
    <input type="hidden" name="{{ $field }}_mode" x-bind:value="mode.{{ $field }}">

    <div x-show="mode.{{ $field }} === 'file'">
        @if($submission && $submission->{$field . '_path'})
        <p class="text-xs text-green-600 mb-1">Berkas saat ini: {{ $submission->{$field . '_original_name'} }} &mdash; biarkan kosong untuk tetap memakai berkas ini.</p>
        @endif
        <input type="file" name="{{ $field }}" accept="{{ $d['accept'] ?? '.pdf' }}"
            class="w-full text-sm border border-gray-300 rounded-lg p-3 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary-50 file:text-primary-700">
        <p class="text-xs text-gray-400 mt-1">Format {{ $d['format'] ?? 'PDF' }}, maksimal {{ $d['max'] }}</p>
    </div>
    <div x-show="mode.{{ $field }} === 'link'" x-cloak>
        <input type="url" name="{{ $field }}_link" value="{{ old("{$field}_link", $submission->{$field . '_url'} ?? '') }}"
            placeholder="https://drive.google.com/..."
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
        <p class="text-xs text-gray-400 mt-1">Tautan Google Drive/OneDrive/lainnya yang bisa diakses publik</p>
    </div>
</div>
