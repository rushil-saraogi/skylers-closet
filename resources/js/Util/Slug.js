export function isValidSlug(slug) {
    return slug.match(/^[a-z_-]+$/) && slug.length > 2;
}