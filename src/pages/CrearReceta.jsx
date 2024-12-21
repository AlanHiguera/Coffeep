import React from "react";
import RecipeForm from "../componets/RecipeForm";
import ImageUploader from "../componets/ImageUploader";

const CreateRecipePage = () => {
  return (
    <div className="max-w-4xl mx-auto p-6">
      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        {/* Formulario principal */}
        <RecipeForm />

        {/* Componente para subir imagen */}
        <ImageUploader />
      </div>
    </div>
  );
};

export default CreateRecipePage;
