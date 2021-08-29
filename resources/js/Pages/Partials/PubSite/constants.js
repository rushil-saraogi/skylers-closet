import { shallowRef } from 'vue'
import IconGithub from '@/icons/IconGithub.vue';
import IconFacebook from '@/icons/IconFacebook.vue';
import ColorIcon from './ColorIcon.vue';
import { InboxIcon } from '@heroicons/vue/solid'
import { FilmIcon, VideoCameraIcon, CameraIcon, BeakerIcon } from '@heroicons/vue/outline'


export const DEFAULT_COLOR = 'gray-800';

export const ICON_MAPPING = {
    Facebook: {
        icon: shallowRef(IconFacebook),
        iconProps: {
            color: 'indigo-700'
        },
    },
    Github: {
        icon: shallowRef(IconGithub),
        iconProps: {
            color: 'gray-800'
        }
    },
    Inbox: {
        icon: InboxIcon,
        iconProps: {
            class: 'text-blue-500'
        }
    },
    Film: {
        icon: FilmIcon,
        iconProps: {
            color: 'gray-800'
        }
    },
    'Video Camera': {
        icon: VideoCameraIcon,
        iconProps: {
            color: 'gray-800'
        }
    },
    Camera: {
        icon: CameraIcon,
        iconProps: {
            color: 'gray-800'
        }
    },
    Beaker: {
        icon: BeakerIcon,
        iconProps: {
            color: 'gray-800'
        }
    }
};

export const COLOR_MAPPING = {
    'red-700': {
        icon: shallowRef(ColorIcon),
        iconProps: {
            color: 'red-700'
        }
    },
    'red-500': {
        icon: ColorIcon,
        iconProps: {
            color: 'red-500'
        }
    },
    'gray-800': {
        icon: shallowRef(ColorIcon),
        iconProps: {
            color: 'gray-800'
        }
    },
    'green-500': {
        icon: shallowRef(ColorIcon),
        iconProps: {
            color: 'green-500'
        }
    },
};

export const TILE_COLORS = Object.keys(COLOR_MAPPING).map(key => ({
    value: key,
    ...COLOR_MAPPING[key]
}));

export const TILE_ICONS = Object.keys(ICON_MAPPING).map(key => ({
    value: key,
    ...ICON_MAPPING[key]
}));

export const GRID_CONSTANTS = {
    rowHeight: 30
};