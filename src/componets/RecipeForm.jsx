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

  const [isAdultOnly, setIsAdultOnly] = useState(false);

  const handleAdultOnlyChange = (e) => {
    setIsAdultOnly(e.target.checked);
  };

  return (
    <div className="max-w-3xl mx-auto mt-8 p-6 bg-[#E5D3C5] shadow-md rounded-lg border border-gray-300">
      <h2 className="text-2xl font-bold underline text-center mb-6">Crear receta</h2>
      <div className="mb-4">
        <label className="block font-semibold">Nombre de la receta</label>
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
        <h3 className="font-semibold">Seleccionar Ingredientes</h3>
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
              className="text-black-500 hover:underline"
            >
              Eliminar
            </button>
          </div>
        ))}
        <button
          type="button"
          onClick={addIngredient}
          className="mt-2 text-black-500 hover:underline"
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
      <div className="flex items-center gap-2 mb-4">
        <input
          type="checkbox"
          id="adult-only"
          checked={isAdultOnly}
          onChange={handleAdultOnlyChange}
          className="w-5 h-5 text-[#C0846F] border-[#C0846F] rounded-full focus:ring-2 focus:ring-[#C0846F] cursor-pointer"
        />
        <label htmlFor="adult-only" className="text-gray-700 font-bold cursor-pointer">
          Restricción de edad
        </label>
      </div>
      <button className="bg-[#C0846F] text-white px-6 py-2 rounded-md font-bold cursor-pointer hover:bg-[#A9715D] 
          transition duration-300">
        Publicar receta
      </button>
      <p className="text-center text-black-500 text-sm mt-4">
      *Al publicar esta receta declaras que la información presente no contiene productos dañinos para la salud 
      ni presenta uso de lenguaje inadecuado. Ante cualquier incumplimiento de normas, asumes total responsabilidad 
      de lo presente en la publicación.
      </p>
    </div>
  );
};

export default RecipeForm;
