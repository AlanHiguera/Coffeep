import React from "react";

const Navbar = () => {
  return (
    <nav className="bg-blue-500 p-4">
      <div className="container mx-auto flex justify-between items-center">
        <div className="text-white text-lg font-bold">Mi Sitio</div>
        <ul className="flex space-x-4">
          <li>
            <a
              href="#home"
              className="text-white hover:text-blue-300 transition duration-300"
            >
              Inicio
            </a>
          </li>
          <li>
            <a
              href="#about"
              className="text-white hover:text-blue-300 transition duration-300"
            >
              Sobre Nosotros
            </a>
          </li>
          <li>
            <a
              href="#services"
              className="text-white hover:text-blue-300 transition duration-300"
            >
              Servicios
            </a>
          </li>
          <li>
            <a
              href="#contact"
              className="text-white hover:text-blue-300 transition duration-300"
            >
              Contacto
            </a>
          </li>
        </ul>
      </div>
    </nav>
  );
};

export default Navbar;
