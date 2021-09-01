export default {
    async isSlugAvailable(slug) {
        const res = await fetch(`/api/pages/valid-slug?slug=${slug}`);
        const data = await res.json();
        return data;
    }
}
