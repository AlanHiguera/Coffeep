import Navbar from "../componets/navbarInicioContacto";
import { Sidebar } from "../componets/Sidebar";
import { Maintainer } from "../componets/Maintainer";
import "./MantenedorTING.css"; // Archivo CSS para los estilos del layout

export const MantenedorTING = () => {
    return (
        <div className="mantenedor-container">
            <Navbar />
            <div className="mantenedor-content">
                <Sidebar />
                <Maintainer />
            </div>
        </div>
    );
};
