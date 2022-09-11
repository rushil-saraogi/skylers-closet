import { post } from './helpers';

export default {
    async getMetaData(url) {
        if (!url) {
            console.error('Need to URL to fetch meta data');
            return;
        }

        const res = await fetch(`/api/links/get-meta?url=${encodeURIComponent(url)}`);
        const data = await res.json();

        return data;
    },
}
