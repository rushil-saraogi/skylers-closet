<template>
    <div class="flex rounded-2xl shadow-2xl flex-col md:flex-row overflow-hidden border dark:border-0">
        <div class="flex-1">
            <slot name="cover" />
        </div>
        <div class="flex flex-col flex-1 sm:justify-center items-center px-6 py-8 bg-white shadow-3xl">
            <div>
                <slot name="logo" />
            </div>

            <div class="w-full sm:max-w-md mt-6 overflow-hidden">
                <slot />
            </div>

            <div>
                <slot name="footer" />
            </div>
        </div>
    </div>
    
</template>
