import  Navbar  from "../componets/navbar";
import UserForm from "../componets/form";
import { Sidebar } from "../componets/Sidebar";
import { Maintainer } from "../componets/Maintainer";

export const MantenedorTING = () => {
    return (
        <div>
        <Navbar />
        <Maintainer />
        <Sidebar />
        <h1 className="bg-black">Alan</h1>
        </div>
    );
    }