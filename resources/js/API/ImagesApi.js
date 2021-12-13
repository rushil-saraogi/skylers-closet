import { post } from './helpers';

export default {
    async upload(image) {
        const res = await post(`/api/images/upload`, { image });
        const data = await res.json();

        return data;
    }
}
