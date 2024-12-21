import React from "react";


const Login = () => {
  return (
    <div className="flex flex-col md:flex-row items-center justify-center flex-1 bg-white">
      {/* Cuadro del formulario */}
      <div className="bg-[#E5D3C5] rounded-lg shadow-lg p-8 w-full max-w-md">
        <h2 className="text-2xl font-bold mb-6 text-black underline text-center">Iniciar Sesión</h2>
        <form>
          <div className="mb-4">
            <label className="block text-sm font-medium text-gray-700">Nombre de usuario</label>
            <input
              type="text"
              placeholder="Ingrese su usuario"
              className="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#b3806c]"
            />
          </div>
          <div className="mb-4">
            <label className="block text-sm font-medium text-gray-700">Contraseña</label>
            <input
              type="password"
              placeholder="Ingrese su contraseña"
              className="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#b3806c]"
            />
          </div>
          <div className="text-right text-sm mb-4">
            <a href="#" className="text-black hover:underline">
              ¿Olvidaste tu contraseña?
            </a>
          </div>
          <button
            type="submit"
            className="w-full bg-[#C0846F] text-white px-6 py-2 rounded-md font-bold cursor-pointer hover:bg-[#A9715D] 
          transition duration-300"
          >
            Ingresar
          </button>
        </form>
        <p className="text-sm mt-4 text-center">
          ¿Aún no tienes una cuenta?{" "}
          <a href="#" className="text-black hover:underline">
            Regístrate
          </a>
        </p>
      </div>


      {/* Imagen */}
      <div className="hidden md:block p-8">
        <img
          src="/logo_coffee-p.png" // Cambia por la ruta de tu imagen
          alt="Coffee-P Logo"
          className="max-w-full h-auto"
        />
      </div>
    </div>
  );
};


export default Login;

