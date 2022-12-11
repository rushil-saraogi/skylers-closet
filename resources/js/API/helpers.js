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

export function del(url) {
    return fetch(url, {
        method: 'DELETE',
        headers: getHeaders(),
    });
}

export function get(url) {
    return fetch(url, {
        method: 'GET',
        headers: getHeaders(),
    }).then(res => res.json());
}

function getHeaders() {
    return {
        'Content-Type': 'application/json'
        // 'Content-Type': 'application/x-www-form-urlencoded',
    }
}
