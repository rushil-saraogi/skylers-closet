<template>
    <div>
        <!-- Hero Icons -->
        <InboxIcon :class="iconClasses" v-if="icon === 'Inbox'" v-bind="$attrs" />
        <VideoCameraIcon :class="iconClasses" v-if="icon === 'Video Camera'" v-bind="$attrs" />
        <BeakerIcon :class="iconClasses" v-if="icon === 'Beaker'" v-bind="$attrs" />
        <CameraIcon :class="iconClasses" v-if="icon === 'Camera'" v-bind="$attrs" />
        <CalendarIcon :class="iconClasses" v-if="icon === 'Calendar'" v-bind="$attrs" />
        <CurrencyDollarIcon :class="iconClasses" v-if="icon === 'Dollar'" v-bind="$attrs" />
        <CurrencyEuroIcon :class="iconClasses" v-if="icon === 'Euro'" v-bind="$attrs" />
        <HeartIcon :class="iconClasses" v-if="icon === 'Heart'" v-bind="$attrs" />
        <MailIcon :class="iconClasses" v-if="icon === 'Mail'" v-bind="$attrs" />

        <!-- Custom Icons -->
        <IconGithub :color="color" :class="iconClasses" v-if="icon === 'Github'" v-bind="$attrs" />
        <IconFacebook :color="color" :class="iconClasses" v-if="icon === 'Facebook'" v-bind="$attrs" />
        <IconLinkedin :color="color" :class="iconClasses" v-if="icon === 'Linkedin'" v-bind="$attrs" />
        <IconBehance :color="color" :class="iconClasses" v-if="icon === 'Behance'" v-bind="$attrs" />
        <IconInstagram :color="color" :class="iconClasses" v-if="icon === 'Instagram'" v-bind="$attrs" />
        <IconSpotify :color="color" :class="iconClasses" v-if="icon === 'Spotify'" v-bind="$attrs" />
        <IconYoutube :color="color" :class="iconClasses" v-if="icon === 'Youtube'" v-bind="$attrs" />
    </div>
</template>

<script>

import {
    InboxIcon,
    CameraIcon,
    VideoCameraIcon,
    BeakerIcon,
    CalendarIcon,
    CurrencyDollarIcon,
    CurrencyEuroIcon,
    HeartIcon,
    MailIcon
} from '@heroicons/vue/20/solid'
import IconGithub from '@/icons/IconGithub.vue';
import IconFacebook from '@/icons/IconFacebook.vue';
import IconLinkedin from '@/icons/IconLinkedin.vue';
import IconBehance from '@/icons/IconBehance.vue';
import IconInstagram from '@/icons/IconInstagram.vue';
import IconSpotify from '@/icons/IconSpotify.vue';
import IconYoutube from '@/icons/IconYoutube.vue';

export const TILE_ICONS = [
    'Facebook',
    'Github',
    'Linkedin',
    'Behance',
    'Instagram',
    'Spotify',
    'Mail',
    'Inbox',
    'Video Camera',
    'Camera',
    'Beaker',
    'Calendar',
    'Dollar',
    'Euro',
    'Heart',
    'Youtube'
]

export default {
    components: {
        InboxIcon,
        VideoCameraIcon,
        CameraIcon,
        BeakerIcon,
        IconGithub,
        IconFacebook,
        IconLinkedin,
        IconBehance,
        IconInstagram,
        IconSpotify,
        CalendarIcon,
        CurrencyDollarIcon,
        CurrencyEuroIcon,
        HeartIcon,
        MailIcon,
        IconYoutube,
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
