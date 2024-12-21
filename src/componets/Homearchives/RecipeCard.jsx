import React from "react";
import "./RecipeCard.css";

export const RecipeCard = ({ image, name, rating }) => {
    return (
        <div className="recipe-card">
            <img src={image} alt={name} />
            <h4>{name}</h4>
            <p>⭐ {rating}</p>
        </div>
    );
};
