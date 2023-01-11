<template>
    <div class="w-full flex items-center justify-center">
        <div class="border rounded-xl overflow-hidden shadow-xl">
            <div class="phone-bezel border-white dark:border-white h-full w-full">
                <div class="ipad-screen border h-full w-full rounded-xl bg-black overflow-hidden">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.ipad-screen {
    height: 600px;
}

.phone-bezel {
    border-width: 18px;
    max-width: 450px;
}
</style>
