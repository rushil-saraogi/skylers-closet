<template>
    <div class="flex flex-col border rounded">
        <div 
            v-for="(item, index) in items" :key="index" 
            @click="$emit('click:item', closet)"
            class="bg-white flex justify-between items-center px-4 py-3 sm:px-6 sm:py-4 border-b hover:cursor-pointer hover:bg-gray-50"
        >
            <div>
                <div class="flex">
                    <div class="font-semibold">{{ item.header }}</div>
                    <Badge v-if="item.badge" class="ml-2 hidden md:block">{{ item.badge }}</Badge>
                </div>
                <div v-if="item.subheader" class="text-gray-500 text-sm">{{ item.subheader }}</div>
            </div>

            <div v-if="$slots.icon">
                <slot name="icon" :closet="closet"></slot>
            </div>
            <ChevronRightIcon
                class="h-5 w-5 text-gray-400"
                v-else
            />
        </div>
    </div>
  </template>
  
  <script>
import { Link } from "@inertiajs/inertia-vue3";
import { ChevronRightIcon } from '@heroicons/vue/20/solid';
import Badge from '@/Jetstream/Badge.vue';

  export default {
    props: ['items'],

    components: {
        ChevronRightIcon,
        Link,
        Badge
    }
  }
  </script>
  