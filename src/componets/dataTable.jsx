import React from "react";
import "./dataTable.css";

export const DataTable = () => {
  // Datos de ejemplo
  const data = [
    { id: "01", name: "Peaberry", origin: "Venezuela" },
    { id: "02", name: "Yirgacheffe", origin: "Etiopía" },
    { id: "03", name: "Blue Mountain", origin: "Jamaica" },
    { id: "04", name: "Sierra Nevada de Santa María", origin: "Colombia" },
  ];

  return (
    <table className="data-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Origen</th>
          <th>Editar</th>
          <th>Gestión</th>
        </tr>
      </thead>
      <tbody>
        {data.map((item) => (
          <tr key={item.id}>
            <td>{item.id}</td>
            <td>{item.name}</td>
            <td>{item.origin}</td>
            <td>
              <button className="edit-button">Editar</button>
            </td>
            <td>
              <button className="delete-button">Eliminar</button>
            </td>
          </tr>
        ))}
      </tbody>
    </table>
  );
};
