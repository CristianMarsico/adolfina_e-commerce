import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import * as Turbo from '@hotwired/turbo';

window.Alpine = Alpine;

Alpine.plugin(collapse);

Alpine.data('productCard', (data) => ({
    precio: data.precio,
    precioOferta: data.precioOferta,
    tieneDescuento: data.tieneDescuento,
    tipoDescuento: data.tipoDescuento,
    valorDescuento: data.valorDescuento,
    stock: data.stock,
    init() {
        this._interval = setInterval(() => this.fetchPrecio(), 60000);
    },
    destroy() {
        if (this._interval) {
            clearInterval(this._interval);
        }
    },
    fetchPrecio() {
        fetch('/api/productos/' + data.id + '/precio')
            .then(r => r.json())
            .then(d => {
                this.precio = d.precio;
                this.precioOferta = d.precio_oferta;
                this.tieneDescuento = !!d.descuento;
                this.tipoDescuento = d.descuento ? d.descuento.tipo : '';
                this.valorDescuento = d.descuento ? d.descuento.valor : null;
                this.stock = d.stock;
            })
            .catch(() => {});
    }
}));

Alpine.start();
