export function post(url, data) {
    return fetch(url, {
        method: 'POST',
        headers: getHeaders(),
        body: JSON.stringify(data)
    });
}

export function put(url, data) {
    return fetch(url, {
        method: 'PUT',
        headers: getHeaders(),
        body: JSON.stringify(data)
    });
}

function getHeaders() {
    return {
        'Content-Type': 'application/json'
        // 'Content-Type': 'application/x-www-form-urlencoded',
    }
}
