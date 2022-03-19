<template>
    <div class="py-12">
        <div class="full-h-screen flex flex-col items-center sm:pt-6 sm:pt-0 bg-gray-100">
            <div>
                <slot name="logo" />
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <slot />
            </div>
        </div>
    </div>
</template>
