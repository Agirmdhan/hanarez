<div
    x-data="{ open: false, form: null }"
    x-on:open-logout-confirm.window="form = $event.detail.form; open = true"
    x-on:keydown.escape.window="open = false"
    x-show="open"
    x-cloak
    class="fixed inset-0 flex items-center justify-center px-4"
    style="display: none; z-index: 9999; background-color: rgba(17, 24, 39, 0.5);"
>
    <div class="w-full max-w-sm rounded-lg bg-white p-6 shadow-xl" x-on:click.outside="open = false">
        <h2 class="text-lg font-semibold text-gray-900">Konfirmasi Logout</h2>
        <p class="mt-2 text-sm text-gray-600">Apakah Anda yakin ingin logout dari akun ini?</p>

        <div class="mt-6 flex justify-end gap-3">
            <button
                type="button"
                class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"
                x-on:click="open = false"
            >
                Tidak
            </button>
            <button
                type="button"
                class="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-500"
                x-on:click="if (form) form.submit()"
            >
                Ya, Logout
            </button>
        </div>
    </div>
</div>