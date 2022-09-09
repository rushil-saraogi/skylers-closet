export function isValidURL(str) {
	let url;

	try {
		url = new URL(str);
	} catch (_) {
		return false;
	}

	return url.protocol === "http:" || url.protocol === "https:";
}

export function updateQueryStringParameter(uri, key, value) {
	var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
	var separator = uri.indexOf('?') !== -1 ? "&" : "?";
	if (uri.match(re)) {
	  return uri.replace(re, '$1' + key + "=" + value + '$2');
	}
	else {
	  return uri + separator + key + "=" + value;
	}
  }
