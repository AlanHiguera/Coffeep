import React from 'react';
import '../styles.css';

const Sidebar = () => {
    return (
        <div className="sidebar">
            <h3>Generar Listados</h3>
            <hr />
            <button className="sidebar-btn">Recetas</button>
            <button className="sidebar-btn active">Usuarios</button>
            <button className="sidebar-btn">Comentarios</button>
        </div>
    );
};

export default Sidebar;