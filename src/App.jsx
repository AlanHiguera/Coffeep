
import { Routes, Route } from 'react-router-dom'
import Home from './pages/Home'
import { Alan } from './pages/Alan'
import { Miperfil } from './pages/Miperfil'
import { New } from './pages/new'
function App() {
  

  return (
    <>
    <Routes> 
      <Route path="/" element={<Home />} />
      <Route path="/alan" element={<Alan />} />
      <Route path="/Home" element={<Home />} />
      <Route path="/miperfil" element={<Miperfil/>} />  
      <Route path="/new" element={<New/>} />
      <Route path="*" element={<h1>Not Found</h1>} />


      </Routes>
    </>
  )
}

export default App
