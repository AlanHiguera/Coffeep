import React, { useState, useEffect } from 'react';
import './recipeList.css';

export const RecipeList = () => {
    const [recipes, setRecipes] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        // Endpoint del ranking
        const API_URL = 'http://tu-servidor.com/api/getRanking.php';

        fetch(API_URL)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                setRecipes(data); // Actualizar las recetas con los datos del ranking
                setLoading(false);
            })
            .catch(err => {
                setError(err.message);
                setLoading(false);
            });
    }, []);

    if (loading) {
        return <p>Cargando recetas...</p>;
    }

    if (error) {
        return <p>Error: {error}</p>;
    }

    return (
        <section className="recipe-list">
            {recipes.map(recipe => (
                <div key={recipe.id} className="recipe-card">
                    <img src={recipe.image_url} alt={recipe.name} />
                    <h4>{recipe.name}</h4>
                    <p>⭐ {recipe.Rec_calificacion}</p>
                </div>
            ))}
        </section>
    );
};