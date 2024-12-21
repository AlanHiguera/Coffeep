import React from "react";
import { DataTable } from "./dataTable";
import "./Maintainer.css";

export const Maintainer = () => {
  return (
    <div className="maintainer-container">

      {/* Tabla de datos */}
      <div className="content">
        <h2>Variedad de Grano</h2>
        <DataTable />
        <button className="add-button">Agregar otra variedad de grano</button>
      </div>
    </div>
  );
};
