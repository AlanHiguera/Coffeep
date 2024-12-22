import React from "react";
import { Link } from "react-router-dom"; // Importar Link para navegación
import "./navbar.css";

const Navbar = () => {
    return (
        <nav className="navbar">
            <center>
                <div className="navbar-links">
                    <Link to="/listados" className="navbar-link">Listados</Link> 
                    <p>|</p>
                    <Link to="/mantenedorting" className="navbar-link">Mantenedor</Link> 
                    <p>|</p>
                    <Link to="/Home" className="navbar-link">Inicio</Link>
                </div>
            </center>
            <div className="navbar-user">
                <span className="user-icon">👤</span>
            </div>
        </nav>
    );
};

export default Navbar;
