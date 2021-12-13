export function isValidSlug(slug) {
    return slug.match(/^[a-z0-9_-]+$/) && slug.length > 2;
}