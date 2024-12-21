import React from "react";
import "./navbar.css";

const Navbar = () => {
    return (
        <nav className="navbar">
            <center>
              <div className="navbar-links">
                    <a href="#" className="navbar-link">Listados</a> 
                    <p>|</p>
                    <a href="#" className="navbar-link">Mantenedor</a> 
              </div>
            </center>
            <div className="navbar-user">
                <span className="user-icon">👤</span>
            </div>
        </nav>
    );
};
export default Navbar;
