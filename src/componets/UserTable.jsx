import React, { useEffect, useState } from 'react';
import axios from 'axios';
import UserCard from './UserCard';
import '../styles.css';

const UserTable = () => {
    const [usuarios, setUsuarios] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        axios.get("http://localhost/backend/api/obtener_usuarios.php")
            .then(response => {
                setUsuarios(response.data);
                setLoading(false);
            })
            .catch(error => {
                console.error("Error al obtener los usuarios", error);
                setLoading(false);
            });
    }, []);

    if (loading) return <p className="loading">Cargando usuarios...</p>;

    return (
        <div className="user-table">
            <h1>Listado de Usuarios</h1>
            <table>
                <thead>
                    <tr>
                        <th>nickname</th>
                        <th>Nombres</th>
                        <th>Edad</th>
                        <th>Correo</th>
                        <th>Gestión</th>
                    </tr>
                </thead>
                <tbody>
                    {usuarios.map((usuario) => (
                        <UserCard key={usuario.nickname} usuario={usuario} />
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default UserTable;