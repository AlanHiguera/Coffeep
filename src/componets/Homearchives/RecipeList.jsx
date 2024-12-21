import React from "react";
import "./RecipeList.css";
import { RecipeCard } from "./RecipeCard";

export const RecipeList = () => {
    // Ejemplo de datos de recetas
    const recipes = [
        { id: 1, image: "https://via.placeholder.com/150", name: "Cappuccino", rating: 4.8 },
        { id: 2, image: "https://via.placeholder.com/150", name: "Espresso", rating: 4.5 },
        { id: 3, image: "https://via.placeholder.com/150", name: "Latte", rating: 4.7 },
    ];

    return (
        <section className="recipe-list">
            {recipes.map((recipe) => (
                <RecipeCard
                    key={recipe.id}
                    image={recipe.image}
                    name={recipe.name}
                    rating={recipe.rating}
                />
            ))}
        </section>
    );
};
