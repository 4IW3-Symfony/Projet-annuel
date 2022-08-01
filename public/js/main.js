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

    //////////////////////////////////////
    ///////////////// MAP/////////////////
    //////////////////////////////////////

    if (document.getElementById('map')) {
        // Init map
        const map = L.map('map', {
            zoomControl: false,
        }).setView([48.851401, 2.364282], 5);

        // Adding layer
        L.tileLayer('https://{s}.tile.openstreetmap.de/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: 'easyloc',
        }).addTo(map);

        // Setting first view
        L.control.zoom({position: 'topright'}).addTo(map);

        // Getting markers info from API
        const dataEl = document.getElementById('map-data');
        const motorcycles = JSON.parse(dataEl.dataset.motorcycles);

        // Markers
        function markerFunction(markers, id) {
            for (let i in markers) {
                const markerID = markers[i].options.id;
                if (markerID === parseInt(id)) {
                    if (!markers[i].isPopupOpen()) {
                        markers[i].openPopup();
                    }
                }
            }
        }

        const markers = [];
        motorcycles.forEach((motorcycle) => {
            if (!motorcycle.lat || !motorcycle.lon) return;
            const marker = L.marker([motorcycle.lat, motorcycle.lon], {id: motorcycle.id}).addTo(map);
            let markerEl = '';
            if ('content' in document.createElement('template')) {
                const markerTemplate = document.getElementById('map-marker');
                const clone = markerTemplate.content.cloneNode(true);
                clone.getElementById('map-marker_image').src = motorcycle.image;
                clone.getElementById('map-marker_title').textContent = `${motorcycle.brand} ${motorcycle.model}`;
                clone.getElementById('map-marker_price').textContent = motorcycle.price + '€';
                clone.getElementById('map-marker_link').href = `/motorcycle/${motorcycle.id}`;
                markerEl = clone;
            } else {
                markerEl = `
            <div class="map-marker">
                <h3>${motorcycle.brand} ${motorcycle.model}</h3>
                <p>${motorcycle.price}€/jour</p>
                <a href="/motorcycle/${motorcycle.id}" class="btn btn-primary">Louer</a>
            </div>
        `;
            }
            markers.push(marker);
            marker.bindPopup(markerEl);
        })

        document.querySelectorAll('.map-item-link').forEach((link) => {
            link.addEventListener('click', () => markerFunction(markers, link.dataset.id));
        });
    }

    /////////////////////////

}

