const sortBy = document.getElementById('sort_by');
const sortTo = document.getElementById('sort_to');

sortBy.onchange = function () {
    window.location.replace(getQueryString('by', this.value));
}

sortTo.onchange = function () {
    window.location.replace(getQueryString('to', this.value));
}

function getQueryString(key, value) {
    const params = new URLSearchParams(document.location.search);
    params.set(key, value);
    return '?' + params.toString();
}
