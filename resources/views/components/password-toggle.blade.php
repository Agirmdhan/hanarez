<button
    type="button"
    @click="showPassword = ! showPassword"
    class="absolute inset-y-0 right-0 flex w-10 items-center justify-center text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
    :aria-label="showPassword ? 'Sembunyikan password' : 'Lihat password'"
    :title="showPassword ? 'Sembunyikan password' : 'Lihat password'"
>
    <svg x-show="! showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 12s3.5-6 9.75-6 9.75 6 9.75 6-3.5 6-9.75 6-9.75-6-9.75-6Z"/>
        <circle cx="12" cy="12" r="2.75" stroke-width="2"/>
    </svg>
    <svg x-cloak x-show="showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m3 3 18 18M10.6 6.2A10.8 10.8 0 0 1 12 6c6.25 0 9.75 6 9.75 6a17 17 0 0 1-2.1 2.8M6.2 6.2C3.6 8 2.25 12 2.25 12s3.5 6 9.75 6c1.35 0 2.57-.28 3.65-.72M9.9 9.9a3 3 0 0 0 4.2 4.2"/>
    </svg>
</button>
