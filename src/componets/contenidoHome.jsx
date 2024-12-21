import './contenidoHome.css';

export const ContenidoHome = () => {
    return (
        <div className="home-container">

            
            {/* Sección principal */}
            <div className="main-content">
                {/* Barra de búsqueda y filtros */}
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
                
                {/* Lista de recetas */}
                <section className="recipe-list">
                    {/* Aquí se renderizan las recetas dinámicamente */}
                    <div className="recipe-card">
                        <img src="https://via.placeholder.com/150" alt="Café" />
                        <h4>Nombre del Café</h4>
                        <p>⭐ 4.5</p>
                    </div>
                </section>
            </div>

            {/* Footer */}
            <footer>
                <p>Coffee-P © Todos los derechos reservados</p>
            </footer>
        </div>
    );
};

