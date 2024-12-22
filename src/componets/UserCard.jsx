import React from 'react';
import '../styles.css';

const UserCard = ({ usuario }) => {
    return (
        <tr>
            <td>{usuario.nickname}</td>
            <td>{usuario.name}</td>
            <td>{usuario.age}</td>
            <td>{usuario.email}</td>
            <td>
                <button 
                    className="delete-btn" 
                    onClick={() => alert(`Usuario ${usuario.nickname} eliminado.`)}
                >
                    Eliminar
                </button>
            </td>
        </tr>
    );
};

export default UserCard;