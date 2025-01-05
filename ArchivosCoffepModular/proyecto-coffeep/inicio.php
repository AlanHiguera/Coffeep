.container {
    display: flex;
    max-width: 1200px;
    margin: 2rem auto;
    gap: 2rem; /* Espacio entre los contenedores */
}

/* Contenedor de filtros */
.filters-container {
    flex: 0 0 280px; /* Fija el ancho de los filtros */
}

/* Contenedor de recetas */
.recipes-container {
    flex: 1; /* Toma el resto del espacio disponible */
}

.recipes {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 15px;
}
