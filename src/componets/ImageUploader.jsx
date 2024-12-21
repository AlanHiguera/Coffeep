import React, { useState } from "react";

const ImageUploader = () => {
  const [image, setImage] = useState(null);

  const handleImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
      setImage(URL.createObjectURL(file)); // Mostrar previsualización
    }
  };

  return (
    <div className="max-w-3xl mx-auto mt-8 p-6 bg-[#E5D3C5] shadow-md rounded-lg border border-gray-300">
      <h3 className="text-2xl font-bold text-center mb-6">Añadir foto</h3>
      <div
        className={`border-dashed border-2 rounded-lg p-6 flex flex-col items-center ${
          image ? "border-[#A9715D]" : "border-gray-300 bg-gray-100"
        }`}
      >
        {image ? (
          <img
            src={image}
            alt="Previsualización"
            className="max-h-48 rounded-lg shadow-md mb-4"
          />
        ) : (
          <p className="text-gray-500 text-center mb-4">Arrastra o selecciona una foto</p>
        )}
        <input
          type="file"
          accept="image/*"
          onChange={handleImageChange}
          className="hidden"
          id="file-upload"
        />
        <label
          htmlFor="file-upload"
          className="bg-[#C0846F] text-white px-6 py-2 rounded-md font-bold cursor-pointer hover:bg-[#A9715D] 
          transition duration-300"
        >
          Seleccionar foto
        </label>
      </div>
      <p className="text-sm text-gray-500 mt-4 text-center">
        *Ante cualquier imagen que incumpla las normas, corres el riesgo de perder tu cuenta.
      </p>
    </div>
  );
};

export default ImageUploader;
