export default {
    async getCurrentUsersClosets() {
        const res = await fetch('/api/closets/current-user');
        const data = await res.json();
        return data;
    },
}
