import React from "react";
import "./Filters.css";

export const Filters = () => {
    return (
        <aside className="filters">
            <input type="text" placeholder="Búsqueda" className="search-bar" />
            <h3>Filtros por categoría</h3>
            <ul>
                <li>Ingrediente</li>
                <li>Variedad de grano</li>
                <li>Método</li>
                <li>Ranking</li>
            </ul>
        </aside>
    );
};
