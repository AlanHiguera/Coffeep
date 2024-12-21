import React from "react";
import "./Sidebar.css";

export const Sidebar = () => {
  return (
    <div className="sidebar">
      <h3>Mantener tablas</h3>
      <button className="sidebar-button">Variedad de grano</button>
      <button className="sidebar-button">Tipo de ingrediente</button>
    </div>
  );
};
