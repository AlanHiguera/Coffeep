
import { Routes, Route, Router } from 'react-router-dom'
import Home from './pages/Home'
import { Alan } from './pages/Alan'
import { Miperfil } from './pages/Miperfil'
import { New } from './pages/new'
import LoginPage from './pages/Iniciosesion'
import CreateRecipePage from './pages/CrearReceta'
import Header from './componets/Lineas'

function App() {
  

  return (
    <Router>
      <div>
        <Header />
        <Routes> 
          <Route path="/" element={<Home />} />
          <Route path="/alan" element={<Alan />} />
          <Route path="/miperfil" element={<Miperfil/>} />  
          <Route path="/new" element={<New/>} />
          <Route path="/iniciosesion" element={<LoginPage/>} />
          <Route path="/crearreceta" element={<CreateRecipePage/>} />
          <Route path="*" element={<h1>Not Found</h1>} />


        </Routes>
      </div>
    </Router>
  )
}

export default App
