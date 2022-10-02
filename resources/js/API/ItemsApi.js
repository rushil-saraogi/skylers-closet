import { put, post, del } from './helpers';

export default {
    async updateItem(itemData, closetId, itemId) {
        const res = await put(`/api/closets/${closetId}/items/${itemId}`, { ...itemData });
        const data = await res.json();

        return data;
    },

    async saveItem(closetId, itemId) {
        const res = await post(`/api/closets/${closetId}/items/${itemId}/copy`);
        const data = await res.json();

        return data;
    },

    async deleteByUrl(closetId, itemId) {
        const res = await del(`/api/closets/${closetId}/items/${itemId}/remove-by-url`);
        const data = await res.json();

        return data;
    }
}
