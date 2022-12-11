import { get } from './helpers';

export default {
    search(queryString) {
        if (!queryString) {
            console.error('Query string is required');
            return;
        }

        return get(`/api/search?queryString=${encodeURIComponent(queryString)}`);
    },
}
