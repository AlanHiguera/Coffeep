import React from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faBell, faUserCircle } from "@fortawesome/free-solid-svg-icons";

const Header = () => {
  return (
    <div>
      {/* Línea superior */}
      <div className="h-2 bg-[#cdab8f]"></div>

      {/* Contenido del header */}
      <div className="flex justify-between items-center px-8 py-4 bg-white">
        {/* Enlaces */}
        <div className="flex space-x-4 text-[#6b4e3d] font-semibold">
          <a href="/" className="hover:underline">Inicio</a>
          <a href="/contact" className="hover:underline">Contacto</a>
        </div>

        {/* Íconos */}
        <div className="flex space-x-6 items-center">
          <FontAwesomeIcon icon={faBell} className="text-[#cdab8f] w-6 h-6" />
          <FontAwesomeIcon icon={faUserCircle} className="text-[#cdab8f] w-8 h-8" />
        </div>
      </div>

      {/* Línea inferior */}
      <div className="h-2 bg-[#cdab8f]"></div>
    </div>
  );
};

export default Header;
