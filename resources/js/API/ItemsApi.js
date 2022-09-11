import { put } from './helpers';

export default {
    async updateItem(itemData, closetId, itemId) {
        const res = await put(`/api/closets/${closetId}/items/${itemId}`, { ...itemData });
        const data = await res.json();

        return data;
    }
}
