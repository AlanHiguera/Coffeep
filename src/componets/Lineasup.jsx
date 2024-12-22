import React from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faBell, faUserCircle } from "@fortawesome/free-solid-svg-icons";

const Header = () => {
  return (
    <div className="bg-[#E5D3C5]">
      <div className="flex justify-between items-center px-8 py-4">
        {/* Enlaces centrados */}
        <div className="absolute inset-x-0 text-center text-black font-bold text-lg">
          <a href="/" className="mx-4 hover:underline">Inicio</a>
          <span>|</span> {/* Barra separadora */}
          <a href="/contact" className="mx-4 hover:underline">Contacto</a>
        </div>

        {/* Espacio vacío a la izquierda para centrar el texto */}
        <div></div>

        {/* Íconos */}
        <div className="flex space-x-4 items-center">
          <FontAwesomeIcon icon={faBell} className="text-[#C0846F] w-6 h-6" />
          <FontAwesomeIcon icon={faUserCircle} className="text-[#C0846F] w-8 h-8" />
        </div>
      </div>
    </div>
  );
};

export default Header;
