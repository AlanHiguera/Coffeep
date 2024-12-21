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
    <div className="p-4 border border-gray-300 rounded">
      <h3 className="text-lg font-semibold mb-2">Añadir foto</h3>
      <div
        className={`border-dashed border-2 rounded p-4 ${
          image ? "border-green-500" : "border-gray-300"
        }`}
      >
        {image ? (
          <img
            src={image}
            alt="Previsualización"
            className="max-h-40 mx-auto mb-4"
          />
        ) : (
          <p className="text-gray-500 text-center">Arrastra o selecciona una foto</p>
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
          className="bg-blue-500 text-white px-4 py-2 rounded cursor-pointer hover:bg-blue-600"
        >
          Seleccionar foto
        </label>
      </div>
      <p className="text-sm text-gray-500 mt-2">
        *Asegúrate de que la imagen cumpla con nuestras normas.
      </p>
    </div>
  );
};

export default ImageUploader;
