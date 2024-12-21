import React, { useEffect, useState } from 'react';
import axios from 'axios';
import usercard from '../componets/usercard';
import navbar from '../componets/navbar';

const UserListPage = () => {
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

  if (loading) return <p>Cargando usuarios...</p>;

  return (
    <div>
      <h1>Listado de Usuarios</h1>
      <div className="user-list">
        {usuarios.map((usuario) => (
          <Usercard key={usuario.nickname} usuario={usuario} />
        ))}
      </div>
    </div>
  );
};

export default UserListPage;