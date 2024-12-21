import React from 'react';

const UserCard = ({ usuario }) => {
  return (
    <div className="user-card">
      <h3>{usuario.nickname}</h3>
      <p>Nombre: {usuario.nombre}</p>
      <p>Edad: {usuario.edad}</p>
      <p>Correo: {usuario.email}</p>
    </div>
  );
};

export default Usercard;