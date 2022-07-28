const header = document.getElementById('header');


document.addEventListener('DOMContentLoaded', loaded);

window.addEventListener('scroll', defineScrolledHeader);

function defineScrolledHeader() {
    if (window.scrollY > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
}


function loaded() {

    defineScrolledHeader();

    const map = L.map('map', {
        zoomControl: false,
    }).setView([48.851401, 2.364282], 10);
    L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.png', {
        maxZoom: 19,
        attribution: 'easyloc',
    }).addTo(map);
    L.control.zoom({position: 'topright'}).addTo(map);

    const dataEl = document.getElementById('map-data');
    const motorcycles = JSON.parse(dataEl.dataset.motorcycles);

    motorcycles.forEach((motorcycle) => {
        if (motorcycle.lat && motorcycle.lon) return;
        const marker = L.marker([51.5, -0.09]).addTo(map);
        const markelEL = `
            <div class="map-marker">
                <h3>${motorcycle.brand} ${motorcycle.model}</h3>
                <p>${motorcycle.price}/jour</p>
                <a href="/motorcycle/${motorcycle.id}" class="btn btn-primary">Louer</a>
            </div>
        `;
        marker.bindPopup(markelEL);
    })

}
