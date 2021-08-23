import { shallowRef } from 'vue'
import IconGithub from '@/icons/IconGithub.vue';

export const TILE_COLORS = [
    {
        value: 'red-800',
        icon: shallowRef(IconGithub)
    },
    {
        value: 'blue-800',
        icon: shallowRef(IconGithub)
    }
]

export const TILE_ICONS = [
    {
        value: 'Github',
        icon: shallowRef(IconGithub)
    },
    {
        value: 'Facebook',
        icon: shallowRef(IconGithub),
    }
]