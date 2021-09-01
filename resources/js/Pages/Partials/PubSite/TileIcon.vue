<template>
    <div>
        <InboxIcon :class="iconClasses" v-if="icon === 'Inbox'" v-bind="$attrs" />
        <FilmIcon :class="iconClasses" v-if="icon === 'Film'" v-bind="$attrs" />
        <VideoCameraIcon :class="iconClasses" v-if="icon === 'Video Camera'" v-bind="$attrs" />
        <BeakerIcon :class="iconClasses" v-if="icon === 'Beaker'" v-bind="$attrs" />
        <CameraIcon :class="iconClasses" v-if="icon === 'Camera'" v-bind="$attrs" />
        <IconGithub :color="color" :class="iconClasses" v-if="icon === 'Github'" v-bind="$attrs" />
        <IconFacebook :color="color" :class="iconClasses" v-if="icon === 'Facebook'" v-bind="$attrs" />
        <IconAlien :class="iconClasses" v-if="icon === 'Alien'" v-bind="$attrs" />
    </div>
</template>

<script>

import { InboxIcon } from '@heroicons/vue/solid'
import { FilmIcon, VideoCameraIcon, CameraIcon, BeakerIcon } from '@heroicons/vue/outline'
import IconGithub from '@/icons/IconGithub.vue';
import IconFacebook from '@/icons/IconFacebook.vue';
import IconAlien from '@/icons/IconAlien.vue';

export const TILE_ICONS = [
    'Facebook',
    'Github',
    'Alien',
    'Inbox',
    'Film',
    'Video Camera',
    'Camera',
    'Beaker',
]

export default {
    components: {
        InboxIcon,
        FilmIcon,
        VideoCameraIcon,
        CameraIcon,
        BeakerIcon,
        IconGithub,
        IconFacebook,
        IconAlien
    },

    props: {
        icon: {
            type: String,
            required: true,
        },
        color: {
            type: String,
            default: 'white'
        }
    },

    data() {
        return {
            iconClasses: `text-${this.color}`,
        }
    }
}
</script>
