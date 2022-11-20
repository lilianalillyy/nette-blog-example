topbar.config({
    barColors: {
        '0': "#86b7fe",
        ".3": "#3d8bfd",
        "1.0": "#0d6efd"
    }
})

function LoaderExtension(naja) {
    naja.addEventListener('start', function () {
        topbar.show()
    });

    naja.addEventListener('complete', function () {
        topbar.hide()
    });

    return this;
}

document.addEventListener('DOMContentLoaded', function () {
    naja.registerExtension(LoaderExtension)
    naja.initialize()
});