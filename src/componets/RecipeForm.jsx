import React, { useState } from "react";

const RecipeForm = () => {
  const [ingredients, setIngredients] = useState([{ name: "", quantity: "" }]);
  const [method, setMethod] = useState("");

  const handleIngredientChange = (index, field, value) => {
    const updatedIngredients = [...ingredients];
    updatedIngredients[index][field] = value;
    setIngredients(updatedIngredients);
  };

  const addIngredient = () => {
    setIngredients([...ingredients, { name: "", quantity: "" }]);
  };

  const removeIngredient = (index) => {
    const updatedIngredients = ingredients.filter((_, i) => i !== index);
    setIngredients(updatedIngredients);
  };

  return (
    <div className="p-4 max-w-lg mx-auto">
      <h2 className="text-xl font-bold mb-4">Crear receta</h2>
      <div className="mb-4">
        <label className="block font-semibold">Nombre de receta</label>
        <input
          type="text"
          placeholder="Café Kopi Luwak"
          className="border border-gray-300 p-2 w-full rounded"
        />
      </div>
      <div className="mb-4">
        <label className="block font-semibold">Preparación</label>
        <textarea
          placeholder="Escribe aquí..."
          className="border border-gray-300 p-2 w-full rounded"
        ></textarea>
      </div>
      <div className="mb-4">
        <h3 className="font-semibold">Ingredientes</h3>
        {ingredients.map((ingredient, index) => (
          <div key={index} className="flex items-center gap-2 mb-2">
            <input
              type="text"
              placeholder="Ingrediente"
              value={ingredient.name}
              onChange={(e) =>
                handleIngredientChange(index, "name", e.target.value)
              }
              className="border border-gray-300 p-2 rounded w-1/2"
            />
            <input
              type="text"
              placeholder="Cantidad"
              value={ingredient.quantity}
              onChange={(e) =>
                handleIngredientChange(index, "quantity", e.target.value)
              }
              className="border border-gray-300 p-2 rounded w-1/3"
            />
            <button
              type="button"
              onClick={() => removeIngredient(index)}
              className="text-red-500 hover:underline"
            >
              Eliminar
            </button>
          </div>
        ))}
        <button
          type="button"
          onClick={addIngredient}
          className="mt-2 text-blue-500 hover:underline"
        >
          Agregar otro ingrediente
        </button>
      </div>
      <div className="mb-4">
        <label className="block font-semibold">Seleccionar Método</label>
        <select
          value={method}
          onChange={(e) => setMethod(e.target.value)}
          className="border border-gray-300 p-2 w-full rounded"
        >
          <option value="">- Método -</option>
          <option value="French Press">French Press</option>
          <option value="Espresso">Espresso</option>
          <option value="Cold Brew">Cold Brew</option>
          <option value="Aeropress">Aeropress</option>
        </select>
      </div>
      <button className="bg-blue-600 text-white px-4 py-2 rounded">
        Publicar receta
      </button>
    </div>
  );
};

export default RecipeForm;
