import React from "react";
import { Sidebar } from "./Sidebar";
import { DataTable } from "./infoMaintainer";
import "./maintainer.css";

export const Maintainer = () => {
  return (
    <div className="maintainer-container">
      {/* Menú lateral */}
      <Sidebar />

      {/* Tabla de datos */}
      <div className="content">
        <h2>Variedad de Grano</h2>
        <DataTable />
        <button className="add-button">Agregar otra variedad de grano</button>
      </div>
    </div>
  );
};
