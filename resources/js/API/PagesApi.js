export default {
    async getUserPages() {
        const data = await fetch('/api/pages');
        console.log(data);
    }
}
