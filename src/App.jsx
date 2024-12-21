//Modulos por hacer?
//Home, Miperfil, subir_Receta, ver_Receta, Mantenedor, Ranking 
import { Routes, Route } from 'react-router-dom'
import Home from './pages/Home'
import { Alan } from './pages/Alan'
import { Miperfil } from './pages/Miperfil'
import { New } from './pages/new'
import { subirReceta } from './pages/subirReceta'
import { verReceta } from './pages/verReceta'
import { Mantenedor } from './pages/Mantenedor'
import { Ranking } from './pages/Ranking'
function App() {
  

  return (
    <>
    <Routes> 
      <Route path="/" element={<Home />} />
      <Route path="/alan" element={<Alan />} />
      <Route path="/miperfil" element={<Miperfil/>} />  
      <Route path="/new" element={<New/>} />
      <Route path="/subirreceta" element={<subirReceta/>} />
      <Route path="/verreceta" element={<verReceta/>} />
      <Route path="/mantenedor" element={<Mantenedor/>} />
      <Route path="/ranking" element={<Ranking/>} />
      <Route path="*" element={<h1>Not Found</h1>} />


      </Routes>
    </>
  )
}

export default App
