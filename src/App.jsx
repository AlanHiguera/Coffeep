
import { Routes, Route } from 'react-router-dom'
import Home from './pages/Home'
import { Alan } from './pages/Alan'
import { Miperfil } from './pages/Miperfil'
function App() {
  

  return (
    <>
    <Routes> 
      <Route path="/" element={<Home />} />
      <Route path="/alan" element={<Alan />} />
      <Route path="/miperfil" element={<Miperfil/>} />


      </Routes>
    </>
  )
}

export default App
