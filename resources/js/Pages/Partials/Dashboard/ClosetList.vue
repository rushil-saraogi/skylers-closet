<template>
    <div class="flex flex-col border rounded">
        <div 
            v-for="closet in closets" :key="closet.id" 
            @click="$emit('click:closet', closet)"
            class="flex justify-between items-center px-6 py-4 border-b hover:cursor-pointer hover:bg-gray-50"
        >
            <div>
                <div class="flex">
                    <div class="font-semibold">{{ closet.name }}</div>
                    <Badge class="ml-2">{{ closet.category.name }}</Badge>
                </div>
                <div class="text-gray-500">{{ closet.items.length }} Items</div>
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
    props: ['closets'],

    components: {
        ChevronRightIcon,
        Link,
        Badge
    }
  }
  </script>
  